<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\NilaiRaport;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiRaportController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama_lengkap', 'ASC')->get();
        return view('walikelas.nilai_raport.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        $nilaiRaports = NilaiRaport::where('siswa_id', $id)
            ->orderBy('mata_pelajaran', 'ASC')
            ->get();

        return view('walikelas.nilai_raport.show', compact('siswa', 'nilaiRaports'));
    }

    /* ================================
       EXPORT PDF FUNGSI BARU
       ================================ */
    public function exportPdf($id)
    {
        $siswa = Siswa::findOrFail($id);

        $nilaiRaports = NilaiRaport::where('siswa_id', $id)
            ->orderBy('mata_pelajaran', 'ASC')
            ->get();

        // Load view into PDF
        $pdf = Pdf::loadView('walikelas.nilai_raport.pdf', [
            'siswa' => $siswa,
            'nilaiRaports' => $nilaiRaports
        ])->setPaper('a4', 'portrait');

        // Nama file otomatis
        $filename = 'Raport_' . $siswa->nama_lengkap . '.pdf';

        return $pdf->stream($filename);
    }
}
