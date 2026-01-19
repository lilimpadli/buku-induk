<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1. FORM INPUT NILAI
    |--------------------------------------------------------------------------
    */
    public function formNilai($siswa_id)
    {
        $siswa = DataSiswa::findOrFail($siswa_id);

        $mapel = MataPelajaran::orderBy('kelompok')
            ->orderBy('urutan')
            ->get();

        return view('rapor.input-nilai', compact('siswa', 'mapel'));
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN NILAI RAPOR
    |--------------------------------------------------------------------------
    */
    public function simpanNilai(Request $req, $siswa_id)
    {
        $req->validate([
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nilai' => 'required|array'
        ]);

        $siswa = DataSiswa::findOrFail($siswa_id);

        foreach ($req->nilai as $mapel_id => $nilaiAkhir) {
            $where = [
                'siswa_id' => $siswa_id,
                'mata_pelajaran_id' => $mapel_id,
                'semester' => $req->semester,
                'tahun_ajaran' => $req->tahun_ajaran,
            ];

            $existing = NilaiRaport::where($where)->first();
            if ($existing) {
                $existing->nilai_akhir = $nilaiAkhir;
                $existing->deskripsi = $req->deskripsi[$mapel_id] ?? $existing->deskripsi;
                if (empty($existing->rombel_id)) {
                    $existing->rombel_id = $siswa->rombel_id ?? null;
                }
                if (empty($existing->kelas_id)) {
                    $existing->kelas_id = $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null;
                }
                $existing->save();
            } else {
                NilaiRaport::create([
                    'siswa_id' => $siswa_id,
                    'mata_pelajaran_id' => $mapel_id,
                    'semester' => $req->semester,
                    'tahun_ajaran' => $req->tahun_ajaran,
                    'nilai_akhir' => $nilaiAkhir,
                    'deskripsi' => $req->deskripsi[$mapel_id] ?? null,
                    'rombel_id' => $siswa->rombel_id ?? null,
                    'kelas_id' => $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null,
                ]);
            }
        }

        return back()->with('success', 'Nilai rapor berhasil disimpan.');
    }


    /*
    |--------------------------------------------------------------------------
    | 2. INPUT EKSTRAKURIKULER
    |--------------------------------------------------------------------------
    */
    public function simpanEkstra(Request $req, $siswa_id)
    {
        $req->validate([
            'nama_ekstra' => 'required',
            'predikat'    => 'required',
        ]);

        EkstrakurikulerSiswa::updateOrCreate(
            [
                'siswa_id' => $siswa_id,
                'nama_ekstra' => $req->nama_ekstra,
            ],
            [
                'predikat' => $req->predikat,
                'keterangan' => $req->keterangan,
            ]
        );

        return back()->with('success', 'Ekstrakurikuler berhasil disimpan.');
    }


    /*
    |--------------------------------------------------------------------------
    | 3. INPUT KEHADIRAN
    |--------------------------------------------------------------------------
    */
    public function simpanKehadiran(Request $req, $siswa_id)
    {
        $req->validate([
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        Kehadiran::updateOrCreate(
            [
                'siswa_id' => $siswa_id,
                'semester' => $req->semester,
                'tahun_ajaran' => $req->tahun_ajaran,
            ],
            [
                'sakit' => $req->sakit ?? 0,
                'izin' => $req->izin ?? 0,
                'tanpa_keterangan' => $req->tanpa_keterangan ?? 0,
            ]
        );

        return back()->with('success', 'Kehadiran berhasil disimpan.');
    }


    /*
    |--------------------------------------------------------------------------
    | 4. INPUT INFO RAPOR
    |--------------------------------------------------------------------------
    */
    public function simpanInfoRapor(Request $req, $siswa_id)
    {
        $req->validate([
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'wali_kelas' => 'required',
            'kepala_sekolah' => 'required',
        ]);

        RaporInfo::updateOrCreate(
            [
                'siswa_id' => $siswa_id,
                'semester' => $req->semester,
                'tahun_ajaran' => $req->tahun_ajaran,
            ],
            [
                'wali_kelas' => $req->wali_kelas,
                'nip_wali' => $req->nip_wali,
                'kepala_sekolah' => $req->kepala_sekolah,
                'nip_kepsek' => $req->nip_kepsek,
                'tanggal_rapor' => $req->tanggal_rapor,
            ]
        );

        return back()->with('success', 'Info rapor berhasil disimpan.');
    }


    /*
    |--------------------------------------------------------------------------
    | 5. CETAK RAPOR
    |--------------------------------------------------------------------------
    */
    public function cetakRapor($siswa_id, $semester, $tahun)
    {
        // normalize tahun parameter: allow links that use '-' instead of '/' (e.g. 2025-2026)
        $tahun = str_replace('-', '/', $tahun);

        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilai = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy(
                MataPelajaran::select('urutan')
                    ->whereColumn('mata_pelajarans.id', 'nilai_raports.mata_pelajaran_id')
            )
            ->get();

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)->get();
        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)->where('semester', $semester)->first();
        $info = RaporInfo::where('siswa_id', $siswa_id)->where('semester', $semester)->first();

        $pdf = Pdf::loadView('rapor.cetak', compact('siswa', 'nilai', 'ekstra', 'kehadiran', 'info', 'semester', 'tahun'));

        // Sanitize filename for HTTP header: replace backslash and slash with '-'
        $safeName = str_replace(['\\', '/'], '-', $siswa->nama_lengkap);
        $safeTahun = str_replace(['\\', '/'], '-', $tahun);
        $filename = 'Raport - ' . $safeName . ' - ' . $semester . ' - ' . $safeTahun . '.pdf';

        return $pdf->stream($filename);
    }


    /*
    |--------------------------------------------------------------------------
    | 6. DASHBOARD WALI KELAS
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $siswa = DataSiswa::orderBy('nama_lengkap')->get();

        return view('walikelas.dashboard', [
            'siswa'        => $siswa,
            'totalSiswa'   => $siswa->count(),
            'nilaiTerisi'  => NilaiRaport::count(),
            'belumTerisi'  => max(
                $siswa->count() - NilaiRaport::select('siswa_id')->distinct()->count(),
                0
            ),
            'ekstraTerisi' => EkstrakurikulerSiswa::count(),
        ]);
    }
}
