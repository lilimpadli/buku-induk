<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TugasGuruController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'guru_id' => 'required',
        'mapel_id' => 'required',
        'kelas_id' => 'required|array', // Supaya bisa pilih banyak kelas sekaligus
    ]);

    foreach ($request->kelas_id as $kelas) {
        TugasGuru::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $kelas,
            'tahun_ajaran' => '2025/2026'
        ]);
    }

    return back()->with('success', 'Tugas berhasil diberikan!');
}
}
