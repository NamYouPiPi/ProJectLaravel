<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);
        foreach ($validated as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = auth()->user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = auth()->user();
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->file('profile_image')->store('profile-images', 'public');
        $user->profile_image = $path;
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profile image updated successfully!');
    }
}
