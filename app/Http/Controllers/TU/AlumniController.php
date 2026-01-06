<?php
namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\KenaikanKelas;
use App\Models\DataSiswa;

class AlumniController extends Controller
{
    public function index()
    {
        // Ambil daftar alumni (siswa yang pernah memiliki record kelulusan)
        $kelulusan = KenaikanKelas::where('status', 'lulus')->with('siswa')->get();
        $siswaIds = $kelulusan->pluck('siswa_id')->unique()->filter();

        $siswas = DataSiswa::whereIn('id', $siswaIds)->get();

        return view('tu.alumni.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('tu.alumni.show', compact('siswa'));
    }
}
