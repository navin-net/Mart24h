<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('auth.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'dob' => 'nullable|date',
            'old_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->save();

        $profileData = ['dob' => $request->dob];

        if ($request->hasFile('image')) {
            if ($user->profile && $user->profile->image) {
                Storage::disk('public')->delete($user->profile->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $profileData['image'] = $image->storeAs('profiles', $imageName, 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }
}
