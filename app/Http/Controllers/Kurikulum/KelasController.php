<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan relasi
        $query = Rombel::with(['kelas.jurusan', 'guru']);
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhereHas('kelas', function($q) use ($search) {
                      $q->where('tingkat', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('kelas.jurusan', function($q) use ($search) {
                      $q->where('nama', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('guru', function($q) use ($search) {
                      $q->where('nama', 'like', '%' . $search . '%');
                  });
        }
        
        // Dapatkan hasil dengan pagination
        $rombels = $query->paginate(12);
        
        // Pertahankan parameter query string di pagination links
        $rombels->appends($request->query());
        
        return view('kurikulum.manajemen-kelas.index', compact('rombels'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        $gurus = \App\Models\Guru::all();
        return view('kurikulum.manajemen-kelas.create', compact('kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        Rombel::create($request->only(['kelas_id', 'nama', 'guru_id']));

        return redirect()->route('kurikulum.kelas.index')
            ->with('success', 'Data rombel berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Find the rombel and load its related class, major, teacher, and students
        $rombel = Rombel::with(['kelas.jurusan', 'guru', 'siswa'])->findOrFail($id);

        // Return the view with the rombel data
        return view('kurikulum.manajemen-kelas.show', compact('rombel'));
    }

    public function edit($id)
    {
        $rombel = Rombel::findOrFail($id);
        $kelas = Kelas::with('jurusan')->get();
        $gurus = \App\Models\Guru::all();
        return view('kurikulum.manajemen-kelas.edit', compact('rombel', 'kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $rombel = Rombel::findOrFail($id);
        $rombel->update($request->only(['kelas_id', 'nama', 'guru_id']));

        return redirect()->route('kurikulum.kelas.index')
            ->with('success', 'Data rombel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->delete();

        return redirect()->route('kurikulum.kelas.index')
            ->with('success', 'Data rombel berhasil dihapus.');
    }
}