<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSiswa;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;
use App\Models\KenaikanKelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WaliKelasSiswaExport;

class WaliKelasSiswaController extends Controller
{
    // List siswa
   public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->query('q');
    $jenisKelamin = $request->query('jenis_kelamin');

    // ambil daftar rombel yang dia pegang sebagai wali kelas
    $rombelsIds = [];
    if ($user) {
        // Gunakan pluck untuk langsung mengambil ID dan memastikan unik
        $rombelsIds = $user->waliKelas()
            ->whereNotNull('rombel_id')
            ->pluck('rombel_id')
            ->unique()
            ->toArray();
            
        // Jika perlu fallback ke kelas_id
        $kelasIds = $user->waliKelas()
            ->whereNull('rombel_id')
            ->whereNotNull('kelas_id')
            ->pluck('kelas_id')
            ->unique()
            ->toArray();
            
        if (!empty($kelasIds)) {
            $rombelFromKelas = Rombel::whereIn('kelas_id', $kelasIds)
                ->pluck('id')
                ->unique()
                ->toArray();
            $rombelsIds = array_merge($rombelsIds, $rombelFromKelas);
        }

        if (!empty($rombelsIds)) {
            // exclude students who have been promoted or graduated
            $excludedIds = KenaikanKelas::whereIn('status', ['lulus', 'naik'])->pluck('siswa_id')->unique()->filter()->toArray();

            $query = DataSiswa::with(['ayah', 'ibu', 'wali'])
                ->whereIn('rombel_id', $rombelsIds)
                ->when(!empty($excludedIds), function($q) use ($excludedIds) {
                    return $q->whereNotIn('id', $excludedIds);
                })
                ->when($search, function($q) use ($search) {
                    $like = '%' . $search . '%';
                    return $q->where(function($qq) use ($like) {
                        $qq->where('nama_lengkap', 'like', $like)
                           ->orWhere('nisn', 'like', $like)
                           ->orWhere('nis', 'like', $like);
                    });
                })
                ->when(in_array($jenisKelamin, ['L', 'P']), function($q) use ($jenisKelamin) {
                    return $q->where('jenis_kelamin', $jenisKelamin);
                })
                ->orderBy('nama_lengkap');
            // Ambil semua hasil tanpa pagination sesuai permintaan
            $siswa = $query->get();
        } else {
            // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
            $siswa = collect();
        }

        return view('walikelas.siswa.index', compact('siswa', 'search', 'jenisKelamin'));
    }

    if (!empty($rombelsIds)) {
        // exclude students who have been promoted or graduated
        $excludedIds = KenaikanKelas::whereIn('status', ['lulus', 'naik'])
            ->pluck('siswa_id')
            ->unique()
            ->filter()
            ->toArray();

        $query = DataSiswa::with(['ayah', 'ibu', 'wali'])
            ->distinct() // Tambahkan distinct untuk menghindari duplikasi
            ->whereIn('rombel_id', $rombelsIds)
            ->when(!empty($excludedIds), function($q) use ($excludedIds) {
                return $q->whereNotIn('id', $excludedIds);
            })
            ->when($search, function($q) use ($search) {
                $like = '%' . $search . '%';
                return $q->where(function($qq) use ($like) {
                    $qq->where('nama_lengkap', 'like', $like)
                       ->orWhere('nisn', 'like', $like)
                       ->orWhere('nomor_induk', 'like', $like);
                });
            })
            ->when(in_array($jenisKelamin, ['L', 'P']), function($q) use ($jenisKelamin) {
                return $q->where('jenis_kelamin', $jenisKelamin);
            })
            ->orderBy('nama_lengkap');

        // Return full collection (no pagination) for wali kelas view
        $siswa = $query->get();
    } else {
        // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
        $siswa = collect();
    }

