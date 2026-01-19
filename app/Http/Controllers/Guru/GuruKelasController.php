<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;

class GuruKelasController extends Controller
{
    /**
     * Menampilkan daftar kelas yang diampu
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        
        // Ambil semua rombel yang diampu guru
        $rombels = $guru->rombels()
            ->with('kelas', 'jurusan', 'siswa')
            ->get();

        return view('guru.kelas.index', compact('guru', 'rombels'));
    }

    /**
     * Menampilkan detail kelas dan siswa di dalamnya
     */
    public function show($rombelId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        
        // Pastikan guru hanya bisa melihat kelas yang dia ampu
        $rombel = $guru->rombels()
            ->with('kelas', 'jurusan', 'siswa')
            ->findOrFail($rombelId);

        return view('guru.kelas.show', compact('guru', 'rombel'));
    }

    /**
     * Menampilkan mata pelajaran yang diampu di kelas tertentu
     */
    public function mataPelajaran($rombelId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        
        $rombel = $guru->rombels()
            ->with('mataPelajaran')
            ->findOrFail($rombelId);

        return view('guru.kelas.mata-pelajaran', compact('guru', 'rombel'));
    }
}
