<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Rombel;
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
     * Group nilai raport by kelompok mata pelajaran
     */
    private function groupNilaiByKelompok(Siswa $siswa)
    {
        $nilaiByKelompok = [];
        $tahunAjaranList = [];
        $semesterMap = ['Ganjil' => 1, 'Genap' => 2, 1 => 1, 2 => 2];
        
        foreach ($siswa->nilaiRaports as $nilai) {
            $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
            $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
            $mapelUrutan = $nilai->mapel->urutan ?? 999;
            
            // Initialize kelompok if not exists
            if (!isset($nilaiByKelompok[$kelompok])) {
                $nilaiByKelompok[$kelompok] = [];
            }
            
            // Initialize mata pelajaran by NAMA (to consolidate same names)
            if (!isset($nilaiByKelompok[$kelompok][$mapelNama])) {
                $nilaiByKelompok[$kelompok][$mapelNama] = [
                    'nama' => $mapelNama,
                    'urutan' => $mapelUrutan,
                    'nilai' => []
                ];
            }
            
            // Ambil tahun ajaran dan semester dari database
            $tahunAjaran = $nilai->tahun_ajaran;
            $semester = $semesterMap[$nilai->semester] ?? $nilai->semester;
            
            // Track all unique tahun ajaran
            if (!in_array($tahunAjaran, $tahunAjaranList)) {
                $tahunAjaranList[] = $tahunAjaran;
            }
            
            // Store nilai by tahun ajaran and semester
            if (!isset($nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran])) {
                $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [];
            }
            
            // Ambil nilai_akhir dari database (gunakan yang pertama jika ada duplikat)
            if (!isset($nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran][$semester])) {
                $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran][$semester] = $nilai->nilai_akhir;
            }
        }
        
        // Sort tahun ajaran
        sort($tahunAjaranList);
        
        // Sort kelompok: A dulu, B kedua, lainnya dibelakang
        $sortedKelompok = [];
        foreach (['A', 'B'] as $k) {
            if (isset($nilaiByKelompok[$k])) {
                $sortedKelompok[$k] = $nilaiByKelompok[$k];
            }
        }
        // Add any remaining kelompok
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