    return view('walikelas.siswa.index', compact('siswa', 'search', 'jenisKelamin'));
}

    // Detail siswa
    public function show($id)
    {
        $s = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('walikelas.siswa.show', compact('s'));
    }

    // Dashboard wali kelas
    public function dashboard()
    {
        $user = Auth::user();

        // ambil daftar rombel yang dia pegang sebagai wali kelas
        $rombelsIds = [];
        if ($user) {
            $assigns = $user->waliKelas()->get();
            foreach ($assigns as $a) {
                // jika kolom rombel_id ada dan terisi, gunakan itu
                if (isset($a->rombel_id) && $a->rombel_id) {
                    $rombelsIds[] = $a->rombel_id;
                    continue;
                }

                // jika rombel_id tidak tersedia di tabel, gunakan kelas_id untuk ambil rombel terkait
                if (isset($a->kelas_id) && $a->kelas_id) {
                    $r = Rombel::where('kelas_id', $a->kelas_id)->pluck('id')->toArray();
                    $rombelsIds = array_merge($rombelsIds, $r);
                    continue;
                }

                // (tidak menggunakan fallback jurusan karena terlalu luas)
            }

            $rombelsIds = array_values(array_unique(array_filter($rombelsIds)));
        }

        if (!empty($rombelsIds)) {
            $excludedIds = KenaikanKelas::whereIn('status', ['lulus', 'naik'])->pluck('siswa_id')->unique()->filter()->toArray();

            $total = DataSiswa::whereIn('rombel_id', $rombelsIds)
                ->when(!empty($excludedIds), function($q) use ($excludedIds) {
                    return $q->whereNotIn('id', $excludedIds);
                })->count();

            // Ambil siswa terbaru hanya dari rombel yang dipegang wali kelas
            $recent = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel'])
                ->whereIn('rombel_id', $rombelsIds)
                ->when(!empty($excludedIds), function($q) use ($excludedIds) {
                    return $q->whereNotIn('id', $excludedIds);
                })
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            $byGender = DataSiswa::whereIn('rombel_id', $rombelsIds)
                ->when(!empty($excludedIds), function($q) use ($excludedIds) {
                    return $q->whereNotIn('id', $excludedIds);
                })
                ->select('jenis_kelamin', DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->pluck('total', 'jenis_kelamin')
                ->toArray();

            // Group recent by rombel
            $recentGrouped = $recent->groupBy(function($siswa) {
                return $siswa->rombel ? $siswa->rombel->nama : 'Tidak ada rombel';
            });
        } else {
            $total = 0;
            $recent = collect();
            $recentGrouped = collect();
            $byGender = [];
        }

        return view('walikelas.dashboard', compact('total', 'recent', 'recentGrouped', 'byGender'));
    }

    // Export data siswa ke PDF (untuk wali kelas)
    public function exportPdf($id)
    {
        $s = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);

        $pdf = Pdf::loadView('siswa.pdf', ['siswa' => $s])
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Data Siswa - ' . ($s->nama_lengkap ?? $s->nis) . '.pdf');
    }

    // Export data siswa ke Excel (untuk wali kelas)
    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        $rombelsIds = [];
        if ($user) {
            $rombelsIds = $user->waliKelas()
                ->whereNotNull('rombel_id')
                ->pluck('rombel_id')
                ->unique()
                ->toArray();

            $kelasIds = $user->waliKelas()
                ->whereNull('rombel_id')
                ->whereNotNull('kelas_id')
                ->pluck('kelas_id')
                ->unique()
                ->toArray();

            if (!empty($kelasIds)) {
                $rombelFromKelas = Rombel::whereIn('kelas_id', $kelasIds)
                    ->pluck('id')
                    ->unique()
                    ->toArray();
                $rombelsIds = array_merge($rombelsIds, $rombelFromKelas);
            }

            $rombelsIds = array_values(array_unique(array_filter($rombelsIds)));
        }

        $export = new WaliKelasSiswaExport($rombelsIds);
        return Excel::download($export, 'Daftar Siswa.xlsx');
    }
}