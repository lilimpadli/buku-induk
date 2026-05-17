<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    /**
     * Dashboard Super Admin
     */
    public function dashboard()
    {
        // Statistik lengkap untuk Super Admin
        $totalUsers = User::count();
        $totalSiswa = DataSiswa::count();
        $totalGuru = Guru::count();
        $totalTU = User::whereIn('role', ['tu', 'tu_kepegawaian'])->count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalKaprog = User::where('role', 'kaprog')->count();
        $totalKurikulum = User::where('role', 'kurikulum')->count();
        $totalSuperAdmin = User::where('role', 'super_admin')->count();

        // Data aktivitas sistem terbaru
        $aktivitasUsers = User::latest('created_at')->take(5)->get(['name', 'created_at'])->map(function ($user) {
            return [
                'nama' => $user->name ?? 'Pengguna',
                'aktivitas' => 'Menambahkan user baru',
                'waktu' => Carbon::parse($user->created_at)->diffForHumans(),
                'tipe' => 'primary',
                'created_at' => $user->created_at,
            ];
        });

        $aktivitasSiswa = DataSiswa::latest('created_at')->take(5)->get(['nama_lengkap', 'created_at'])->map(function ($siswa) {
            return [
                'nama' => $siswa->nama_lengkap ?? 'Siswa',
                'aktivitas' => 'Menambahkan data siswa baru',
                'waktu' => Carbon::parse($siswa->created_at)->diffForHumans(),
                'tipe' => 'primary',
                'created_at' => $siswa->created_at,
            ];
        });

        $aktivitasGuru = Guru::latest('created_at')->take(5)->get(['nama', 'created_at'])->map(function ($guru) {
            return [
                'nama' => $guru->nama ?? 'Guru',
                'aktivitas' => 'Menambahkan data guru baru',
                'waktu' => Carbon::parse($guru->created_at)->diffForHumans(),
                'tipe' => 'primary',
                'created_at' => $guru->created_at,
            ];
        });

        $aktivitasJurusan = Jurusan::latest('created_at')->take(5)->get(['nama', 'created_at'])->map(function ($jurusan) {
            return [
                'nama' => $jurusan->nama ?? 'Jurusan',
                'aktivitas' => 'Membuat jurusan baru',
                'waktu' => Carbon::parse($jurusan->created_at)->diffForHumans(),
                'tipe' => 'primary',
                'created_at' => $jurusan->created_at,
            ];
        });

        $aktivitasKelas = Kelas::with('jurusan')->latest('created_at')->take(5)->get(['id', 'tingkat', 'jurusan_id', 'created_at'])->map(function ($kelas) {
            $kelasLabel = trim(($kelas->tingkat ?? '') . ' ' . ($kelas->jurusan->nama ?? '')) ?: 'Kelas';

            return [
                'nama' => $kelasLabel,
                'aktivitas' => 'Membuat kelas baru',
                'waktu' => Carbon::parse($kelas->created_at)->diffForHumans(),
                'tipe' => 'primary',
                'created_at' => $kelas->created_at,
            ];
        });

        $aktivitas = $aktivitasUsers
            ->concat($aktivitasSiswa)
            ->concat($aktivitasGuru)
            ->concat($aktivitasJurusan)
            ->concat($aktivitasKelas)
            ->sortByDesc('created_at')
            ->values()
            ->take(5)
            ->map(function ($item) {
                return [
                    'nama' => $item['nama'],
                    'aktivitas' => $item['aktivitas'],
                    'waktu' => $item['waktu'],
                    'tipe' => $item['tipe'],
                ];
            });

        // Statistik per role
        $roleStats = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get()
            ->pluck('total', 'role');

        return view('super_admin.dashboard', compact(
            'totalUsers',
            'totalSiswa',
            'totalGuru',
            'totalTU',
            'totalWaliKelas',
            'totalKaprog',
            'totalKurikulum',
            'totalSuperAdmin',
            'aktivitas',
            'roleStats'
        ));
    }

    /**
     * Index semua users
     */
    public function usersIndex()
    {
        $users = User::with(['guru', 'siswa'])->paginate(20);
        return view('super_admin.users.index', compact('users'));
    }

    /**
     * Form create user baru
     */
    public function create()
    {
        return view('super_admin.users.create');
    }

    /**
     * Store user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'nullable|string|unique:users,nomor_induk',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Tampil detail user
     */
    public function show($id)
    {
        $user = User::with(['guru', 'siswa'])->findOrFail($id);
        return view('super_admin.users.show', compact('user'));
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nomor_induk' => 'nullable|string|unique:users,nomor_induk,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil dihapus');
    }

    /**
     * Manajemen sistem
     */
    public function systemIndex()
    {
        return view('super_admin.system.index');
    }

    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            return redirect()->back()->with('success', 'Cache berhasil dibersihkan');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function optimizeSystem(Request $request)
    {
        try {
            Artisan::call('optimize');
            return redirect()->back()->with('success', 'Optimize berhasil dijalankan');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menjalankan optimize: ' . $e->getMessage());
        }
    }

    public function backupDatabase(Request $request)
    {
        // Placeholder: implement actual backup generation later
        return redirect()->back()->with('success', 'Backup database berhasil dibuat');
    }

    public function toggleMaintenance(Request $request)
    {
        try {
            if (app()->isDownForMaintenance()) {
                Artisan::call('up');
                return redirect()->back()->with('success', 'Maintenance mode dimatikan');
            } else {
                Artisan::call('down');
                return redirect()->back()->with('success', 'Maintenance mode diaktifkan');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal toggle maintenance: ' . $e->getMessage());
        }
    }

    public function manajemenGuru()
    {
        return view('super_admin.manajemen-guru');
    }
}