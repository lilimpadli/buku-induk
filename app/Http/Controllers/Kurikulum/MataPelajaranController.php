<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\Kurikulum;
use App\Models\Jurusan;
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
            // Use many-to-many relationship instead of direct jurusan_id column
            $query->whereHas('jurusans', function($q) use ($jurusan) {
                $q->where('jurusans.id', $jurusan);
            });
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
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        $jurusans = Jurusan::orderBy('nama')->get();
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.store'),
            'method' => 'POST',
            'title' => 'Tambah Mata Pelajaran',
            'kurikulums' => $kurikulums,
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer',
            'kurikulum_ids' => 'nullable|array',
            'kurikulum_ids.*' => 'exists:kurikum,id',
            'jurusan_ids' => 'nullable|array',
            'jurusan_ids.*' => 'exists:jurusans,id'
        ]);

        // Validasi urutan tidak boleh sama di 1 tingkat
        if ($request->filled('urutan') && $request->filled('tingkat')) {
            $urutan = $request->input('urutan');
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            
            foreach ($tingkats as $t) {
                $exists = \App\Models\MataPelajaranTingkat::whereHas('mataPelajaran', function($q) use ($urutan) {
                    $q->where('urutan', $urutan);
                })->where('tingkat', $t)->exists();
                
                if ($exists) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Urutan $urutan sudah digunakan di kelas $t. Gunakan urutan yang berbeda.");
                }
            }
        }

        $mapel = MataPelajaran::create($request->only(['nama', 'kelompok', 'urutan']));

        // Sync kurikulum relationships
        if ($request->filled('kurikulum_ids')) {
            $mapel->kurikulums()->sync($request->kurikulum_ids);
        }

        // Sync jurusan relationships
        if ($request->filled('jurusan_ids')) {
            $mapel->jurusans()->sync($request->jurusan_ids);
        }

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
        $mapel = MataPelajaran::with(['kurikulums', 'jurusans'])->findOrFail($id);
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        $jurusans = Jurusan::orderBy('nama')->get();
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.update', $mapel->id),
            'method' => 'PUT',
            'title' => 'Edit Mata Pelajaran',
            'kurikulums' => $kurikulums,
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
            'kurikulum_ids' => 'nullable|array',
            'kurikulum_ids.*' => 'exists:kurikum,id',
            'jurusan_ids' => 'nullable|array',
            'jurusan_ids.*' => 'exists:jurusans,id'
        ]);

        // Validasi urutan tidak boleh sama di 1 tingkat (exclude mapel saat ini)
        if ($request->filled('urutan') && $request->filled('tingkat')) {
            $urutan = $request->input('urutan');
            $tingkats = array_map('intval', (array) $request->input('tingkat'));
            
            foreach ($tingkats as $t) {
                $exists = \App\Models\MataPelajaranTingkat::whereHas('mataPelajaran', function($q) use ($urutan, $id) {
                    $q->where('urutan', $urutan)
                      ->where('id', '!=', $id);
                })->where('tingkat', $t)->exists();
                
                if ($exists) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Urutan $urutan sudah digunakan di kelas $t. Gunakan urutan yang berbeda.");
                }
            }
        }

        $mapel->update($request->only(['nama', 'kelompok', 'urutan']));

        // Sync kurikulum relationships
        $mapel->kurikulums()->sync($data['kurikulum_ids'] ?? []);

        // Sync jurusan relationships
        $mapel->jurusans()->sync($data['jurusan_ids'] ?? []);

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
