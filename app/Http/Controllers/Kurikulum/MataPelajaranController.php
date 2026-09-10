<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\Kurikulum;
use App\Models\Jurusan;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tingkat = $request->query('tingkat');
        $jurusan = $request->query('jurusan');

        $jurusans = Jurusan::orderBy('nama')->get();
        $query = MataPelajaran::query();

        if ($jurusan) {
            $query->whereHas('jurusans', function($q) use ($jurusan) {
                $q->where('jurusans.id', $jurusan);
            });
        }

        if ($tingkat) {
            $query->whereHas('tingkats', function($q) use ($tingkat) {
                $q->where('tingkat', intval($tingkat));
            });
        }

        $mapels = $query->orderBy('kelompok')->orderBy('urutan')->get();

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

        // Auto-generate urutan jika diisi kosong/null
        if (!$request->filled('urutan')) {
            $request->merge(['urutan' => MataPelajaran::max('urutan') + 1]);
        }

        $mapel = MataPelajaran::create($request->only(['nama', 'kelompok', 'urutan']));

        if ($request->filled('kurikulum_ids')) {
            $mapel->kurikulums()->sync($request->kurikulum_ids);
        }

        if ($request->filled('jurusan_ids')) {
            $mapel->jurusans()->sync($request->jurusan_ids);
        }

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

        $mapel->update($request->only(['nama', 'kelompok', 'urutan']));

        // Sync kurikulum & jurusan tanpa memicu error urutan
        $mapel->kurikulums()->sync($data['kurikulum_ids'] ?? []);
        $mapel->jurusans()->sync($data['jurusan_ids'] ?? []);

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