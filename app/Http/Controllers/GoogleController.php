<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {

    return Socialite::driver('google')->redirect();

    }

   public function handleGoogleCallback()
{
    // $user = Socialite::driver('google')->user();
    $user = Socialite::driver('google')->stateless()->user(); // Use stateless() to bypass state verification

    $findUser = User::where('google_id', $user->getId())
        ->orWhere('email', $user->getEmail())
        ->first();

    if ($findUser) {
        // Update google_id if user exists by email but doesn't have google_id
        if (!$findUser->google_id) {
            $findUser->update([
            'google_id' => $user->getId(),
                'avatar' => $user->getAvatar()
            ]);
        }

        Auth::login($findUser);

        // Redirect based on role
        if ($findUser->role && $findUser->role->name === 'customer') {
            return redirect('/');
        } else {
            // Redirect admin, employee, superadmin, manager to dashboard
            return redirect('dashboard');
        }
    } else {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->getId(),
            'avatar' => $user->getAvatar(),
            'password' => ''
        ]);

        // Assign default role to new user
        $newUser->assignRole('customer');

        Auth::login($newUser);

        // Redirect new customers to home, not dashboard
        return redirect('/')->with('success', 'User created successfully and logged in.');
    }
}
}

