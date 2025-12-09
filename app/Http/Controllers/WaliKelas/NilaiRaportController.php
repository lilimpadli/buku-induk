<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiRaportController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        return view('walikelas.nilai_raport.index', compact('siswas'));
    }

    // =============================
    // SHOW RAPOR BERDASARKAN SEMESTER & TAHUN
    // =============================
    public function show(Request $req, $siswa_id)
    {
        $semester = $req->semester;
        $tahun    = $req->tahun;

        if (!$semester || !$tahun) {
            abort(404, "Semester atau tahun ajaran tidak ditemukan.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        // NILAI
        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        // EKSTRA
        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        // KEHADIRAN
        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        // INFO RAPOR
        $info = RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        // KENAIKAN KELAS
        $kenaikan = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        return view('walikelas.nilai_raport.show', compact(
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

    // REVIEW (TANPA FILTER — OPSIONAL)
    public function review($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $nilaiRaports = NilaiRaport::where('siswa_id', $id)->get();
        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $id)->get();
        $kehadiran = Kehadiran::where('siswa_id', $id)->first();
        $kenaikan = KenaikanKelas::where('siswa_id', $id)->first();

        return view('walikelas.nilai_raport.review', compact(
            'siswa', 'nilaiRaports', 'ekstra', 'kehadiran', 'kenaikan'
        ));
    }

    // EXPORT PDF (SUDAH PAKE FILTER)
    public function exportPdf(Request $req, $id)
    {
        $semester = $req->semester;
        $tahun    = $req->tahun;

        $siswa = DataSiswa::findOrFail($id);

        $nilaiRaports = NilaiRaport::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $pdf = Pdf::loadView('walikelas.nilai_raport.pdf', [
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun' => $tahun,
            'nilaiRaports' => $nilaiRaports
        ]);

        return $pdf->stream("Raport_{$siswa->nama_lengkap}.pdf");
    }

    // LIST HISTORY
    public function list($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $id)
            ->groupBy('semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('walikelas.nilai_raport.list', compact('siswa', 'raports'));
    }
}
