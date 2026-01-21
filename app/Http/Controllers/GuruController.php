<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Tampilkan profil guru (login)
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = Guru::where('user_id', $user->id)->first();

        return view('walikelas.guru.profile', compact('guru', 'user'));
    }

    /**
     * Form edit profil
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = Guru::where('user_id', $user->id)->first();

        return view('walikelas.guru.edit', compact('guru', 'user'));
    }

    /**
     * Update profil guru
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = Guru::where('user_id', $user->id)->first();

        $redirectRoute = 'walikelas.data_diri.profile';
        if (!$guru) {
            return redirect()
                ->route($redirectRoute)
                ->with('error', 'Data guru tidak ditemukan.');
        }

        // ================= VALIDASI DATA =================
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'nip'            => ['nullable', 'string', 'max:50', Rule::unique('gurus', 'nip')->ignore($guru->id)],
            'email'          => 'nullable|email|max:255',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|string|max:30',
            'alamat'         => 'nullable|string',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ================= UPDATE DATA GURU =================
        $guru->update([
            'nama'          => $validated['nama'],
            'nip'           => $validated['nip'] ?? null,
            'email'         => $validated['email'] ?? null,
            'tempat_lahir'  => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'alamat'        => $validated['alamat'] ?? null,
        ]);

        // ================= SINKRON USER =================
        $user->name = $validated['nama'];

        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }

        // Sinkron nomor_induk (untuk login dengan NIP baru)
        if (!empty($validated['nip'])) {
            $user->nomor_induk = $validated['nip'];
        }

        // ================= UPLOAD FOTO =================
        if ($request->hasFile('photo')) {

            // Hapus foto lama
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        // ================= SIMPAN USER =================
        $user->save();

        return redirect()
            ->route($redirectRoute)
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
