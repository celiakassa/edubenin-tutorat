<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PlanSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AdminPlanController extends Controller
{
    public function edit(PlanSettings $settings): View
    {
        return view('admin.plans', [
            'settings' => $settings->all(),
            'featureLabels' => config('plans.feature_labels'),
        ]);
    }

    public function update(Request $request, PlanSettings $settings): RedirectResponse
    {
        $data = $request->validate([
            'renewal_day' => ['required', 'integer', 'between:1,28'],
            'reminder_days_before' => ['required', 'integer', 'between:1,28'],
            'plans' => ['required', 'array'],
            'plans.*.label' => ['required', 'string', 'max:50'],
            'plans.*.price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'plans.*.max_annonces' => ['nullable', 'integer', 'min:0', 'max:100000'],
        ]);

        $features = array_keys(config('plans.feature_labels'));
        $plans = [];

        foreach (array_keys(config('plans.plans')) as $key) {
            $plan = $data['plans'][$key] ?? null;

            abort_if($plan === null, 422);

            $plans[$key] = [
                'label' => $plan['label'],
                'price' => (int) $plan['price'],
                'max_annonces' => ($plan['max_annonces'] ?? null) === null ? null : (int) $plan['max_annonces'],
                'features' => collect($features)->mapWithKeys(
                    fn (string $feature): array => [$feature => $request->boolean("plans.$key.features.$feature")]
                )->all(),
            ];
        }

        $settings->save([
            'renewal_day' => (int) $data['renewal_day'],
            'reminder_days_before' => (int) $data['reminder_days_before'],
            'plans' => $plans,
        ]);

        return back()->with('success', 'Paramètres des abonnements enregistrés.');
    }
}
