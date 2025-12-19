<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Jurusan::query();
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kode', 'like', '%' . $search . '%');
        }
        
        // Dapatkan hasil dengan pagination
        $jurusans = $query->paginate(12);
        
        // Pertahankan parameter query string di pagination links
        $jurusans->appends($request->query());
        
        return view('kurikulum.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('kurikulum.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:jurusans,kode',
            'nama' => 'required|string|max:255|unique:jurusans,nama',
        ]);

        Jurusan::create($request->only(['kode', 'nama']));

        return redirect()->route('kurikulum.jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jurusan = Jurusan::with('kelas.rombels')->findOrFail($id);
        return view('kurikulum.jurusan.show', compact('jurusan'));
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('kurikulum.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:jurusans,kode,' . $id,
            'nama' => 'required|string|max:255|unique:jurusans,nama,' . $id,
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->only(['kode', 'nama']));

        return redirect()->route('kurikulum.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('kurikulum.jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus.');
    }
}