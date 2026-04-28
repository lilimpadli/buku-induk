<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\KonsentrasiKeahlian;

class ProgramKeahlianController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with('kelas', 'gurus', 'mataPelajarans')->get();
        return view('kurikulum.program_keahlian.index', compact('jurusans'));
    }

    public function create()
    {
        $konsentrasi = KonsentrasiKeahlian::all();
        return view('kurikulum.program_keahlian.create', compact('konsentrasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jurusans,kode',
            'nama' => 'required',
            'id_konsentrasi' => 'required|exists:konsentrasi_keahlian,id',
        ]);
        $jurusan = new Jurusan();
        $jurusan->kode = $request->kode;
        $jurusan->nama = $request->nama;
        $jurusan->id_bidang = null; // default, bisa diubah nanti
        $jurusan->save();
        // relasi ke konsentrasi bisa diatur jika ada pivot
        return redirect()->route('kurikulum.program-keahlian.index')->with('success', 'Program Keahlian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $konsentrasi = KonsentrasiKeahlian::all();
        return view('kurikulum.program_keahlian.edit', compact('jurusan', 'konsentrasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:jurusans,kode,' . $id,
            'nama' => 'required',
            'id_konsentrasi' => 'required|exists:konsentrasi_keahlian,id',
        ]);
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->kode = $request->kode;
        $jurusan->nama = $request->nama;
        $jurusan->save();
        // relasi ke konsentrasi bisa diatur jika ada pivot
        return redirect()->route('kurikulum.program-keahlian.index')->with('success', 'Program Keahlian berhasil diupdate');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        return redirect()->route('kurikulum.program-keahlian.index')->with('success', 'Program Keahlian berhasil dihapus');
    }
}
