<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataPribadiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Jika guru belum ada, buat instance baru (agar view tidak perlu cek null)
        if (!$guru) {
            $guru = new Guru();
            $guru->user_id = $user->id;
            $guru->nama = $user->nama_lengkap ?? $user->name ?? '';
            $guru->jenis_kelamin = 'L'; // Default value
        }

        return view('kurikulum.data-pribadi.index', compact('user', 'guru'));
    }

    public function edit()
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Jika guru belum ada, buat instance baru
        if (!$guru) {
            $guru = new Guru();
            $guru->user_id = Auth::user()->id;
            $guru->nama = Auth::user()->nama_lengkap ?? Auth::user()->name ?? '';
            $guru->jenis_kelamin = 'L'; // Default value
        }

        return view('kurikulum.data-pribadi.edit', compact('guru', 'user'));
    }

    public function update()
    {
        $validated = request()->validate([
            'nip' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $guru = $user->guru;

        // Jika guru belum ada, buat baru
        if (!$guru) {
            $guru = new Guru();
            $guru->user_id = Auth::user()->id;
        }

        // Jika NIP tidak diisi, generate otomatis
        if (empty($validated['nip'])) {
            $validated['nip'] = 'TEMP-' . $user->id . '-' . time();
        }

        // Handle foto profil
        if (request()->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                $oldPhotoPath = storage_path('app/public/' . $user->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            // Simpan foto baru
            $photoPath = request()->file('photo')->store('profile-photos', 'public');
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
        
        $guru->fill($validated)->save();

        return redirect()->route('kurikulum.data-pribadi.index')->with('success', 'Data pribadi dan profil berhasil diperbarui');
    }
}
