<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Frontend.auth.login'); // same page hosts both forms
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('customer')->attempt($data, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials for customer'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('fe.cinemagic'); // your public home
    }
}
