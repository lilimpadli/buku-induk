<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TUKepegawaianController extends Controller
{
    /**
     * Dashboard TU Kepegawaian
     */
    public function dashboard()
    {
        // Statistik dasar untuk TU Kepegawaian
        $totalGuru = Guru::count();
        $totalTU = User::where('role', 'tu')->count();
        $totalTUKepegawaian = User::where('role', 'tu_kepegawaian')->count();
        $totalStaffAktif = User::whereIn('role', ['guru', 'tu', 'tu_kepegawaian'])->count();

        // Data guru terbaru
        $guruBaru = Guru::with('user')->latest()->take(5)->get();

        // Data aktivitas terbaru (simulasi)
        $aktivitas = [
            [
                'nama' => 'Ahmad Rizki',
                'jabatan' => 'Guru Matematika',
                'aktivitas' => 'Update data kepegawaian',
                'waktu' => '2 jam yang lalu'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'jabatan' => 'TU Akademik',
                'aktivitas' => 'Penambahan data guru baru',
                'waktu' => '5 jam yang lalu'
            ],
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'TU Kepegawaian',
                'aktivitas' => 'Verifikasi data pegawai',
                'waktu' => '1 hari yang lalu'
            ]
        ];

        return view('tu_kepegawaian.dashboard', compact(
            'totalGuru',
            'totalTU',
            'totalTUKepegawaian',
            'totalStaffAktif',
            'guruBaru',
            'aktivitas'
        ));
    }

    /**
     * Index data guru
     */
    public function guruIndex()
    {
        $guru = Guru::with('user')->paginate(10);
        return view('tu_kepegawaian.guru.index', compact('guru'));
    }

    /**
     * Index data TU
     */
    public function tuIndex()
    {
        $tu = User::whereIn('role', ['tu', 'tu_kepegawaian'])->paginate(10);
        return view('tu_kepegawaian.tu.index', compact('tu'));
    }
}