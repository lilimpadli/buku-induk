<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use App\Models\Rombel;
use App\Exports\NilaiRaportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KurikulumRaportController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        return view('kurikulum.siswa.rapor.index', compact('siswas'));
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

        return view('kurikulum.siswa.rapor.show', compact('siswa', 'raports'));
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
            Log::warning('No NilaiRaport found', [
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

        // Get rombel raport dari NilaiRaport jika ada
        $rombelRaport = NilaiRaport::where('siswa_id', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->with('rombel')
            ->first()
            ?->rombel;

        return view('kurikulum.siswa.rapor.detail', compact(
            'siswa',
            'semester',
            'tahun',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'info',
            'kenaikan',
            'rombelRaport'
        ));
    }

    /**
     * Export rapor sebagai PDF
     */
    public function exportPdf($siswa_id, $semester, $tahun)
    {
        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, 'Parameter tidak lengkap.');
        }

        // convert tahun from URL-safe format (e.g. 2025-2026) back to stored format (2025/2026)
        $tahun_ajaran = str_replace('-', '/', $tahun);

        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel', 'rombel.kelas'])->findOrFail($siswa_id);

        // Eager load mapel dengan relasi lainnya untuk menghindari N+1 query
        $nilaiRaports = NilaiRaport::with(['mapel', 'siswa'])
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->orderBy('mata_pelajaran_id')
            ->get();

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        $kenaikan = KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        // Get rombel raport dari NilaiRaport jika ada
        $rombelRaport = NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->with('rombel')
            ->first()
            ?->rombel;

        // Render PDF dari template view
        $pdf = Pdf::loadView('kurikulum.siswa.rapor.pdf', [
            'siswa'         => $siswa,
            'nilaiRaports'  => $nilaiRaports,
            'ekstra'        => $ekstra,
            'kehadiran'     => $kehadiran,
            'info'          => $info,
            'kenaikan'      => $kenaikan,
            'rombelRaport'  => $rombelRaport,
            'tahun'         => $tahun_ajaran,
            'semester'      => $semester,
        ]);

        // Download PDF
        return $pdf->download('Raport_' . $siswa->nama_lengkap . '_' . $semester . '_' . str_replace('/', '-', $tahun_ajaran) . '.pdf');
    }

    /**
     * Export rapor sebagai HTML untuk review
     */
    public function show_html($siswa_id, $semester, $tahun)
    {
        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, 'Parameter tidak lengkap.');
        }

        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel', 'rombel.kelas'])->findOrFail($siswa_id);

        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $siswa_id)
            ->groupBy('semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('kurikulum.siswa.rapor.show', compact('siswa', 'raports'));
    }
}