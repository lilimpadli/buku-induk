<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BidangKeahlian;

class BidangKeahlianController extends Controller
{
    public function index()
    {
        $bidang = BidangKeahlian::all();
        return view('kurikulum.bidang_keahlian.index', compact('bidang'));
    }

    public function create()
    {
        return view('kurikulum.bidang_keahlian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_keahlian' => 'required',
        ]);
        BidangKeahlian::create($request->only('nama_keahlian'));
        return redirect()->route('kurikulum.bidang-keahlian.index')->with('success', 'Bidang Keahlian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bidang = BidangKeahlian::findOrFail($id);
        return view('kurikulum.bidang_keahlian.edit', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_keahlian' => 'required',
        ]);
        $bidang = BidangKeahlian::findOrFail($id);
        $bidang->update($request->only('nama_keahlian'));
        return redirect()->route('kurikulum.bidang-keahlian.index')->with('success', 'Bidang Keahlian berhasil diupdate');
    }

    public function destroy($id)
    {
        $bidang = BidangKeahlian::findOrFail($id);
        $bidang->delete();
        return redirect()->route('kurikulum.bidang-keahlian.index')->with('success', 'Bidang Keahlian berhasil dihapus');
    }
}
