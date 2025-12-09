<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class KurikulumDashboardController extends Controller
{
   public function index()
{
    $totalSiswa = Siswa::count();
    $totalGuru = 12; // contoh
    $totalKelas = 18; // contoh

    $aktivitas = [
        [
            'nama' => 'Ade Santoso',
            'kelas' => 'X RPL 1',
            'aktivitas' => 'Mengubah data profil',
            'waktu' => '2025-12-05',
        ],
        [
            'nama' => 'Putri Lestari',
            'kelas' => 'XI TKJ 2',
            'aktivitas' => 'Menambahkan data anggota keluarga',
            'waktu' => '2025-12-04',
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
