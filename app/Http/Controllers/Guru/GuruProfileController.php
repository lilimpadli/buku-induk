<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruProfileController extends Controller
{
    /**
     * Display guru profile
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();

        return view('guru.data-diri.profile', compact('guru', 'user'));
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();

        return view('guru.data-diri.edit', compact('guru', 'user'));
    }

    /**
     * Update guru profile
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:30|unique:gurus,nip,' . $guru->id,
            'email' => 'required|email|max:100|unique:gurus,email,' . $guru->id,
            'telepon' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update guru profile
        $guru->update([
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'] ?? '',
            'tempat_lahir' => $validated['tempat_lahir'] ?? '',
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'] ?? '',
        ]);

        // Update user
        $userData = [
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'nomor_induk' => $validated['nip'], // Sinkron NIP untuk login
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }

            $photoPath = $request->file('photo')->store('photos/guru', 'public');
            $user->update(['photo' => $photoPath]);
        }

        return redirect()->route('guru.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}