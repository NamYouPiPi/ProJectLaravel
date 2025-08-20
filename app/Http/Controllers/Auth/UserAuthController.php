<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Frontend.auth.login'); // same page
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required'],   // email or username
            'password' => ['required'],
            'role' => ['required','in:admin,manager,staff,superadmin'],
        ]);

        $remember = $request->boolean('remember');

        // Try logging in by email first, then username
        $credentials = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
            ? ['email' => $data['login'], 'password' => $data['password']]
            : ['name' => $data['login'],  'password' => $data['password']];

        if (Auth::guard('user')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::guard('user')->user();

            // Make sure role matches selection (optional but safer)
            if (!$user->hasRole($data['role'])) {
                Auth::guard('user')->logout();
                return back()->withErrors(['login' => 'Role does not match your account'])->onlyInput('login');
            }

            // Redirect by role
            return match ($data['role']) {
                'admin'      => redirect()->intended(route('admin.dashboard')),
                'manager'    => redirect()->intended(route('manager.dashboard')),
                'staff'      => redirect()->intended(route('staff.dashboard')),
                'superadmin' => redirect()->intended(route('superadmin.dashboard')),
            };
        }

        return back()->withErrors(['login' => 'Invalid credentials for user'])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('fe.cinemagic');
    }
}
