<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function store(Request $request)
{
    // Validasi data
    $validated = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nip_nuptk' => 'required|unique:pegawais',
        // tambahkan validasi kolom lainnya...
    ]);

    // Simpan ke database
    \App\Models\Pegawai::create($validated);

    return redirect()->route('pegawai.index')->with('success', 'Data berhasil disimpan!');
}

public function index()
{
    // Mengambil semua data pegawai dari database
    $pegawais = \App\Models\Pegawai::all();
    
    // Mengirim data ke view
    return view('pegawai.index', compact('pegawais'));
}

}
