<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\DataSiswa;

class SiswaExportController extends Controller
{
    public function exportPDF()
    {
        $data = DataSiswa::where('user_id', Auth::id())->firstOrFail();

        $pdf = Pdf::loadView('export.siswa_pdf', compact('data'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('data_diri_siswa.pdf');
    }
}
