<?php
namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\KenaikanKelas;
use App\Models\DataSiswa;

class AlumniController extends Controller
{
    public function index()
    {
        // Ambil semua jurusan
        $allJurusan = \App\Models\Jurusan::orderBy('nama')->get();

        // Ambil daftar alumni dengan relasi lengkap
        $query = KenaikanKelas::where('status', 'lulus')
            ->with([
                'siswa' => function($q) {
                    $q->with(['rombel' => function($r) {
                        $r->with('kelas.jurusan');
                    }]);
                },
                'rombelTujuan.kelas.jurusan'
            ]);

        // Filter berdasarkan tahun ajaran jika ada request
        $tahunSearch = request('tahun_ajaran');
        if ($tahunSearch) {
            $query->where('tahun_ajaran', $tahunSearch);
        }

        $kelulusan = $query->orderBy('tahun_ajaran', 'desc')->get();

        // Group data berdasarkan tahun ajaran dan jurusan (untuk card view)
        $groupedAlumniCard = [];
        
        foreach ($kelulusan as $k) {
            $siswa = $k->siswa;
            $rombel = $k->rombelTujuan ?? $siswa->rombel;
            $kelas = $rombel?->kelas;
            $jurusan = $kelas?->jurusan;
            
            $tahun = $k->tahun_ajaran;
            $namaJurusan = $jurusan?->nama ?? 'Jurusan Tidak Diketahui';
            $idJurusan = $jurusan?->id;
            
            // Group untuk card view: tahun > jurusan
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

        // Ambil daftar tahun ajaran yang tersedia
        $tahunAjaranList = KenaikanKelas::where('status', 'lulus')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        // Buat card untuk semua jurusan (dengan atau tanpa data)
        $allJurusanCards = [];
        foreach ($allJurusan as $jurusan) {
            $cardKey = ($tahunSearch ?? 'all') . '_' . $jurusan->id;
            $count = 0;

            // Hitung alumni untuk jurusan ini (sesuai tahun filter jika ada)
            if ($tahunSearch) {
                $count = collect($groupedAlumniCard)->filter(function($card) use ($tahunSearch, $jurusan) {
                    return $card['tahun'] == $tahunSearch && $card['jurusan_id'] == $jurusan->id;
                })->sum('count');
            } else {
                $count = collect($groupedAlumniCard)->filter(function($card) use ($jurusan) {
                    return $card['jurusan_id'] == $jurusan->id;
                })->sum('count');
            }

            $allJurusanCards[$cardKey] = [
                'tahun' => $tahunSearch ?? 'Semua Tahun',
                'jurusan' => $jurusan->nama,
                'jurusan_id' => $jurusan->id,
                'count' => $count,
            ];
        }

        return view('kurikulum.alumni.index', compact('allJurusanCards', 'tahunAjaranList', 'tahunSearch'));
    }

    public function byJurusan($jurusanId)
    {
        $jurusanId = (int) $jurusanId;
        $tahun = trim(request('tahun', 'Semua Tahun')); // Read from query string
        
        // Ambil daftar tahun ajaran yang tersedia untuk jurusan ini
        $tahunAjaranList = KenaikanKelas::where('status', 'lulus')
            ->with(['siswa.rombel.kelas.jurusan', 'rombelTujuan.kelas.jurusan'])
            ->get()
            ->filter(function($k) use ($jurusanId) {
                $siswa = $k->siswa;
                $rombel = $k->rombelTujuan ?? $siswa->rombel;
                $kelas = $rombel?->kelas;
                $jurusan = $kelas?->jurusan;
                return $jurusan && (int) $jurusan->id === $jurusanId;
            })
            ->pluck('tahun_ajaran')
            ->unique()
            ->sort()
            ->reverse()
            ->values();
        
        // Ambil data alumni berdasarkan tahun dan jurusan
        $query = KenaikanKelas::where('status', 'lulus');
        
        // Filter tahun jika bukan "Semua Tahun"
        if ($tahun !== 'Semua Tahun' && !empty($tahun)) {
            $query->where('tahun_ajaran', $tahun);
        }
        
        $kelulusan = $query->with([
                'siswa' => function($q) {
                    $q->with(['rombel' => function($r) {
                        $r->with('kelas.jurusan');
                    }]);
                },
                'rombelTujuan.kelas.jurusan'
            ])
            ->orderBy('tahun_ajaran', 'desc')
            ->get();

        // Filter berdasarkan jurusan
        $alumni = [];
        $namaJurusan = '';
        
        foreach ($kelulusan as $k) {
            $siswa = $k->siswa;
            $rombel = $k->rombelTujuan ?? $siswa->rombel;
            $kelas = $rombel?->kelas;
            $jurusan = $kelas?->jurusan;
            
            if ($jurusan && (int) $jurusan->id === $jurusanId) {
                $namaJurusan = $jurusan->nama;
                $alumni[] = [
                    'siswa' => $siswa,
                    'kelas' => 'Kelas ' . $kelas?->tingkat . ' ' . $jurusan?->nama ?? '-',
                    'rombel' => $rombel?->nama ?? '-',
                ];
            }
        }

        return view('kurikulum.alumni.by-jurusan', compact('alumni', 'tahun', 'jurusanId', 'namaJurusan', 'tahunAjaranList'));
    }

    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('kurikulum.alumni.show', compact('siswa'));
    }

