<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DataPribadiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru ?? null; // Coba ambil data guru jika ada

        return view('tu.data-pribadi.index', compact('user', 'guru'));
    }

    public function edit()
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Jika guru belum ada, inisialisasi object kosong untuk form
        if (!$guru) {
            $guru = new Guru([
                'user_id' => $user->id,
                'nama' => $user->nama_lengkap ?? $user->name ?? '',
                'nip' => '',
                'email' => $user->email ?? '',
                'telepon' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L',
                'alamat' => '',
                'jurusan_id' => null,
                'kelas_id' => null,
            ]);
        }

        return view('tu.data-pribadi.edit', compact('user', 'guru'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:gurus,email,' . ($guru->id ?? 'NULL'),
            'telepon' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Jika NIP tidak diisi, generate otomatis
        if (empty($validated['nip'])) {
            $validated['nip'] = 'TEMP-' . $user->id . '-' . time();
        }
        $validated['kelas_id'] = $validated['kelas_id'] ?? null;
        $validated['user_id'] = $user->id;

        // Handle foto profil
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                $oldPhotoPath = storage_path('app/public/' . $user->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            // Simpan foto baru
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = $photoPath;
        }

        // Handle password
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Simpan user changes
        $user->save();

        // Remove password dari validated karena tidak ada di table gurus
        unset($validated['password']);

        if (!$guru) {
            // Buat entry baru jika belum ada
            $guru = Guru::create($validated);
        } else {
            // Update entry yang sudah ada
            $guru->update($validated);
        }

        return redirect()->route('tu.data-pribadi.index')
            ->with('success', 'Data pribadi dan profil berhasil diperbarui');
    }
}
