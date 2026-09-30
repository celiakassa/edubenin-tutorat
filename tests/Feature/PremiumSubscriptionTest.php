<?php

declare(strict_types=1);

use App\Enums\SubscriptionPlan;
use App\Mail\PremiumDowngradedMail;
use App\Mail\PremiumExpiringMail;
use App\Models\User;
use App\Services\SubscriptionBillingService;
use App\Services\SubscriptionGateway;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

beforeEach(function () {
    DB::beginTransaction();
    Mail::fake();

    $gateway = Mockery::mock(SubscriptionGateway::class);
    $gateway->shouldReceive('chargeSavedMethod')->andReturn(false)->byDefault();
    $gateway->shouldReceive('createCheckout')->andReturn(['id' => 'py_x', 'checkout_url' => 'https://pay.test/x'])->byDefault();
    app()->instance(SubscriptionGateway::class, $gateway);

    $this->student = User::create([
        'firstname' => 'Awa',
        'lastname' => 'Kone',
        'email' => Str::random(10).'@example.com',
        'password' => bcrypt('password'),
        'role_id' => 2,
        'is_active' => true,
    ]);
});

afterEach(function () {
    DB::rollBack();
});

it('est en standard par défaut puis en premium après paiement', function () {
    expect($this->student->currentPlan())->toBe(SubscriptionPlan::Standard);

    $subscription = app(SubscriptionBillingService::class)
        ->activatePremium($this->student, 'py_'.Str::random(6), Carbon::parse('2026-10-12'));

    expect($this->student->currentPlan())->toBe(SubscriptionPlan::Premium)
        ->and($subscription->date_fin->toDateString())->toBe('2026-10-31');
});

it('envoie le rappel 5 jours avant la fin, une seule fois', function () {
    app(SubscriptionBillingService::class)->activatePremium($this->student, 'py_a', Carbon::parse('2026-10-01'));

    expect(app(SubscriptionBillingService::class)->sendExpiryReminders(Carbon::parse('2026-10-26')))->toBe(1)
        ->and(app(SubscriptionBillingService::class)->sendExpiryReminders(Carbon::parse('2026-10-27')))->toBe(0);

    Mail::assertSent(PremiumExpiringMail::class, 1);
});

it('ne rappelle pas trop tôt', function () {
    app(SubscriptionBillingService::class)->activatePremium($this->student, 'py_b', Carbon::parse('2026-10-01'));

    expect(app(SubscriptionBillingService::class)->sendExpiryReminders(Carbon::parse('2026-10-20')))->toBe(0);
});

it('repasse en standard le 1er si le débit échoue', function () {
    app(SubscriptionBillingService::class)->activatePremium($this->student, 'py_c', Carbon::parse('2026-10-01'));

    $result = app(SubscriptionBillingService::class)->renewDuePremiums(Carbon::parse('2026-11-01'));

    expect($result)->toBe(['renewed' => 0, 'downgraded' => 1])
        ->and($this->student->fresh()->subscriptions()->first()->statut)->toBe('expired');

    Mail::assertSent(PremiumDowngradedMail::class);
});

it('prolonge le premium à la suite de la période en cours quand on renouvelle via le lien', function () {
    $billing = app(SubscriptionBillingService::class);
    $billing->activatePremium($this->student, 'py_e', Carbon::parse('2026-10-01'));

    $renewed = $billing->activatePremium($this->student, 'py_f', Carbon::parse('2026-10-28'));

    expect($renewed->date_debut->toDateString())->toBe('2026-11-01')
        ->and($renewed->date_fin->toDateString())->toBe('2026-11-30');

    expect($billing->renewDuePremiums(Carbon::parse('2026-11-01')))->toBe(['renewed' => 1, 'downgraded' => 0]);
    expect($this->student->isPremium())->toBeTrue();
    Mail::assertNotSent(PremiumDowngradedMail::class);
});

it('envoie un mail le dernier jour avec le lien de renouvellement', function () {
    $billing = app(SubscriptionBillingService::class);
    $billing->activatePremium($this->student, 'py_g', Carbon::parse('2026-10-01'));

    $billing->sendExpiryReminders(Carbon::parse('2026-10-26'));
    expect($billing->sendExpiryReminders(Carbon::parse('2026-10-31')))->toBe(1)
        ->and($billing->sendExpiryReminders(Carbon::parse('2026-10-31')))->toBe(0);

    Mail::assertSent(PremiumExpiringMail::class, 2);
    Mail::assertSent(PremiumExpiringMail::class, fn ($mail) => $mail->isLastDay && str_contains($mail->renewalUrl, 'signature='));
});

it('ne rappelle pas un élève qui a déjà renouvelé', function () {
    $billing = app(SubscriptionBillingService::class);
    $billing->activatePremium($this->student, 'py_h', Carbon::parse('2026-10-01'));
    $billing->activatePremium($this->student, 'py_i', Carbon::parse('2026-10-20'));

    expect($billing->sendExpiryReminders(Carbon::parse('2026-10-31')))->toBe(0);
});

it('redirige le lien signé vers le paiement et refuse un lien non signé', function () {
    app(SubscriptionGateway::class)->shouldReceive('createCheckout')->andReturn(['id' => 'py_z', 'checkout_url' => 'https://pay.test/z']);

    $url = app(SubscriptionBillingService::class)->renewalUrl($this->student);

    $this->get($url)->assertRedirect('https://pay.test/z');
    $this->get(route('subscriptions.renew', $this->student->id))->assertForbidden();
});

it('ne facture pas le standard tant que son prix est à 0', function () {
    config(['plans.plans.standard.price' => 0]);

    expect(app(SubscriptionBillingService::class)->billStandardUsers())->toBe(0);
});

it('permet à l\'admin de modifier les offres et le calendrier', function () {
    $admin = User::create([
        'firstname' => 'Ad', 'lastname' => 'Min', 'email' => Str::random(10).'@example.com',
        'password' => bcrypt('password'), 'role_id' => 1, 'is_active' => true,
    ]);
    $admin->forceFill(['email_verified_at' => now()])->save();

    $this->actingAs($admin)->get(route('admin.plans'))->assertOk()->assertSee('Offres Standard et Premium');

    $this->actingAs($admin)->put(route('admin.plans.update'), [
        'renewal_day' => 15,
        'reminder_days_before' => 3,
        'plans' => [
            'standard' => ['label' => 'Standard', 'price' => 1000, 'max_annonces' => 2],
            'premium' => ['label' => 'Premium', 'price' => 9000, 'max_annonces' => '', 'features' => ['priority_support' => '1']],
        ],
    ])->assertSessionHasNoErrors();

    expect(SubscriptionPlan::Premium->price())->toBe(9000)
        ->and(SubscriptionPlan::Premium->maxAnnonces())->toBeNull()
        ->and(SubscriptionPlan::Premium->allows('priority_support'))->toBeTrue()
        ->and(SubscriptionPlan::Premium->allows('featured_annonces'))->toBeFalse()
        ->and(SubscriptionPlan::Standard->maxAnnonces())->toBe(2);

    $subscription = app(SubscriptionBillingService::class)
        ->activatePremium($this->student, 'py_cal', Carbon::parse('2026-10-20'));

    expect($subscription->date_fin->toDateString())->toBe('2026-11-14');
});

it('interdit la page admin aux élèves', function () {
    $this->student->forceFill(['email_verified_at' => now()])->save();

    $response = $this->actingAs($this->student)->get(route('admin.plans'));

    expect($response->status())->not->toBe(200);
});
