<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\NilaiRaport;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class InputNilaiRaportController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return view('walikelas.input_nilai_raport.index', compact('siswas'));
    }

    public function create($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $mataPelajaran = MataPelajaran::all();

        return view('walikelas.input_nilai_raport.create', compact('siswa', 'mataPelajaran'));
    }

   public function store(Request $request, $siswa_id)
{
    $request->validate([
        'semester' => 'required|string',
        'tahun_ajaran' => 'required|string',

        'nilai' => 'required|array',

        'nilai.*.mata_pelajaran' => 'required|string',
        'nilai.*.nilai_pengetahuan' => 'required|integer|min:0|max:100',
        'nilai.*.deskripsi_pengetahuan' => 'required|string',
    ]);

    // Hapus data lama yang sama (semester & tahun ajaran)
    NilaiRaport::where('siswa_id', $siswa_id)
        ->where('semester', $request->semester)
        ->where('tahun_ajaran', $request->tahun_ajaran)
        ->delete();

    // Simpan data baru
    foreach ($request->nilai as $row) {

       NilaiRaport::create([
    'siswa_id' => $siswa_id,
    'semester' => $request->semester,
    'tahun_ajaran' => $request->tahun_ajaran,

    'mata_pelajaran' => $row['mata_pelajaran'],
    'nilai_pengetahuan' => $row['nilai_pengetahuan'],
    'deskripsi_pengetahuan' => $row['deskripsi_pengetahuan'],
]);

    }

    return redirect()->route('walikelas.input_nilai_raport.index')
        ->with('success', 'Nilai raport berhasil disimpan');
}

}
