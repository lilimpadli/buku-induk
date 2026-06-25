<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        return view('kurikulum.tahun_ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('kurikulum.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|string|max:9|unique:tahun_ajarans,tahun',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
            'is_current' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Jika set current, nonaktifkan current lainnya
        if ($request->is_current) {
            TahunAjaran::where('is_current', true)->update(['is_current' => false]);
        }

        // Jika set active, nonaktifkan active lainnya
        if ($request->is_active) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create($request->all());

        return redirect()->route('kurikulum.tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('kurikulum.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun' => 'required|string|max:9|unique:tahun_ajarans,tahun,' . $id,
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
            'is_current' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Jika set current, nonaktifkan current lainnya
        if ($request->is_current) {
            TahunAjaran::where('is_current', true)->where('id', '!=', $id)->update(['is_current' => false]);
        }

        // Jika set active, nonaktifkan active lainnya
        if ($request->is_active) {
            TahunAjaran::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $tahunAjaran->update($request->all());

        return redirect()->route('kurikulum.tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        // Cek apakah tahun ajaran memiliki semester
        if ($tahunAjaran->semesters()->count() > 0) {
            return redirect()->back()->with('error', 'Tahun Ajaran tidak bisa dihapus karena memiliki data Semester.');
        }

        $tahunAjaran->delete();
        return redirect()->route('kurikulum.tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    public function setCurrent($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        
        TahunAjaran::where('is_current', true)->update(['is_current' => false]);
        $tahunAjaran->update(['is_current' => true]);

        return redirect()->back()->with('success', 'Tahun Ajaran ' . $tahunAjaran->tahun . ' ditetapkan sebagai tahun berjalan.');
    }

    public function toggleActive($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update(['is_active' => !$tahunAjaran->is_active]);

        $status = $tahunAjaran->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil ' . $status . '.');
    }
}