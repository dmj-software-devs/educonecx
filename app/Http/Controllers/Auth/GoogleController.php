<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();
            $isNewUser = false;
            
            if ($user) {
                // Update Google ID if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                    
                    // User existed but Google ID was not set (linked Google account)
                    Auth::login($user, true);
                    return redirect('/')->with('success', 'Google account linked successfully! You can now login with Google anytime.');
                }
                
                // Existing user logging in with Google
                Auth::login($user, true);
                return redirect('/')->with('success', 'Welcome back! You\'ve successfully logged in with Google.');
                
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                    'avatar' => $googleUser->avatar,
                ]);
                
                Auth::login($user, true);
                
                return redirect('/')->with('success', 'Welcome to Educonecx! Your account has been successfully created. You can now login with Google anytime.');
            }
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Google Login Error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->with('error', 'Google login failed. Please try again.');
        }
    }
}