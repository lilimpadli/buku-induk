<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;

class ProgramKeahlianController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with('kelas', 'gurus', 'mataPelajarans')->get();
        return view('kurikulum.program_keahlian.index', compact('jurusans'));
    }

    public function create()
    {
        return view('kurikulum.program_keahlian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jurusans,kode',
            'nama' => 'required',
        ]);

        Jurusan::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'id_bidang' => null,
        ]);

        return redirect()->route('kurikulum.program-keahlian.index')
            ->with('success', 'Program Keahlian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('kurikulum.program_keahlian.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:jurusans,kode,' . $id,
            'nama' => 'required',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kurikulum.program-keahlian.index')
            ->with('success', 'Program Keahlian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('kurikulum.program-keahlian.index')
            ->with('success', 'Program Keahlian berhasil dihapus');
    }
}