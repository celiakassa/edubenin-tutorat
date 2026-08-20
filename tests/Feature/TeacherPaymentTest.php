<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

beforeEach(function () {
    DB::beginTransaction();
});

afterEach(function () {
    DB::rollBack();
});

it('active l abonnement lorsque le paiement Moneroo est en succès', function () {
    $user = User::create([
        'firstname' => 'Jean',
        'lastname' => 'Dupont',
        'email' => Str::random(10).'@example.com',
        'password' => bcrypt('password'),
        'telephone' => '+22997000000',
        'role_id' => 3,
        'is_active' => true,
    ]);

    $user->forceFill(['email_verified_at' => now()])->save();

    $transactionId = 'py_test_success_'.Str::random(6);

    Http::fake([
        "https://api.moneroo.io/v1/payments/$transactionId" => Http::response([
            'data' => [
                'id' => $transactionId,
                'status' => 'success',
                'is_processed' => false,
                'amount' => 6500,
                'currency' => ['code' => 'XOF', 'name' => 'Franc CFA'],
                'description' => 'Abonnement Tuteur - 1 mois',
                'metadata' => ['user_id' => (string) $user->id],
                'customer' => ['email' => $user->email],
                'capture' => ['method' => ['short_code' => 'mtn', 'name' => 'MTN Mobile Money']],
                'initiated_at' => now()->toIso8601String(),
            ],
        ], 200),
        "https://api.moneroo.io/v1/payments/$transactionId/process" => Http::response(['data' => ['id' => $transactionId]], 200),
    ]);

    $this->actingAs($user)
        ->get(route('paiement.success').'?paymentId='.$transactionId)
        ->assertRedirect(route('annonces'))
        ->assertSessionHas('success', 'Abonnement activé avec succès !');

    $this->assertDatabaseHas('payments', [
        'moneroo_payment_id' => $transactionId,
        'user_id' => $user->id,
        'status' => 'completed',
    ]);

    $this->assertDatabaseHas('subscriptions', [
        'user_id' => $user->id,
        'statut' => 'active',
    ]);
});

it('retourne une erreur si la vérification Moneroo échoue', function () {
    $user = User::create([
        'firstname' => 'Marie',
        'lastname' => 'Martin',
        'email' => Str::random(10).'@example.com',
        'password' => bcrypt('password'),
        'telephone' => '+22997000001',
        'role_id' => 3,
        'is_active' => true,
    ]);

    $user->forceFill(['email_verified_at' => now()])->save();

    $transactionId = 'py_test_failed_'.Str::random(6);

    Http::fake([
        "https://api.moneroo.io/v1/payments/$transactionId" => Http::response([
            'data' => [
                'id' => $transactionId,
                'status' => 'failed',
                'is_processed' => false,
            ],
        ], 200),
    ]);

    $this->actingAs($user)
        ->get(route('paiement.success').'?paymentId='.$transactionId)
        ->assertRedirect(route('subscription.user'))
        ->assertSessionHas('error');

    $this->assertDatabaseMissing('payments', [
        'moneroo_payment_id' => $transactionId,
    ]);
});
