<?php
namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\KenaikanKelas;
use App\Models\DataSiswa;
use App\Models\Jurusan;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua jurusan
        $allJurusan = Jurusan::orderBy('nama')->get();

        // Filter tahun
        $tahunSearch = $request->tahun_ajaran;

        // ============================================================
        // 🔥 FIX 1: Ambil data alumni dengan handling jurusan_id NULL
        // ============================================================
        $query = KenaikanKelas::where('status', 'Lulus')
            ->with(['siswa', 'jurusan']);

        if ($tahunSearch) {
            $query->where('tahun_ajaran', $tahunSearch);
        }

        $alumni = $query->orderBy('tahun_ajaran', 'desc')->get();

        Log::info("Total alumni di controller: " . $alumni->count());

        // ============================================================
        // 🔥 FIX 2: Tambahkan data alumni dengan jurusan_id NULL ke group
        // ============================================================
        $groupedAlumniCard = [];
        $alumniWithoutJurusan = [];

        foreach ($alumni as $item) {
            // Skip jika tidak ada siswa
            if (!$item->siswa) {
                Log::warning("Alumni ID {$item->id} tidak punya siswa");
                continue;
            }

            // Ambil jurusan dari relasi kenaikan_kelas
            $jurusan = $item->jurusan;

            // 🔥 FIX: Jika jurusan null, coba ambil dari sumber lain
            if (!$jurusan) {
                // Coba dari rombel_tujuan_id
                if ($item->rombel_tujuan_id) {
                    $rombel = \App\Models\Rombel::with('kelas.jurusan')->find($item->rombel_tujuan_id);
                    if ($rombel && $rombel->kelas && $rombel->kelas->jurusan) {
                        $jurusan = $rombel->kelas->jurusan;
                        // Update data alumni
                        $item->jurusan_id = $jurusan->id;
                        $item->save();
                        Log::info("✅ Fix jurusan dari rombel_tujuan: Alumni ID {$item->id} -> jurusan_id={$jurusan->id}");
                    }
                }

                // Jika masih null, coba dari siswa
                if (!$jurusan && $item->siswa && $item->siswa->rombel && $item->siswa->rombel->kelas) {
                    $jurusan = $item->siswa->rombel->kelas->jurusan;
                    if ($jurusan) {
                        $item->jurusan_id = $jurusan->id;
                        $item->save();
                        Log::info("✅ Fix jurusan dari siswa: Alumni ID {$item->id} -> jurusan_id={$jurusan->id}");
                    }
                }
            }

            // Jika masih tidak ada jurusan, masukkan ke group khusus
            if (!$jurusan) {
                $alumniWithoutJurusan[] = $item;
                Log::warning("Alumni ID {$item->id} TIDAK PUNYA JURUSAN, siswa: " . ($item->siswa ? $item->siswa->nama_lengkap : 'null'));
                continue;
            }

            $idJurusan = $jurusan->id;
            $namaJurusan = $jurusan->nama;
            $tahun = $item->tahun_ajaran;

            $cardKey = $tahun . '_' . $idJurusan;

            if (!isset($groupedAlumniCard[$cardKey])) {
                $groupedAlumniCard[$cardKey] = [
                    'tahun' => $tahun,
                    'jurusan' => $namaJurusan,
                    'jurusan_id' => $idJurusan,
                    'count' => 0,
                ];
            }
            $groupedAlumniCard[$cardKey]['count']++;
        }

        // ============================================================
        // 🔥 FIX 3: Tambahkan jurusan yang tidak punya alumni (count 0)
        // ============================================================
        $allJurusanCards = [];

        foreach ($allJurusan as $jurusan) {
            $totalCount = 0;
            $tahunDisplay = $tahunSearch ?? 'Semua Tahun';

            foreach ($groupedAlumniCard as $group) {
                if ($group['jurusan_id'] == $jurusan->id) {
                    $totalCount += $group['count'];
                    $tahunDisplay = $group['tahun'];
                }
            }

            $allJurusanCards[] = [
                'jurusan_id' => $jurusan->id,
                'jurusan' => $jurusan->nama,
                'tahun' => $tahunDisplay,
                'count' => $totalCount,
            ];
        }

        // ============================================================
        // 🔥 FIX 4: Tambahkan card untuk alumni tanpa jurusan
        // ============================================================
        if (count($alumniWithoutJurusan) > 0) {
            $allJurusanCards[] = [
                'jurusan_id' => null,
                'jurusan' => '⚠️ Belum Teridentifikasi',
                'tahun' => 'Semua Tahun',
                'count' => count($alumniWithoutJurusan),
                'is_unknown' => true
            ];
        }

        foreach ($allJurusanCards as &$card) {
            if ($card['jurusan_id'] === null || $card['jurusan_id'] === 0) {
                $card['jurusan_id'] = 0;
                $card['jurusan'] = $card['jurusan'] ?? '⚠️ Belum Teridentifikasi';
            }
        }

        // Ambil daftar tahun ajaran untuk filter
        $tahunAjaranList = KenaikanKelas::where('status', 'Lulus')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        return view('tu.alumni.index', compact('allJurusanCards', 'tahunAjaranList', 'tahunSearch'));
    }

    public function byJurusan($jurusanId = null, Request $request)
    {
        // Jika jurusanId null atau 0, tampilkan semua
        if ($jurusanId === null || $jurusanId == 0) {
            $jurusanId = 0;
            $namaJurusan = '⚠️ Belum Teridentifikasi';
            
            $query = KenaikanKelas::where('status', 'Lulus')
                ->whereNull('jurusan_id')
                ->with(['siswa', 'jurusan']);
        } else {
            $jurusan = Jurusan::find($jurusanId);
            if (!$jurusan) {
                abort(404, 'Jurusan tidak ditemukan');
            }
            $namaJurusan = $jurusan->nama;

            $query = KenaikanKelas::where('status', 'Lulus')
                ->where(function($q) use ($jurusanId) {
                    $q->where('jurusan_id', $jurusanId)
                      ->orWhereHas('siswa.rombel.kelas.jurusan', function($jq) use ($jurusanId) {
                          $jq->where('id', $jurusanId);
                      });
                })
                ->with(['siswa', 'jurusan']);
        }

        $tahun = trim($request->tahun ?? 'Semua Tahun');
        if ($tahun !== 'Semua Tahun' && !empty($tahun)) {
            $query->where('tahun_ajaran', $tahun);
        }

        $alumni = $query->orderBy('tahun_ajaran', 'desc')->get();

        // Group berdasarkan rombel/kelas
        $groupedAlumni = [];

        foreach ($alumni as $item) {
            if (!$item->siswa) {
                continue;
            }

            $siswa = $item->siswa;
            $rombelNama = $siswa->rombel ? $siswa->rombel->nama : 'Tidak Ada Kelas';
            $kelasTingkat = $item->kelas_tingkat ?? 'XII';

            $key = $kelasTingkat . '_' . $rombelNama;

            if (!isset($groupedAlumni[$key])) {
                $groupedAlumni[$key] = [
                    'kelas_tingkat' => $kelasTingkat,
                    'rombel_nama' => $rombelNama,
                    'display_name' => 'Kelas ' . $kelasTingkat . ' - ' . $rombelNama,
                    'students' => []
                ];
            }

            $groupedAlumni[$key]['students'][] = $siswa;
        }

        // Tahun ajaran list untuk filter
        $tahunAjaranList = KenaikanKelas::where('status', 'Lulus')
            ->when($jurusanId == 0, function($q) {
                return $q->whereNull('jurusan_id');
            }, function($q) use ($jurusanId) {
                return $q->where('jurusan_id', $jurusanId)
                    ->orWhereHas('siswa.rombel.kelas.jurusan', function($jq) use ($jurusanId) {
                        $jq->where('id', $jurusanId);
                    });
            })
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        return view('tu.alumni.by-jurusan', compact(
            'groupedAlumni', 
            'tahun', 
            'jurusanId', 
            'namaJurusan', 
            'tahunAjaranList'
        ));
    }

    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel', 'ayah', 'ibu', 'wali', 'agama', 'jenisKelamin'])->findOrFail($id);
        return view('tu.alumni.show', compact('siswa'));
    }

    // 🔥 FIX 7: Tambahkan method untuk memperbaiki data alumni
    public function fixJurusan(Request $request)
    {
        $fixed = 0;
        $alumniNull = KenaikanKelas::where('status', 'Lulus')
            ->whereNull('jurusan_id')
            ->get();

        foreach ($alumniNull as $alumni) {
            $jurusanId = null;

            // Coba dari rombel_tujuan_id
            if ($alumni->rombel_tujuan_id) {
                $rombel = \App\Models\Rombel::with('kelas.jurusan')->find($alumni->rombel_tujuan_id);
                if ($rombel && $rombel->kelas && $rombel->kelas->jurusan) {
                    $jurusanId = $rombel->kelas->jurusan_id;
                }
            }

            // Coba dari siswa
            if (!$jurusanId && $alumni->siswa && $alumni->siswa->rombel && $alumni->siswa->rombel->kelas) {
                $jurusanId = $alumni->siswa->rombel->kelas->jurusan_id;
            }

            if ($jurusanId) {
                $alumni->jurusan_id = $jurusanId;
                $alumni->save();
                $fixed++;
            }
        }

        return redirect()->back()->with('success', "Berhasil memperbaiki {$fixed} data alumni");
    }

    // ================================================================
    // 🔥 TAMBAHAN METHOD UNTUK RAPORT ALUMNI
    // ================================================================

    /**
     * Tampilkan daftar raport yang tersedia untuk alumni
     */
    public function raporList($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan'])->findOrFail($siswa_id);
        
        $raports = NilaiRaport::where('siswa_id', $siswa_id)
            ->select('semester', 'tahun_ajaran')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
        
        return view('tu.alumni.raport.list', compact('siswa', 'raports'));
    }

    /**
     * Tampilkan detail raport alumni
     */
    public function raporShow($siswa_id, $semester, $tahun)
    {
        $siswa = DataSiswa::with(['rombel.kelas'])->findOrFail($siswa_id);
        
        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with(['mapel', 'kelas.jurusan', 'rombel'])
            ->get();
        
        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();
        
        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        
        $kenaikan = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        
        $kelasHistory = $nilaiRaports->first()?->kelas;
        
        return view('tu.alumni.raport.show', compact(
            'siswa',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'kenaikan',
            'kelasHistory',
            'semester',
            'tahun'
        ));
    }

    /**
     * Cetak raport alumni
     */
    public function raporCetak($siswa_id, $semester, $tahun)
    {
        $siswa = DataSiswa::with(['rombel.kelas'])->findOrFail($siswa_id);
        $tahun = str_replace('-', '/', $tahun);
        
        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with(['mapel', 'kelas.jurusan', 'rombel'])
            ->get();
        
        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();
        
        $kehadiran = Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        
        $kenaikan = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        
        $kelasHistory = $nilaiRaports->first()?->kelas;
        
        return view('tu.alumni.raport.cetak', compact(
            'siswa',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'kenaikan',
            'kelasHistory',
            'semester',
            'tahun'
        ));
    }

    /**
     * Buku Induk Alumni
     */
    public function bukuInduk($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'ayah', 'ibu', 'wali'])->findOrFail($siswa_id);
        
        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa_id)
            ->with('mapel')
            ->orderBy('tahun_ajaran')
            ->orderBy('semester')
            ->get();
        
        $byKelompok = [];
        $tahunAjaranList = [];
        
        foreach ($nilaiRaports as $nilai) {
            if (!$nilai->mapel) continue;
            
            $tahun = $nilai->tahun_ajaran;
            $semester = $nilai->semester;
            $kelompok = $nilai->mapel->kelompok ?? 'A';
            $mapelNama = $nilai->mapel->nama;
            $nilaiAkhir = $nilai->nilai_akhir ?? '-';
            
            $semesterNum = $semester;
            if (is_string($semester)) {
                $semesterNum = strtolower($semester) === 'ganjil' ? 1 : (strtolower($semester) === 'genap' ? 2 : $semester);
            }
            
            if (!in_array($tahun, $tahunAjaranList)) {
                $tahunAjaranList[] = $tahun;
            }
            
            if (!isset($byKelompok[$kelompok])) {
                $byKelompok[$kelompok] = [];
            }
            
            if (!isset($byKelompok[$kelompok][$mapelNama])) {
                $byKelompok[$kelompok][$mapelNama] = [
                    'nama' => $mapelNama,
                    'nilai' => []
                ];
            }
            
            if (!isset($byKelompok[$kelompok][$mapelNama]['nilai'][$tahun])) {
                $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun] = [];
            }
            
            $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun][$semesterNum] = $nilaiAkhir;
        }
        
        sort($tahunAjaranList);
        
        $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa_id)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->first();
        
        $siswa->mutasiTerakhir = $kenaikanKelas;
        
        $nilaiByKelompok = [
            'byKelompok' => $byKelompok,
            'tahunAjaranList' => $tahunAjaranList
        ];
        
        return view('tu.alumni.buku-induk.show', compact('siswa', 'nilaiByKelompok'));
    }

    /**
     * Cetak Buku Induk Alumni
     */
    public function bukuIndukCetak($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'ayah', 'ibu', 'wali'])->findOrFail($siswa_id);
        
        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa_id)
            ->with('mapel')
            ->orderBy('tahun_ajaran')
            ->orderBy('semester')
            ->get();
        
        $byKelompok = [];
        $tahunAjaranList = [];
        
        foreach ($nilaiRaports as $nilai) {
            if (!$nilai->mapel) continue;
            
            $tahun = $nilai->tahun_ajaran;
            $semester = $nilai->semester;
            $kelompok = $nilai->mapel->kelompok ?? 'A';
            $mapelNama = $nilai->mapel->nama;
            $nilaiAkhir = $nilai->nilai_akhir ?? '-';
            
            $semesterNum = $semester;
            if (is_string($semester)) {
                $semesterNum = strtolower($semester) === 'ganjil' ? 1 : (strtolower($semester) === 'genap' ? 2 : $semester);
            }
            
            if (!in_array($tahun, $tahunAjaranList)) {
                $tahunAjaranList[] = $tahun;
            }
            
            if (!isset($byKelompok[$kelompok])) {
                $byKelompok[$kelompok] = [];
            }
            
            if (!isset($byKelompok[$kelompok][$mapelNama])) {
                $byKelompok[$kelompok][$mapelNama] = [
                    'nama' => $mapelNama,
                    'nilai' => []
                ];
            }
            
            if (!isset($byKelompok[$kelompok][$mapelNama]['nilai'][$tahun])) {
                $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun] = [];
            }
            
            $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun][$semesterNum] = $nilaiAkhir;
        }
        
        sort($tahunAjaranList);
        
        $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa_id)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->first();
        
        $siswa->mutasiTerakhir = $kenaikanKelas;
        
        $nilaiByKelompok = [
            'byKelompok' => $byKelompok,
            'tahunAjaranList' => $tahunAjaranList
        ];
        
        return view('tu.alumni.buku-induk.cetak', compact('siswa', 'nilaiByKelompok'));
    }
}