<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleLoginController extends Controller
{
    // Redirect the user to the Google authentication page
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the Google callback after the user has authenticated
  public function handleGoogleCallback()
{
    try {
        // Get the Google user information
        $googleUser = Socialite::driver('google')->user();

        // Check if a user already exists by email
        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            // If the user exists but does not have a Google ID, update their record
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }
        } else {
            // If the user does not exist, create a new user
            $user = User::create([
                'first_name' => $googleUser->user['given_name'] ?? '',
                'last_name' => $googleUser->user['family_name'] ?? '',
                'email' => $googleUser->email,
                'password' => bcrypt(uniqid()), // Random password
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'phone' => $googleUser->phone ?? null,
            ]);
        }

        // Log in the user
        Auth::login($user, true);

        // Redirect to the intended page
        return redirect()->intended('/');

    } catch (\Exception $e) {
        \Log::error('Google login error: ' . $e->getMessage());
        return redirect('/login')->withErrors('Google login failed. Please try again.');
    }
}

}
