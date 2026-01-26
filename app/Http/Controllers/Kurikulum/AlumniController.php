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

    public function byJurusan($tahun, $jurusanId)
    {
        $jurusanId = (int) $jurusanId;
        
        // Ambil data alumni berdasarkan tahun dan jurusan
        $query = KenaikanKelas::where('status', 'lulus');
        
        // Hanya filter tahun jika bukan "Semua Tahun"
        if ($tahun !== 'Semua Tahun') {
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
                    'kelas' => $kelas?->tingkat ?? '-',
                    'rombel' => $rombel?->nama ?? '-',
                ];
            }
        }

        return view('kurikulum.alumni.by-jurusan', compact('alumni', 'tahun', 'jurusanId', 'namaJurusan'));
    }

    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('kurikulum.alumni.show', compact('siswa'));
    }
}
