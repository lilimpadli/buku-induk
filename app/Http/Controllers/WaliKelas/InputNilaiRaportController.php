<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use App\Models\Rombel;
use Illuminate\Http\Request;

class InputNilaiRaportController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        return view('walikelas.input_nilai_raport.index', compact('siswas'));
    }

    public function create($siswa_id)
    {
        $siswa = DataSiswa::findOrFail($siswa_id);

        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan')->get();
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan')->get();

        return view('walikelas.input_nilai_raport.create', compact(
            'siswa', 'kelompokA', 'kelompokB'
        ));
    }

    public function store(Request $req, $siswa_id)
    {
        $req->validate([
            'semester'      => 'required',
            'tahun_ajaran'  => 'required',
            'nilai'         => 'required|array'
        ]);

        $semester = $req->semester;
        $tahun    = $req->tahun_ajaran;

        // SIMPAN NILAI MAPEL
        foreach ($req->nilai as $mapel_id => $row) {
            NilaiRaport::updateOrCreate(
                [
                    'siswa_id'          => $siswa_id,
                    'mata_pelajaran_id' => $mapel_id,
                    'semester'          => $semester,
                    'tahun_ajaran'      => $tahun,
                ],
                [
                    'nilai_akhir' => $row['nilai_akhir'] ?? null,
                    'deskripsi'   => $row['deskripsi'] ?? null,
                ]
            );
        }

        // SIMPAN EKSTRA
        if ($req->has('ekstra')) {
            foreach ($req->ekstra as $item) {
                if (empty($item['nama_ekstra'])) continue;

                EkstrakurikulerSiswa::updateOrCreate(
                    [
                        'siswa_id'     => $siswa_id,
                        'semester'     => $semester,
                        'tahun_ajaran' => $tahun,
                        'nama_ekstra'  => $item['nama_ekstra'],
                    ],
                    [
                        'predikat'   => $item['predikat'] ?? null,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]
                );
            }
        }

        // KEHADIRAN
        Kehadiran::updateOrCreate(
            [
                'siswa_id'     => $siswa_id,
                'semester'     => $semester,
                'tahun_ajaran' => $tahun,
            ],
            [
                'sakit'             => $req->hadir['sakit'] ?? 0,
                'izin'              => $req->hadir['izin'] ?? 0,
                'tanpa_keterangan'  => $req->hadir['alpa'] ?? 0,
            ]
        );

        // INFO RAPOR
        RaporInfo::updateOrCreate(
            [
                'siswa_id'     => $siswa_id,
                'semester'     => $semester,
                'tahun_ajaran' => $tahun,
            ],
            [
                'wali_kelas'     => $req->info['wali_kelas'] ?? null,
                'nip_wali'       => $req->info['nip_wali'] ?? null,
                'kepala_sekolah' => $req->info['kepsek'] ?? null,
                'nip_kepsek'     => $req->info['nip_kepsek'] ?? null,
                'tanggal_rapor'  => $req->info['tanggal_rapor'] ?? null,
            ]
        );

        // KENAIKAN
        if ($req->has('kenaikan')) {
            KenaikanKelas::updateOrCreate(
                [
                    'siswa_id'     => $siswa_id,
                    'semester'     => $semester,
                    'tahun_ajaran' => $tahun,
                ],
                [
                    'status'            => $req->kenaikan['status'] ?? 'Belum Ditentukan',
                    'catatan'           => $req->kenaikan['catatan'] ?? null,
                    'rombel_tujuan_id'  => $req->kenaikan['rombel_tujuan_id'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('walikelas.input_nilai_raport.index')
            ->with('success', 'Rapor berhasil disimpan!');
    }

    public function list($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $id)
            ->groupBy('semester','tahun_ajaran')
            ->orderBy('tahun_ajaran','desc')
            ->orderBy('semester','desc')
            ->get();

        return view('walikelas.nilai_raport.list', compact('siswa','raports'));
    }

    public function edit(Request $req, $siswa_id)
    {
        $semester = $req->semester;
        $tahun    = $req->tahun_ajaran;

        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilai = NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get()
            ->keyBy('mata_pelajaran_id');

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

        $kenaikan = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kelompokA = MataPelajaran::where('kelompok','A')->orderBy('urutan')->get();
        $kelompokB = MataPelajaran::where('kelompok','B')->orderBy('urutan')->get();

        // 🔥 WAJIB DITAMBAHKAN → FIX ERROR
        $rombels = Rombel::orderBy('nama')->get();

        return view('walikelas.input_nilai_raport.edit', compact(
            'siswa', 'nilai', 'ekstra', 'kehadiran', 'info',
            'kenaikan', 'kelompokA', 'kelompokB', 'semester', 'tahun', 'rombels'
        ));
    }
}
