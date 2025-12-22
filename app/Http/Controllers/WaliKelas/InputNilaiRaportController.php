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
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputNilaiRaportController extends Controller
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

        return view('walikelas.input_nilai_raport.index', compact('siswas'));
    }

    public function create($siswa_id)
    {
        $siswa = DataSiswa::findOrFail($siswa_id);

        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan')->get();
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan')->get();

        // ambil jurusan + rombels beserta relasi kelas supaya bisa difilter per jurusan
        $jurusans = Jurusan::orderBy('nama')->get();
        $rombels = Rombel::with('kelas')->orderBy('nama')->get();

        // jika siswa punya rombel -> tentukan jurusan dan tingkat tujuan (naik kelas)
        $rombelsFiltered = collect();
        $currentJurusanId = null;
        $targetTingkat = null;

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $currentKelas = $siswa->rombel->kelas;
            $currentJurusanId = $currentKelas->jurusan_id;
            $currentTingkat = (string) $currentKelas->tingkat;

            // dukung angka dan romawi (X,XI,XII)
            $toInt = function($t) {
                $map = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8,'IX'=>9,'X'=>10,'XI'=>11,'XII'=>12];
                $tUp = strtoupper(trim($t));
                if (is_numeric($tUp)) return (int)$tUp;
                if (isset($map[$tUp])) return $map[$tUp];
                return null;
            };

            $fromInt = function($n) {
                $map = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
                return $map[$n] ?? (string)$n;
            };

            $cur = $toInt($currentTingkat);
            if ($cur !== null) {
                $targetInt = $cur + 1;
                $targetTingkat = $fromInt($targetInt);

                // filter rombels yang punya kelas dengan jurusan yang sama dan tingkat == target
                $rombelsFiltered = $rombels->filter(function($r) use ($currentJurusanId, $targetTingkat) {
                    return $r->kelas && $r->kelas->jurusan_id == $currentJurusanId && (string)$r->kelas->tingkat == (string)$targetTingkat;
                })->values();
            }
        }

        return view('walikelas.input_nilai_raport.create', compact(
            'siswa', 'kelompokA', 'kelompokB', 'rombels', 'jurusans', 'rombelsFiltered', 'currentJurusanId', 'targetTingkat'
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

        // --------------------------
        // SIMPAN NILAI MAPEL
        // --------------------------
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

        // --------------------------
        // SIMPAN EKSTRA — FIXED
        // --------------------------
        if ($req->has('ekstra')) {
            foreach ($req->ekstra as $i => $item) {

                if (empty($item['nama_ekstra'])) continue;

                EkstrakurikulerSiswa::updateOrCreate(
                    [
                        'id'           => $item['id'] ?? null, // aman saat edit
                    ],
                    [
                        'siswa_id'     => $siswa_id,
                        'semester'     => $semester,
                        'tahun_ajaran' => $tahun,
                        'nama_ekstra'  => $item['nama_ekstra'],
                        'predikat'     => $item['predikat'] ?? null,
                        'keterangan'   => $item['keterangan'] ?? null,
                    ]
                );
            }
        }

        // --------------------------
        // KEHADIRAN
        // --------------------------
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

        // --------------------------
        // INFO RAPOR
        // --------------------------
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

        // --------------------------
        // KENAIKAN KELAS
        // --------------------------
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

        $raports = NilaiRaport::select('semester','tahun_ajaran')
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

        // juga kirim jurusan + rombels + rombelsFiltered untuk edit
        $jurusans = Jurusan::orderBy('nama')->get();
        $rombels   = Rombel::with('kelas')->orderBy('nama')->get();

        // hitung rombelsFiltered sama seperti di create
        $rombelsFiltered = collect();
        $currentJurusanId = null;
        $targetTingkat = null;

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $currentKelas = $siswa->rombel->kelas;
            $currentJurusanId = $currentKelas->jurusan_id;
            $currentTingkat = (string) $currentKelas->tingkat;

            $toInt = function($t) {
                $map = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8,'IX'=>9,'X'=>10,'XI'=>11,'XII'=>12];
                $tUp = strtoupper(trim($t));
                if (is_numeric($tUp)) return (int)$tUp;
                if (isset($map[$tUp])) return $map[$tUp];
                return null;
            };
            $fromInt = function($n) {
                $map = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
                return $map[$n] ?? (string)$n;
            };

            $cur = $toInt($currentTingkat);
            if ($cur !== null) {
                $targetInt = $cur + 1;
                $targetTingkat = $fromInt($targetInt);
                $rombelsFiltered = $rombels->filter(function($r) use ($currentJurusanId, $targetTingkat) {
                    return $r->kelas && $r->kelas->jurusan_id == $currentJurusanId && (string)$r->kelas->tingkat == (string)$targetTingkat;
                })->values();
            }
        }

        return view('walikelas.input_nilai_raport.edit', compact(
            'siswa', 'nilai', 'ekstra', 'kehadiran', 'info',
            'kenaikan', 'kelompokA', 'kelompokB',
            'semester', 'tahun', 'rombels', 'jurusans', 'rombelsFiltered', 'currentJurusanId', 'targetTingkat'
        ));
    }
}
