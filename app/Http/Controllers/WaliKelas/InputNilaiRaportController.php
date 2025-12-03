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
            'nilai.*.mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nilai.*.nilai_akhir' => 'required|integer|min:0|max:100',
            'nilai.*.predikat' => 'required|string',
            'nilai.*.deskripsi' => 'required|string',
        ]);

        $siswa = Siswa::findOrFail($siswa_id);

        // Hapus nilai raport lama untuk siswa, semester, dan tahun ajaran yang sama
        NilaiRaport::where('siswa_id', $siswa_id)
            ->where('semester', $request->semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->delete();

        // Simpan nilai raport baru
        foreach ($request->nilai as $nilai) {
            $mapel = MataPelajaran::find($nilai['mata_pelajaran_id']);
            
            NilaiRaport::create([
                'siswa_id' => $siswa_id,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'mata_pelajaran' => $mapel->nama,
                'kkm' => $mapel->kkm,
                'nilai_pengetahuan' => $nilai['nilai_akhir'],
                'predikat_pengetahuan' => $nilai['predikat'],
                'deskripsi_pengetahuan' => $nilai['deskripsi'],
                'nilai_keterampilan' => 0, // Default 0 jika tidak ada input
                'predikat_keterampilan' => '',
                'deskripsi_keterampilan' => '',
            ]);
        }

        return redirect()->route('walikelas.input_nilai_raport.index')
            ->with('success', 'Nilai raport berhasil disimpan');
    }
}