<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class GuruSiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa yang diampu guru
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        
        // Ambil semua siswa dari rombel yang diampu guru
        $rombels = $guru->rombels()->pluck('id');
        
        $siswas = Siswa::whereIn('rombel_id', $rombels)
            ->with('user', 'rombel.kelas', 'rombel.jurusan')
            ->paginate(15);

        return view('guru.siswa.index', compact('guru', 'siswas'));
    }

    /**
     * Menampilkan detail siswa
     */
    public function show($siswaId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        
        // Pastikan guru hanya bisa melihat siswa yang ada di kelasnya
        $rombels = $guru->rombels()->pluck('id');
        
        $siswa = Siswa::whereIn('rombel_id', $rombels)
            ->with('user', 'rombel', 'rombel.kelas', 'rombel.jurusan')
            ->findOrFail($siswaId);

        return view('guru.siswa.show', compact('guru', 'siswa'));
    }
}
