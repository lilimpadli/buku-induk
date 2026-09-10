<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\MutasiSiswa;
use App\Models\Siswa;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\KenaikanKelas;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classes = Kelas::with(['jurusan', 'rombels.siswas'])
            ->orderBy('tingkat')
            ->orderBy('id')
            ->get();

        $allStudents = [];
        foreach ($classes as $kelas) {
            foreach ($kelas->rombels as $rombel) {
                foreach ($rombel->siswas as $siswa) {
                    $allStudents[] = [
                        'id' => $siswa->id,
                        'nis' => $siswa->nis,
                        'nama_lengkap' => $siswa->nama_lengkap,
                        'kelas_id' => $kelas->id,
                        'rombel_name' => $rombel->nama
                    ];
                }
            }
        }

        $mutasis = MutasiSiswa::with('siswa')
            ->where('status', '!=', 'lulus')
            ->latest('tanggal_mutasi')
            ->get();

        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('tu.mutasi.index', compact('classes', 'allStudents', 'mutasis', 'statuses'));
    }

    /**
     * AJAX search for students used by Select2
     */
    public function searchStudents(Request $request)
    {
        $q = $request->get('q', '');
        $kelasId = $request->get('kelas_id');

        $query = DataSiswa::query()->with('rombel.kelas')
            ->whereNotNull('rombel_id')
            ->whereDoesntHave('mutasis', function ($sub) {
                $sub->whereRaw('LOWER(status) = ?', ['lulus']);
            });

        if ($kelasId) {
            $query->whereHas('rombel.kelas', function ($qq) use ($kelasId) {
                $qq->where('id', $kelasId);
            });
        }

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('nama_lengkap', 'like', "%{$q}%")
                   ->orWhere('nis', 'like', "%{$q}%")
                   ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        $results = $query->orderBy('nama_lengkap')->limit(30)->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'text' => ($s->nis ? $s->nis . ' - ' : '') . $s->nama_lengkap . ($s->rombel ? ' (' . $s->rombel->nama . ')' : ''),
                'kelasId' => optional(optional($s->rombel)->kelas)->id,
                'kelasName' => optional(optional($s->rombel)->kelas)->tingkat . ' ' . optional(optional($s->rombel)->kelas->jurusan)->nama,
                'rombelName' => $s->rombel->nama ?? '',
            ];
        });

        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = DataSiswa::with('rombel.kelas.jurusan')
            ->whereDoesntHave('mutasiTerakhir', function ($q) {
                $q->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal']);
            })
            ->orderBy('nama_lengkap')
            ->get();

        $classes = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('id')
            ->get();

        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('tu.mutasi.create', compact('siswas', 'classes', 'statuses'));
    }

    public function kelasByJurusan($jurusanId)
    {
        $jurusan = Jurusan::with(['kelas.rombels.siswas', 'kelas.rombels.guru'])->findOrFail($jurusanId);

        return view('tu.mutasi.kelas.kelas', compact('jurusan'));
    }

    /**
     * Show rombel for mutation with student grid
     */
    public function showRombel($id)
    {
        $rombel = Rombel::with([
            'kelas.jurusan',
            'siswas.mutasiTerakhir',
        ])->findOrFail($id);

        return view('tu.mutasi.kelas.show', compact('rombel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:data_siswa,id',
            'status' => 'required|in:pindah,do,meninggal,naik_kelas,lulus',
            'tanggal_mutasi' => 'required|date',
            'tahun_ajaran' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string',
            'no_sk_keluar' => 'nullable|string',
            'tanggal_sk_keluar' => 'nullable|date',
            'tujuan_pindah' => 'nullable|string',
        ]);

        $siswa = DataSiswa::with('rombel')->find($validated['siswa_id']);
        $validated['rombel_asal_id'] = $siswa->rombel_id ?? null;
        $validated['diproses_oleh'] = $this->getValidUserId();

        MutasiSiswa::create($validated);

        return redirect()->route('tu.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MutasiSiswa $mutasi)
    {
        $mutasi->load('siswa');
        return view('tu.mutasi.show', compact('mutasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MutasiSiswa $mutasi)
    {
        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('tu.mutasi.edit', compact('mutasi', 'siswas', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'action' => 'required|in:lulus,naik_kelas,pindah,do,meninggal',
            'tanggal_mutasi' => 'required|date',
            'rombel_id' => 'nullable|exists:rombels,id',
            'keterangan' => 'nullable|string|max:255',
            'alasan_pindah' => 'nullable|string|max:255',
            'tujuan_pindah' => 'nullable|string|max:255',
            'no_sk_keluar' => 'nullable|string|max:255',
            'tanggal_sk_keluar' => 'nullable|date',
        ]);

        $action = $request->action;
        $siswaIds = $request->siswa_ids;

        DB::beginTransaction();
        try {
            foreach ($siswaIds as $siswaId) {
                $siswa = DataSiswa::find($siswaId);
                if (!$siswa) {
                    continue;
                }

                MutasiSiswa::create([
                    'siswa_id' => $siswa->id,
                    'status' => $action,
                    'tanggal_mutasi' => $request->tanggal_mutasi,
                    'rombel_asal_id' => $siswa->rombel_id,
                    'keterangan' => $request->keterangan,
                    'alasan_pindah' => $request->alasan_pindah,
                    'tujuan_pindah' => $request->tujuan_pindah,
                    'no_sk_keluar' => $request->no_sk_keluar,
                    'tanggal_sk_keluar' => $request->tanggal_sk_keluar,
                    'diproses_oleh' => $this->getValidUserId(),
                ]);

                switch ($action) {
                    case 'lulus':
                        $siswa->update([
                            'rombel_id' => null,
                            'status_siswa' => 'lulus',
                            'is_active' => false,
                        ]);
                        break;

                    case 'naik_kelas':
                        $siswa->update([
                            'status_siswa' => 'aktif',
                        ]);
                        break;

                    case 'pindah':
                        $siswa->update([
                            'rombel_id' => null,
                            'status_siswa' => 'pindah',
                            'is_active' => false,
                        ]);
                        break;

                    case 'do':
                        $siswa->update([
                            'rombel_id' => null,
                            'status_siswa' => 'drop_out',
                            'is_active' => false,
                        ]);
                        break;

                    case 'meninggal':
                        $siswa->update([
                            'rombel_id' => null,
                            'status_siswa' => 'meninggal',
                            'is_active' => false,
                        ]);
                        break;
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Proses mutasi ' . count($siswaIds) . ' siswa berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat proses mutasi siswa: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Gagal memproses mutasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MutasiSiswa $mutasi)
    {
        $mutasi->delete();

        return redirect()->route('tu.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil dihapus!');
    }

    /**
     * 🔥 FIX: Get valid user ID for diproses_oleh
     */
    private function getValidUserId()
    {
        $userId = auth()->id();
        
        if ($userId) {
            $userExists = User::where('id', $userId)->exists();
            if ($userExists) {
                Log::info("Using auth user ID: {$userId}");
                return $userId;
            }
        }
        
        $firstUser = User::first();
        if ($firstUser) {
            Log::info("Using first user ID: {$firstUser->id}");
            return $firstUser->id;
        }
        
        $defaultUser = User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'name' => 'Admin Sekolah',
                'password' => bcrypt('password123'),
            ]
        );
        
        Log::info("Created default user ID: {$defaultUser->id}");
        return $defaultUser->id;
    }

    /**
     * 🔥 FIND TARGET ROMBEL WITH SMART LOGIC
     */
    private function findTargetRombel($rombelAsal, $nextKelas)
    {
        $rombelNumber = preg_replace('/[^0-9]/', '', $rombelAsal->nama);
        $rombelName = $rombelAsal->nama;
        
        // STRATEGI 1: Cari berdasarkan angka (untuk rombel bernomor)
        if (!empty($rombelNumber)) {
            $found = Rombel::where('kelas_id', $nextKelas->id)
                ->where('nama', 'like', '%' . $rombelNumber . '%')
                ->first();
            if ($found) {
                Log::info("✅ Found by number: {$found->nama}");
                return $found;
            }
        }
        
        // STRATEGI 2: Ganti 'XI' dengan 'XII' di nama (EXACT MATCH)
        $targetName = str_replace('XI', 'XII', $rombelName);
        $targetName = str_replace('X ', 'XII ', $targetName);
        $targetName = str_replace('XII ', 'XII ', $targetName);
        
        $found = Rombel::where('kelas_id', $nextKelas->id)
            ->where('nama', $targetName)
            ->first();
        if ($found) {
            Log::info("✅ Found by name replacement: {$found->nama}");
            return $found;
        }
        
        // STRATEGI 3: Cari berdasarkan kata kunci (tanpa tingkat)
        $keywords = preg_replace('/^(X|XI|XII|10|11|12)\s*/i', '', $rombelName);
        $keywords = trim($keywords);
        
        if (!empty($keywords)) {
            $found = Rombel::where('kelas_id', $nextKelas->id)
                ->where('nama', 'like', '%' . $keywords . '%')
                ->first();
            if ($found) {
                Log::info("✅ Found by keyword: {$found->nama}");
                return $found;
            }
        }
        
        // STRATEGI 4: Cari berdasarkan jurusan (ambil rombel pertama di kelas tersebut)
        $found = Rombel::where('kelas_id', $nextKelas->id)->first();
        if ($found) {
            Log::warning("⚠️ Fallback to first rombel: {$found->nama}");
            return $found;
        }
        
        return null;
    }

    /**
     * Update/mutasi siswa from form - MAIN METHOD (FIXED)
     */
    public function updateSiswa(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'rombel_id' => 'required|exists:rombels,id',
            'action' => 'required|in:lulus,naik_kelas,pindah,do,meninggal',
            'tanggal_mutasi' => 'required|date',
            'rombel_asal_id' => 'nullable|exists:rombels,id',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string|required_if:action,pindah',
            'tujuan_pindah' => 'nullable|string|required_if:action,pindah',
            'no_sk_keluar' => 'nullable|string|required_if:action,do,meninggal',
            'tanggal_sk_keluar' => 'nullable|date|required_if:action,do,meninggal',
        ]);

        $userId = $this->getValidUserId();
        Log::info("Processing mutasi with user ID: {$userId}");

        DB::beginTransaction();
        try {
            $rombelAsal = Rombel::with('kelas.jurusan')->findOrFail($validated['rombel_id']);
            $action = $validated['action'];
            $nextRombel = null;
            $nextKelas = null;

            if ($action === 'naik_kelas') {
                $currentTingkat = strtoupper($rombelAsal->kelas->tingkat);
                if (in_array($currentTingkat, ['XII', '12'])) {
                    return redirect()->back()->with('error', 'Siswa kelas XII harus diproses LULUS.');
                }

                $tingkatMap = ['X' => 'XI', 'XI' => 'XII', '10' => '11', '11' => '12'];
                $nextTingkat = $tingkatMap[$currentTingkat] ?? null;

                $nextKelas = Kelas::where('jurusan_id', $rombelAsal->kelas->jurusan_id)
                    ->where('tingkat', $nextTingkat)
                    ->first();

                if (!$nextKelas) {
                    return redirect()->back()->with('error', "Kelas tingkat $nextTingkat belum tersedia.");
                }

                // 🔥 FIX: Gunakan logika cari rombel yang lebih pintar
                $nextRombel = $this->findTargetRombel($rombelAsal, $nextKelas);

                // 🔥 FIX: Buat rombel baru jika tidak ditemukan
                if (!$nextRombel) {
                    $newName = str_replace('XI', 'XII', $rombelAsal->nama);
                    $newName = str_replace('X ', 'XII ', $newName);
                    $newName = str_replace('XII ', 'XII ', $newName);
                    
                    $nextRombel = Rombel::create([
                        'kelas_id' => $nextKelas->id,
                        'nama' => $newName,
                        'tahun_ajaran' => $rombelAsal->tahun_ajaran ?? now()->format('Y') . '/' . (now()->format('Y') + 1),
                    ]);
                    
                    Log::info("🔥 Buat rombel baru: {$newName} (ID: {$nextRombel->id})");
                }
            }

            foreach ($validated['siswa_ids'] as $siswaId) {
                $siswa = DataSiswa::find($siswaId);
                if (!$siswa) continue;

                $mutasiData = [
                    'siswa_id' => $siswaId,
                    'status' => $action,
                    'tanggal_mutasi' => $validated['tanggal_mutasi'],
                    'rombel_asal_id' => $siswa->rombel_id,
                    'keterangan' => $validated['keterangan'] ?? null,
                    'diproses_oleh' => $userId,
                ];

                if ($action === 'naik_kelas' && $nextRombel) {
                    $mutasiData['rombel_tujuan_id'] = $nextRombel->id;
                    $siswa->update([
                        'kelas_id' => $nextKelas->id,
                        'rombel_id' => $nextRombel->id,
                        'status_siswa' => 'aktif',
                    ]);
                } elseif ($action === 'lulus') {
                    $siswa->update([
                        'rombel_id' => null,
                        'status_siswa' => 'lulus',
                        'is_active' => false,
                    ]);
                    $this->lepasWaliKelasXII($siswa);
                } else {
                    $siswa->update([
                        'rombel_id' => null,
                        'status_siswa' => $action,
                        'is_active' => false,
                    ]);
                }

                MutasiSiswa::create($mutasiData);
            }

            if ($action === 'naik_kelas' && $nextRombel) {
                $this->pindahWaliKelas($rombelAsal, $nextRombel);
            }

            DB::commit();
            
            $statusLabel = [
                'lulus' => 'lulus',
                'naik_kelas' => 'naik kelas',
                'pindah' => 'pindah sekolah',
                'do' => 'keluar sekolah',
                'meninggal' => 'meninggal dunia'
            ][$action] ?? 'dimutasi';
            
            return redirect()->back()->with('success', "✅ " . count($validated['siswa_ids']) . " siswa berhasil $statusLabel!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updateSiswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses mutasi: ' . $e->getMessage());
        }
    }

    /**
     * Pindahkan wali kelas dari rombel asal ke rombel tujuan
     */
    private function pindahWaliKelas($rombelAsal, $rombelTujuan)
    {
        if (!$rombelAsal || !$rombelTujuan) {
            return;
        }

        $guruId = $rombelAsal->guru_id;
        
        if (!$guruId) {
            return;
        }

        $existingWali = Rombel::where('id', $rombelTujuan->id)
            ->whereNotNull('guru_id')
            ->first();

        if ($existingWali) {
            Log::warning("Rombel tujuan {$rombelTujuan->nama} sudah memiliki wali kelas.");
            return;
        }

        $rombelAsal->guru_id = null;
        $rombelAsal->save();

        $rombelTujuan->guru_id = $guruId;
        $rombelTujuan->save();

        $guru = Guru::find($guruId);
        if ($guru) {
            $guru->rombel_id = $rombelTujuan->id;
            $guru->save();
        }

        Log::info("Wali kelas pindah dari {$rombelAsal->nama} ke {$rombelTujuan->nama}");
    }

    /**
     * Lepas wali kelas jika siswa kelas XII lulus
     */
    private function lepasWaliKelasXII($siswa)
    {
        if (!$siswa->rombel) {
            return;
        }

        $kelas = $siswa->rombel->kelas;
        if (!$kelas || $kelas->tingkat !== 'XII') {
            return;
        }

        $rombel = $siswa->rombel;
        $guruId = $rombel->guru_id;
        
        if (!$guruId) {
            return;
        }

        $rombel->guru_id = null;
        $rombel->save();
        
        $guru = Guru::find($guruId);
        if ($guru) {
            $guru->rombel_id = null;
            $guru->save();
        }

        Log::info("Wali kelas dilepas dari rombel {$rombel->nama} (kelas XII lulus)");
    }

    /**
     * Bulk mutasi siswa untuk berbagai status
     */
    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'status' => 'required|in:naik_kelas,lulus,do,pindah,meninggal',
            'kelas_id' => 'nullable|exists:kelas,id',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string|required_if:status,pindah',
            'tujuan_pindah' => 'nullable|string|required_if:status,pindah',
        ]);

        try {
            $count = 0;
            $today = now()->format('Y-m-d');
            $status = $validated['status'];
            $userId = $this->getValidUserId();

            foreach ($validated['siswa_ids'] as $siswaId) {
                $mutasiData = [
                    'siswa_id' => $siswaId,
                    'status' => $status,
                    'tanggal_mutasi' => $today,
                    'keterangan' => $validated['keterangan'] ?? null,
                    'diproses_oleh' => $userId,
                ];

                if ($status === 'pindah') {
                    $mutasiData['alasan_pindah'] = $validated['alasan_pindah'] ?? null;
                    $mutasiData['tujuan_pindah'] = $validated['tujuan_pindah'] ?? null;
                }

                MutasiSiswa::create($mutasiData);
                $count++;
            }

            $statusLabel = [
                'naik_kelas' => 'dinaikkan kelasnya',
                'lulus' => 'lulus',
                'do' => 'putus sekolah',
                'pindah' => 'pindah sekolah',
                'meninggal' => 'tercatat meninggal dunia'
            ][$status] ?? 'dimutasi';

            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => "$count siswa berhasil $statusLabel"
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk mutasi error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Up all students automatically (X->XI, XI->XII, XII->Lulus)
     */
    public function upAll(Request $request)
    {
        try {
            $today = now()->format('Y-m-d');
            $tahunAjaran = $request->input('tahun_ajaran') ?? (now()->format('Y') . '-' . (now()->format('Y') + 1));
            $count = 0;
            $graduatedCount = 0;
            $userId = $this->getValidUserId();

            $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'rombel.guru'])
                ->whereHas('rombel.kelas', function ($q) {
                    $q->whereIn('tingkat', ['X', 'XI', 'XII']);
                })
                ->whereDoesntHave('mutasiTerakhir', function ($q) {
                    $q->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal']);
                })
                ->get();

            if ($siswa->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada siswa aktif untuk dinaikkan kelas'
                ], 422);
            }

            $byRombel = $siswa->groupBy('rombel_id');

            foreach ($byRombel as $rombelId => $students) {
                $currentRombel = Rombel::with(['kelas.jurusan', 'guru'])->find($rombelId);
                if (!$currentRombel) continue;

                $currentKelas = $currentRombel->kelas;
                $currentTingkat = $currentKelas->tingkat;
                $rombelNama = $currentRombel->nama;

                if ($currentTingkat === 'XII') {
                    foreach ($students as $s) {
                        $this->lepasWaliKelasXII($s);

                        $sudahLulus = MutasiSiswa::where('siswa_id', $s->id)
                            ->where('status', 'lulus')
                            ->exists();
                        
                        if ($sudahLulus) {
                            continue;
                        }
                        
                        $lastKenaikanKelas = KenaikanKelas::where('siswa_id', $s->id)
                            ->orderBy('tahun_ajaran', 'desc')
                            ->orderBy('semester', 'desc')
                            ->first();
                        
                        $tahunAjaranLulus = $lastKenaikanKelas ? $lastKenaikanKelas->tahun_ajaran : $tahunAjaran;
                        
                        MutasiSiswa::create([
                            'siswa_id' => $s->id,
                            'status' => 'lulus',
                            'tanggal_mutasi' => $today,
                            'tahun_ajaran' => $tahunAjaranLulus,
                            'keterangan' => 'Lulus otomatis - UP ALL',
                            'diproses_oleh' => $userId,
                        ]);

                        $graduatedCount++;
                    }
                } else {
                    $nextTingkat = $currentTingkat === 'X' ? 'XI' : 'XII';
                    
                    $targetKelas = Kelas::where('tingkat', $nextTingkat)
                        ->where('jurusan_id', $currentKelas->jurusan_id)
                        ->first();

                    if (!$targetKelas) {
                        continue;
                    }

                    $targetRombel = Rombel::where('kelas_id', $targetKelas->id)
                        ->where('nama', 'like', '%' . preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) . '%')
                        ->first();

                    if (!$targetRombel) {
                        $targetRombel = Rombel::where('kelas_id', $targetKelas->id)->first();
                    }

                    if (!$targetRombel) {
                        continue;
                    }

                    $this->pindahWaliKelas($currentRombel, $targetRombel);

                    foreach ($students as $s) {
                        $hasTerminalStatus = MutasiSiswa::where('siswa_id', $s->id)
                            ->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal'])
                            ->exists();
                        
                        if ($hasTerminalStatus) {
                            continue;
                        }
                        
                        MutasiSiswa::create([
                            'siswa_id' => $s->id,
                            'status' => 'naik_kelas',
                            'tanggal_mutasi' => $today,
                            'tahun_ajaran' => $tahunAjaran,
                            'keterangan' => "Naik dari {$currentTingkat} ke {$nextTingkat} - UP ALL",
                            'diproses_oleh' => $userId,
                        ]);

                        DataSiswa::where('id', $s->id)->update([
                            'kelas_id' => $targetKelas->id,
                            'rombel_id' => $targetRombel->id,
                        ]);

                        $count++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'naik_kelas' => $count,
                'lulus' => $graduatedCount,
                'message' => "Berhasil: {$count} siswa naik kelas, {$graduatedCount} siswa lulus"
            ]);

        } catch (\Exception $e) {
            Log::error('UpAll error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Laporan mutasi siswa
     */
    public function laporan(Request $request)
    {
        $query = MutasiSiswa::with('siswa')->latest('tanggal_mutasi');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mutasi', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_mutasi', '<=', $request->tanggal_sampai);
        }

        $mutasis = $query->get();
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('tu.mutasi.laporan', compact('mutasis', 'statuses'));
    }
}