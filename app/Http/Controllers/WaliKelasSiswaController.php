<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSiswa;

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
}
