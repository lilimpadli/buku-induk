<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Guru;
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
        
        // Get search and filter parameters
        $search = $request->get('search', '');
        $jurusan_id = $request->get('jurusan', '');
        
        // Filter berdasarkan pencarian
        if (!empty($search)) {
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
        
        // Filter berdasarkan jurusan
        if (!empty($jurusan_id)) {
            $query->whereHas('kelas', function($q) use ($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            });
        }
        
        // Get all jurusans for dropdown
        $allJurusans = Jurusan::all();
        
        // Dapatkan hasil dengan pagination
        $rombels = $query->paginate(12)->withQueryString();
        
        return view('kurikulum.manajemen-kelas.index', compact('rombels', 'search', 'jurusan_id', 'allJurusans'));
    }

    public function create()
    {
        $tingkats = [10, 11, 12];
        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        return view('kurikulum.manajemen-kelas.create', compact('tingkats', 'jurusans', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:10,11,12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        // Cari kelas berdasarkan tingkat dan jurusan
        $kelas = Kelas::where('tingkat', $request->tingkat)
                      ->where('jurusan_id', $request->jurusan_id)
                      ->first();

        if (!$kelas) {
            return back()->withErrors(['kelas' => 'Kelas dengan tingkat dan jurusan tersebut tidak ditemukan.'])->withInput();
        }

        Rombel::create([
            'kelas_id' => $kelas->id,
            'nama' => $request->nama,
            'guru_id' => $request->guru_id,
        ]);

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
        $tingkats = [10, 11, 12];
        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        return view('kurikulum.manajemen-kelas.edit', compact('rombel', 'tingkats', 'jurusans', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat' => 'required|in:10,11,12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        // Cari kelas berdasarkan tingkat dan jurusan
        $kelas = Kelas::where('tingkat', $request->tingkat)
                      ->where('jurusan_id', $request->jurusan_id)
                      ->first();

        if (!$kelas) {
            return back()->withErrors(['kelas' => 'Kelas dengan tingkat dan jurusan tersebut tidak ditemukan.'])->withInput();
        }

        $rombel = Rombel::findOrFail($id);
        $rombel->update([
            'kelas_id' => $kelas->id,
            'nama' => $request->nama,
            'guru_id' => $request->guru_id,
        ]);

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