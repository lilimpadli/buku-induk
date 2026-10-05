<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $role = $request->get('role', '');

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%");
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        $roles = [
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'tu' => 'TU',
            'kurikulum' => 'Kurikulum',
            'super_admin' => 'Super Admin',
        ];

        return view('super_admin.users.index', compact('users', 'search', 'role', 'roles'));
    }

    public function create()
    {
        $roles = [
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'tu' => 'TU',
            'kurikulum' => 'Kurikulum',
            'super_admin' => 'Super Admin',
        ];

        return view('super_admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'role' => 'required|in:siswa,guru,walikelas,kaprog,tu,tu_kepegawaian,kurikulum,super_admin',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nomor_induk.required' => 'Nomor induk wajib diisi!',
            'nomor_induk.unique' => 'Nomor induk sudah digunakan!',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nomor_induk' => $request->nomor_induk,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            Log::info('User berhasil dibuat:', [
                'id' => $user->id,
                'nomor_induk' => $user->nomor_induk,
                'role' => $user->role
            ]);

            return redirect()->route('super_admin.users.index')
                ->with('success', 'User berhasil ditambahkan! Gunakan NOMOR INDUK untuk login.');

        } catch (\Exception $e) {
            Log::error('Gagal buat user:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = [
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'tu' => 'TU',
            'kurikulum' => 'Kurikulum',
            'super_admin' => 'Super Admin',
        ];

        return view('super_admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $id,
            'role' => 'required|in:siswa,guru,walikelas,kaprog,tu,tu_kepegawaian,kurikulum,super_admin',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nomor_induk.required' => 'Nomor induk wajib diisi!',
            'nomor_induk.unique' => 'Nomor induk sudah digunakan!',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('super_admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function show($id)
    {
        $user = User::with(['guru', 'siswa'])->findOrFail($id);
        return view('super_admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('super_admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('12345678')
        ]);

        return redirect()->route('super_admin.users.index')
            ->with('success', 'Password user berhasil direset menjadi 12345678');
    }
}