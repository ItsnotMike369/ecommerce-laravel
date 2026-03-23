<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }

        return $this->loginOrCreateUser($socialUser, 'google');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Facebook login failed. Please try again.');
        }

        return $this->loginOrCreateUser($socialUser, 'facebook');
    }

    private function loginOrCreateUser($socialUser, string $provider)
    {
        $field = $provider . '_id';

        $user = User::where($field, $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if ($user) {
            $user->update([
                $field   => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            $nameParts = explode(' ', $socialUser->getName() ?? '', 2);
            $user = User::create([
                'name'           => $socialUser->getName() ?? $socialUser->getEmail(),
                'email'          => $socialUser->getEmail(),
                $field           => $socialUser->getId(),
                'avatar'         => $socialUser->getAvatar(),
                'email_verified_at' => now(),
                'password'       => null,
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('account'));
    }
}
