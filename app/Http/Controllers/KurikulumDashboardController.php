<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa; // kalau nama model bukan ini, bilang ya!
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL SISWA
        $totalSiswa = DataSiswa::count();

        // TOTAL GURU (dummy dulu kalau belum ada tabel guru)
        $totalGuru = 25;

        // TOTAL KELAS (dummy dulu kalau belum ada tabel kelas)
        $totalKelas = 18;

        // DATA AKTIVITAS (dummy biar tidak error)
        $aktivitas = [
            [
                'nama' => 'Lili Amelia',
                'kelas' => 'X PPLG 1',
                'aktivitas' => 'Mengupdate data diri',
                'waktu' => '2 menit lalu'
            ],
            [
                'nama' => 'Soni Permana',
                'kelas' => 'XI TJKT',
                'aktivitas' => 'Mengupload foto',
                'waktu' => '10 menit lalu'
            ],
            [
                'nama' => 'Mega Sari',
                'kelas' => 'XII AKL',
                'aktivitas' => 'Melihat raport',
                'waktu' => '1 jam lalu'
            ],
        ];

        return view('kurikulum.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'aktivitas'
        ));
    }
}
