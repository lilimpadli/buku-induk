<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Jurusan;

class BukuIndukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::with(['rombel.kelas.jurusan', 'user'])->paginate(15);
        $jurusans = Jurusan::all();
        return view('kurikulum.buku-induk.index', compact('siswas', 'jurusans'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = Siswa::with(['rombel.kelas.jurusan', 'user', 'nilaiRaports'])->findOrFail($id);
        return view('kurikulum.buku-induk.show', compact('siswa'));
    }

    /**
     * Print the specified resource.
     */
    public function cetak($id)
    {
        $siswa = Siswa::with(['rombel.kelas.jurusan', 'user', 'nilaiRaports'])->findOrFail($id);
        return view('kurikulum.buku-induk.cetak', compact('siswa'));
    }
}