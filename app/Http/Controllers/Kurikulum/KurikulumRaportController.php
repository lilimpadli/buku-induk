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

        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
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