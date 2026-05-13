<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Exports\KaprogSiswaByRombelExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ManajemenKelasController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan relasi
        $query = Rombel::with(['kelas.jurusan', 'guru', 'siswa']);

        $search = $request->get('search', '');
        $jurusan_id = $request->get('jurusan', '');

        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhereHas('kelas', function ($q2) use ($search) {
                        $q2->where('tingkat', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kelas.jurusan', function ($q2) use ($search) {
                        $q2->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('guru', function ($q2) use ($search) {
                        $q2->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter jurusan
        if (!empty($jurusan_id)) {
            $query->whereHas('kelas', function ($q) use ($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            });
        }

        $allJurusans = Jurusan::all();

        // Pagination
        $rombels = $query->paginate(12)->withQueryString();

        return view('super_admin.manajemen-kelas.index', compact(
            'rombels',
            'allJurusans',
            'search',
            'jurusan_id'
        ));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        $tingkats = [10, 11, 12];

        return view('super_admin.manajemen-kelas.create', compact(
            'jurusans',
            'gurus',
            'tingkats'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer|min:10|max:12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        // Create kelas
        $kelas = Kelas::create([
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
        ]);

        // Create rombel
        Rombel::create([
            'nama' => $request->nama,
            'kelas_id' => $kelas->id,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()
            ->route('super_admin.manajemen-kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rombel = Rombel::with([
            'kelas.jurusan',
            'guru',
            'siswa'
        ])->findOrFail($id);

        return view('super_admin.manajemen-kelas.show', compact('rombel'));
    }

    public function edit($id)
    {
        $rombel = Rombel::with('kelas.jurusan')->findOrFail($id);

        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        $tingkats = [10, 11, 12];

        return view('super_admin.manajemen-kelas.edit', compact(
            'rombel',
            'jurusans',
            'gurus',
            'tingkats'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer|min:10|max:12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        $rombel = Rombel::findOrFail($id);
        $kelas = $rombel->kelas;

        // Update kelas
        $kelas->update([
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
        ]);

        // Update rombel
        $rombel->update([
            'nama' => $request->nama,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()
            ->route('super_admin.manajemen-kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rombel = Rombel::findOrFail($id);

        $rombel->delete();

        return redirect()
            ->route('super_admin.manajemen-kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }

    public function export($id)
    {
        $rombel = Rombel::with([
            'kelas.jurusan',
            'siswa'
        ])->findOrFail($id);

        return Excel::download(
            new KaprogSiswaByRombelExport($rombel),
            'Data Siswa ' . $rombel->nama . '.xlsx'
        );
    }
}