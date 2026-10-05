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
    protected $mapelAlias = [
        'Kreativitas, Inovasi, dan Kewirausahaan' => 'Projek Kreatif dan Kewirausahaan',
        'Muatan Lokal Bahasa Daerah' => 'Muatan Lokal',
        'Layanan Perbankan' => 'Mata Pelajaran Pilihan',
        'Desain Grafis' => 'Mata Pelajaran Pilihan',
        'Pengembangan Gim' => 'Mata Pelajaran Pilihan',
        'Pemrograman Web' => 'Mata Pelajaran Pilihan',
        'BIM' => 'Mata Pelajaran Pilihan',
        'Kerja Bangku' => 'Mata Pelajaran Pilihan',
        'Pengelasan' => 'Mata Pelajaran Pilihan',
        'Musik Nusantara' => 'Mata Pelajaran Pilihan',
        'Musik Kolaborasi' => 'Mata Pelajaran Pilihan',
    ];

    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'nilaiRaports.mapel', 'mutasis', 'rombel.kelas.jurusan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
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
            'kenaikanKelas.rombelTujuan.kelas.jurusan',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);

        $konsentrasi = $this->detectKonsentrasi($siswa);
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.show', compact('siswa', 'nilaiByKelompok', 'konsentrasi'));
    }

    protected function detectKonsentrasi(Siswa $siswa): string
    {
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            return $siswa->rombel->kelas->jurusan->nama;
        }

        if ($siswa->relationLoaded('kenaikanKelas') || $siswa->kenaikanKelas) {
            $kenaikan = $siswa->kenaikanKelas
                ->sortByDesc('created_at')
                ->sortByDesc('id')
                ->first();

            if ($kenaikan) {
                if ($kenaikan->jurusan_id) {
                    $jurusan = Jurusan::find($kenaikan->jurusan_id);
                    if ($jurusan) {
                        return $jurusan->nama;
                    }
                }

                if ($kenaikan->rombel_tujuan_id) {
                    $rombel = DB::table('rombels')->where('id', $kenaikan->rombel_tujuan_id)->first();
                    if ($rombel && $rombel->id_konke) {
                        $konke = DB::table('konsentrasi_keahlian')->where('id', $rombel->id_konke)->first();
                        if ($konke) {
                            return $konke->nama_konsentrasi;
                        }
                    }
                }
            }
        }

        return 'Tidak Tersedia';
    }

    public function exportSiswa(Request $request)
    {
        try {
            $search = $request->input('search');
            $jurusanId = $request->input('jurusan_id');

            $fileName = 'Buku_Induk';
            if ($search) {
                $fileName .= '_' . preg_replace('/[^A-Za-z0-9]/', '', $search);
            }
            if ($jurusanId) {
                $jurusan = \App\Models\Jurusan::find($jurusanId);
                if ($jurusan) {
                    $fileName .= '_' . preg_replace('/[^A-Za-z0-9]/', '', $jurusan->nama);
                }
            }
            $fileName .= '_' . date('Y-m-d') . '.xlsx';

            $query = Siswa::with(['rombel.kelas.jurusan', 'user', 'kenaikanKelas']);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");
                });
            }

            if ($jurusanId) {
                $query->whereHas('rombel.kelas.jurusan', function ($q) use ($jurusanId) {
                    $q->where('id', $jurusanId);
                });
            }

            $query->whereDoesntHave('mutasis', function ($q) {
                $q->whereRaw('LOWER(status) = ?', ['lulus']);
            });

            $excludedByKenaikan = \App\Models\KenaikanKelas::whereRaw('LOWER(status) = ?', ['lulus'])
                ->pluck('siswa_id')
                ->unique()
                ->filter()
                ->toArray();

            if (!empty($excludedByKenaikan)) {
                $query->whereNotIn('id', $excludedByKenaikan);
            }

            $siswa = $query->orderBy('nama_lengkap')->get();

            $fallbackTahunAjaran = '-';
            $semesterAktif = \App\Models\Semester::where('is_active', 1)->first();
            if ($semesterAktif && $semesterAktif->tahunAjaran) {
                $fallbackTahunAjaran = $semesterAktif->tahunAjaran->tahun;
            } else {
                $semesterCurrent = \App\Models\Semester::where('is_current', 1)->first();
                if ($semesterCurrent && $semesterCurrent->tahunAjaran) {
                    $fallbackTahunAjaran = $semesterCurrent->tahunAjaran->tahun;
                } else {
                    $taTerakhir = \App\Models\TahunAjaran::orderBy('id', 'desc')->first();
                    if ($taTerakhir) {
                        $fallbackTahunAjaran = $taTerakhir->tahun;
                    }
                }
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headers = ['No', 'NIS', 'NISN', 'Nama', 'Kelas', 'Jurusan', 'Rombel', 'Tahun Ajaran', 'Status'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $col++;
            }

            $row = 2;
            $no = 1;
            foreach ($siswa as $s) {
                $taSiswa = $fallbackTahunAjaran;
                if ($s->kenaikanKelas && $s->kenaikanKelas->count() > 0) {
                    $kenaikanTerakhir = $s->kenaikanKelas
                        ->sortByDesc('created_at')
                        ->sortByDesc('id')
                        ->first();
                    if ($kenaikanTerakhir && !empty($kenaikanTerakhir->tahun_ajaran)) {
                        $taSiswa = $kenaikanTerakhir->tahun_ajaran;
                    }
                }

                $statusSiswa = 'Aktif';
                if ($s->mutasis && $s->mutasis->count() > 0) {
                    $mutasiTerakhir = $s->mutasis->sortByDesc('id')->first();
                    if ($mutasiTerakhir && strtolower($mutasiTerakhir->status) === 'lulus') {
                        $statusSiswa = 'Lulus';
                    }
                }
                if ($statusSiswa === 'Aktif' && !empty($excludedByKenaikan) && in_array($s->id, $excludedByKenaikan)) {
                    $statusSiswa = 'Lulus';
                }

                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $s->nis ?? '-');
                $sheet->setCellValue('C' . $row, $s->nisn ?? '-');
                $sheet->setCellValue('D' . $row, $s->nama_lengkap ?? '-');
                $sheet->setCellValue('E' . $row, $s->rombel?->kelas?->tingkat ?? '-');
                $sheet->setCellValue('F' . $row, $s->rombel?->kelas?->jurusan?->nama ?? '-');
                $sheet->setCellValue('G' . $row, $s->rombel?->nama ?? '-');
                $sheet->setCellValue('H' . $row, $taSiswa);
                $sheet->setCellValue('I' . $row, $statusSiswa);
                $row++;
            }

            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $tempFile = tempnam(sys_get_temp_dir(), 'export_');
            $writer->save($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal export: ' . $e->getMessage());
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
        set_time_limit(600);
        ini_set('memory_limit', '1024M');

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

            $headers = [];
            $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
            
            for ($colIndex = 1; $colIndex <= $highestColumnIndex; $colIndex++) {
                $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
                $headers[$colIndex - 1] = $worksheet->getCell($columnLetter . '1')->getValue();
            }

            $mapelMap = [];
            $mapels = \App\Models\MataPelajaran::all();
            foreach ($mapels as $mapel) {
                $mapelMap[strtolower(trim($mapel->nama))] = $mapel->id;
            }

            $mapelAlias = [
                'projek kreatif dan kewirausahaan' => 'kreativitas, inovasi, dan kewirausahaan',
                'pkk' => 'kreativitas, inovasi, dan kewirausahaan',
                'muatan lokal' => 'muatan lokal',
                'mulok' => 'muatan lokal',
            ];

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

                $semesterVal = $worksheet->getCell('F' . $row)->getValue() ?: $semester;
                $semesterVal = strtolower($semesterVal);
                if ($semesterVal === 'ganjil' || $semesterVal === '1') {
                    $semesterVal = 'Ganjil';
                } elseif ($semesterVal === 'genap' || $semesterVal === '2') {
                    $semesterVal = 'Genap';
                }

                $tahunVal = $worksheet->getCell('G' . $row)->getValue() ?: $tahunAjaran;

                for ($colIndex = 7; $colIndex < count($headers); $colIndex++) {
                    $mapelNama = trim($headers[$colIndex] ?? '');
                    
                    if (empty($mapelNama)) {
                        continue;
                    }

                    $mapelNamaLower = strtolower($mapelNama);

                    if (isset($mapelAlias[$mapelNamaLower])) {
                        $mapelNamaLower = $mapelAlias[$mapelNamaLower];
                    }

                    if ($mapelNamaLower === 'mata pelajaran pilihan') {
                        $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                        $nilaiValue = $worksheet->getCell($columnLetter . $row)->getValue();

                        if ($nilaiValue !== null && $nilaiValue !== '') {
                            $pilihanNama = $worksheet->getCell('H' . $row)->getValue();

                            if (empty($pilihanNama)) {
                                $errors[] = "Nama mapel pilihan kosong di baris {$row}";
                                continue;
                            }

                            $mapelId = $mapelMap[strtolower(trim($pilihanNama))] ?? null;
                            if (!$mapelId) {
                                $errors[] = "Mapel pilihan '{$pilihanNama}' tidak ditemukan (baris {$row})";
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
                                    'kelas_id' => $siswa->kelas_id ?? null,
                                    'rombel_id' => $siswa->rombel_id,
                                ]
                            );
                            $successCount++;
                        }
                        continue;
                    }

                    if ($mapelNamaLower === 'praktek kerja lapangan' || $mapelNamaLower === 'pkl') {
                        $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                        $nilaiValue = $worksheet->getCell($columnLetter . $row)->getValue();

                        if ($nilaiValue !== null && $nilaiValue !== '') {
                            $siswa->update(['pkl_nilai' => (string) $nilaiValue]);
                            $successCount++;
                        }
                        continue;
                    }

                    $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                    $nilaiValue = $worksheet->getCell($columnLetter . $row)->getValue();

                    if ($nilaiValue === null || $nilaiValue === '') {
                        continue;
                    }

                    $mapelId = $mapelMap[$mapelNamaLower] ?? null;
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
                            'kelas_id' => $siswa->kelas_id ?? null,
                            'rombel_id' => $siswa->rombel_id,
                        ]
                    );
                    $successCount++;
                }
            }

            $message = "Import selesai! {$successCount} nilai berhasil disimpan.";
            if (!empty($errors)) {
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
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            'kenaikanKelas.rombelTujuan.kelas.jurusan',
            'nilaiRaports' => function($query) {
                $query->with('mapel')
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester');
            }
        ]);
        
        $konsentrasi = $this->detectKonsentrasi($siswa);
        $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
        
        return view('tu.buku-induk.cetak', compact('siswa', 'nilaiByKelompok', 'konsentrasi'));
    }

    public function export(Siswa $siswa)
    {
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
        $request->validate([
            'nis' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
        ]);

        $jenisKelaminId = null;
        if ($request->filled('jenis_kelamin')) {
            $jkNama = $request->input('jenis_kelamin');
            $jk = \DB::table('jenis_kelamins')->where('nama', $jkNama)->first();
            if ($jk) {
                $jenisKelaminId = $jk->id;
            }
        }

        $data = $request->only([
            'nis', 'nama_lengkap', 'nisn', 'tempat_lahir', 'tanggal_lahir',
            'agama_id', 'agama_lainnya', 'kewarganegaraan', 'dusun', 'kelurahan', 'kecamatan',
            'rt', 'rw', 'kode_pos', 'pkl_nilai', 'pkl_sertifikat', 'pkl_nama_industri',
            'pkl_alamat', 'ijazah_nomor', 'ijazah_tanggal', 'transkip_nomor', 'transkip_tanggal',
            'tanggal_lulus', 'status_kelulusan',
        ]);

        if ($jenisKelaminId) {
            $data['jenis_kelamin_id'] = $jenisKelaminId;
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('foto-siswa', 'public');

            if ($siswa->user) {
                if ($siswa->user->photo) {
                    \Storage::disk('public')->delete($siswa->user->photo);
                }
                $siswa->user->photo = $path;
                $siswa->user->save();
            } else {
                if ($siswa->foto) {
                    \Storage::disk('public')->delete($siswa->foto);
                }
                $data['foto'] = $path;
            }
        }

        if ($request->input('remove_foto') === '1') {
            if ($siswa->user && $siswa->user->photo) {
                \Storage::disk('public')->delete($siswa->user->photo);
                $siswa->user->photo = null;
                $siswa->user->save();
            }
            if ($siswa->foto) {
                \Storage::disk('public')->delete($siswa->foto);
                $data['foto'] = null;
            }
        }

        $ayahData = $request->input('ayah', []);
        if (!empty(array_filter($ayahData))) {
            if ($siswa->ayah) {
                $siswa->ayah->update($ayahData);
            } else {
                $created = \App\Models\Ayah::create($ayahData);
                $siswa->ayah_id = $created->id;
            }
        }

        $ibuData = $request->input('ibu', []);
        if (!empty(array_filter($ibuData))) {
            if ($siswa->ibu) {
                $siswa->ibu->update($ibuData);
            } else {
                $created = \App\Models\Ibu::create($ibuData);
                $siswa->ibu_id = $created->id;
            }
        }

        $waliData = $request->input('wali', []);
        if (!empty(array_filter($waliData))) {
            if ($siswa->wali) {
                $siswa->wali->update($waliData);
            } else {
                $created = \App\Models\Wali::create($waliData);
                $siswa->wali_id = $created->id;
            }
        }

        $siswa->update($data);
        $siswa->save();

        $isAlumni = \App\Models\KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('status', 'Lulus')
            ->exists();

        if ($isAlumni) {
            return redirect()->route('tu.alumni.buku-induk.show', $siswa->id)->with('success', 'Data siswa berhasil diperbarui.');
        }

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

                    if (isset($this->mapelAlias[$mapelNama])) {
                        $mapelNama = $this->mapelAlias[$mapelNama];
                    }
                    
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

                if (isset($this->mapelAlias[$mapelNama])) {
                    $mapelNama = $this->mapelAlias[$mapelNama];
                }
                
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

                        if (isset($this->mapelAlias[$mapelNama])) {
                            $mapelNama = $this->mapelAlias[$mapelNama];
                        }
                        
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

            if (isset($this->mapelAlias[$mapelNama])) {
                $mapelNama = $this->mapelAlias[$mapelNama];
            }
            
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