<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('kurikulum.semester.index', compact('semesters'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        return view('kurikulum.semester.create', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
            'is_current' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek duplikasi
        $exists = Semester::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            $nama = $request->semester == '1' ? 'Ganjil' : 'Genap';
            return redirect()->back()
                ->with('error', 'Semester ' . $nama . ' sudah ada untuk tahun ajaran ini.')
                ->withInput();
        }

        // Jika set current, nonaktifkan current lainnya
        if ($request->is_current) {
            Semester::where('is_current', true)->update(['is_current' => false]);
        }

        // Jika set active, nonaktifkan active lainnya
        if ($request->is_active) {
            Semester::where('is_active', true)->update(['is_active' => false]);
        }

        Semester::create($request->all());

        return redirect()->route('kurikulum.semester.index')
            ->with('success', 'Semester berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $semester = Semester::with('tahunAjaran')->findOrFail($id);
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        return view('kurikulum.semester.edit', compact('semester', 'tahunAjarans'));
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
            'is_current' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek duplikasi (kecuali dirinya sendiri)
        $exists = Semester::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('semester', $request->semester)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            $nama = $request->semester == '1' ? 'Ganjil' : 'Genap';
            return redirect()->back()
                ->with('error', 'Semester ' . $nama . ' sudah ada untuk tahun ajaran ini.')
                ->withInput();
        }

        // Jika set current, nonaktifkan current lainnya
        if ($request->is_current) {
            Semester::where('is_current', true)->where('id', '!=', $id)->update(['is_current' => false]);
        }

        // Jika set active, nonaktifkan active lainnya
        if ($request->is_active) {
            Semester::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $semester->update($request->all());

        return redirect()->route('kurikulum.semester.index')
            ->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();

        return redirect()->route('kurikulum.semester.index')
            ->with('success', 'Semester berhasil dihapus.');
    }

    public function setCurrent($id)
    {
        $semester = Semester::findOrFail($id);
        
        Semester::where('is_current', true)->update(['is_current' => false]);
        $semester->update(['is_current' => true]);

        $nama = $semester->semester == '1' ? 'Ganjil' : 'Genap';
        return redirect()->back()->with('success', 'Semester ' . $nama . ' ditetapkan sebagai semester berjalan.');
    }

    public function toggleActive($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->update(['is_active' => !$semester->is_active]);

        $status = $semester->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Semester berhasil ' . $status . '.');
    }
}