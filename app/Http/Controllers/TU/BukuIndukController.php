<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class BukuIndukController extends Controller
{
    /**
     * Display a listing of students for Buku Induk
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'nilaiRaports.mapel', 'mutasis']);

        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
        }

        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter berdasarkan rombel
        if ($request->filled('rombel_id')) {
            // Assuming siswa has relationship to rombel through some join table
            // Adjust this based on your actual database structure
        }

        $siswas = $query->paginate(15);

        return view('tu.buku-induk.index', compact('siswas'));
    }

    /**
     * Show the Buku Induk for a specific student
     */
    public function show(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'mutasis',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        // Group nilai by kelompok and nama mata pelajaran
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.show', compact('siswa', 'nilaiByKelompok'));
    }

    /**
     * Show printable version of Buku Induk
     */
    public function cetak(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'mutasis', 
            'mutasiTerakhir',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        // Group nilai by kelompok and nama mata pelajaran
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.cetak', compact('siswa', 'nilaiByKelompok'));
    }

    /**
     * Export Buku Induk to PDF
     */
    public function export(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'mutasis', 
            'mutasiTerakhir',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        // This would require a PDF library like DomPDF
        // For now, we'll return the print view
        return $this->cetak($siswa);
    }

    /**
     * Get tahun ajaran list based on student's class level
     */
    private function getTahunAjaranList(Siswa $siswa)
    {
        // Get current year and month
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        // Determine tahun ajaran saat ini
        // Jika bulan < 7 (sebelum Juli), tahun ajaran adalah tahun lalu
        $tahunAjaranSekarang = $currentMonth < 7 ? $currentYear - 1 : $currentYear;
        
        // Get student's class level (tingkat)
        $tingkat = $siswa->rombel && $siswa->rombel->kelas ? 
                   intval($siswa->rombel->kelas->tingkat) : 10;
        
        // Get tahun masuk from nilaiRaports or estimate
        $tahunMasuk = null;
        if ($siswa->nilaiRaports->count() > 0) {
            $tahunMasukStr = $siswa->nilaiRaports->first()->tahun_ajaran;
            $tahunMasuk = intval(explode('/', $tahunMasukStr)[0]);
        }
        
        // If no nilai found, estimate from current tahun ajaran and tingkat
        // Kelas 10 masuk tahun ini, Kelas 11 masuk tahun lalu, Kelas 12 2 tahun lalu
        if (!$tahunMasuk) {
            $tahunMasuk = $tahunAjaranSekarang - ($tingkat - 10);
        }
        
        // Generate tahun ajaran list for 3 years (Kelas 10, 11, 12)
        $tahunAjaranList = [];
        for ($i = 0; $i < 3; $i++) {
            $startYear = $tahunMasuk + $i;
            $endYear = $startYear + 1;
            $tahunAjaranList[] = "{$startYear}/{$endYear}";
        }
        
        return $tahunAjaranList;
    }

    /**
     * Get mata pelajaran by jurusan and kelompok
     */
    private function getMataPelajaranByJurusan(Siswa $siswa)
    {
        $mapelByKelompok = [];
        
        // First priority: Get from jurusan if siswa has one
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            $jurusanId = $siswa->rombel->kelas->jurusan->id;
            
            // Get all mata pelajaran for this specific jurusan
            $mapels = MataPelajaran::where('jurusan_id', $jurusanId)
                                   ->orderBy('kelompok')
                                   ->orderBy('urutan')
                                   ->get();
            
            if ($mapels->count() > 0) {
                foreach ($mapels as $mapel) {
                    $kelompok = $mapel->kelompok;
                    $mapelNama = trim($mapel->nama);
                    
                    if (!isset($mapelByKelompok[$kelompok])) {
                        $mapelByKelompok[$kelompok] = [];
                    }
                    
                    // Check if this mapel name already exists in this kelompok
                    $exists = false;
                    foreach ($mapelByKelompok[$kelompok] as $existing) {
                        if (trim($existing['nama']) === $mapelNama) {
                            $exists = true;
                            break;
                        }
                    }
                    
                    if (!$exists) {
                        $mapelByKelompok[$kelompok][] = [
                            'nama' => $mapelNama,
                            'urutan' => $mapel->urutan,
                        ];
                    }
                }
            }
        }
        
        // Second priority: If no mapel from jurusan, get from nilai raport
        if (empty($mapelByKelompok) && $siswa->nilaiRaports->count() > 0) {
            foreach ($siswa->nilaiRaports as $nilai) {
                $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
                $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
                $mapelUrutan = $nilai->mapel->urutan ?? 999;
                
                if (!isset($mapelByKelompok[$kelompok])) {
                    $mapelByKelompok[$kelompok] = [];
                }
                
                // Check if already added
                $exists = false;
                foreach ($mapelByKelompok[$kelompok] as $existing) {
                    if (trim($existing['nama']) === $mapelNama) {
                        $exists = true;
                        break;
                    }
                }
                
                if (!$exists) {
                    $mapelByKelompok[$kelompok][] = [
                        'nama' => $mapelNama,
                        'urutan' => $mapelUrutan,
                    ];
                }
            }
        }
        
        // Third priority: If still empty and no jurusan, use first jurusan as fallback placeholder
        if (empty($mapelByKelompok) && !($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan)) {
            $firstJurusan = \App\Models\Jurusan::first();
            if ($firstJurusan) {
                $mapels = MataPelajaran::where('jurusan_id', $firstJurusan->id)
                                       ->orderBy('kelompok')
                                       ->orderBy('urutan')
                                       ->get();
                
                if ($mapels->count() > 0) {
                    foreach ($mapels as $mapel) {
                        $kelompok = $mapel->kelompok;
                        $mapelNama = trim($mapel->nama);
                        
                        if (!isset($mapelByKelompok[$kelompok])) {
                            $mapelByKelompok[$kelompok] = [];
                        }
                        
                        // Check if this mapel name already exists
                        $exists = false;
                        foreach ($mapelByKelompok[$kelompok] as $existing) {
                            if (trim($existing['nama']) === $mapelNama) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if (!$exists) {
                            $mapelByKelompok[$kelompok][] = [
                                'nama' => $mapelNama,
                                'urutan' => $mapel->urutan,
                            ];
                        }
                    }
                }
            }
        }
        
        // Sort each kelompok by urutan and nama
        foreach ($mapelByKelompok as &$mapels) {
            usort($mapels, function ($a, $b) {
                if ($a['urutan'] == $b['urutan']) {
                    return strcmp($a['nama'], $b['nama']);
                }
                return $a['urutan'] - $b['urutan'];
            });
        }
        
        // Sort kelompok
        $sortedKelompok = [];
        foreach (['A', 'B'] as $k) {
            if (isset($mapelByKelompok[$k])) {
                $sortedKelompok[$k] = $mapelByKelompok[$k];
            }
        }
        foreach ($mapelByKelompok as $k => $v) {
            if (!isset($sortedKelompok[$k])) {
                $sortedKelompok[$k] = $v;
            }
        }
        
        return $sortedKelompok;
    }

    /**
     * Group nilai raport by kelompok mata pelajaran
     */
    private function groupNilaiByKelompok(Siswa $siswa)
    {
        $nilaiByKelompok = [];
        $tahunAjaranList = [];
        $semesterMap = ['Ganjil' => 1, 'Genap' => 2, 1 => 1, 2 => 2];
        
        // Get tahun ajaran list
        $tahunAjaranList = $this->getTahunAjaranList($siswa);
        
        // Get mata pelajaran from database
        $mapelByKelompok = $this->getMataPelajaranByJurusan($siswa);
        
        // Initialize structure with mata pelajaran from database
        foreach ($mapelByKelompok as $kelompok => $mapels) {
            if (!isset($nilaiByKelompok[$kelompok])) {
                $nilaiByKelompok[$kelompok] = [];
            }
            
            foreach ($mapels as $mapel) {
                $mapelNama = $mapel['nama'];
                if (!isset($nilaiByKelompok[$kelompok][$mapelNama])) {
                    $nilaiByKelompok[$kelompok][$mapelNama] = [
                        'nama' => $mapelNama,
                        'urutan' => $mapel['urutan'],
                        'nilai' => []
                    ];
                    
                    // Initialize all tahun ajaran with empty values
                    foreach ($tahunAjaranList as $tahunAjaran) {
                        $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [
                            1 => null,
                            2 => null
                        ];
                    }
                }
            }
        }
        
        // Fill in actual nilai from database
        foreach ($siswa->nilaiRaports as $nilai) {
            $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
            $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
            $tahunAjaran = $nilai->tahun_ajaran;
            $semester = $semesterMap[$nilai->semester] ?? $nilai->semester;
            
            // Initialize if not exists
            if (!isset($nilaiByKelompok[$kelompok])) {
                $nilaiByKelompok[$kelompok] = [];
            }
            if (!isset($nilaiByKelompok[$kelompok][$mapelNama])) {
                $nilaiByKelompok[$kelompok][$mapelNama] = [
                    'nama' => $mapelNama,
                    'urutan' => $nilai->mapel->urutan ?? 999,
                    'nilai' => []
                ];
            }
            if (!isset($nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran])) {
                $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [
                    1 => null,
                    2 => null
                ];
            }
            
            // Store nilai
            $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran][$semester] = $nilai->nilai_akhir;
        }
        
        // Sort kelompok: A dulu, B kedua
        $sortedKelompok = [];
        foreach (['A', 'B'] as $k) {
            if (isset($nilaiByKelompok[$k])) {
                $sortedKelompok[$k] = $nilaiByKelompok[$k];
            }
        }
        foreach ($nilaiByKelompok as $k => $v) {
            if (!isset($sortedKelompok[$k])) {
                $sortedKelompok[$k] = $v;
            }
        }
        
        // Sort mata pelajaran dalam setiap kelompok berdasarkan urutan
        foreach ($sortedKelompok as &$mapelGroup) {
            uasort($mapelGroup, function ($a, $b) {
                if ($a['urutan'] == $b['urutan']) {
                    return strcmp($a['nama'], $b['nama']);
                }
                return $a['urutan'] - $b['urutan'];
            });
        }
        
        return [
            'byKelompok' => $sortedKelompok,
            'tahunAjaranList' => $tahunAjaranList
        ];
    }
}
