<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangKelasController extends Controller
{
    public function index()
    {
        $ruangKelas = RuangKelas::orderBy('kode_ruang')->get();
        return view('kurikulum.ruang_kelas.index', compact('ruangKelas'));
    }

    public function create()
    {
        return view('kurikulum.ruang_kelas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_ruang' => 'required|string|max:20|unique:ruang_kelas,kode_ruang',
            'nama_ruang' => 'required|string|max:100',
            'lantai' => 'nullable|string|max:10',
            'gedung' => 'nullable|string|max:50',
            'kapasitas' => 'required|integer|min:1',
            'jenis_ruang' => 'required|string|max:50',
            'fasilitas' => 'nullable|string',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        RuangKelas::create($request->all());

        return redirect()->route('kurikulum.ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);
        return view('kurikulum.ruang_kelas.edit', compact('ruangKelas'));
    }

    public function update(Request $request, $id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_ruang' => 'required|string|max:20|unique:ruang_kelas,kode_ruang,' . $id,
            'nama_ruang' => 'required|string|max:100',
            'lantai' => 'nullable|string|max:10',
            'gedung' => 'nullable|string|max:50',
            'kapasitas' => 'required|integer|min:1',
            'jenis_ruang' => 'required|string|max:50',
            'fasilitas' => 'nullable|string',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ruangKelas->update($request->all());

        return redirect()->route('kurikulum.ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);
        $ruangKelas->delete();

        return redirect()->route('kurikulum.ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);
        $ruangKelas->update(['is_active' => !$ruangKelas->is_active]);

        $status = $ruangKelas->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Ruang Kelas berhasil ' . $status . '.');
    }
}