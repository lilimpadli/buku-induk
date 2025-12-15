<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;
use App\Models\DataSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;

class KelaskaprogController extends Controller
{
    // Tampilkan daftar rombel/kelas untuk kaprog
    public function index()
    {
        $user = Auth::user();
        $guru = $user ? Guru::where('user_id', $user->id)->first() : null;

        // Jika guru (kaprog) punya jurusan, tampilkan rombel untuk jurusan itu saja
        if ($guru && $guru->jurusan_id) {
            $jurusan = Jurusan::find($guru->jurusan_id);

            // Ambil rombel yang kelasnya termasuk dalam jurusan ini
            $rombels = Rombel::with('kelas')
                ->whereHas('kelas', function ($q) use ($guru) {
                    $q->where('jurusan_id', $guru->jurusan_id);
                })
                ->orderBy('nama')
                ->get();

            return view('kaprog.kelas.index', compact('jurusan', 'rombels'));
        }

        // Kalau tidak ada jurusan (admin/umum), tampilkan semua jurusan dan rombel per jurusan
        $jurusans = Jurusan::with(['kelas.rombels'])->orderBy('nama')->get();
        return view('kaprog.kelas.index', compact('jurusans'));
    }

    // Tampilkan detail rombel (siswa yang berada di rombel ini)
    public function show($id)
    {
        $rombel = Rombel::with('kelas.jurusan')->findOrFail($id);

        // Ambil siswa di rombel ini, pastikan rombel->kelas->jurusan sesuai
        $siswa = DataSiswa::with('rombel')
            ->where('rombel_id', $rombel->id)
            ->whereHas('rombel.kelas', function ($q) use ($rombel) {
                $q->where('jurusan_id', $rombel->kelas->jurusan_id);
            })
            ->orderBy('nama_lengkap')
            ->get();

        return view('kaprog.kelas.show', compact('rombel', 'siswa'));
    }
}

