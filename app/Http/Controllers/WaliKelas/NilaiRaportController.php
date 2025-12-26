<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiRaportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil daftar rombel yang dia pegang sebagai wali kelas
        $rombelsIds = [];
        if ($user) {
            $assigns = $user->waliKelas()->get();
            foreach ($assigns as $a) {
                // jika kolom rombel_id ada dan terisi, gunakan itu
                if (isset($a->rombel_id) && $a->rombel_id) {
                    $rombelsIds[] = $a->rombel_id;
                    continue;
                }

                // jika rombel_id tidak tersedia di tabel, gunakan kelas_id untuk ambil rombel terkait
                if (isset($a->kelas_id) && $a->kelas_id) {
                    $r = Rombel::where('kelas_id', $a->kelas_id)->pluck('id')->toArray();
                    $rombelsIds = array_merge($rombelsIds, $r);
                    continue;
                }

                // (tidak menggunakan fallback jurusan karena terlalu luas)
            }

            $rombelsIds = array_values(array_unique(array_filter($rombelsIds)));
        }

        if (!empty($rombelsIds)) {
            $siswas = DataSiswa::with('rombel')
                ->whereIn('rombel_id', $rombelsIds)
                ->orderBy('nama_lengkap')
                ->get()
                ->groupBy(function($siswa) {
                    return $siswa->rombel ? $siswa->rombel->nama : 'Tidak ada rombel';
                });
        } else {
            // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
            $siswas = collect();
        }

        return view('walikelas.nilai_raport.index', compact('siswas'));
    }

    public function exportPdf($siswa_id, $semester, $tahun)
    {
        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, 'Parameter tidak lengkap.');
        }

        // convert tahun from URL-safe format (e.g. 2025-2026) back to stored format (2025/2026)
        $tahun = str_replace('-', '/', $tahun);

        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        if ($nilaiRaports->isEmpty()) {
            return redirect()->route('walikelas.nilai_raport.list', $siswa->id)
                ->with('error', 'Data raport untuk semester ' . $semester . ' tahun ajaran ' . $tahun . ' tidak ditemukan');
        }

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $pdf = Pdf::loadView('walikelas.nilai_raport.pdf', compact(
            'siswa', 'semester', 'tahun', 'nilaiRaports', 'ekstra', 'kehadiran', 'info', 'kenaikan'
        ))->setPaper('A4', 'portrait');

        $safeNama = str_replace(['/', '\\'], '-', $siswa->nama_lengkap);
        $safeTahun = str_replace(['/', '\\'], '-', $tahun);
        $filename = 'Raport - ' . $safeNama . ' - ' . $semester . ' - ' . $safeTahun . '.pdf';

        return $pdf->stream($filename);
    }

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

    public function show(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahun = $request->tahun;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
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

    public function edit(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahun = $request->tahun;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        // Ambil semua mapel
        $mapel = MataPelajaran::orderBy('urutan')->get();
        $kelompokA = $mapel->where('kelompok', 'A');
        $kelompokB = $mapel->where('kelompok', 'B');

        // Ambil nilai & mapping berdasarkan mapel ID
        $nilai = NilaiRaport::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get()
            ->keyBy('mata_pelajaran_id');

        // Ambil data lain
        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        // Ambil semua rombel untuk dropdown kenaikan kelas
        $rombels = Rombel::orderBy('nama')->get();

        return view('walikelas.nilai_raport.edit', compact(
            'siswa',
            'semester',
            'tahun',
            'nilai',
            'kelompokA',
            'kelompokB',
            'ekstra',
            'kehadiran',
            'info',
            'kenaikan',
            'rombels'
        ));
    }

    public function update(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahun = $request->tahun;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        /* ================================
       UPDATE NILAI MAPEL
    ==================================*/
        if ($request->nilai) {
            foreach ($request->nilai as $mapel_id => $value) {
                NilaiRaport::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mapel_id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'nilai_akhir' => $value['nilai_akhir'] ?? null,
                        'deskripsi'   => $value['deskripsi'] ?? null,
                    ]
                );
            }
        }

        /* ================================
       UPDATE EKSTRAKURIKULER
    ==================================*/
        if ($request->ekstra) {
            foreach ($request->ekstra as $data) {
                // Skip jika nama ekstra kosong
                if (!$data['nama_ekstra']) continue;

                EkstrakurikulerSiswa::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'nama_ekstra' => $data['nama_ekstra'],
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'predikat' => $data['predikat'] ?? null,
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );
            }
        }

        /* ================================
       UPDATE KEHADIRAN
    ==================================*/
        Kehadiran::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun,
            ],
            [
                'sakit' => $request->hadir['sakit'] ?? 0,
                'izin'  => $request->hadir['izin'] ?? 0,
                'tanpa_keterangan' => $request->hadir['alpa'] ?? 0,
            ]
        );

        /* ================================
       UPDATE INFO RAPOR
    ==================================*/
        RaporInfo::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun,
            ],
            [
                'wali_kelas' => $request->info['wali_kelas'] ?? '',
                'nip_wali' => $request->info['nip_wali'] ?? '',
                'kepala_sekolah' => $request->info['kepsek'] ?? '',
                'nip_kepsek' => $request->info['nip_kepsek'] ?? '',
                'tanggal_rapor' => $request->info['tanggal_rapor'] ?? date('Y-m-d'),
            ]
        );

        /* ================================
        UPDATE KENAIKAN KELAS
    ==================================*/
        KenaikanKelas::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun,
            ],
            [
                'status' => $request->kenaikan['status'] ?? '-',
                'rombel_tujuan_id' => $request->kenaikan['rombel_tujuan_id'] ?? null,
                'catatan' => $request->kenaikan['catatan'] ?? '',
            ]
        );

        return redirect()->route('walikelas.nilai_raport.show', [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun' => $tahun
        ])->with('success', 'Rapor berhasil diperbarui!');
    }
}
