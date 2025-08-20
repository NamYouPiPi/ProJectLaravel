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

    public function handleGoogleCallback(){

        // try{
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

                // Auth
                Auth::login($findUser);
                return redirect('dashboard');
            } else {
            $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->getId(),
                    'avatar' => $user->getAvatar(),
                    'password' => bcrypt(rand(100000, 999999))
                ]);

                // Assign default role to new user
                $newUser->assignRole('user');

                // Add this line to log in the user
                Auth::login($newUser);

                return redirect('home')->with('success', 'User created successfully and logged in.');
        // }
        // }catch(Exception $e){
        //     return redirect('/')->with('error', 'Something went wrong while authenticating with Google.');
        }

    }
}

