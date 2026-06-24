<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\KenaikanKelas;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\User;
use App\Exports\NilaiExport;
use App\Exports\SiswaExport;
use App\Exports\PklIjazahExport;
use App\Exports\SiswaTemplateExport;
use App\Exports\NilaiTemplateExport;
use App\Exports\PklIjazahTemplateExport;
use App\Imports\SiswaImport;
use App\Imports\NilaiImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BukuIndukController extends Controller
{
    /**
     * Display a listing of students for Buku Induk
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'nilaiRaports.mapel', 'mutasis', 'rombel.kelas.jurusan']);

        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
        }

        // Filter berdasarkan jurusan
        if ($request->filled('jurusan_id')) {
            $query->whereHas('rombel.kelas.jurusan', function($q) {
                $q->where('id', request('jurusan_id'));
            });
        }

        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Only include students currently assigned to a rombel
        $query->whereNotNull('rombel_id');

        // Exclude students who have a 'lulus' mutation (moved to alumni)
        // Use case-insensitive comparison to handle variations like 'Lulus'
        $query->whereDoesntHave('mutasis', function($q) {
            $q->whereRaw('LOWER(status) = ?', ['lulus']);
        });

        // Also exclude students recorded in kenaikan_kelas with status 'lulus' (case-insensitive)
        $excludedIds = KenaikanKelas::whereRaw('LOWER(status) = ?', ['lulus'])
            ->pluck('siswa_id')
            ->unique()
            ->filter()
            ->toArray();
        if (!empty($excludedIds)) {
            $query->whereNotIn('id', $excludedIds);
        }

        $siswas = $query->paginate(15);
        
        // Get all jurusans for filter dropdown
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('tu.buku-induk.index', compact('siswas', 'jurusans'));
    }

    /**
     * Show the Buku Induk for a specific student
     */
    public function show(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'kurikulum',
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

    public function exportSiswa()
    {
        $filename = 'data_siswa_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new SiswaExport(), $filename);
    }

    public function exportNilai()
    {
        $filename = 'nilai_semua_siswa_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new NilaiExport(), $filename);
    }

    public function exportPkl()
    {
        $filename = 'pkl_ijazah_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new PklIjazahExport(), $filename);
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new SiswaImport();
        Excel::import($import, $request->file('file'));

        $message = 'Import data siswa berhasil disimpan.';
        if (method_exists($import, 'getErrors')) {
            $errors = $import->getErrors();
            if (!empty($errors)) {
                return redirect()->route('tu.buku-induk.index')
                    ->with('warning', 'Import selesai namun ada beberapa baris tidak diproses.')
                    ->with('import_errors', $errors);
            }
        }

        return redirect()->route('tu.buku-induk.index')->with('success', $message);
    }

    public function importNilai(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new NilaiImport();
        Excel::import($import, $request->file('file'));

        $message = 'Import nilai berhasil disimpan.';
        if (method_exists($import, 'getErrors')) {
            $errors = $import->getErrors();
            if (!empty($errors)) {
                return redirect()->route('tu.buku-induk.index')
                    ->with('warning', 'Import selesai namun ada beberapa baris tidak diproses.')
                    ->with('import_errors', $errors);
            }
        }

        return redirect()->route('tu.buku-induk.index')->with('success', $message);
    }

    public function importPkl(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new SiswaImport();
        Excel::import($import, $request->file('file'));

        $message = 'Import PKL & Ijazah berhasil disimpan.';
        if (method_exists($import, 'getErrors')) {
            $errors = $import->getErrors();
            if (!empty($errors)) {
                return redirect()->route('tu.buku-induk.index')
                    ->with('warning', 'Import selesai namun ada beberapa baris tidak diproses.')
                    ->with('import_errors', $errors);
            }
        }

        return redirect()->route('tu.buku-induk.index')->with('success', $message);
    }

    public function downloadTemplateSiswa()
    {
        return Excel::download(new SiswaTemplateExport(), 'template_data_siswa.xlsx');
    }

    public function downloadTemplateNilai()
    {
        return Excel::download(new NilaiTemplateExport(), 'template_nilai_rapor.xlsx');
    }

    public function downloadTemplatePkl()
    {
        return Excel::download(new PklIjazahTemplateExport(), 'template_pkl_ijazah.xlsx');
    }

    public function downloadTemplatePklIjazah()
    {
        return Excel::download(new PklIjazahTemplateExport(), 'template_pkl_ijazah.xlsx');
    }

    /**
     * Show printable version of Buku Induk
     */
    public function cetak(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'kurikulum',
            'ayah',
            'ibu',
            'wali',
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
            'kurikulum',
            'ayah',
            'ibu',
            'wali',
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
     * Show edit form for Buku Induk (edit siswa data)
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load(['user','ayah','ibu','wali','rombel.kelas.jurusan','mutasiTerakhir']);
        return view('tu.buku-induk.edit', compact('siswa'));
    }

    /**
     * Update siswa data from Buku Induk edit form
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'nama_lengkap' => 'required|string',
            'nisn' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'dusun' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'pkl_nilai' => 'nullable|string',
            'pkl_sertifikat' => 'nullable|string',
            'pkl_nama_industri' => 'nullable|string',
            'pkl_alamat' => 'nullable|string',
            'ijazah_nomor' => 'nullable|string',
            'ijazah_tanggal' => 'nullable|date',
            'transkip_nomor' => 'nullable|string',
            'transkip_tanggal' => 'nullable|date',
            'tanggal_lulus' => 'nullable|date',
            'status_kelulusan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // other fields may be added as needed
        ]);

        // Update main siswa fields
        $siswa->update($validated);

        // Handle ayah/ibu/wali relations if provided
        $ayahData = $request->input('ayah', []);
        if (!empty(array_filter($ayahData))) {
            if ($siswa->ayah) {
                $siswa->ayah->update($ayahData);
            } else {
                $created = Ayah::create($ayahData);
                $siswa->ayah_id = $created->id;
            }
        }

        $ibuData = $request->input('ibu', []);
        if (!empty(array_filter($ibuData))) {
            if ($siswa->ibu) {
                $siswa->ibu->update($ibuData);
            } else {
                $created = Ibu::create($ibuData);
                $siswa->ibu_id = $created->id;
            }
        }

        $waliData = $request->input('wali', []);
        if (!empty(array_filter($waliData))) {
            if ($siswa->wali) {
                $siswa->wali->update($waliData);
            } else {
                $created = Wali::create($waliData);
                $siswa->wali_id = $created->id;
            }
        }

        // Handle photo upload / removal for related user
        $removeFoto = $request->input('remove_foto', '0');
        if ($removeFoto === '1' && $siswa->user && $siswa->user->photo) {
            Storage::disk('public')->delete($siswa->user->photo);
            $siswa->user->photo = null;
            $siswa->user->save();
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('foto-siswa', 'public');
            if ($siswa->user) {
                if ($siswa->user->photo) {
                    Storage::disk('public')->delete($siswa->user->photo);
                }
                $siswa->user->photo = $path;
                $siswa->user->save();
            }
        }

        $siswa->save();

        return redirect()->route('tu.buku-induk.show', $siswa->id)->with('success', 'Data siswa berhasil diperbarui.');
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
     * Get mata pelajaran by jurusan, kurikulum, and kelas tingkat
     */
    private function getMataPelajaranByJurusan(Siswa $siswa)
    {
        $mapelByKelompok = [];
        
        // Get tingkat kelas siswa
        $tingkat = $siswa->rombel && $siswa->rombel->kelas ? 
                   intval($siswa->rombel->kelas->tingkat) : 10;
        
        // Get kurikulum siswa
        $kurikulumId = $siswa->kurikulum_id;
        
        // First priority: Get from jurusan if siswa has one
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            $jurusanId = $siswa->rombel->kelas->jurusan->id;
            
            // Strategy 1: Try to get with jurusan + kurikulum + tingkat
            $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })
            ->whereHas('kurikulums', function($q) use ($kurikulumId) {
                $q->where('kurikulum_id', $kurikulumId);
            })
            ->whereHas('tingkats', function($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            })
            ->orderBy('kelompok')
            ->orderBy('urutan')
            ->get();
            
            // Strategy 2: If no result, try jurusan + tingkat (without kurikulum)
            if ($mapels->count() === 0) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusan_id', $jurusanId);
                })
                ->whereHas('tingkats', function($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            // Strategy 3: If still no result, try jurusan + kurikulum (without tingkat)
            if ($mapels->count() === 0 && $kurikulumId) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusan_id', $jurusanId);
                })
                ->whereHas('kurikulums', function($q) use ($kurikulumId) {
                    $q->where('kurikulum_id', $kurikulumId);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            // Strategy 4: If still no result, try jurusan only
            if ($mapels->count() === 0) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusan_id', $jurusanId);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            // Process mapels
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
            $firstJurusan = Jurusan::first();
            if ($firstJurusan) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($firstJurusan) {
                    $q->where('jurusan_id', $firstJurusan->id);
                })
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
