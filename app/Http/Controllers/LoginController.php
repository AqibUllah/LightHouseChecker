<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function googleLogin()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(uniqid()), // Random password
                ]);
            }

            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/auth/login')->withErrors('Google login failed.');
        }
    }

    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Google login failed'], 401);
        }

        // Check if the user already exists
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt(uniqid()), // Random password
            ]);
        }

        // Log in the user
        Auth::login($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
    }

    public function loginWithGoogle(Request $request)
    {
        $token = $request->token;
        try {
            $googleUser = Socialite::driver('google')->userFromToken($token);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        // Check if the user already exists
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt(uniqid()), // Random password
            ]);
        }

        // Log in the user
        Auth::login($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
    }
}
