<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // CARI GURU/WALI KELAS berdasarkan user_id
        $guru = DB::table('gurus')->where('user_id', $user->id)->first();
        
        if (!$guru) {
            // Jika tidak ada data guru
            return view('walikelas.dashboard', [
                'total' => 0,
                'byGender' => ['Laki-laki' => 0, 'Perempuan' => 0],
                'recentGrouped' => collect()
            ]);
        }
        
        // CARI ROMBEL yang memiliki guru_id = id guru
        $rombel = Rombel::where('guru_id', $guru->id)->first();
        
        if (!$rombel) {
            return view('walikelas.dashboard', [
                'total' => 0,
                'byGender' => ['Laki-laki' => 0, 'Perempuan' => 0],
                'recentGrouped' => collect()
            ]);
        }
        
        // AMBIL SISWA berdasarkan rombel_id
        $siswaQuery = DataSiswa::with('rombel')
            ->where('rombel_id', $rombel->id);
        
        $total = $siswaQuery->count();
        
        $byGender = [
            'Laki-laki' => (clone $siswaQuery)->where('jenis_kelamin', 'Laki-laki')->count(),
            'Perempuan' => (clone $siswaQuery)->where('jenis_kelamin', 'Perempuan')->count()
        ];
        
        // Ambil 10 siswa terbaru
        $recentSiswa = (clone $siswaQuery)
            ->latest()
            ->take(10)
            ->get();
        
        $recentGrouped = $recentSiswa->groupBy(function($siswa) {
            return $siswa->rombel ? $siswa->rombel->nama : 'Tidak ada rombel';
        });
        
        return view('walikelas.dashboard', compact('total', 'byGender', 'recentGrouped'));
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class, 'user_id');
    }
}