<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Kkm;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Rombel;  // 🔥 Pindahkan ke sini (di atas class)
use Illuminate\Http\Request;

class KkmController extends Controller
{
    public function index()
    {
        $kkmList = Kkm::with(['mataPelajaran', 'kelas', 'tahunAjaran'])->paginate(10);
        return view('kurikulum.kkm.index', compact('kkmList'));
    }

public function create()
{
    $mataPelajarans = MataPelajaran::select('id', 'nama')->get();
    $rombels = Rombel::all();
    $tahunAjarans = TahunAjaran::all();

    return view('kurikulum.kkm.create', compact('mataPelajarans', 'rombels', 'tahunAjarans'));
}

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nilai_kkm' => 'required|numeric|min:0|max:100',
        ]);

        Kkm::updateOrCreate(
            [
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
            ],
            ['nilai_kkm' => $request->nilai_kkm]
        );

        return redirect()->route('kurikulum.kkm.index')->with('success', 'KKM berhasil disimpan');
    }

    public function edit(Kkm $kkm)
    {
        $mataPelajarans = MataPelajaran::select('id', 'nama')->get();
        $rombels = Rombel::with(['kelas.jurusan'])->get();
        $tahunAjarans = TahunAjaran::all();

        return view('kurikulum.kkm.edit', compact('kkm', 'mataPelajarans', 'rombels', 'tahunAjarans'));
    }

    public function update(Request $request, Kkm $kkm)
    {
        $request->validate([
            'nilai_kkm' => 'required|numeric|min:0|max:100',
        ]);

        $kkm->update($request->only('nilai_kkm'));

        return redirect()->route('kurikulum.kkm.index')->with('success', 'KKM berhasil diupdate');
    }

    public function destroy(Kkm $kkm)
    {
        $kkm->delete();
        return redirect()->route('kurikulum.kkm.index')->with('success', 'KKM berhasil dihapus');
    }
}