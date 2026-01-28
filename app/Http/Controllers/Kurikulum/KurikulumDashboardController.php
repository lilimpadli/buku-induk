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
        
        // Ambil peserta PPDB terbaru dengan relasi jurusan
        $aktivitas = DataSiswa::with(['ppdb.jalurPpdb.jurusan'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $jurusanNama = '-';
                if ($item->ppdb && $item->ppdb->jalurPpdb && $item->ppdb->jalurPpdb->jurusan) {
                    $jurusanNama = $item->ppdb->jalurPpdb->jurusan->nama;
                }
                
                return [
                    'nama' => $item->nama_lengkap,
                    'aktivitas' => 'PROCESSED',
                    'kelas' => $jurusanNama,
                    'waktu' => $item->created_at?->format('d-M-Y') ?? '-'
                ];
            })
            ->toArray();

        return view('kurikulum.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'siswas', 'jurusan', 'aktivitas'));
    }

    public function detail($id)
{
    $siswa = DataSiswa::findOrFail($id);

    return response()->json($siswa);
}

}