<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return view('kurikulum.user.index', compact('users', 'search', 'role', 'roles'));
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

        return view('kurikulum.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'nullable|unique:users,nomor_induk',
            'role' => 'required|in:siswa,guru,walikelas,kaprog,tu,kurikulum,super_admin',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('kurikulum.user.index')
            ->with('success', 'User berhasil ditambahkan');
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

        return view('kurikulum.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nomor_induk' => 'nullable|unique:users,nomor_induk,' . $id,
            'role' => 'required|in:siswa,guru,walikelas,kaprog,tu,kurikulum,super_admin',
            'password' => 'nullable|string|min:6|confirmed',
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

        return redirect()->route('kurikulum.user.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah hapus user sendiri
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('kurikulum.user.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('12345678')
        ]);

        return redirect()->route('kurikulum.user.index')
            ->with('success', 'Password user berhasil direset menjadi 12345678');
    }
}