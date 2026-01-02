<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class TambahKelasController extends Controller
{
    /**
     * Menampilkan daftar kelas
     */
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.kelas.index', compact('kelas'));
    }

    /**
     * Menampilkan form tambah kelas
     */
    public function create()
    {
        $jurusans = Jurusan::all();
        return view('tu.kelas.create', compact('jurusans'));
    }

    /**
     * Menyimpan data kelas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        Kelas::create($validated);
        
        return redirect()->route('tu.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }
}