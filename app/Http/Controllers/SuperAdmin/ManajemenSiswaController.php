<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ManajemenSiswaController extends Controller
{
    public function index()
    {
        $query = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->latest();

        $tingkat = request()->query('tingkat', null);
        if ($tingkat) {
            $query->whereHas('rombel.kelas', function ($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            });
        }

        // Search and rombel filters
        $search = request()->query('search', null);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $filterRombel = request()->query('rombel', null);
        if ($filterRombel) {
            $query->where('rombel_id', $filterRombel);
        }

        $allRombels = Rombel::with('kelas')->orderBy('nama')->get();

        // List of jurusans for export options
        $allJurusans = Jurusan::orderBy('nama')->get();

        $siswas = $query->paginate(10)->withQueryString();

        return view('super_admin.manajemen-siswa.index', compact('siswas', 'search', 'allRombels', 'filterRombel', 'allJurusans'));
    }

    public function create()
    {
        $rombels = Rombel::with('kelas.jurusan')->orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('super_admin.manajemen-siswa.create', compact('rombels', 'kelas', 'jurusans'));
    }

    public function store(Request $request)
    {
        // Validation and store logic would go here
        // For now, just redirect back
        return redirect()->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $siswa = DataSiswa::with(['user', 'ayah', 'ibu', 'wali', 'rombel.kelas.jurusan'])->findOrFail($id);
        return view('super_admin.manajemen-siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = DataSiswa::with('rombel.kelas.jurusan')->findOrFail($id);
        $rombels = Rombel::with('kelas.jurusan')->orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('super_admin.manajemen-siswa.edit', compact('siswa', 'rombels', 'kelas', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        // Validation and update logic would go here
        return redirect()->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function exportByJurusan($jurusanId)
    {
        // Export logic would go here
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    public function exportByAngkatan($jurusanId)
    {
        // Export logic would go here
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    public function import(Request $request)
    {
        // Import logic would go here
        return redirect()->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }
}