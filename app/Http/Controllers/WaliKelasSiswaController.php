<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSiswa;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WaliKelasSiswaController extends Controller
{
    // List siswa
    public function index()
    {
        $siswa = DataSiswa::orderBy('nama_lengkap')->get();
        return view('walikelas.siswa.index', compact('siswa'));
    }

    // Detail siswa
    public function show($id)
    {
        $s = DataSiswa::findOrFail($id);
        return view('walikelas.siswa.show', compact('s'));
    }

    // Dashboard wali kelas
    public function dashboard()
    {
        $total = DataSiswa::count();
        $recent = DataSiswa::orderBy('created_at', 'desc')->limit(6)->get();

        $byGender = DataSiswa::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')
            ->toArray();

        return view('walikelas.dashboard', compact('total', 'recent', 'byGender'));
    }

    // Export data siswa ke PDF (untuk wali kelas)
    public function exportPdf($id)
    {
        $s = DataSiswa::findOrFail($id);

        $pdf = Pdf::loadView('siswa.pdf', ['siswa' => $s])
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Data Siswa - ' . ($s->nama_lengkap ?? $s->nis) . '.pdf');
    }
}
