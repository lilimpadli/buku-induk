<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'rombels.waliKelas'])->get();
        return view('kurikulum.manajemen-kelas.index', compact('kelas'));
    }
}
