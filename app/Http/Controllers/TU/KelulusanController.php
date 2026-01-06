<?php
namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KenaikanKelas;

class KelulusanController extends Controller
{
    public function index()
    {
        // Ambil semua record kenaikan_kelas yang berstatus lulus, eager load relasi
        $items = KenaikanKelas::where('status', 'lulus')
            ->with(['siswa', 'rombelTujuan.kelas.jurusan'])
            ->get()
            ->groupBy('tahun_ajaran');

        return view('tu.kelulusan.index', compact('items'));
    }

    public function showRombel($rombelId, $tahun)
    {
        // decode tahun in case it was URL-encoded (e.g. "2026%2F2027")
        $tahun = urldecode($tahun);

        $items = KenaikanKelas::where('status', 'lulus')
            ->where('tahun_ajaran', $tahun)
            ->where('rombel_tujuan_id', $rombelId)
            ->with('siswa')
            ->get();

        return view('tu.kelulusan.show', compact('items', 'tahun'));
    }
}
