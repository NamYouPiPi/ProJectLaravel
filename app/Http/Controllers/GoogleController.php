<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            $googleUser = Socialite::driver('google')->stateless()->user();
            // 1. Check if email exists in users table (admin, employee, manager, superadmin)
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user && in_array(optional($user->role)->name, ['admin', 'employee', 'manager', 'superadmin'])) {
                // Update google_id if needed
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar()
                    ]);
                }
                Auth::login($user);
                return redirect('dashboard');
            }
            // 2. Check if email exists in customers table
            $customer = Customer::where('email', $googleUser->getEmail())->first();
            if ($customer) {
                // Update google_id if needed
                if (!$customer->google_id) {
                    $customer->update([
                        'google_id' => $googleUser->getId(),
                        'profile_photo' => $googleUser->getAvatar()
                    ]);
                }
                Auth::login($customer);
                return redirect('/')->with('success', 'Logged in as customer.');
            }
            // 3. If not found, create new customer
            $newCustomer = Customer::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'profile_photo' => $googleUser->getAvatar(),
                'password' => '', // You may want to generate a random password
                'status' => 'active'
            ]);
            // If you use spatie/laravel-permission for roles
            if (method_exists($newCustomer, 'assignRole')) {
                $newCustomer->assignRole('customer');
            }
            Auth::login($newCustomer);
            return redirect('/')->with('success', 'User created successfully and logged in as customer.');
        }
}

