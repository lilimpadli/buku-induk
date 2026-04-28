<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KonsentrasiKeahlian;
use App\Models\BidangKeahlian;

class KonsentrasiKeahlianController extends Controller
{
    public function index()
    {
        $konsentrasi = KonsentrasiKeahlian::with('bidang')->get();
        return view('kurikulum.konsentrasi_keahlian.index', compact('konsentrasi'));
    }

    public function create()
    {
        $bidang = BidangKeahlian::all();
        return view('kurikulum.konsentrasi_keahlian.create', compact('bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_konsentrasi' => 'required',
            'id_bidang' => 'required|exists:bidang_keahlian,id',
        ]);
        KonsentrasiKeahlian::create($request->only('nama_konsentrasi', 'id_bidang'));
        return redirect()->route('kurikulum.konsentrasi-keahlian.index')->with('success', 'Konsentrasi Keahlian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $bidang = BidangKeahlian::all();
        return view('kurikulum.konsentrasi_keahlian.edit', compact('konsentrasi', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_konsentrasi' => 'required',
            'id_bidang' => 'required|exists:bidang_keahlian,id',
        ]);
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $konsentrasi->update($request->only('nama_konsentrasi', 'id_bidang'));
        return redirect()->route('kurikulum.konsentrasi-keahlian.index')->with('success', 'Konsentrasi Keahlian berhasil diupdate');
    }

    public function destroy($id)
    {
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $konsentrasi->delete();
        return redirect()->route('kurikulum.konsentrasi-keahlian.index')->with('success', 'Konsentrasi Keahlian berhasil dihapus');
    }
}
