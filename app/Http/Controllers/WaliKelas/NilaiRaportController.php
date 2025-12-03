<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\NilaiRaport;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiRaportController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return view('walikelas.nilai_raport.index', compact('siswas'));
    }

    public function show($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $nilaiRaports = NilaiRaport::where('siswa_id', $siswa_id)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('walikelas.nilai_raport.show', compact('siswa', 'nilaiRaports'));
    }
}