<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tingkat = $request->query('tingkat');

        if ($tingkat) {
            $mapels = MataPelajaran::whereHas('tingkats', function($q) use ($tingkat) {
                $q->where('tingkat', intval($tingkat));
            })->orderBy('urutan')->get();
        } else {
            $mapels = MataPelajaran::orderBy('urutan')->get();
        }

        return view('kurikulum.mata-pelajaran.index', compact('mapels', 'tingkat'));
    }

    public function create()
    {
        $mapel = new MataPelajaran();
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.store'),
            'method' => 'POST',
            'title' => 'Tambah Mata Pelajaran'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer'
        ]);

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
        return view('kurikulum.mata-pelajaran.form', [
            'mapel' => $mapel,
            'action' => route('kurikulum.mata-pelajaran.update', $mapel->id),
            'method' => 'PUT',
            'title' => 'Edit Mata Pelajaran'
        ]);
    }

    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer'
        ]);

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
