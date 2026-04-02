<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialController extends Controller
{
    /**
     * Redirect to Google auth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Try to find by Google ID
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                // Check if user exists by email
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Update existing user with Google ID
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar_url' => $googleUser->avatar ?? $user->avatar_url,
                    ]);
                } else {
                    // Create a new user
                    $user = User::create([
                        'id' => Str::uuid(),
                        'display_name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar_url' => $googleUser->avatar,
                        'password_hash' => bcrypt(Str::random(24)), // Random for social users
                        'is_verified' => true,
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Google authentication failed. Internal telemetry error.']);
        }
    }
}
