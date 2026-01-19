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
use App\Models\Jurusan;
use App\Exports\NilaiRaportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class NilaiRaportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('q');

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
            $query = DataSiswa::with('rombel')
                ->whereIn('rombel_id', $rombelsIds)
                ->when($search, function($q) use ($search) {
                    $like = '%' . $search . '%';
                    return $q->where(function($qq) use ($like) {
                        $qq->where('nama_lengkap', 'like', $like)
                           ->orWhere('nis', 'like', $like)
                           ->orWhere('nisn', 'like', $like);
                    });
                })
                ->orderBy('nama_lengkap');

            $siswas = $query->get()->groupBy(function($siswa) {
                return $siswa->rombel ? $siswa->rombel->nama : 'Tidak ada rombel';
            });

            // Get available tahun ajaran and semester for the modal
            $tahunAjaranList = NilaiRaport::whereIn('siswa_id', $query->pluck('id'))
                ->distinct()
                ->orderBy('tahun_ajaran', 'desc')
                ->pluck('tahun_ajaran')
                ->toArray();

            $semesterList = NilaiRaport::whereIn('siswa_id', $query->pluck('id'))
                ->distinct()
                ->orderBy('semester', 'asc')
                ->pluck('semester')
                ->toArray();
        } else {
            // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
            $siswas = collect();
            $tahunAjaranList = [];
            $semesterList = [];
        }

        return view('walikelas.nilai_raport.index', compact('siswas', 'search', 'tahunAjaranList', 'semesterList'));
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('q');
        $semester = $request->query('semester');
        $tahunAjaran = $request->query('tahun_ajaran');

        // Validasi semester dan tahun ajaran
        if (!$semester || !$tahunAjaran) {
            return back()->with('error', 'Semester dan Tahun Ajaran harus dipilih.');
        }

        // ambil daftar rombel yang dia pegang sebagai wali kelas (sama seperti di index)
        $rombelsIds = [];
        if ($user) {
            $assigns = $user->waliKelas()->get();
            foreach ($assigns as $a) {
                if (isset($a->rombel_id) && $a->rombel_id) {
                    $rombelsIds[] = $a->rombel_id;
                    continue;
                }

                if (isset($a->kelas_id) && $a->kelas_id) {
                    $r = Rombel::where('kelas_id', $a->kelas_id)->pluck('id')->toArray();
                    $rombelsIds = array_merge($rombelsIds, $r);
                    continue;
                }
            }

            $rombelsIds = array_values(array_unique(array_filter($rombelsIds)));
        }

        if (empty($rombelsIds)) {
            return back()->with('error', 'Tidak ada kelas yang ditugaskan untuk Anda.');
        }

        $filename = 'Ledger_Nilai_Raport_' . $semester . '_' . str_replace('/', '-', $tahunAjaran) . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new NilaiRaportExport($rombelsIds, $search, $semester, $tahunAjaran),
            $filename
        );
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

        // default: all mapel by kelompok, but prefer filtering by siswa rombel->kelas->tingkat
        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan');
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan');

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $currentKelas = $siswa->rombel->kelas;
            $currentTingkat = (string) $currentKelas->tingkat;
            $currentJurusanId = $currentKelas->jurusan_id ?? null;

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

            $opts = [(string)$currentTingkat];
            $cur = $toInt($currentTingkat);
            if ($cur !== null) {
                $opts[] = (string) $cur;
                $opts[] = $fromInt($cur);
            }
            $opts = array_values(array_unique(array_filter($opts)));

            if (class_exists(\App\Models\MataPelajaranTingkat::class)) {
                try {
                    $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });
                    $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });

                    if (!empty($currentJurusanId)) {
                        $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                        $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                    }
                } catch (\Exception $e) {
                    // if tingkats relation or schema is incompatible, skip filtering
                }
            }
        }

        $kelompokA = $kelompokA->get();
        $kelompokB = $kelompokB->get();

        // map existing nilai by mapel id for quick lookup in view
        $nilaiMap = $nilaiRaports->keyBy('mata_pelajaran_id');

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
            'siswa', 'semester', 'tahun', 'nilaiRaports', 'kelompokA', 'kelompokB', 'nilaiMap', 'ekstra', 'kehadiran', 'info', 'kenaikan'
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
    $tahun    = str_replace('-', '/', $request->tahun);

    // ambil siswa
    $siswa = DataSiswa::findOrFail($siswa_id);

    // ambil nilai raport
    $nilaiRaports = NilaiRaport::with(['mapel', 'kelas', 'rombel'])
        ->where('siswa_id', $siswa_id)
        ->where('semester', $semester)
        ->where('tahun_ajaran', $tahun)
        ->get();

    if ($nilaiRaports->isEmpty()) {
        abort(404);
    }

    // Try to get kelas/tingkat from the first raport row; fallback to siswa->rombel->kelas
    $firstRaport = $nilaiRaports->first();
    $kelasRaport = null;
    $rombelRaport = null;
    if ($firstRaport) {
        if (isset($firstRaport->kelas) && $firstRaport->kelas) {
            $kelasRaport = $firstRaport->kelas;
        }
        if (isset($firstRaport->rombel) && $firstRaport->rombel) {
            $rombelRaport = $firstRaport->rombel;
        }
    }

    if (!$kelasRaport && $siswa->rombel && $siswa->rombel->kelas) {
        $kelasRaport = $siswa->rombel->kelas;
    }
    if (!$rombelRaport && $siswa->rombel) {
        $rombelRaport = $siswa->rombel;
    }

    $tingkat = $kelasRaport ? (string) $kelasRaport->tingkat : null;
    $currentJurusanId = $kelasRaport->jurusan_id ?? ($siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->jurusan_id : null);

    // Build kelompok lists filtered by tingkat and jurusan via relation 'tingkats' if available
    $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan');
    $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan');

            if ($tingkat && class_exists(\App\Models\MataPelajaranTingkat::class)) {
                try {
                    $opts = [ (string) $tingkat ];
                    $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });
                    $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });

                    if (!empty($currentJurusanId)) {
                        $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                        $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                    }
                } catch (\Exception $e) {
                    // skip filtering if schema differs
                }
            }

    $kelompokA = $kelompokA->get();
    $kelompokB = $kelompokB->get();

    // map existing nilai by mapel id for quick lookup in view
    $nilaiMap = $nilaiRaports->keyBy('mata_pelajaran_id');

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

    return view('walikelas.nilai_raport.show', compact(
        'siswa',
        'semester',
        'tahun',
        'kelasRaport',
        'nilaiRaports',
        'kelompokA',
        'kelompokB',
        'nilaiMap',
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

        // Ambil nilai raport (koleksi) dan mapping berdasarkan mapel ID
        $nilaiRaports = NilaiRaport::with(['kelas', 'mapel'])
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $nilai = $nilaiRaports->keyBy('mata_pelajaran_id');

        // default: all mapel by kelompok, but prefer filtering by siswa rombel->kelas->tingkat
        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan');
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan');

          if ($siswa->rombel && $siswa->rombel->kelas) {
              $kelasRaport = $nilaiRaports->first()->kelas;
              $tingkat = (string) $kelasRaport->tingkat;
              $currentJurusanId = $kelasRaport->jurusan_id ?? null;

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

            $opts = [(string)$tingkat];
            $cur = $toInt($tingkat);
            if ($cur !== null) {
                $opts[] = (string) $cur;
                $opts[] = $fromInt($cur);
            }
            $opts = array_values(array_unique(array_filter($opts)));

            if (class_exists(\App\Models\MataPelajaranTingkat::class)) {
                try {
                    $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });
                    $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });

                    if (!empty($currentJurusanId)) {
                        $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                        $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                            $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                        });
                    }
                } catch (\Exception $e) {
                    // skip filtering if Tingkat model/schema unavailable
                }
            }
        }

        $kelompokA = $kelompokA->get();
        $kelompokB = $kelompokB->get();

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
            'rombels',
            'jurusans',
            'rombelsFiltered',
            'currentJurusanId',
            'targetTingkat'
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
                $where = [
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mapel_id,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahun,
                ];

                $existing = NilaiRaport::where($where)->first();
                if ($existing) {
                    $existing->nilai_akhir = $value['nilai_akhir'] ?? $existing->nilai_akhir;
                    $existing->deskripsi = $value['deskripsi'] ?? $existing->deskripsi;
                    if (empty($existing->rombel_id)) {
                        $existing->rombel_id = $siswa->rombel_id ?? null;
                    }
                    if (empty($existing->kelas_id)) {
                        $existing->kelas_id = $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null;
                    }
                    $existing->save();
                } else {
                    NilaiRaport::create([
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mapel_id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                        'nilai_akhir' => $value['nilai_akhir'] ?? null,
                        'deskripsi' => $value['deskripsi'] ?? null,
                        'rombel_id' => $siswa->rombel_id ?? null,
                        'kelas_id' => $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null,
                    ]);
                }
            }
        }

        /* ================================
       UPDATE EKSTRAKURIKULER
    ==================================*/
        if ($request->ekstra) {
            foreach ($request->ekstra as $i => $data) {
                // Skip jika nama ekstra kosong
                if (!$data['nama_ekstra']) continue;

                EkstrakurikulerSiswa::updateOrCreate(
                    [
                        'id' => $data['id'] ?? null,
                    ],
                    [
                        'siswa_id' => $siswa->id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                        'nama_ekstra' => $data['nama_ekstra'],
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
        if ($request->has('kenaikan')) {
            if (strtolower($semester) === 'ganjil') {
                // enforce no promotion on ganjil: clear rombel tujuan
                KenaikanKelas::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'status' => 'Tidak Naik',
                        'catatan' => $request->kenaikan['catatan'] ?? null,
                        'rombel_tujuan_id' => null,
                    ]
                );
            } else {
                // Genap or other semesters: normalize status and persist; move student only on non-ganjil when status==Naik Kelas
                $raw = $request->kenaikan['status'] ?? 'Naik Kelas';
                $sNorm = strtolower(str_replace([' ', '_'], '', trim($raw)));
                if (in_array($sNorm, ['naik', 'naikkelas'])) {
                    $status = 'Naik Kelas';
                } elseif (in_array($sNorm, ['tidaknaik', 'tidak'])) {
                    $status = 'Tidak Naik';
                } elseif (in_array($sNorm, ['lulus', 'lulusan'])) {
                    $status = 'Lulus';
                } else {
                    $status = 'Naik Kelas';
                }

                $kenaikan = KenaikanKelas::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'status' => $status,
                        'catatan' => $request->kenaikan['catatan'] ?? null,
                        'rombel_tujuan_id' => $request->kenaikan['rombel_tujuan_id'] ?? null,
                    ]
                );

                // Apply actual move only when not Ganjil and status indicates promotion
                if (strtolower($semester) !== 'ganjil' && $status === 'Naik Kelas') {
                    // prefer the submitted rombel_tujuan_id, fallback to the saved kenaikan record
                    $target = $request->kenaikan['rombel_tujuan_id'] ?? ($kenaikan->rombel_tujuan_id ?? null);
                    if ($target) {
                        $s = DataSiswa::find($siswa->id);
                        if ($s) {
                            $s->rombel_id = $target;
                            $s->save();
                        }
                    }
                }
            }
        }

        return redirect()->route('walikelas.nilai_raport.show', [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun' => $tahun
        ])->with('success', 'Rapor berhasil diperbarui!');
    }
}