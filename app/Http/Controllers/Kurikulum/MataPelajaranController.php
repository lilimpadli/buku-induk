<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Schema;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tingkat = $request->query('tingkat');
        $jurusan = $request->query('jurusan');

        // available jurusans for the filter dropdown
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();

        $query = MataPelajaran::query();

        if ($jurusan) {
            // only apply jurusan filter if the column exists in the table
            if (Schema::hasColumn('mata_pelajarans', 'jurusan_id')) {
                $query->where('jurusan_id', $jurusan);
            }
            // otherwise skip jurusan filtering (legacy schema)
        }

        if ($tingkat) {
            $query->whereHas('tingkats', function($q) use ($tingkat) {
                $q->where('tingkat', intval($tingkat));
            });
        }

        $mapels = $query->orderBy('urutan')->get();

        return view('kurikulum.mata-pelajaran.index', compact('mapels', 'tingkat', 'jurusans', 'jurusan'));
    }

    public function create()
    {
        $mapel = new MataPelajaran();
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.store'),
            'method' => 'POST',
            'title' => 'Tambah Mata Pelajaran',
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer',
            'jurusan_id' => 'nullable|exists:jurusans,id'
        ]);

        // Validasi urutan tidak boleh sama di 1 tingkat
        if ($request->filled('urutan') && $request->filled('tingkat')) {
            $urutan = $request->input('urutan');
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            
            foreach ($tingkats as $t) {
                $exists = \App\Models\MataPelajaranTingkat::whereHas('mataPelajaran', function($q) use ($urutan, $data) {
                    $q->where('urutan', $urutan);
                    if ($data['jurusan_id']) {
                        $q->where('jurusan_id', $data['jurusan_id']);
                    }
                })->where('tingkat', $t)->exists();
                
                if ($exists) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Urutan $urutan sudah digunakan di kelas $t. Gunakan urutan yang berbeda.");
                }
            }
        }

        $mapel = MataPelajaran::create($data);

        // sync tingkat
        if ($request->filled('tingkat')) {
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            foreach ($tingkats as $t) {
                \App\Models\MataPelajaranTingkat::create(['mata_pelajaran_id' => $mapel->id, 'tingkat' => $t]);
            }
        }

        return redirect()->route('kurikulum.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.update', $mapel->id),
            'method' => 'PUT',
            'title' => 'Edit Mata Pelajaran',
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer',
            'jurusan_id' => 'nullable|exists:jurusans,id'
        ]);

        // Validasi urutan tidak boleh sama di 1 tingkat (exclude mapel saat ini)
        if ($request->filled('urutan') && $request->filled('tingkat')) {
            $urutan = $request->input('urutan');
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            
            foreach ($tingkats as $t) {
                $exists = \App\Models\MataPelajaranTingkat::whereHas('mataPelajaran', function($q) use ($urutan, $data, $id) {
                    $q->where('urutan', $urutan)
                      ->where('id', '!=', $id);
                    if ($data['jurusan_id']) {
                        $q->where('jurusan_id', $data['jurusan_id']);
                    }
                })->where('tingkat', $t)->exists();
                
                if ($exists) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Urutan $urutan sudah digunakan di kelas $t. Gunakan urutan yang berbeda.");
                }
            }
        }

        $mapel->update($data);

        // sync tingkat: delete existing then insert
        \App\Models\MataPelajaranTingkat::where('mata_pelajaran_id', $mapel->id)->delete();
        if ($request->filled('tingkat')) {
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            foreach ($tingkats as $t) {
                \App\Models\MataPelajaranTingkat::create(['mata_pelajaran_id' => $mapel->id, 'tingkat' => $t]);
            }
        }

        return redirect()->route('kurikulum.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return redirect()->route('kurikulum.mata-pelajaran.index')->with('success', 'Mata pelajaran dihapus.');
    }
}
