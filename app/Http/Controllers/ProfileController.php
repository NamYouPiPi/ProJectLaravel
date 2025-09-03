<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

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
        $user = User::find(auth()->id());
        // dd($request->all(   ));
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update profile image
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
        }
        // Update name and email on users table
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // Update or create user profile
        $profileData = [
            'phone' => $validated['phone'],
            'bio' => $validated['bio'],
            'profile_image' => $imagePath,
        ];
        if ($user->userProfile) {
            $user->userProfile->update($profileData);
        } else {
            $user->userProfile()->create($profileData);
        }

        // After profile creation/update, redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
        $user = User::find(auth()->id());
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }


}
