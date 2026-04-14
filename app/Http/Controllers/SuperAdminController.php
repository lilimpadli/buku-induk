<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Data aktivitas sistem (simulasi)
        $aktivitas = [
            [
                'nama' => 'System',
                'aktivitas' => 'Backup database berhasil',
                'waktu' => '2 jam yang lalu',
                'tipe' => 'system'
            ],
            [
                'nama' => 'Admin',
                'aktivitas' => 'User baru ditambahkan',
                'waktu' => '5 jam yang lalu',
                'tipe' => 'admin'
            ],
            [
                'nama' => 'System',
                'aktivitas' => 'Log aktivitas dibersihkan',
                'waktu' => '1 hari yang lalu',
                'tipe' => 'system'
            ]
        ];

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
     * Manajemen sistem
     */
    public function systemIndex()
    {
        return view('super_admin.system.index');
    }
}