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
use App\Exports\NilaiRaportTemplate;
use App\Exports\LegerTemplate;
use App\Imports\NilaiRaportImport;
use App\Imports\LegerImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class InputNilaiRaportController extends Controller
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
        } else {
            // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
            $siswas = collect();
        }

        return view('walikelas.input_nilai_raport.index', compact('siswas', 'search'));
    }

    public function create($siswa_id)
    {
        $siswa = DataSiswa::findOrFail($siswa_id);

        // default: all mapel by kelompok
        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan');
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan');

        // jika siswa memiliki rombel->kelas, filter mapel berdasarkan tingkat angkatan
        if ($siswa->rombel && $siswa->rombel->kelas) {
            $currentKelas = $siswa->rombel->kelas;
            $currentTingkat = (string) $currentKelas->tingkat;
            $currentJurusanId = $currentKelas->jurusan_id ?? null;
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

            $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                $q->whereIn('tingkat', $opts);
            });

            $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                $q->whereIn('tingkat', $opts);
            });

            // filter by jurusan: include global (jurusan_id NULL) and subjects for the student's jurusan
            if ($currentJurusanId) {
                $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                    $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                });

                $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                    $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                });
            }
        }

        $kelompokA = $kelompokA->get();
        $kelompokB = $kelompokB->get();

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

        $siswa = DataSiswa::findOrFail($siswa_id);

        // --------------------------
        // SIMPAN NILAI MAPEL
        // --------------------------
        foreach ($req->nilai as $mapel_id => $row) {
            $where = [
                'siswa_id' => $siswa_id,
                'mata_pelajaran_id' => $mapel_id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun,
            ];

            $existing = NilaiRaport::where($where)->first();
            if ($existing) {
                $existing->nilai_akhir = $row['nilai_akhir'] ?? $existing->nilai_akhir;
                $existing->deskripsi = $row['deskripsi'] ?? $existing->deskripsi;
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
                    'semester' => $semester,
                    'tahun_ajaran' => $tahun,
                    'nilai_akhir' => $row['nilai_akhir'] ?? null,
                    'deskripsi' => $row['deskripsi'] ?? null,
                    'rombel_id' => $siswa->rombel_id ?? null,
                    'kelas_id' => $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null,
                ]);
            }
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
        // KENAIKAN KELAS (Rules)
        // - Jika semester Ganjil -> siswa tetap di kelas (tidak dipromosikan)
        // - Jika semester Genap  -> default dipromosikan (Naik Kelas) dan rombel tujuan dapat diset
        // --------------------------
        if ($req->has('kenaikan')) {
            if (strtolower($semester) === 'ganjil') {
                // enforce no promotion on ganjil: clear rombel tujuan
                KenaikanKelas::updateOrCreate(
                    [
                        'siswa_id'     => $siswa_id,
                        'semester'     => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'status'           => 'Tidak Naik',
                        'catatan'          => $req->kenaikan['catatan'] ?? null,
                        'rombel_tujuan_id' => null,
                    ]
                );
            } else {
                // Genap or other semesters: normalize status and persist; move student only on non-ganjil when status==Naik Kelas
                $raw = $req->kenaikan['status'] ?? 'Naik Kelas';
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
                        'siswa_id'     => $siswa_id,
                        'semester'     => $semester,
                        'tahun_ajaran' => $tahun,
                    ],
                    [
                        'status'           => $status,
                        'catatan'          => $req->kenaikan['catatan'] ?? null,
                        'rombel_tujuan_id' => $req->kenaikan['rombel_tujuan_id'] ?? null,
                    ]
                );

                // Apply actual move only when not Ganjil and status indicates promotion
                    if (strtolower($semester) !== 'ganjil' && $status === 'Naik Kelas') {
                        // prefer submitted target, fallback to saved kenaikan record
                        $target = $req->kenaikan['rombel_tujuan_id'] ?? ($kenaikan->rombel_tujuan_id ?? null);
                        if ($target) {
                            $s = DataSiswa::find($siswa_id);
                            if ($s) {
                                $s->rombel_id = $target;
                                $s->save();
                            }
                        }
                    }
            }
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

        // default: all mapel by kelompok, but prefer filtering by siswa rombel->kelas->tingkat
        $kelompokA = MataPelajaran::where('kelompok','A')->orderBy('urutan');
        $kelompokB = MataPelajaran::where('kelompok','B')->orderBy('urutan');

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $currentKelas = $siswa->rombel->kelas;
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

            $opts = [(string)$currentTingkat];
            $cur = $toInt($currentTingkat);
            if ($cur !== null) {
                $opts[] = (string) $cur;
                $opts[] = $fromInt($cur);
            }
            $opts = array_values(array_unique(array_filter($opts)));

            $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                $q->whereIn('tingkat', $opts);
            });
            $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                $q->whereIn('tingkat', $opts);
            });

            if ($currentJurusanId) {
                $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                    $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                });
                $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                    $q->whereNull('jurusan_id')->orWhere('jurusan_id', $currentJurusanId);
                });
            }
        }

        $kelompokA = $kelompokA->get();
        $kelompokB = $kelompokB->get();

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

    public function destroy(Request $req, $siswa_id)
    {
        $semester = $req->semester ?? $req->input('semester');
        $tahun = $req->tahun_ajaran ?? $req->input('tahun_ajaran') ?? $req->input('tahun');

        if (!$semester || !$tahun) {
            return redirect()->back()->with('error', 'Parameter semester atau tahun ajaran diperlukan untuk menghapus.');
        }

        // delete nilai mapel
        NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        // delete ekstra
        EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        // delete kehadiran
        Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        // delete rapor info
        RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        // delete kenaikan record for that semester/tahun
        KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->delete();

        return redirect()->route('walikelas.input_nilai_raport.index')
            ->with('success', 'Data raport berhasil dihapus untuk semester ' . $semester . ' tahun ' . $tahun);
    }

    /**
     * Download template leger untuk rombel tertentu
     */
    public function downloadTemplate(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
        ]);

        $user = Auth::user();
        $rombelId = $request->rombel_id;

        // Verify user memiliki akses ke rombel ini
        $rombel = Rombel::findOrFail($rombelId);
        $assigns = $user->waliKelas()->pluck('rombel_id')->toArray();
        
        if (!in_array($rombelId, $assigns)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke rombel ini');
        }

        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;

        // Sanitize filename - remove "/" and "\" characters
        $rombelName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $rombel->nama);
        $tahunAjaranClean = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $tahunAjaran);

        $export = new LegerTemplate($rombelId, $semester, $tahunAjaran);
        $filename = "Leger_{$rombelName}_Sem{$semester}_{$tahunAjaranClean}.xlsx";

        return Excel::download($export, $filename);
    }

    /**
     * Import data leger dari file Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $user = Auth::user();
        $rombelId = $request->rombel_id;

        // Verify user memiliki akses ke rombel ini
        $rombel = Rombel::findOrFail($rombelId);
        $assigns = $user->waliKelas()->pluck('rombel_id')->toArray();
        
        if (!in_array($rombelId, $assigns)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke rombel ini');
        }

        try {
            $semester = $request->semester;
            $tahunAjaran = $request->tahun_ajaran;

            $import = new LegerImport($rombelId, $semester, $tahunAjaran);
            Excel::import($import, $request->file('file'));

            if ($import->hasErrors()) {
                $errorMsg = 'Import berhasil namun ada beberapa warning: ' . implode(', ', $import->getErrors());
                return redirect()->route('walikelas.input_nilai_raport.index')
                    ->with('warning', $errorMsg);
            }

            return redirect()->route('walikelas.input_nilai_raport.index')
                ->with('success', 'Data leger berhasil diimport untuk rombel ' . $rombel->nama);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
