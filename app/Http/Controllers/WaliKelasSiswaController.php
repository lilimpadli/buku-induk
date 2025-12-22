<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSiswa;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;
use Barryvdh\DomPDF\Facade\Pdf;

class WaliKelasSiswaController extends Controller
{
    // List siswa
    public function index()
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
            $siswa = DataSiswa::with(['ayah', 'ibu', 'wali'])
                ->whereIn('rombel_id', $rombelsIds)
                ->orderBy('nama_lengkap')
                ->get();
        } else {
            // jika tidak ada penugasan, kembalikan kosong supaya wali tidak melihat seluruh siswa
            $siswa = collect();
        }
        return view('walikelas.siswa.index', compact('siswa'));
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
            $total = DataSiswa::whereIn('rombel_id', $rombelsIds)->count();
            $recent = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel'])
                ->whereIn('rombel_id', $rombelsIds)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            $byGender = DataSiswa::whereIn('rombel_id', $rombelsIds)
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
}