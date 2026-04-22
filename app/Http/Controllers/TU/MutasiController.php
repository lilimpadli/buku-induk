<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\MutasiSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MutasiSiswa::with('siswa')
            ->where('status', '!=', 'lulus')  // Exclude alumni (lulus)
            ->latest('tanggal_mutasi');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $mutasis = $query->paginate(15);
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
        ];

        return view('tu.mutasi.index', compact('mutasis', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::whereDoesntHave('mutasiTerakhir', function ($q) {
            $q->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal']);
        })
            ->orderBy('nama_lengkap')
            ->get();

        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('tu.mutasi.create', compact('siswas', 'statuses'));
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
     * Bulk mutasi siswa (naik kelas)
     */
    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'rombel_id' => 'nullable|exists:rombels,id',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $count = 0;
            $today = now()->format('Y-m-d');

            foreach ($validated['siswa_ids'] as $siswaId) {
                // Create mutasi record
                MutasiSiswa::create([
                    'siswa_id' => $siswaId,
                    'status' => 'naik_kelas',
                    'tanggal_mutasi' => $today,
                    'keterangan' => $validated['keterangan'] ?? null,
                ]);

                // Update siswa's kelas and rombel
                Siswa::where('id', $siswaId)->update([
                    'kelas_id' => $validated['kelas_id'],
                    'rombel_id' => $validated['rombel_id'] ?? null,
                ]);

                $count++;
            }

            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => "$count siswa berhasil dinaikkan kelasnya"
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
