<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Ayah;
use App\Models\Guru;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TUController extends Controller
{
    /**
     * Dashboard TU
     */
    public function dashboard()
    {
        // Statistik dasar
        $totalSiswa = DataSiswa::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalKelas = Kelas::count();
        
        // Inisialisasi variabel jurusan untuk menghindari error
        $jurusan = null;
        
        // Data aktivitas terbaru
        $aktivitas = [
            [
                'nama' => 'Ahmad Rizki',
                'kelas' => 'XII RPL 1',
                'aktivitas' => 'Penambahan data nilai',
                'waktu' => '2 jam yang lalu'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'XI TKJ 2',
                'aktivitas' => 'Update profil siswa',
                'waktu' => '5 jam yang lalu'
            ],
            [
                'nama' => 'Budi Santoso',
                'kelas' => 'X MM 1',
                'aktivitas' => 'Pengajuan pindah kelas',
                'waktu' => '1 hari yang lalu'
            ]
        ];
        
        // Data siswa terbaru
        $siswaBaru = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->latest()->take(5)->get();
        
        // Data wali kelas (untuk ditampilkan semua di bagian bawah)
        $waliKelas = User::where('role', 'walikelas')->get();
        
        // Data wali kelas dengan limit (untuk ringkasan)
        $waliKelasLimit = User::where('role', 'walikelas')->take(5)->get();
        
        // Data kelas dengan limit (untuk ringkasan)
        $kelasLimit = Kelas::with('jurusan')->take(5)->get();
        
        // Statistik nilai raport
        $totalNilai = NilaiRaport::count();
        $nilaiTerbaru = NilaiRaport::with('siswa')->latest()->take(5)->get();
        
        return view('tu.dashboard', compact(
            'totalSiswa', 
            'totalGuru',
            'totalWaliKelas',
            'totalKelas',
            'jurusan',
            'aktivitas',
            'siswaBaru',
            'waliKelas',
            'waliKelasLimit',
            'kelasLimit',
            'totalNilai',
            'nilaiTerbaru'
        ));
    }
    
    /**
     * Halaman daftar siswa
     */
    public function siswa()
    {
        $query = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->latest();

        $tingkat = request()->query('tingkat', null);
        if ($tingkat) {
            $query->whereHas('rombel.kelas', function ($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            });
        }

        // Search and rombel filters
        $search = request()->query('search', null);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $filterRombel = request()->query('rombel', null);
        if ($filterRombel) {
            $query->where('rombel_id', $filterRombel);
        }

        $allRombels = Rombel::with('kelas')->orderBy('nama')->get();

        $siswas = $query->paginate(10)->withQueryString();

        return view('tu.siswa.index', compact('siswas', 'search', 'allRombels', 'filterRombel'));
    }

    /**
     * Daftar guru untuk TU
     */
    public function guruIndex()
    {
        // Fetch a paginated list of all Guru models, with their associated User data
        // and the rombels they teach (including the rombel's kelas and jurusan).
        $search = request('search');
        $jurusan_id = request('jurusan');
        
        $gurus = Guru::with(['user', 'rombels.kelas.jurusan'])
            ->when($search, function($query) use($search) {
                $query->where(function($q) use($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('user', function($uq) use($search) {
                          $uq->where('email', 'like', "%{$search}%");
                      });
                });
            })
            ->when($jurusan_id, function($query) use($jurusan_id) {
                $query->where('jurusan_id', $jurusan_id);
            })
            // Order by kaprog role first, then by nama
            ->orderByRaw("FIELD(user_id, (SELECT id FROM users WHERE role = 'kaprog' AND id = user_id)) DESC, nama")
            ->paginate(10)
            ->withQueryString();

        $allJurusans = Jurusan::orderBy('nama')->get();

        return view('tu.guru.index', compact('gurus', 'search', 'jurusan_id', 'allJurusans'));
    }

    /**
     * Form tambah guru
     */
    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->get();

        $rombels = Rombel::with(['kelas.jurusan'])
            ->orderBy('nama')
            ->get();

        $kelasArr = $kelas->map(function($k){
            return [
                'value' => (string) $k->id,
                'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function($r){
            return [
                'value' => (string) $r->id,
                'text' => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'walikelas' => 'Guru',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu.guru.create', compact(
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    /**
     * Simpan guru (user + guru)
     */
    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:50|unique:users,nomor_induk',
            'nip' => 'required|string|max:30|unique:gurus,nip',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|unique:users,email',
            'telepon' => 'nullable|string|max:30',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // create user (use NIK as nomor_induk)
            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);

            // create guru record
            $guru = Guru::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'telepon' => $request->telepon ?? null,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'jurusan_id' => $request->jurusan_id,
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail guru
     */
    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu.guru.show', compact('guru'));
    }
    
    /**
     * Halaman tambah siswa
     */
    public function siswaCreate()
    {
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.siswa.create', compact('jurusans','rombels','kelas'));
    }
    
    /**
     * Simpan data siswa baru
     */
    public function nilaiRaportDestroy(Request $request)
    {
        // Minimal safe destroy: try to delete a NilaiRaport by id if provided.
        $id = $request->input('id') ?? $request->route('id') ?? null;
        if ($id) {
            try {
                NilaiRaport::find($id)?->delete();
            } catch (\Throwable $e) {
                // ignore errors to avoid breaking UI; log if needed
                \Log::error('Failed to delete NilaiRaport: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Data nilai raport berhasil dihapus');
    }

    /**
     * Simpan data siswa baru (minimal implementation)
     */
    public function siswaStore(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string|max:30|unique:data_siswa,nis',
            'nisn' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:L,P,Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        DB::beginTransaction();
        try {
            $siswa = DataSiswa::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'nis' => $data['nis'] ?? null,
                'nisn' => $data['nisn'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'tempat_lahir' => $data['tempat_lahir'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'rombel_id' => $data['rombel_id'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Halaman detail siswa
     */
    public function siswaDetail($id)
    {
        $siswa = DataSiswa::with(['user', 'nilaiRaports', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('tu.siswa.data-diri.show', compact('siswa'));
    }

    /**
     * Halaman raport siswa (TU)
     */
    public function siswaRaport($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        // list available raport semester/tahun for this siswa
        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $id)
            ->groupBy('semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('tu.siswa.raport.list', compact('siswa', 'raports'));
    }

    /**
     * Show a specific raport (TU view)
     */
    public function nilaiRaportShow(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilaiRaports = NilaiRaport::with(['mapel','kelas','rombel'])
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        if ($nilaiRaports->isEmpty()) {
            return redirect()->back()->with('error', 'Data raport tidak ditemukan');
        }

        // Derive historical kelas/rombel from NilaiRaport so the TU view
        // can display the class context as it was when the raport was recorded.
        $firstNilai = $nilaiRaports->first();
        $kelasRaport = $firstNilai->kelas ?? ($siswa->rombel->kelas ?? null);
        $rombelRaport = $firstNilai->rombel ?? ($siswa->rombel ?? null);

        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = \App\Models\RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = \App\Models\KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        // keep original route param formatting for route links
        return view('tu.siswa.raport.show', compact('siswa', 'semester', 'tahunParam', 'tahun', 'nilaiRaports', 'ekstra', 'kehadiran', 'info', 'kenaikan', 'kelasRaport', 'rombelRaport'));
    }

    /**
     * Edit raport (TU view)
     */
    public function nilaiRaportEdit(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

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
            // try derive kelas from existing raport rows; fallback to siswa->rombel->kelas
            $kelasRaport = $nilaiRaports->first()?->kelas ?? $siswa->rombel->kelas;
            $tingkat = $kelasRaport ? (string) $kelasRaport->tingkat : null;
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

            $opts = [$tingkat];
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

        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = \App\Models\RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = \App\Models\KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $rombels = Rombel::orderBy('nama')->get();

        return view('tu.siswa.raport.edit', compact('siswa','semester','tahunParam','tahun','nilai','kelompokA','kelompokB','ekstra','kehadiran','info','kenaikan','rombels','kelasRaport','rombelRaport'));
    }

    public function nilaiRaportUpdate(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? str_replace('-', '/', $tahunParam) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        if ($request->nilai) {
            foreach ($request->nilai as $mapel_id => $value) {
                $trimmedTahun = is_string($tahun) ? trim($tahun) : $tahun;
                $where = [
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mapel_id,
                    'semester' => $semester,
                    'tahun_ajaran' => $trimmedTahun,
                ];

                $existing = NilaiRaport::where($where)->first();

                $hasNilai = isset($value['nilai_akhir']) && $value['nilai_akhir'] !== '';
                $hasDeskripsi = isset($value['deskripsi']) && $value['deskripsi'] !== '';

                if (!$existing && !$hasNilai && !$hasDeskripsi) {
                    continue;
                }

                if ($existing) {
                    $existing->nilai_akhir = $hasNilai ? $value['nilai_akhir'] : ($existing->nilai_akhir ?? null);
                    $existing->deskripsi = $hasDeskripsi ? $value['deskripsi'] : ($existing->deskripsi ?? null);
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
                        'tahun_ajaran' => $trimmedTahun,
                        'nilai_akhir' => $hasNilai ? $value['nilai_akhir'] : null,
                        'deskripsi' => $hasDeskripsi ? $value['deskripsi'] : null,
                        'rombel_id' => $siswa->rombel_id ?? null,
                        'kelas_id' => $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null,
                    ]);
                }
            }
        }

        if ($request->ekstra) {
            foreach ($request->ekstra as $data) {
                if (empty($data['nama_ekstra'])) continue;

                \App\Models\EkstrakurikulerSiswa::updateOrCreate(
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

        $whereKehadiran = [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
        ];

        $existingKehadiran = \App\Models\Kehadiran::where($whereKehadiran)->first();
        $hadir = $request->hadir ?? [];

        $sakit = isset($hadir['sakit']) && $hadir['sakit'] !== '' ? $hadir['sakit'] : ($existingKehadiran->sakit ?? 0);
        $izin  = isset($hadir['izin']) && $hadir['izin'] !== '' ? $hadir['izin'] : ($existingKehadiran->izin ?? 0);
        $alpa  = isset($hadir['alpa']) && $hadir['alpa'] !== '' ? $hadir['alpa'] : ($existingKehadiran->tanpa_keterangan ?? 0);

        \App\Models\Kehadiran::updateOrCreate($whereKehadiran, [
            'sakit' => $sakit,
            'izin'  => $izin,
            'tanpa_keterangan' => $alpa,
        ]);

        $whereInfo = [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
        ];

        $existingInfo = \App\Models\RaporInfo::where($whereInfo)->first();
        $infoIn = $request->info ?? [];

        $wali_kelas = isset($infoIn['wali_kelas']) && $infoIn['wali_kelas'] !== '' ? $infoIn['wali_kelas'] : ($existingInfo->wali_kelas ?? '');
        $nip_wali = isset($infoIn['nip_wali']) && $infoIn['nip_wali'] !== '' ? $infoIn['nip_wali'] : ($existingInfo->nip_wali ?? '');
        $kepala = isset($infoIn['kepsek']) && $infoIn['kepsek'] !== '' ? $infoIn['kepsek'] : ($existingInfo->kepala_sekolah ?? '');
        $nip_kepsek = isset($infoIn['nip_kepsek']) && $infoIn['nip_kepsek'] !== '' ? $infoIn['nip_kepsek'] : ($existingInfo->nip_kepsek ?? '');
        $tanggal = isset($infoIn['tanggal_rapor']) && $infoIn['tanggal_rapor'] !== '' ? $infoIn['tanggal_rapor'] : ($existingInfo->tanggal_rapor ?? date('Y-m-d'));

        \App\Models\RaporInfo::updateOrCreate($whereInfo, [
            'wali_kelas' => $wali_kelas,
            'nip_wali' => $nip_wali,
            'kepala_sekolah' => $kepala,
            'nip_kepsek' => $nip_kepsek,
            'tanggal_rapor' => $tanggal,
        ]);

        $whereKenaikan = [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
        ];

        $existingKenaikan = \App\Models\KenaikanKelas::where($whereKenaikan)->first();
        $kenaikanIn = $request->kenaikan ?? [];

        $status = isset($kenaikanIn['status']) && $kenaikanIn['status'] !== '' ? $kenaikanIn['status'] : ($existingKenaikan->status ?? '-');
        $rombel_tujuan = isset($kenaikanIn['rombel_tujuan_id']) && $kenaikanIn['rombel_tujuan_id'] !== '' ? $kenaikanIn['rombel_tujuan_id'] : ($existingKenaikan->rombel_tujuan_id ?? null);
        $catatan = isset($kenaikanIn['catatan']) && $kenaikanIn['catatan'] !== '' ? $kenaikanIn['catatan'] : ($existingKenaikan->catatan ?? '');

        \App\Models\KenaikanKelas::updateOrCreate($whereKenaikan, [
            'status' => $status,
            'rombel_tujuan_id' => $rombel_tujuan,
            'catatan' => $catatan,
        ]);

        return redirect()->route('tu.nilai_raport.show', [
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun' => $tahunParam
        ])->with('success', 'Rapor berhasil diperbarui!');
    }

    

    public function guruEdit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $jurusans = Jurusan::orderBy('nama')->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->get();

        $rombels = Rombel::with(['kelas.jurusan'])
            ->orderBy('nama')
            ->get();

        $kelasArr = $kelas->map(function ($k) {
            return [
                'value'   => (string) $k->id,
                'text'    => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function ($r) {
            return [
                'value' => (string) $r->id,
                'text'  => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'walikelas' => 'Guru',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view(
            'tu.guru.edit',
            compact(
                'guru',
                'jurusans',
                'kelas',
                'rombels',
                'roles',
                'kelasArr',
                'rombelArr'
            )
        );
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk,' . $guru->user_id,
            'email'       => 'nullable|email',
            'password'    => 'nullable|string|min:6',
            'role'        => 'required|string',
            'jurusan_id'  => 'nullable|exists:jurusans,id',
            'kelas_id'    => 'nullable|exists:kelas,id',
            'rombel_id'   => 'nullable|exists:rombels,id',
        ]);

        $user = $guru->user;
        $user->name        = $data['nama'];
        $user->nomor_induk = $data['nomor_induk'];
        $user->email       = $data['email'] ?? null;
        $user->role        = $data['role'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        $guru->update([
            'nama'       => $data['nama'],
            'nip'        => $data['nomor_induk'],
            'email'      => $data['email'] ?? ($data['nomor_induk'] . '@no-reply.local'),
            'jurusan_id' => $data['jurusan_id'] ?? null,
            'kelas_id'   => $data['kelas_id'] ?? null,
        ]);

        Rombel::where('guru_id', $guru->id)
            ->update(['guru_id' => null]);

        if (!empty($data['rombel_id'])) {
            $rombel = Rombel::find($data['rombel_id']);
            $rombel->guru_id = $guru->id;
            $rombel->save();

            $guru->rombel_id = $rombel->id;
        } else {
            $guru->rombel_id = null;
        }

        $guru->save();

        return redirect()
            ->route('tu.guru.index')
            ->with('success', 'Guru berhasil diperbarui');
    }

    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();

        return redirect()
            ->route('tu.guru.index')
            ->with('success', 'Guru berhasil dihapus');
    }
    public function siswaEdit($id)
    {
        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        // Return the TU siswa edit view (use the tu.siswa edit form)
        return view('tu.siswa.edit', compact('siswa','jurusans','rombels','kelas'));
    }
    
    /**
     * Update data siswa
     */
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);
        Log::info('TU: siswaUpdate called', [
            'id' => $id,
            'user_id' => optional($request->user())->id ?? null,
            'fields' => $request->only(['nama_lengkap','nis','nisn','jenis_kelamin','sekolah_asal','kelas_id','rombel_id'])
        ]);

        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nis'              => 'required|string|max:20|unique:data_siswa,nis,' . $id,
            'nisn'             => 'nullable|string|max:20|unique:data_siswa,nisn,' . $id,
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'sekolah_asal'     => 'nullable|string|max:255',
            'jurusan_id'       => 'nullable|exists:jurusans,id',
            'kelas_id'         => 'nullable|exists:kelas,id',
            'rombel_id'        => 'nullable|exists:rombels,id',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|string|max:50',
            'alamat'           => 'nullable|string|max:1000',
            'no_hp'            => 'nullable|string|max:30',
            'tanggal_diterima' => 'nullable|date',
            'kelas'            => 'nullable|string|max:50',
            'password'         => 'nullable|string|min:6|confirmed',

            // Orang tua / wali
            'ayah_nama'        => 'nullable|string|max:255',
            'ayah_pekerjaan'   => 'nullable|string|max:255',
            'ayah_telepon'     => 'nullable|string|max:50',
            'ayah_alamat'      => 'nullable|string|max:1000',

            'ibu_nama'         => 'nullable|string|max:255',
            'ibu_pekerjaan'    => 'nullable|string|max:255',
            'ibu_telepon'      => 'nullable|string|max:50',
            'ibu_alamat'       => 'nullable|string|max:1000',

            'wali_nama'        => 'nullable|string|max:255',
            'wali_pekerjaan'   => 'nullable|string|max:255',
            'wali_telepon'     => 'nullable|string|max:50',
            'wali_alamat'      => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            // basic siswa fields (account-like)
            $siswa->nama_lengkap = $request->nama_lengkap;
            $siswa->nis = $request->nis;
            $siswa->nisn = $request->nisn;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->sekolah_asal = $request->sekolah_asal;

            // additional personal fields
            $siswa->tempat_lahir = $request->input('tempat_lahir');
            if ($request->filled('tanggal_lahir')) {
                $siswa->tanggal_lahir = $request->input('tanggal_lahir');
            }
            $siswa->agama = $request->input('agama');
            $siswa->alamat = $request->input('alamat');
            $siswa->no_hp = $request->input('no_hp');
            if ($request->filled('tanggal_diterima')) {
                $siswa->tanggal_diterima = $request->input('tanggal_diterima');
            }

            // only set rombel_id (the DB doesn't have a 'kelas' column)
            if ($request->filled('rombel_id')) {
                $siswa->rombel_id = $request->rombel_id;
            }

            // handle Ayah
            if ($request->filled('ayah_nama') || $request->filled('ayah_pekerjaan') || $request->filled('ayah_telepon') || $request->filled('ayah_alamat')) {
                if ($siswa->ayah) {
                    $ayah = $siswa->ayah;
                    $ayah->nama = $request->input('ayah_nama');
                    $ayah->pekerjaan = $request->input('ayah_pekerjaan');
                    $ayah->telepon = $request->input('ayah_telepon');
                    $ayah->alamat = $request->input('ayah_alamat');
                    $ayah->save();
                } else {
                    $ayah = Ayah::create([
                        'nama' => $request->input('ayah_nama'),
                        'pekerjaan' => $request->input('ayah_pekerjaan'),
                        'telepon' => $request->input('ayah_telepon'),
                        'alamat' => $request->input('ayah_alamat'),
                    ]);
                    $siswa->ayah_id = $ayah->id;
                }
            }

            // handle Ibu
            if ($request->filled('ibu_nama') || $request->filled('ibu_pekerjaan') || $request->filled('ibu_telepon') || $request->filled('ibu_alamat')) {
                if ($siswa->ibu) {
                    $ibu = $siswa->ibu;
                    $ibu->nama = $request->input('ibu_nama');
                    $ibu->pekerjaan = $request->input('ibu_pekerjaan');
                    $ibu->telepon = $request->input('ibu_telepon');
                    $ibu->alamat = $request->input('ibu_alamat');
                    $ibu->save();
                } else {
                    $ibu = Ibu::create([
                        'nama' => $request->input('ibu_nama'),
                        'pekerjaan' => $request->input('ibu_pekerjaan'),
                        'telepon' => $request->input('ibu_telepon'),
                        'alamat' => $request->input('ibu_alamat'),
                    ]);
                    $siswa->ibu_id = $ibu->id;
                }
            }

            // handle Wali
            if ($request->filled('wali_nama') || $request->filled('wali_pekerjaan') || $request->filled('wali_telepon') || $request->filled('wali_alamat')) {
                if ($siswa->wali) {
                    $wali = $siswa->wali;
                    $wali->nama = $request->input('wali_nama');
                    $wali->pekerjaan = $request->input('wali_pekerjaan');
                    $wali->telepon = $request->input('wali_telepon');
                    $wali->alamat = $request->input('wali_alamat');
                    $wali->save();
                } else {
                    $wali = Wali::create([
                        'nama' => $request->input('wali_nama'),
                        'pekerjaan' => $request->input('wali_pekerjaan'),
                        'telepon' => $request->input('wali_telepon'),
                        'alamat' => $request->input('wali_alamat'),
                    ]);
                    $siswa->wali_id = $wali->id;
                }
            }

            // update related user (nomor_induk + name + optional password)
            if ($siswa->user) {
                $siswa->user->name = $request->nama_lengkap;
                $siswa->user->nomor_induk = $request->nis;
                if ($request->filled('password')) {
                    $siswa->user->password = Hash::make($request->password);
                }
                $siswa->user->save();
            }

            Log::info('TU: siswaUpdate about to save', ['siswa_id' => $siswa->id ?? null]);
            $saved = $siswa->save();
            Log::info('TU: siswaUpdate save result', ['siswa_id' => $siswa->id, 'saved' => (bool)$saved]);
            DB::commit();

            return redirect()->route('tu.siswa.detail', $siswa->id)
                ->with('success', 'Data akun siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('TU: siswaUpdate exception', ['id' => $id, 'error' => $e->getMessage()]);
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Hapus data siswa
     */
    public function siswaDestroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Hapus data orang tua jika tidak terkait dengan siswa lain
            if ($siswa->ayah_id) {
                $ayahCount = DataSiswa::where('ayah_id', $siswa->ayah_id)->count();
                if ($ayahCount <= 1) {
                    Ayah::destroy($siswa->ayah_id);
                }
            }
            
            if ($siswa->ibu_id) {
                $ibuCount = DataSiswa::where('ibu_id', $siswa->ibu_id)->count();
                if ($ibuCount <= 1) {
                    Ibu::destroy($siswa->ibu_id);
                }
            }
            
            if ($siswa->wali_id) {
                $waliCount = DataSiswa::where('wali_id', $siswa->wali_id)->count();
                if ($waliCount <= 1) {
                    Wali::destroy($siswa->wali_id);
                }
            }
            
            // Hapus user terkait
            if ($siswa->user) {
                $siswa->user->delete();
            }
            
            // Hapus data siswa
            $siswa->delete();
            
            DB::commit();
            return redirect()->route('tu.siswa.index')
                ->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Halaman daftar kelas
     */
   public function kelas()
{
    // 获取 Rombel 数据而不是 Kelas
    $search = request('search');
    $jurusan_id = request('jurusan');
    
    $rombels = Rombel::with(['kelas.jurusan', 'guru'])
        ->when($search, function($query) use($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function($q) use($search) {
                      $q->where('tingkat', 'like', "%{$search}%")
                        ->orWhereHas('jurusan', function($j) use($search) {
                            $j->where('nama', 'like', "%{$search}%");
                        });
                  });
        })
        ->when($jurusan_id, function($query) use($jurusan_id) {
            $query->whereHas('kelas', function($q) use($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            });
        })
        ->orderBy('nama')
        ->paginate(12)
        ->withQueryString();

    $allJurusans = Jurusan::orderBy('nama')->get();

    return view('tu.kelas.index', compact('rombels', 'allJurusans', 'search', 'jurusan_id'));
}

    /**
     * Halaman tambah kelas
     */
    public function kelasCreate()
    {
        $jurusans = Jurusan::all();
        $tingkats = ['X','XI','XII'];
        $gurus = Guru::all();
        return view('tu.kelas.create', compact('jurusans','tingkats','gurus'));
    }

    /**
     * Simpan data kelas baru
     */
    public function kelasStore(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        Kelas::create($request->only(['tingkat','jurusan_id','nama']));

        return redirect()->route('tu.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Halaman detail kelas
     */
    public function kelasDetail(Request $request, $id)
    {
        // If $id corresponds to a Rombel, show rombel detail.
        $rombel = Rombel::with([
            'kelas.jurusan',
            'guru',
            'siswa' => function($query) {
                $query->with(['ayah', 'ibu', 'wali']);
            }
        ])->find($id);

        if ($rombel) {
            return view('tu.kelas.show', compact('rombel'));
        }

        // Otherwise, if it's a Kelas id, show list of rombels for that kelas
        $kelas = Kelas::with(['jurusan', 'rombels.guru'])->findOrFail($id);
        $rombels = $kelas->rombels ?? collect();

        return view('tu.kelas.detail_kelas', compact('kelas', 'rombels'));
    }

    /**
     * Halaman edit kelas
     */
    public function kelasEdit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusans = Jurusan::all();
        $tingkats = ['X','XI','XII'];
        return view('tu.kelas.edit', compact('kelas', 'jurusans','tingkats'));
    }

    /**
     * Update data kelas
     */
    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $kelas->update($request->only(['tingkat','jurusan_id','nama']));

        return redirect()->route('tu.kelas.show', $id)
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Hapus data kelas
     */
    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('tu.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
    
    /**
     * Halaman daftar wali kelas
     */
    public function waliKelas()
    {
        $waliKelas = Guru::with([
            'user',
            'kelas',
            'jurusan',
            'rombels'
        ])
        ->latest()
        ->paginate(10);

        $jurusans = Jurusan::with(['gurus.user', 'gurus.kelas'])->get();

        return view('tu.wali-kelas.index', compact('waliKelas', 'jurusans'));
    }

    /**
     * Halaman tambah wali kelas
     */
    public function waliKelasCreate()
    {
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.create', compact('users', 'kelas', 'jurusans', 'rombels'));
    }

    /**
     * Simpan data wali kelas baru
     */
    public function waliKelasStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Guru::create($request->all());
        
        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil ditambahkan.');
    }

    /**
     * Halaman edit wali kelas
     */
    public function waliKelasEdit($id)
    {
        $waliKelas = Guru::findOrFail($id);
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.edit', compact('waliKelas', 'users', 'kelas', 'jurusans', 'rombels'));
    }

    /**
     * Update data wali kelas
     */
    public function waliKelasUpdate(Request $request, $id)
    {
        $waliKelas = Guru::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $waliKelas->update($request->all());

        return redirect()->route('tu.wali-kelas.detail', $id)
            ->with('success', 'Data wali kelas berhasil diperbarui.');
    }

    /**
     * Hapus data wali kelas
     */
    public function waliKelasDestroy($id)
    {
        $waliKelas = Guru::findOrFail($id);
        $waliKelas->delete();

        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil dihapus.');
    }
    
    /**
     * Halaman detail wali kelas
     */
    public function waliKelasDetail($id)
    {
        $waliKelas = Guru::with([
            'user',
            'kelas',
            'jurusan',
            'rombels'
        ])->findOrFail($id);

        return view('tu.wali-kelas.show', compact('waliKelas'));
    }
    
    /**
     * Halaman laporan nilai raport
     */
    public function laporanNilai()
    {
        $nilaiRaports = NilaiRaport::with(['siswa' => function($query) {
            $query->with(['ayah', 'ibu', 'wali']);
        }])
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(20);
            
        return view('tu.laporan-nilai', compact('nilaiRaports'));
    }
}