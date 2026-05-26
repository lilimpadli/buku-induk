<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\MutasiSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Load classes with rombels and students
        $classes = Kelas::with(['jurusan', 'rombels.siswas'])
            ->orderBy('tingkat')
            ->orderBy('id')
            ->get();

        // Build array of all students by class for JSON in view
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

        // Get existing mutasi records for reference
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

        $query = Siswa::query()->with('rombel.kelas')
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
        $siswas = Siswa::with('rombel.kelas.jurusan')
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
    public function showRombel($rombelId)
    {
        $rombel = Rombel::with(['siswas.mutasiTerakhir', 'kelas.jurusan', 'guru'])->findOrFail($rombelId);

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
        $siswas = Siswa::orderBy('nama_lengkap')->get();
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
    public function update(Request $request, MutasiSiswa $mutasi)
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

        $mutasi->update($validated);

        return redirect()->route('tu.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil diperbarui!');
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
     * Update/mutasi siswa from form
     */
    public function updateSiswa(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'rombel_id' => 'required|exists:rombels,id',
            'action' => 'required|in:lulus,naik_kelas,pindah,do,meninggal',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string|required_if:action,pindah',
            'tujuan_pindah' => 'nullable|string|required_if:action,pindah',
            'no_sk_keluar' => 'nullable|string|required_if:action,do,meninggal',
            'tanggal_sk_keluar' => 'nullable|date|required_if:action,do,meninggal',
        ]);

        try {
            $rombel = Rombel::with('kelas.jurusan')->findOrFail($validated['rombel_id']);
            $action = $validated['action'];
            $currentKelas = $rombel->kelas;
            $currentTingkat = $currentKelas->tingkat;
            
            // Validasi untuk aksi naik kelas
            if ($action === 'naik_kelas') {
                // Map tingkat ke level (X=10, XI=11, XII=12)
                $tingkatMap = ['X' => 10, 'XI' => 11, 'XII' => 12, '10' => 10, '11' => 11, '12' => 12];
                $reverseMap = [10 => 'XI', 11 => 'XII', 12 => 'XII'];
                
                if (!isset($tingkatMap[$currentTingkat])) {
                    return redirect()
                        ->back()
                        ->with('error', 'Tingkat kelas tidak dikenali');
                }
                
                $currentLevel = $tingkatMap[$currentTingkat];
                
                // Kelas XII harus LULUS, tidak boleh naik
                if ($currentLevel === 12 || strtoupper($currentTingkat) === 'XII' || $currentTingkat === '12') {
                    return redirect()
                        ->back()
                        ->with('error', '❌ Siswa kelas XII harus LULUS, bukan naik kelas. Silakan pilih aksi "Lulus Siswa".');
                }
                
                // Tentukan kelas tujuan
                $nextLevel = $currentLevel + 1;
                $nextTingkat = $reverseMap[$nextLevel] ?? null;
                if (!$nextTingkat) {
                    return redirect()
                        ->back()
                        ->with('error', '❌ Tingkat tujuan tidak ditemukan untuk naik kelas.');
                }
                
                // Cek apakah kelas tujuan ada
                $nextKelas = Kelas::where('jurusan_id', $currentKelas->jurusan_id)
                    ->where('tingkat', $nextTingkat)
                    ->first();
                
                if (!$nextKelas) {
                    $kelasName = $nextTingkat . ' ' . $currentKelas->jurusan->nama;
                    return redirect()
                        ->back()
                        ->with('error', "❌ Kelas $kelasName belum ada di sistem. Silakan buat kelas terlebih dahulu sebelum melakukan naik kelas.");
                }
                
                // Cari rombel tujuan dengan nomor/nama yang sama di kelas berikutnya
                // Ambil nomor rombel dari nama (contoh: "RPL 1" -> 1, "IPA 2" -> 2)
                $rombelNumber = preg_replace('/[^0-9]/', '', $rombel->nama);
                
                $nextRombel = Rombel::where('kelas_id', $nextKelas->id)
                    ->where('nama', 'like', '%' . $rombelNumber . '%')
                    ->first();
                
                if (!$nextRombel) {
                    // Jika tidak ada dengan nomor sama, coba cari dengan nama yang sama persis
                    $nextRombel = Rombel::where('kelas_id', $nextKelas->id)
                        ->where('nama', $rombel->nama)
                        ->first();
                }
                
                if (!$nextRombel) {
                    $rombelName = $nextTingkat . ' ' . $rombel->nama;
                    return redirect()
                        ->back()
                        ->with('error', "❌ Rombel $rombelName belum ada di sistem. Silakan buat rombel terlebih dahulu sebelum melakukan naik kelas.");
                }
            }

            $count = 0;
            $today = now()->format('Y-m-d');
            $status = $action;
            $terminalStatuses = ['pindah', 'do', 'meninggal'];

            foreach ($validated['siswa_ids'] as $siswaId) {
                $siswa = Siswa::with('mutasiTerakhir')->find($siswaId);
                $lastStatus = optional($siswa->mutasiTerakhir)->status;

                if ($action === 'naik_kelas' && in_array($lastStatus, $terminalStatuses, true)) {
                    if (isset($nextRombel) && isset($nextKelas)) {
                        $siswa->update([
                            'rombel_id' => $nextRombel->id,
                            'kelas_id' => $nextKelas->id,
                        ]);
                    }
                    $count++;
                    continue;
                }

                $mutasiData = [
                    'siswa_id' => $siswaId,
                    'status' => $status,
                    'tanggal_mutasi' => $validated['tanggal_mutasi'],
                    'keterangan' => $validated['keterangan'] ?? null,
                ];

                if ($status === 'pindah') {
                    $mutasiData['alasan_pindah'] = $validated['alasan_pindah'];
                    $mutasiData['tujuan_pindah'] = $validated['tujuan_pindah'];
                }

                if (in_array($status, ['do', 'meninggal'], true)) {
                    $mutasiData['no_sk_keluar'] = $validated['no_sk_keluar'];
                    $mutasiData['tanggal_sk_keluar'] = $validated['tanggal_sk_keluar'];
                }

                MutasiSiswa::create($mutasiData);
                $count++;
            }

            $statusLabel = [
                'naik_kelas' => 'dinaikkan kelasnya',
                'lulus' => 'lulus',
                'pindah' => 'pindah sekolah',
                'do' => 'keluar sekolah',
                'meninggal' => 'tercatat meninggal dunia',
            ][$status] ?? 'dimutasi';

            return redirect()
                ->route('tu.mutasi.kelas', ['jurusan' => $rombel->kelas->jurusan->id])
                ->with('success', "✅ $count siswa berhasil $statusLabel!");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
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

            foreach ($validated['siswa_ids'] as $siswaId) {
                $mutasiData = [
                    'siswa_id' => $siswaId,
                    'status' => $status,
                    'tanggal_mutasi' => $today,
                    'keterangan' => $validated['keterangan'] ?? null,
                ];

                // Add fields based on status
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
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Up all students automatically (X->XI, XI->XII, XII->Lulus)
     * Each student moves to the same rombel number in next class
     * e.g., X RPL 1 -> XI RPL 1, X RPL 2 -> XI RPL 2
     */
    public function upAll(Request $request)
    {
        try {
            $today = now()->format('Y-m-d');
            // Gunakan tahun ajaran dari request, atau hitung otomatis
            $tahunAjaran = $request->input('tahun_ajaran') ?? (now()->format('Y') . '-' . (now()->format('Y') + 1));
            $count = 0;
            $graduatedCount = 0;

            // Get all active students (not graduated and not with terminal status)
            $siswa = Siswa::with('rombel.kelas.jurusan')
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

            // Group siswa by current rombel
            $byRombel = $siswa->groupBy('rombel_id');

            foreach ($byRombel as $rombelId => $students) {
                $currentRombel = Rombel::with('kelas.jurusan')->find($rombelId);
                if (!$currentRombel) continue;

                $currentKelas = $currentRombel->kelas;
                $currentTingkat = $currentKelas->tingkat;
                $rombelNama = $currentRombel->nama;

                if ($currentTingkat === 'XII') {
                    // XII -> Lulus (Graduated)
                    foreach ($students as $s) {
                        // Check apakah siswa sudah pernah lulus (status='lulus' di mutasi_siswas)
                        $sudahLulus = MutasiSiswa::where('siswa_id', $s->id)
                            ->where('status', 'lulus')
                            ->exists();
                        
                        // Skip jika sudah lulus
                        if ($sudahLulus) {
                            continue;
                        }
                        
                        // Ambil tahun ajaran dari kenaikan_kelas terbaru
                        $lastKenaikanKelas = KenaikanKelas::where('siswa_id', $s->id)
                            ->orderBy('tahun_ajaran', 'desc')
                            ->orderBy('semester', 'desc')
                            ->first();
                        
                        $tahunAjaranLulus = $lastKenaikanKelas ? $lastKenaikanKelas->tahun_ajaran : $tahunAjaran;
                        
                        // Create mutasi record
                        MutasiSiswa::create([
                            'siswa_id' => $s->id,
                            'status' => 'lulus',
                            'tanggal_mutasi' => $today,
                            'tahun_ajaran' => $tahunAjaranLulus,
                            'keterangan' => 'Lulus otomatis - UP ALL',
                        ]);

                        $graduatedCount++;
                    }
                } else {
                    // X -> XI atau XI -> XII
                    $nextTingkat = $currentTingkat === 'X' ? 'XI' : 'XII';
                    
                    // Find target kelas dengan jurusan sama
                    $targetKelas = Kelas::where('tingkat', $nextTingkat)
                        ->where('jurusan_id', $currentKelas->jurusan_id)
                        ->first();

                    if (!$targetKelas) {
                        continue; // Skip jika kelas tujuan tidak ada
                    }

                    // Cari rombel dengan nama sama di kelas tujuan
                    $targetRombel = Rombel::where('kelas_id', $targetKelas->id)
                        ->where('nama', 'like', '%' . preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) . '%')
                        ->first();

                    // Jika tidak ada rombel dengan nama serupa, gunakan rombel pertama
                    if (!$targetRombel) {
                        $targetRombel = Rombel::where('kelas_id', $targetKelas->id)->first();
                    }

                    if (!$targetRombel) {
                        continue; // Skip jika tidak ada rombel di kelas tujuan
                    }

                    foreach ($students as $s) {
                        // Check apakah siswa sudah punya status terminal (lulus, pindah, do, meninggal)
                        $hasTerminalStatus = MutasiSiswa::where('siswa_id', $s->id)
                            ->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal'])
                            ->exists();
                        
                        // Skip jika sudah punya status terminal
                        if ($hasTerminalStatus) {
                            continue;
                        }
                        
                        // Create mutasi record
                        MutasiSiswa::create([
                            'siswa_id' => $s->id,
                            'status' => 'naik_kelas',
                            'tanggal_mutasi' => $today,
                            'tahun_ajaran' => $tahunAjaran,
                            'keterangan' => "Naik dari {$currentTingkat} ke {$nextTingkat} - UP ALL",
                        ]);

                        // Update siswa's kelas and rombel
                        Siswa::where('id', $s->id)->update([
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
