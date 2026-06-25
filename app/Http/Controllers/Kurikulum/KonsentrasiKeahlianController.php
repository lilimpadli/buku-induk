<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KonsentrasiKeahlian;

class KonsentrasiKeahlianController extends Controller
{
    public function index()
    {
        $konsentrasi = KonsentrasiKeahlian::all();
        return view('kurikulum.konsentrasi_keahlian.index', compact('konsentrasi'));
    }

    public function create()
    {
        return view('kurikulum.konsentrasi_keahlian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_konsentrasi' => 'required',
        ]);

        KonsentrasiKeahlian::create([
            'nama_konsentrasi' => $request->nama_konsentrasi,
        ]);

        return redirect()->route('kurikulum.konsentrasi-keahlian.index')
            ->with('success', 'Konsentrasi Keahlian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        return view('kurikulum.konsentrasi_keahlian.edit', compact('konsentrasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_konsentrasi' => 'required',
        ]);

        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $konsentrasi->update([
            'nama_konsentrasi' => $request->nama_konsentrasi,
        ]);

        return redirect()->route('kurikulum.konsentrasi-keahlian.index')
            ->with('success', 'Konsentrasi Keahlian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $konsentrasi->delete();

        return redirect()->route('kurikulum.konsentrasi-keahlian.index')
            ->with('success', 'Konsentrasi Keahlian berhasil dihapus');
    }
}