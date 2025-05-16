<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show the profile edit form
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('auth.profile.edit', compact('user'));
    }

    // Update or create the profile
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'dob' => 'nullable|date',
            'old_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:6|confirmed', // Must match new_password_confirmation
        ]);

        $user = User::findOrFail($id);

        $imagePath = $user->profile->image ?? null;

        // Handle new image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('profiles', $imageName, 'public');
        }

        // Update password if new_password is provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        // Create or update the profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'image' => $imagePath,
                'dob' => $request->dob,
            ]
        );

    return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }
}
