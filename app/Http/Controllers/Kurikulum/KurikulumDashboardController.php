<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumDashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalSiswa = DataSiswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalRombel = Rombel::count();
        $totalMapel = MataPelajaran::count();
        $totalJurusan = Jurusan::count();

        // Jenis Kelamin
        $siswaLaki = DataSiswa::where('jenis_kelamin', 'Laki-laki')->count();
        $siswaPerempuan = DataSiswa::where('jenis_kelamin', 'Perempuan')->count();

        // Siswa per Tingkat
        $siswaX = DataSiswa::whereHas('rombel.kelas', function($q) {
            $q->where('tingkat', 'X');
        })->count();

        $siswaXI = DataSiswa::whereHas('rombel.kelas', function($q) {
            $q->where('tingkat', 'XI');
        })->count();

        $siswaXII = DataSiswa::whereHas('rombel.kelas', function($q) {
            $q->where('tingkat', 'XII');
        })->count();

        // Siswa per Jurusan
        $jurusanData = Jurusan::with(['kelas.rombels.siswa'])->get()->map(function($j) {
            $total = 0;
            foreach ($j->kelas as $kelas) {
                foreach ($kelas->rombels as $rombel) {
                    $total += $rombel->siswa->count();
                }
            }
            return [
                'nama' => $j->nama,
                'total' => $total
            ];
        });

        // Rombel Terbaru
        $rombels = Rombel::with(['kelas.jurusan', 'guru'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('kurikulum.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalRombel',
            'totalMapel',
            'totalJurusan',
            'siswaLaki',
            'siswaPerempuan',
            'siswaX',
            'siswaXI',
            'siswaXII',
            'jurusanData',
            'rombels'
        ));
    }
}