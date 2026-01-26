<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\MutasiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MutasiSiswa::with('siswa')
            ->where('status', '!=', 'lulus')  // Exclude alumni (lulus)
            ->latest('tanggal_mutasi');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $mutasis = $query->paginate(15);
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
        ];

        return view('kurikulum.mutasi.index', compact('mutasis', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::whereDoesntHave('mutasiTerakhir', function ($q) {
            $q->whereIn('status', ['lulus', 'pindah', 'do', 'meninggal']);
        })
            ->orderBy('nama_lengkap')
            ->get();

        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('kurikulum.mutasi.create', compact('siswas', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:data_siswa,id',
            'status' => 'required|in:pindah,do,meninggal,naik_kelas,lulus',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string',
            'no_sk_keluar' => 'nullable|string',
            'tanggal_sk_keluar' => 'nullable|date',
            'tujuan_pindah' => 'nullable|string',
        ]);

        MutasiSiswa::create($validated);

        return redirect()->route('kurikulum.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MutasiSiswa $mutasi)
    {
        $mutasi->load('siswa');
        return view('kurikulum.mutasi.show', compact('mutasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MutasiSiswa $mutasi)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('kurikulum.mutasi.edit', compact('mutasi', 'siswas', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MutasiSiswa $mutasi)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:data_siswa,id',
            'status' => 'required|in:pindah,do,meninggal,naik_kelas,lulus',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'alasan_pindah' => 'nullable|string',
            'no_sk_keluar' => 'nullable|string',
            'tanggal_sk_keluar' => 'nullable|date',
            'tujuan_pindah' => 'nullable|string',
        ]);

        $mutasi->update($validated);

        return redirect()->route('kurikulum.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MutasiSiswa $mutasi)
    {
        $mutasi->delete();

        return redirect()->route('kurikulum.mutasi.index')
            ->with('success', 'Data mutasi siswa berhasil dihapus!');
    }

    /**
     * Laporan mutasi siswa
     */
    public function laporan(Request $request)
    {
        $query = MutasiSiswa::with('siswa')->latest('tanggal_mutasi');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mutasi', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_mutasi', '<=', $request->tanggal_sampai);
        }

        $mutasis = $query->get();
        $statuses = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return view('kurikulum.mutasi.laporan', compact('mutasis', 'statuses'));
    }
}
