<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataSiswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\NilaiRaport;

class BukuIndukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DataSiswa::with([
            'rombel.kelas.jurusan', 
            'user', 
            'jenisKelamin', 
            'agama'
        ]);

        // Filter jurusan
        if ($request->filled('jurusan_id')) {
            $query->whereHas('rombel.kelas.jurusan', function($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $jk = $request->jenis_kelamin;
            $query->whereHas('jenisKelamin', function($q) use ($jk) {
                $q->where('nama', 'like', "%{$jk}%");
            });
        }

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswas = $query->orderBy('nama_lengkap')->paginate(15)->withQueryString();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('kurikulum.buku-induk.index', compact('siswas', 'jurusans'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = DataSiswa::with([
            'rombel.kelas.jurusan',
            'user',
            'jenisKelamin',
            'agama',
            'ayah',
            'ibu',
            'wali',
            'nilaiRaports' => function($q) {
                $q->with('mapel')
                  ->orderBy('tahun_ajaran')
                  ->orderBy('semester');
            }
        ])->findOrFail($id);

        return view('kurikulum.buku-induk.show', compact('siswa'));
    }

    /**
     * Print the specified resource.
     */
    public function cetak($id)
    {
        $siswa = DataSiswa::with([
            'rombel.kelas.jurusan',
            'user',
            'jenisKelamin',
            'agama',
            'ayah',
            'ibu',
            'wali',
            'nilaiRaports' => function($q) {
                $q->with('mapel')
                  ->orderBy('tahun_ajaran')
                  ->orderBy('semester');
            }
        ])->findOrFail($id);

        return view('kurikulum.buku-induk.cetak', compact('siswa'));
    }
} 