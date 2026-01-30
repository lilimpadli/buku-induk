<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Ppdb;
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
        
        // Ambil peserta PPDB terbaru langsung dari model Ppdb (relasi yang benar)
        $aktivitas = Ppdb::with(['jalur','jurusan'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $jurusanNama = '-';
                if ($item->jurusan) {
                    $jurusanNama = $item->jurusan->nama;
                }
                // fallback: jika jalur membawa info jurusan di masa depan
                elseif ($item->jalur && isset($item->jalur->jurusan)) {
                    $jurusanNama = $item->jalur->jurusan->nama ?? '-';
                }

                return [
                    'nama' => $item->nama_lengkap,
                    'aktivitas' => strtoupper($item->status ?? 'PROCESSED'),
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