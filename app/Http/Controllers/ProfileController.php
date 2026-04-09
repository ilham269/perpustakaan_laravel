<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user    = Auth::user();
        $profile = $user->profile;
        return view('profile.show', compact('user', 'profile'));
    }

    public function edit()
    {
        $user    = Auth::user();
        $profile = $user->profile;
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama user
        $user->update(['name' => $request->name]);

        $profileData = $request->only(['no_hp', 'alamat', 'tanggal_lahir']);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($user->profile && $user->profile->foto) {
                Storage::disk('public')->delete($user->profile->foto);
            }
            $profileData['foto'] = $request->file('foto')->store('profiles', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('profile.show')
                         ->with('success', 'Profil berhasil diperbarui.');
    }
}
