<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelastuController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('tu.kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        Kelas::create($validated);
        
        return redirect()->route('tu.kelas')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $kelas = Kelas::with('jurusan')->findOrFail($id);
        return view('tu.kelas.show', compact('kelas'));
    }
}