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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AlumniController extends Controller
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

    // ================================================================
    // INDEX — LIST ALUMNI (CARD PER TAHUN)
    // ================================================================
    public function index(Request $request)
    {
        $allJurusan = Jurusan::orderBy('nama')->get();

        $tahunSearch   = $request->tahun_ajaran;
        $jurusanSearch = $request->jurusan_id;
        $search        = $request->search;
        $sortBy        = $request->sort ?? 'tahun_desc';

        $query = KenaikanKelas::where('status', 'Lulus')
            ->with(['siswa', 'jurusan']);

        if ($tahunSearch) {
            $query->where('tahun_ajaran', 'like', "%{$tahunSearch}%");
        }

        if ($jurusanSearch) {
            $query->where('jurusan_id', $jurusanSearch);
        }

        if ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        switch ($sortBy) {
            case 'nama_asc':
                $query->join('data_siswa', 'kenaikan_kelas.siswa_id', '=', 'data_siswa.id')
                      ->orderBy('data_siswa.nama_lengkap', 'asc')
                      ->select('kenaikan_kelas.*');
                break;
            case 'nama_desc':
                $query->join('data_siswa', 'kenaikan_kelas.siswa_id', '=', 'data_siswa.id')
                      ->orderBy('data_siswa.nama_lengkap', 'desc')
                      ->select('kenaikan_kelas.*');
                break;
            case 'tahun_asc':
                $query->orderBy('tahun_ajaran', 'asc');
                break;
            case 'tahun_desc':
            default:
                $query->orderBy('tahun_ajaran', 'desc');
                break;
        }

        $alumni = $query->get();

        $groupedCards = [];

        foreach ($alumni as $item) {
            $jurusan = $item->jurusan;
            $tahunLulus = $item->tahun_ajaran ?? 'Tidak Diketahui';

            $jurusanId   = $jurusan->id ?? 0;
            $jurusanNama = $jurusan->nama ?? 'Belum Teridentifikasi';

            $key = $tahunLulus . '_' . $jurusanId;

            if (!isset($groupedCards[$key])) {
                $groupedCards[$key] = [
                    'tahun'      => $tahunLulus,
                    'jurusan_id' => $jurusanId,
                    'jurusan'    => $jurusanNama,
                    'count'      => 0,
                    'siswa'      => [],
                ];
            }

            $groupedCards[$key]['count']++;

            if ($item->siswa) {
                $groupedCards[$key]['siswa'][] = [
                    'id'    => $item->siswa->id,
                    'nama'  => $item->siswa->nama_lengkap,
                    'nis'   => $item->siswa->nis,
                    'nisn'  => $item->siswa->nisn,
                ];
            }
        }

        usort($groupedCards, function ($a, $b) {
            if ($a['tahun'] === $b['tahun']) {
                return strcmp($a['jurusan'], $b['jurusan']);
            }
            return strcmp($b['tahun'], $a['tahun']);
        });

        $totalAlumni  = $alumni->count();
        $totalJurusan = collect($groupedCards)->pluck('jurusan_id')->unique()->count();
        $totalTahun   = collect($groupedCards)->pluck('tahun')->unique()->count();

        $tahunAjaranList = KenaikanKelas::where('status', 'Lulus')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        return view('tu.alumni.index', compact(
            'groupedCards',
            'allJurusan',
            'tahunAjaranList',
            'tahunSearch',
            'jurusanSearch',
            'search',
            'sortBy',
            'totalAlumni',
            'totalJurusan',
            'totalTahun'
        ));
    }

    // ================================================================
    // IMPORT NILAI RAPOR ALUMNI (TEMPORARY)
    // ================================================================
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
            foreach (\App\Models\MataPelajaran::all() as $mapel) {
                $mapelMap[strtolower(trim($mapel->nama))] = $mapel->id;
            }

           $importAlias = [
    'projek kreatif dan kewirausahaan' => 'kreativitas, inovasi, dan kewirausahaan',
    'pkk' => 'kreativitas, inovasi, dan kewirausahaan',
    'muatan lokal' => 'muatan lokal',
    'mulok' => 'muatan lokal',
    'bim (building information modelling)' => 'bim',
    'building information modelling' => 'bim',
    'bim' => 'bim',
];
            $successCount = 0;
            $errors = [];

            for ($row = 2; $row <= $highestRow; $row++) {
                $nis = $worksheet->getCell('B' . $row)->getValue();
                $nisn = $worksheet->getCell('C' . $row)->getValue();

                if (empty($nis) || empty($nisn)) {
                    continue;
                }

                $siswa = DataSiswa::where('nis', $nis)->where('nisn', $nisn)->first();
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

                    if (isset($importAlias[$mapelNamaLower])) {
                        $mapelNamaLower = $importAlias[$mapelNamaLower];
                    }

                    if ($mapelNamaLower === 'mata pelajaran pilihan') {
                        $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                        $nilaiValue = $worksheet->getCell($columnLetter . $row)->getValue();

                        if ($nilaiValue !== null && $nilaiValue !== '') {
                            // DETEKSI OTOMATIS nama mapel pilihan berdasarkan jurusan & konsentrasi siswa
                            $pilihanNama = $this->detectMapelPilihan($siswa);

                            if (empty($pilihanNama)) {
                                $errors[] = "Mapel pilihan tidak terdeteksi untuk siswa NIS {$nis} (baris {$row})";
                                continue;
                            }

                            $mapelId = $mapelMap[strtolower(trim($pilihanNama))] ?? null;
                            if (!$mapelId) {
                                $errors[] = "Mapel pilihan '{$pilihanNama}' tidak ditemukan (baris {$row})";
                                continue;
                            }

                            NilaiRaport::updateOrCreate(
                                [
                                    'siswa_id' => $siswa->id,
                                    'mata_pelajaran_id' => $mapelId,
                                    'semester' => $semesterVal,
                                    'tahun_ajaran' => $tahunVal,
                                ],
                                [
                                    'nilai_akhir' => (float) $nilaiValue,
                                    'kelas_id' => $siswa->kelas_id ?? ($siswa->rombel->kelas_id ?? null),
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

                    NilaiRaport::updateOrCreate(
                        [
                            'siswa_id' => $siswa->id,
                            'mata_pelajaran_id' => $mapelId,
                            'semester' => $semesterVal,
                            'tahun_ajaran' => $tahunVal,
                        ],
                        [
                            'nilai_akhir' => (float) $nilaiValue,
                            'kelas_id' => $siswa->kelas_id ?? ($siswa->rombel->kelas_id ?? null),
                            'rombel_id' => $siswa->rombel_id,
                        ]
                    );
                    $successCount++;
                }
            }

            $message = "Import selesai! {$successCount} nilai alumni berhasil disimpan.";
            if (!empty($errors)) {
                $errorLimit = array_slice($errors, 0, 20);
                $errorCount = count($errors);
                if ($errorCount > 20) {
                    $errorLimit[] = "... dan " . ($errorCount - 20) . " error lainnya.";
                }
                return redirect()->route('tu.alumni.index')
                    ->with('warning', $message)
                    ->with('import_errors', $errorLimit);
            }

            return redirect()->route('tu.alumni.index')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Import nilai alumni error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('tu.alumni.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ================================================================
    // DETEKSI OTOMATIS MAPEL PILIHAN BERDASARKAN JURUSAN & KONSENTRASI
    // ================================================================
    protected function detectMapelPilihan($siswa)
    {
        $jurusanId = null;
        $tingkat = null;
        $idKonke = null;

        // Cek dari rombel siswa (kalau masih ada)
        if ($siswa->rombel && $siswa->rombel->kelas) {
            $jurusanId = $siswa->rombel->kelas->jurusan_id;
            $tingkat = $siswa->rombel->kelas->tingkat;
            $idKonke = $siswa->rombel->id_konke;
        }

        // Fallback ke kenaikan_kelas (alumni)
        if (!$jurusanId || !$tingkat) {
            $kenaikan = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'Lulus')
                ->orderBy('tahun_ajaran', 'desc')
                ->first();

            if ($kenaikan) {
                $jurusanId = $jurusanId ?? $kenaikan->jurusan_id;
                $tingkat = $tingkat ?? $kenaikan->kelas_tingkat;

                if (!$idKonke && $kenaikan->rombel_tujuan_id) {
                    $rombel = \DB::table('rombels')->where('id', $kenaikan->rombel_tujuan_id)->first();
                    if ($rombel) {
                        $idKonke = $rombel->id_konke;
                    }
                }
            }
        }

        // Normalisasi tingkat: 'XII' → 12
        $tingkatMap = ['X' => 10, 'XI' => 11, 'XII' => 12];
        $tingkatNum = $tingkatMap[$tingkat] ?? (int) $tingkat;

        // Mapping berdasarkan konsentrasi (id_konke) & tingkat
        $mapelPilihanMap = [
            1 => [ // TKRO
                11 => 'Kerja Bangku',
                12 => 'Pengelasan',
            ],
            2 => [ // TJKT
                11 => 'Desain Grafis',
                12 => 'Desain Grafis',
            ],
            3 => [ // RPL
                11 => 'Pengembangan Gim',
                12 => 'Pengembangan Gim',
            ],
            4 => [ // GIM
                11 => 'Pemrograman Web',
                12 => 'Pemrograman Web',
            ],
            5 => [ // DPIB
                11 => 'BIM',
                12 => 'BIM',
            ],
            6 => [ // MP
                11 => 'Akuntansi',
                12 => 'Akuntansi',
            ],
            7 => [ // AK
                11 => 'Layanan Perbankan',
                12 => 'Layanan Perbankan',
            ],
            8 => [ // SP
                11 => 'Musik Nusantara',
                12 => 'Musik Kolaborasi',
            ],
        ];

        if ($idKonke && isset($mapelPilihanMap[$idKonke])) {
            if (isset($mapelPilihanMap[$idKonke][$tingkatNum])) {
                return $mapelPilihanMap[$idKonke][$tingkatNum];
            }
        }

        // Fallback: kalau id_konke tidak ada, coba dari jurusan_id
        $jurusanToKonke = [
            1 => 3,  // PPLG → RPL (default)
            4 => 6,  // MP → MP
            5 => 7,  // AK → AK
            6 => 2,  // TJKT → TJKT
            7 => 1,  // TKRO → TKRO
            8 => 5,  // DPIB → DPIB
            9 => 8,  // SP → SP
        ];

        if ($jurusanId && isset($jurusanToKonke[$jurusanId])) {
            $konkeFallback = $jurusanToKonke[$jurusanId];
            if (isset($mapelPilihanMap[$konkeFallback][$tingkatNum])) {
                return $mapelPilihanMap[$konkeFallback][$tingkatNum];
            }
        }

        return null;
    }

    // ================================================================
    // BY JURUSAN
    // ================================================================
    public function byJurusan($jurusanId = null, Request $request)
    {
        if ($jurusanId === null || $jurusanId == 0) {
            $jurusanId = 0;
            $namaJurusan = 'Belum Teridentifikasi';
        } else {
            $jurusan = Jurusan::find($jurusanId);
            if (!$jurusan) {
                abort(404, 'Jurusan tidak ditemukan');
            }
            $namaJurusan = $jurusan->nama;
        }

        $tahun = trim($request->tahun ?? 'Semua Tahun');

        $query = KenaikanKelas::where('status', 'Lulus')
            ->with(['siswa', 'jurusan']);

        if ($jurusanId == 0) {
            $query->whereNull('jurusan_id');
        } else {
            $query->where('jurusan_id', $jurusanId);
        }

        if ($tahun !== 'Semua Tahun' && !empty($tahun)) {
            $query->where('tahun_ajaran', $tahun);
        }

        $alumni = $query->orderBy('tahun_ajaran', 'desc')
                        ->orderBy('siswa_id')
                        ->get();

        $groupedAlumni = [];

        foreach ($alumni as $item) {
            if (!$item->siswa) {
                continue;
            }

            $siswa = $item->siswa;
            $kelasTingkat = $item->kelas_tingkat ?? 'XII';

            $rombelNama = 'Alumni';
            if (!empty($item->catatan) && preg_match('/Lulus dari (.+)/', $item->catatan, $m)) {
                $rombelNama = trim($m[1]);
            } elseif ($siswa->rombel) {
                $rombelNama = $siswa->rombel->nama;
            }

            $key = $kelasTingkat . '_' . $rombelNama;

            if (!isset($groupedAlumni[$key])) {
                $groupedAlumni[$key] = [
                    'kelas_tingkat' => $kelasTingkat,
                    'rombel_nama'   => $rombelNama,
                    'display_name'  => $rombelNama,
                    'students'      => [],
                ];
            }

            $groupedAlumni[$key]['students'][] = $siswa;
        }

        $tahunAjaranList = KenaikanKelas::where('status', 'Lulus')
            ->when($jurusanId == 0, function ($q) {
                return $q->whereNull('jurusan_id');
            }, function ($q) use ($jurusanId) {
                return $q->where('jurusan_id', $jurusanId);
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

    // ================================================================
    // SHOW ALUMNI
    // ================================================================
    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel', 'ayah', 'ibu', 'wali', 'agama', 'jenisKelamin'])->findOrFail($id);
        return view('tu.alumni.show', compact('siswa'));
    }

    // ================================================================
    // FIX JURUSAN
    // ================================================================
    public function fixJurusan(Request $request)
    {
        $fixed = 0;
        $alumniNull = KenaikanKelas::where('status', 'Lulus')
            ->whereNull('jurusan_id')
            ->get();

        foreach ($alumniNull as $alumni) {
            $jurusanId = null;

            if ($alumni->rombel_tujuan_id) {
                $rombel = \App\Models\Rombel::with('kelas.jurusan')->find($alumni->rombel_tujuan_id);
                if ($rombel && $rombel->kelas && $rombel->kelas->jurusan) {
                    $jurusanId = $rombel->kelas->jurusan_id;
                }
            }

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
    // RAPORT ALUMNI
    // ================================================================
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

    // ================================================================
    // BUKU INDUK ALUMNI
    // ================================================================
        private function buildNilaiByKelompok($siswa)
    {
        $jurusanId = null;
        $tingkat = 'XII';

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $jurusanId = $siswa->rombel->kelas->jurusan_id;
            $tingkat = $siswa->rombel->kelas->tingkat ?? 'XII';
        }

        if (!$jurusanId) {
            $kenaikan = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'Lulus')
                ->orderBy('tahun_ajaran', 'desc')
                ->first();
            if ($kenaikan && $kenaikan->jurusan_id) {
                $jurusanId = $kenaikan->jurusan_id;
            }
            if ($kenaikan && $kenaikan->kelas_tingkat) {
                $tingkat = $kenaikan->kelas_tingkat;
            }
        }

        $mapels = \App\Models\MataPelajaran::query()
            ->when($jurusanId, function ($q) use ($jurusanId) {
                $q->whereHas('jurusans', function ($jq) use ($jurusanId) {
                    $jq->where('jurusan_id', $jurusanId);
                });
            })
            ->orderBy('kelompok')
            ->orderBy('urutan')
            ->get();

        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa->id)
            ->with('mapel')
            ->get();

        $nilaiMap = [];
        $tahunAjaranList = [];

        foreach ($nilaiRaports as $n) {
            $tahun = $n->tahun_ajaran;
            $semester = $n->semester;

            $semNum = $semester;
            if (is_string($semester)) {
                $s = strtolower($semester);
                $semNum = ($s === 'ganjil' || $s == '1') ? 1 : 2;
            }

            $nilaiMap[$n->mata_pelajaran_id][$tahun][$semNum] = $n->nilai_akhir;
            if (!in_array($tahun, $tahunAjaranList)) {
                $tahunAjaranList[] = $tahun;
            }
        }

        sort($tahunAjaranList);

        $byKelompok = [];

        foreach ($mapels as $mapel) {
            $kelompok = $mapel->kelompok ?? 'A';
            $mapelNama = trim($mapel->nama);

            if (isset($this->mapelAlias[$mapelNama])) {
                $mapelNama = $this->mapelAlias[$mapelNama];
            }

            $mapelKey = $mapelNama;

            if (!isset($byKelompok[$kelompok])) {
                $byKelompok[$kelompok] = [];
            }

            if (!isset($byKelompok[$kelompok][$mapelKey])) {
                $byKelompok[$kelompok][$mapelKey] = [
                    'nama' => $mapelNama,
                    'urutan' => $mapel->urutan ?? 999,
                    'nilai' => [],
                ];

                foreach ($tahunAjaranList as $tahun) {
                    $byKelompok[$kelompok][$mapelKey]['nilai'][$tahun] = [
                        1 => null,
                        2 => null,
                    ];
                }
            }

            foreach ($tahunAjaranList as $tahun) {
                foreach ([1, 2] as $sem) {
                    $nilai = $nilaiMap[$mapel->id][$tahun][$sem] ?? null;
                    if ($nilai !== null) {
                        $byKelompok[$kelompok][$mapelKey]['nilai'][$tahun][$sem] = $nilai;
                    }
                }
            }
        }

        if (empty($tahunAjaranList)) {
            $tahunAjaranList = ['2023/2024', '2024/2025', '2025/2026'];
        }

        if (!isset($byKelompok['B'])) {
            $byKelompok['B'] = [];
        }

        if (!isset($byKelompok['B']['Praktek Kerja Lapangan'])) {
            $byKelompok['B']['Praktek Kerja Lapangan'] = [
                'nama' => 'Praktek Kerja Lapangan',
                'urutan' => 9998,
                'nilai' => [],
            ];
            foreach ($tahunAjaranList as $tahun) {
                $byKelompok['B']['Praktek Kerja Lapangan']['nilai'][$tahun] = [
                    1 => null,
                    2 => null,
                ];
            }
        }

        foreach ($byKelompok as &$group) {
            uasort($group, function ($a, $b) {
                return ($a['urutan'] ?? 999) <=> ($b['urutan'] ?? 999);
            });
        }
        unset($group);

        return [
            'byKelompok' => $byKelompok,
            'tahunAjaranList' => $tahunAjaranList,
        ];
    }
    public function bukuInduk($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'ayah', 'ibu', 'wali', 'agama', 'jenisKelamin'])
            ->findOrFail($siswa_id);

        $nilaiByKelompok = $this->buildNilaiByKelompok($siswa);

        $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('status', 'Lulus')
            ->orderBy('tahun_ajaran', 'desc')
            ->first();

        $siswa->mutasiTerakhir = $kenaikanKelas;

        $konsentrasi = $this->detectKonsentrasi($siswa, $kenaikanKelas);

        return view('tu.alumni.buku-induk.show', compact('siswa', 'nilaiByKelompok', 'konsentrasi'));
    }

    public function bukuIndukCetak($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'ayah', 'ibu', 'wali', 'agama', 'jenisKelamin'])
            ->findOrFail($siswa_id);

        $nilaiByKelompok = $this->buildNilaiByKelompok($siswa);

        $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('status', 'Lulus')
            ->orderBy('tahun_ajaran', 'desc')
            ->first();

        $siswa->mutasiTerakhir = $kenaikanKelas;

        $konsentrasi = $this->detectKonsentrasi($siswa, $kenaikanKelas);

        return view('tu.alumni.buku-induk.cetak', compact('siswa', 'nilaiByKelompok', 'konsentrasi'));
    }

    protected function detectKonsentrasi($siswa, $kenaikanKelas = null)
    {
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            return $siswa->rombel->kelas->jurusan->nama;
        }

        if (!$kenaikanKelas) {
            $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'Lulus')
                ->orderBy('tahun_ajaran', 'desc')
                ->first();
        }

        if ($kenaikanKelas) {
            if ($kenaikanKelas->rombel_tujuan_id) {
                $rombelTujuan = \App\Models\Rombel::find($kenaikanKelas->rombel_tujuan_id);
                if ($rombelTujuan && $rombelTujuan->id_konke) {
                    $konke = \DB::table('konsentrasi_keahlian')->where('id', $rombelTujuan->id_konke)->first();
                    if ($konke) {
                        return $konke->nama_konsentrasi;
                    }
                }

                if ($rombelTujuan && $rombelTujuan->nama) {
                    return $rombelTujuan->nama;
                }
            }

            if ($kenaikanKelas->jurusan_id) {
                $jurusan = Jurusan::find($kenaikanKelas->jurusan_id);
                if ($jurusan) {
                    return $jurusan->nama;
                }
            }
        }

        return 'Tidak Tersedia';
    }
}