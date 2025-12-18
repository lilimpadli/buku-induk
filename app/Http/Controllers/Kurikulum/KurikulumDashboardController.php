<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KurikulumDashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = DataSiswa::count();
        $totalGuru  = User::where('role', '!=', 'siswa')->count();
        $totalKelas = DB::table('kelas')->count();

        $siswas = DataSiswa::orderBy('nama_lengkap')->get();
        $jurusan = null;
        $aktivitas = []; // Placeholder for activities

        return view('kurikulum.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'siswas', 'jurusan', 'aktivitas'));
    }

    public function detail($id)
{
    $siswa = DataSiswa::findOrFail($id);

    return response()->json($siswa);
}

}