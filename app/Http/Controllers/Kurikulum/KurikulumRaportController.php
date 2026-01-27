<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;

class KurikulumRaportController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        return view('kurikulum.rapor.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $id)
            ->groupBy('semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('kurikulum.rapor.show', compact('siswa', 'raports'));
    }

    public function detail($id, $semester, $tahun)
    {
        $siswa = DataSiswa::findOrFail($id);

        // Konversi format tahun dari 2024-2025 ke 2024/2025
        $tahun_ajaran = str_replace('-', '/', $tahun);

        // Eager load mapel dengan relasi lainnya untuk menghindari N+1 query
        $nilaiRaports = NilaiRaport::with(['mapel', 'siswa'])
            ->where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->orderBy('mata_pelajaran_id')
            ->get();
        
        // Debug: Log jika tidak ada nilai yang ditemukan
        if ($nilaiRaports->isEmpty()) {
            \Log::warning('No NilaiRaport found', [
                'siswa_id' => $id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun_ajaran
            ]);
        }

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        $info = RaporInfo::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        $kenaikan = KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        return view('kurikulum.rapor.detail', compact(
            'siswa',
            'semester',
            'tahun',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'info',
            'kenaikan'
        ));
    }
}