<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    public function index()
    {
        // Menampilkan daftar penugasan dengan relasi ke Guru dan Mapel
        $penugasans = Penugasan::with(['guru', 'mapel'])->latest()->get();
        return view('tu_kepegawaian.penugasan.index', compact('penugasans'));
    }

    public function create()
    {
        // Mengirim data untuk pilihan di dropdown
        $gurus = Guru::all();
        $mapels = Mapel::all();
        return view('tu_kepegawaian.penugasan.create', compact('gurus', 'mapels'));
    }

   public function store(Request $request)
{
    $request->validate([
        'guru_id' => 'required',
        'kategori' => 'required',
        'tahun_ajaran' => 'required',
    ]);

    // Ambil semua data
    $data = $request->all();

    // Jika kategorinya bukan 'Mengajar', kosongkan mapel_id
    if ($request->kategori !== 'Mengajar') {
        $data['mapel_id'] = null;
    }

    Penugasan::create($data);

    return redirect()->route('tu_kepegawaian.penugasan.index')
                     ->with('success', 'Penugasan berhasil disimpan!');
}
    
}