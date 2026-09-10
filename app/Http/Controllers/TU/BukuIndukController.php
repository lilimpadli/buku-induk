<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\TahunAjaran;
use App\Models\DataSiswa as Siswa;
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
use App\Exports\NilaiRaportExportByJurusan;
use App\Exports\NilaiRaportTemplateByJurusan;
use App\Exports\NilaiRaportTemplateByFilters;
use App\Imports\SiswaImport;
use App\Imports\NilaiImport;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BukuIndukController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'nilaiRaports.mapel', 'mutasis', 'rombel.kelas.jurusan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
        }

        if ($request->filled('jurusan_id')) {
            $query->whereHas('rombel.kelas.jurusan', function($q) {
                $q->where('id', request('jurusan_id'));
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->filterByJenisKelamin($request->jenis_kelamin);
        }

        $query->whereNotNull('rombel_id');

        $query->whereDoesntHave('mutasis', function($q) {
            $q->whereRaw('LOWER(status) = ?', ['lulus']);
        });

        $excludedIds = KenaikanKelas::whereRaw('LOWER(status) = ?', ['lulus'])
            ->pluck('siswa_id')
            ->unique()
            ->filter()
            ->toArray();
        if (!empty($excludedIds)) {
            $query->whereNotIn('id', $excludedIds);
        }

        $perPage = (int) $request->query('per_page', 15);
        $allowedPerPage = [15, 25, 50, 100, 200, 500];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 15;

        $siswas = $query->paginate($perPage)->withQueryString();
        
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('tu.buku-induk.index', compact('siswas', 'jurusans', 'perPage'));
    }

    public function show(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'kurikulum',
            'agama',
            'mutasis',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.show', compact('siswa', 'nilaiByKelompok'));
    }

    public function exportSiswa(Request $request)
    {
        try {
            // Ambil parameter filter
            $kelasId = $request->input('kelas');
            $rombelId = $request->input('rombel');
            $tahunAjaran = $request->input('tahun_ajaran');
            $semester = $request->input('semester');
            $status = $request->input('status');

            // BUILD NAMA FILE BERDASARKAN FILTER
            $fileName = 'Buku_Induk';
            
            // Tambahkan tahun ajaran
            if ($tahunAjaran) {
                $fileName .= '_' . str_replace('/', '-', $tahunAjaran);
            }
            
            // Tambahkan semester
            if ($semester) {
                $fileName .= '_' . $semester;
            }
            
            // Tambahkan kelas & rombel
            if ($kelasId || $rombelId) {
                $kelas = \App\Models\Kelas::find($kelasId);
                $rombel = \App\Models\Rombel::find($rombelId);
                
                if ($kelas) {
                    $fileName .= '_' . $kelas->nama;
                }
                if ($rombel) {
                    $fileName .= '_' . $rombel->nama;
                }
            }
            
            // Tambahkan status
            if ($status) {
                $fileName .= '_' . $status;
            }
            
            // Tambahkan tanggal
            $fileName .= '_' . date('Y-m-d');
            
            $fileName .= '.xlsx';

            // Query data siswa dengan filter
            $query = Siswa::with(['rombel.kelas.jurusan', 'user']);
            
            if ($kelasId) {
                $query->whereHas('rombel.kelas', function($q) use ($kelasId) {
                    $q->where('id', $kelasId);
                });
            }
            
            if ($rombelId) {
                $query->where('rombel_id', $rombelId);
            }
            
            if ($tahunAjaran) {
                $query->where('tahun_ajaran', $tahunAjaran);
            }
            
            // Filter status (aktif/tidak)
            if ($status === 'aktif') {
                $query->where('status', 'Aktif');
            } elseif ($status === 'tidak_aktif') {
                $query->where('status', '!=', 'Aktif');
            }
            
            $siswa = $query->get();

            // Generate Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $headers = ['No', 'NIS', 'NISN', 'Nama', 'Kelas', 'Jurusan', 'Rombel', 'Tahun Ajaran', 'Status'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $col++;
            }

            // Isi data
            $row = 2;
            $no = 1;
            foreach ($siswa as $s) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $s->nis);
                $sheet->setCellValue('C' . $row, $s->nisn);
                $sheet->setCellValue('D' . $row, $s->nama_lengkap);
                $sheet->setCellValue('E' . $row, $s->rombel?->kelas?->nama ?? '-');
                $sheet->setCellValue('F' . $row, $s->rombel?->kelas?->jurusan?->nama ?? '-');
                $sheet->setCellValue('G' . $row, $s->rombel?->nama ?? '-');
                $sheet->setCellValue('H' . $row, $s->tahun_ajaran ?? '-');
                $sheet->setCellValue('I' . $row, $s->status ?? 'Aktif');
                $row++;
            }

            // Auto size columns
            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Export
            $writer = new Xlsx($spreadsheet);
            $tempFile = tempnam(sys_get_temp_dir(), 'export_');
            $writer->save($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ Gagal export: ' . $e->getMessage());
        }
    }

    public function exportNilai(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        $search = $request->query('search');
        $semester = $request->query('semester');
        $tahunAjaran = $request->query('tahun_ajaran');

        $filename = 'nilai_raport_' . ($jurusanId ? 'jurusan_' . $jurusanId . '_' : '') . date('Ymd_His') . '.xlsx';
        return Excel::download(new NilaiRaportExportByJurusan($jurusanId, $search, $semester, $tahunAjaran), $filename);
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

    $semester = $request->input('semester', 'Ganjil');
    $tahunAjaran = $request->input('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));

    try {
        $file = $request->file('file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        // 🔥 PERBAIKAN: Gunakan Coordinate untuk mendapatkan semua kolom
        $headers = [];
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        
        for ($colIndex = 1; $colIndex <= $highestColumnIndex; $colIndex++) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
            $headers[$colIndex - 1] = $worksheet->getCell($columnLetter . '1')->getValue();
        }

        // Buat mapel map
        $mapelMap = [];
        $mapels = \App\Models\MataPelajaran::all();
        foreach ($mapels as $mapel) {
            $mapelMap[strtolower(trim($mapel->nama))] = $mapel->id;
        }

        $successCount = 0;
        $errors = [];

        for ($row = 2; $row <= $highestRow; $row++) {
            $nis = $worksheet->getCell('B' . $row)->getValue();
            $nisn = $worksheet->getCell('C' . $row)->getValue();

            if (empty($nis) || empty($nisn)) {
                continue;
            }

            $siswa = \App\Models\DataSiswa::where('nis', $nis)->where('nisn', $nisn)->first();
            if (!$siswa) {
                $errors[] = "Siswa NIS {$nis} tidak ditemukan (baris {$row})";
                continue;
            }

            // Ambil semester dari Excel atau pakai default
            $semesterVal = $worksheet->getCell('F' . $row)->getValue() ?: $semester;
            $semesterVal = strtolower($semesterVal);
            if ($semesterVal === 'ganjil' || $semesterVal === '1') {
                $semesterVal = 'Ganjil';
            } elseif ($semesterVal === 'genap' || $semesterVal === '2') {
                $semesterVal = 'Genap';
            }

            $tahunVal = $worksheet->getCell('G' . $row)->getValue() ?: $tahunAjaran;

            // 🔥 PERBAIKAN: Loop berdasarkan header dengan index yang benar
            // Kolom mulai dari index 7 (kolom H) untuk mata pelajaran
            for ($colIndex = 7; $colIndex < count($headers); $colIndex++) {
                $mapelNama = trim($headers[$colIndex] ?? '');
                
                // Lewati jika header kosong
                if (empty($mapelNama)) {
                    continue;
                }

                // Dapatkan nilai dengan cara yang benar
                $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                $nilaiValue = $worksheet->getCell($columnLetter . $row)->getValue();

                if ($nilaiValue === null || $nilaiValue === '') {
                    continue;
                }

                $mapelId = $mapelMap[strtolower(trim($mapelNama))] ?? null;
                if (!$mapelId) {
                    $errors[] = "Mata pelajaran '{$mapelNama}' tidak ditemukan (baris {$row})";
                    continue;
                }

                \App\Models\NilaiRaport::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mapelId,
                        'semester' => $semesterVal,
                        'tahun_ajaran' => $tahunVal,
                    ],
                    [
                        'nilai_akhir' => (float) $nilaiValue,
                        'kelas_id' => $siswa->rombel->kelas_id ?? null,
                        'rombel_id' => $siswa->rombel_id,
                    ]
                );
                $successCount++;
            }
        }

        $message = "✅ Import selesai! {$successCount} nilai berhasil disimpan.";
        if (!empty($errors)) {
            // Batasi error yang ditampilkan
            $errorLimit = array_slice($errors, 0, 20);
            $errorCount = count($errors);
            if ($errorCount > 20) {
                $errorLimit[] = "... dan " . ($errorCount - 20) . " error lainnya.";
            }
            return redirect()->route('tu.buku-induk.index')
                ->with('warning', $message)
                ->with('import_errors', $errorLimit);
        }

        return redirect()->route('tu.buku-induk.index')->with('success', $message);

    } catch (\Exception $e) {
        Log::error('Import nilai error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        return redirect()->route('tu.buku-induk.index')
            ->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
    }
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

    public function downloadTemplateNilaiFiltered(Request $request)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $kurikulumIds = $request->input('kurikulum_ids', []);
        $jurusanIds = $request->input('jurusan_ids', []);
        $tingkatLevels = $request->input('tingkat_levels', []);
        $konsentrasiIds = $request->input('konsentrasi_ids', []);

        if (empty($kurikulumIds) && empty($jurusanIds) && empty($tingkatLevels) && empty($konsentrasiIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu filter!');
        }

        $fileName = 'template_nilai_rapor_' . date('Ymd_His') . '.xlsx';
        
        return Excel::download(
            new \App\Exports\NilaiRaportTemplateByFilters($kurikulumIds, $jurusanIds, $tingkatLevels, $konsentrasiIds),
            $fileName
        );
    }

    public function cetak(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'kurikulum',
            'agama',
            'mutasis', 
            'mutasiTerakhir',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.cetak', compact('siswa', 'nilaiByKelompok'));
    }

    public function export(Siswa $siswa)
    {
        $siswa->load([
            'user', 
            'rombel.kelas.jurusan',
            'kurikulum',
            'agama',
            'mutasis', 
            'mutasiTerakhir',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        return $this->cetak($siswa);
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load(['user','rombel.kelas.jurusan','mutasiTerakhir','agama']);
        $agamas = Agama::all();
        return view('tu.buku-induk.edit', compact('siswa', 'agamas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama_id' => 'nullable|exists:agamas,id',
            'agama_lainnya' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'dusun' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kode_pos' => 'nullable|string|max:10',
            'pkl_nilai' => 'nullable|string|max:50',
            'pkl_sertifikat' => 'nullable|string|max:100',
            'pkl_nama_industri' => 'nullable|string|max:255',
            'pkl_alamat' => 'nullable|string',
            'ijazah_nomor' => 'nullable|string|max:100',
            'ijazah_tanggal' => 'nullable|date',
            'transkip_nomor' => 'nullable|string|max:100',
            'transkip_tanggal' => 'nullable|date',
            'tanggal_lulus' => 'nullable|date',
            'status_kelulusan' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->agama_id === 'other') {
            $agamaId = null;
            $agamaLainnya = $request->agama_lainnya;
        } elseif ($request->agama_id) {
            $agamaId = $request->agama_id;
            $agamaLainnya = null;
        } else {
            $agamaId = null;
            $agamaLainnya = null;
        }

        $siswa->update([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama_id' => $agamaId,
            'agama_lainnya' => $agamaLainnya,
            'kewarganegaraan' => $request->kewarganegaraan,
            'dusun' => $request->dusun,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'pkl_nilai' => $request->pkl_nilai,
            'pkl_sertifikat' => $request->pkl_sertifikat,
            'pkl_nama_industri' => $request->pkl_nama_industri,
            'pkl_alamat' => $request->pkl_alamat,
            'ijazah_nomor' => $request->ijazah_nomor,
            'ijazah_tanggal' => $request->ijazah_tanggal,
            'transkip_nomor' => $request->transkip_nomor,
            'transkip_tanggal' => $request->transkip_tanggal,
            'tanggal_lulus' => $request->tanggal_lulus,
            'status_kelulusan' => $request->status_kelulusan,
        ]);

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

    private function getTahunAjaranList(Siswa $siswa)
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        
        if ($currentMonth >= 7) {
            $tahunAjaranAktif = $currentYear . '/' . ($currentYear + 1);
        } else {
            $tahunAjaranAktif = ($currentYear - 1) . '/' . $currentYear;
        }
        
        $tahunAktifMulai = (int) substr($tahunAjaranAktif, 0, 4);
        
        $tingkat = 10;
        if ($siswa->rombel && $siswa->rombel->kelas) {
            $tingkatRaw = $siswa->rombel->kelas->tingkat;
            if (is_numeric($tingkatRaw)) {
                $tingkat = (int) $tingkatRaw;
            } else {
                $map = ['X' => 10, 'XI' => 11, 'XII' => 12];
                $tingkat = $map[strtoupper($tingkatRaw)] ?? 10;
            }
        }
        
        $offset = $tingkat - 10;
        $tahunKelasX = $tahunAktifMulai - $offset;
        
        $tahunAjaranList = [];
        for ($i = 0; $i < 3; $i++) {
            $year = $tahunKelasX + $i;
            $tahunAjaranList[] = $year . '/' . ($year + 1);
        }
        
        return $tahunAjaranList;
    }

    private function getMataPelajaranByJurusan(Siswa $siswa)
    {
        $mapelByKelompok = [];
        
        $tingkat = $siswa->rombel && $siswa->rombel->kelas ? 
                   intval($siswa->rombel->kelas->tingkat) : 10;
        
        $kurikulumId = $siswa->kurikulum_id;
        
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            $jurusanId = $siswa->rombel->kelas->jurusan->id;
            
            $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                $q->where('jurusans.id', $jurusanId);
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
            
            if ($mapels->count() === 0) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusans.id', $jurusanId);
                })
                ->whereHas('tingkats', function($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            if ($mapels->count() === 0 && $kurikulumId) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusans.id', $jurusanId);
                })
                ->whereHas('kurikulums', function($q) use ($kurikulumId) {
                    $q->where('kurikulum_id', $kurikulumId);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            if ($mapels->count() === 0) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                    $q->where('jurusans.id', $jurusanId);
                })
                ->orderBy('kelompok')
                ->orderBy('urutan')
                ->get();
            }
            
            if ($mapels->count() > 0) {
                foreach ($mapels as $mapel) {
                    $kelompok = $mapel->kelompok;
                    $mapelNama = trim($mapel->nama);
                    
                    if (!isset($mapelByKelompok[$kelompok])) {
                        $mapelByKelompok[$kelompok] = [];
                    }
                    
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
        
        if (empty($mapelByKelompok) && $siswa->nilaiRaports->count() > 0) {
            foreach ($siswa->nilaiRaports as $nilai) {
                $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
                $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
                $mapelUrutan = $nilai->mapel->urutan ?? 999;
                
                if (!isset($mapelByKelompok[$kelompok])) {
                    $mapelByKelompok[$kelompok] = [];
                }
                
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
        
        if (empty($mapelByKelompok) && !($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan)) {
            $firstJurusan = Jurusan::first();
            if ($firstJurusan) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($firstJurusan) {
                    $q->where('jurusans.id', $firstJurusan->id);
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
        
        foreach ($mapelByKelompok as &$mapels) {
            usort($mapels, function ($a, $b) {
                if ($a['urutan'] == $b['urutan']) {
                    return strcmp($a['nama'], $b['nama']);
                }
                return $a['urutan'] - $b['urutan'];
            });
        }
        
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

    private function groupNilaiByKelompok(Siswa $siswa)
    {
        $nilaiByKelompok = [];
        $tahunAjaranList = [];
        $semesterMap = ['Ganjil' => 1, 'Genap' => 2, 1 => 1, 2 => 2];
        
        $tahunAjaranList = $this->getTahunAjaranList($siswa);
        
        $mapelByKelompok = $this->getMataPelajaranByJurusan($siswa);
        
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
                    
                    foreach ($tahunAjaranList as $tahunAjaran) {
                        $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [
                            1 => null,
                            2 => null
                        ];
                    }
                }
            }
        }
        
        foreach ($siswa->nilaiRaports as $nilai) {
            $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
            $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
            $tahunAjaran = $nilai->tahun_ajaran;
            $semester = $semesterMap[$nilai->semester] ?? $nilai->semester;
            
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
            
            $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran][$semester] = $nilai->nilai_akhir;
        }
        
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