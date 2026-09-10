<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Guru;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $allowedRoles = ['tu', 'tu_kepegawaian'];
            if ($user && in_array(strtolower($user->role), $allowedRoles)) {
                return $next($request);
            }
            abort(403, 'Akses ditolak!');
        });
    }

    public function create()
    {
        $gurus = Guru::all();
        $pegawais = Pegawai::all(); 
        return view('tu.mutasi.create', compact('gurus', 'pegawais')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'entitas_id'   => 'required', 
            'jenis_mutasi' => 'required',
            'tanggal'      => 'required|date',
        ]);

        // Mengambil data dari string (misal: "guru-1" atau "pegawai-5")
        $data = explode('-', $request->entitas_id);
        
        // Pastikan data valid
        if (count($data) !== 2) {
            return redirect()->back()->with('error', 'Format data entitas tidak valid!');
        }

        $id   = $data[1];

        // PERBAIKAN: Simpan ke kolom 'guru_id' dan 'jenis' (sesuai database)
        Mutasi::create([
            'guru_id'    => $id,
            'jenis'      => $request->jenis_mutasi,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan ?? null,
        ]);

        return redirect()->route('tu_kepegawaian.mutasi.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $gurus = Guru::all();
        $pegawais = Pegawai::all(); 
        
        return view('tu.mutasi.edit', compact('mutasi', 'gurus', 'pegawais')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_mutasi' => 'required',
            'tanggal'      => 'required|date',
        ]);

        $mutasi = Mutasi::findOrFail($id);

        // PERBAIKAN: Hanya update kolom 'jenis' dan 'tanggal' (bisa tambahkan keterangan jika diinput)
        $mutasi->update([
            'jenis'      => $request->jenis_mutasi,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan ?? null,
        ]);

        return redirect()->route('tu_kepegawaian.mutasi.index')->with('success', 'Data berhasil diupdate!');
    }
}