<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ])->first();

            if ($user) {
                Auth::login($user);
                return redirect('/dashboard');
            } else {
                $user = User::where('email', $socialUser->email)->first();

                if ($user) {
                    // Update user with provider details
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->id,
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->name,
                        'email' => $socialUser->email,
                        'provider' => $provider,
                        'provider_id' => $socialUser->id,
                        'password' => bcrypt(str_random(16)), // Set a random password
                        'email_verified_at' => now(),
                    ]);
                }

                Auth::login($user);
                return redirect('/dashboard');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong or you have rejected the app.');
        }
    }
}