    public function bukuInduk($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan'])->findOrFail($siswa_id);
        
        // Ambil data nilai untuk buku induk
        $nilaiRaports = \App\Models\NilaiRaport::where('siswa_id', $siswa_id)
            ->with('mapel')
            ->orderBy('tahun_ajaran')
            ->orderBy('semester')
            ->get();
        
        // Group nilai berdasarkan tahun ajaran dan kelompok
        $byKelompok = [];
        $tahunAjaranList = [];
        
        foreach ($nilaiRaports as $nilai) {
            if (!$nilai->mapel) continue;
            
            $tahun = $nilai->tahun_ajaran;
            $semester = $nilai->semester;
            $kelompok = $nilai->mapel->kelompok ?? 'A';
            $mapelNama = $nilai->mapel->nama;
            $nilaiAkhir = $nilai->nilai_akhir ?? '-';
            
            // Konversi semester ke angka jika string
            $semesterNum = $semester;
            if (is_string($semester)) {
                $semesterNum = strtolower($semester) === 'ganjil' ? 1 : (strtolower($semester) === 'genap' ? 2 : $semester);
            }
            
            // Tambah ke tahun ajaran list jika belum ada
            if (!in_array($tahun, $tahunAjaranList)) {
                $tahunAjaranList[] = $tahun;
            }
            
            // Buat struktur kelompok jika belum ada
            if (!isset($byKelompok[$kelompok])) {
                $byKelompok[$kelompok] = [];
            }
            
            // Buat struktur mapel jika belum ada
            if (!isset($byKelompok[$kelompok][$mapelNama])) {
                $byKelompok[$kelompok][$mapelNama] = [
                    'nama' => $mapelNama,
                    'nilai' => []
                ];
            }
            
            // Buat struktur tahun ajaran jika belum ada
            if (!isset($byKelompok[$kelompok][$mapelNama]['nilai'][$tahun])) {
                $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun] = [];
            }
            
            // Simpan nilai dengan key semester (1 atau 2)
            $byKelompok[$kelompok][$mapelNama]['nilai'][$tahun][$semesterNum] = $nilaiAkhir;
        }
        
        // Sort tahun ajaran
        sort($tahunAjaranList);
        
        // Ambil status mutasi terakhir (jika ada)
        $kenaikanKelas = KenaikanKelas::where('siswa_id', $siswa_id)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->first();
        
        // Attach mutasi terakhir ke siswa untuk view
        $siswa->mutasiTerakhir = $kenaikanKelas;
        
        // Struktur data sesuai view
        $nilaiByKelompok = [
            'byKelompok' => $byKelompok,
            'tahunAjaranList' => $tahunAjaranList
        ];
        
        return view('kurikulum.alumni.buku-induk.show', compact('siswa', 'nilaiByKelompok'));
    }

    public function raporList($siswa_id)
    {
        $siswa = DataSiswa::findOrFail($siswa_id);
        
        // Ambil semua raport yang tersedia untuk alumni ini
        $raports = \App\Models\NilaiRaport::where('siswa_id', $siswa_id)
            ->select('semester', 'tahun_ajaran')
            ->distinct('tahun_ajaran', 'semester')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
        
        return view('kurikulum.alumni.raport.list', compact('siswa', 'raports'));
    }

    public function raporShow($siswa_id, $semester, $tahun)
    {
        $siswa = DataSiswa::with(['rombel.kelas'])->findOrFail($siswa_id);
        
        // Ubah format tahun jika perlu
        $tahun = str_replace('-', '/', $tahun);
        
        // Ambil nilai raport dengan kelas dan jurusan history
        $nilaiRaports = \App\Models\NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with(['mapel', 'kelas.jurusan', 'rombel'])
            ->get();
        
        // Ambil ekstrakurikuler
        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_ajaran', $tahun)
            ->get();
        
        // Ambil kehadiran
        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa_id)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();
        
        // Ambil kenaikan kelas
        $kenaikan = KenaikanKelas::where('siswa_id', $siswa_id)
            ->where('tahun_ajaran', $tahun)
            ->first();
        
        // Ambil kelas history (dari nilai raport yang pertama)
        $kelasHistory = $nilaiRaports->first()?->kelas;
        
        return view('kurikulum.alumni.raport.show', compact('siswa', 'nilaiRaports', 'ekstra', 'kehadiran', 'kenaikan', 'kelasHistory', 'semester', 'tahun'));
    }
}
