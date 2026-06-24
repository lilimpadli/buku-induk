<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JamPelajaranController extends Controller
{
    public function index()
    {
        $jamPelajarans = JamPelajaran::ordered()->get();
        return view('kurikulum.jam_pelajaran.index', compact('jamPelajarans'));
    }

    public function create()
    {
        return view('kurikulum.jam_pelajaran.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_jam' => 'required|string|max:10|unique:jam_pelajarans,kode_jam',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JamPelajaran::create($request->all());

        return redirect()->route('kurikulum.jam-pelajaran.index')
            ->with('success', 'Jam Pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);
        return view('kurikulum.jam_pelajaran.edit', compact('jamPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_jam' => 'required|string|max:10|unique:jam_pelajarans,kode_jam,' . $id,
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jamPelajaran->update($request->all());

        return redirect()->route('kurikulum.jam-pelajaran.index')
            ->with('success', 'Jam Pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);
        $jamPelajaran->delete();

        return redirect()->route('kurikulum.jam-pelajaran.index')
            ->with('success', 'Jam Pelajaran berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);
        $jamPelajaran->update(['is_active' => !$jamPelajaran->is_active]);

        $status = $jamPelajaran->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Jam Pelajaran berhasil ' . $status . '.');
    }
}