<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar guru dengan filter lengkap
     */
    public function index(Request $request)
    {
        $query = Guru::query();

        // Logika Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jurusan')) $query->where('jurusan_id', $request->jurusan);
        if ($request->filled('role')) $query->where('role', $request->role);
        if ($request->filled('status_kepegawaian')) $query->where('status_kepegawaian', $request->status_kepegawaian);
        if ($request->filled('jenis_kelamin')) $query->where('jenis_kelamin', $request->jenis_kelamin);
        if ($request->filled('pendidikan')) $query->where('pendidikan', $request->pendidikan);

        // Ambil data untuk rekap
        $isFiltered = $request->anyFilled(['search', 'jurusan', 'role', 'status_kepegawaian', 'jenis_kelamin', 'pendidikan']);
        $dataUntukRekap = $query->get();
        
        $rekap = [
            'Total' => $dataUntukRekap->count(),
            'L' => $dataUntukRekap->where('jenis_kelamin', 'L')->count(),
            'P' => $dataUntukRekap->where('jenis_kelamin', 'P')->count(),
            'D4' => $dataUntukRekap->where('pendidikan', 'D4')->count(),
            'S1' => $dataUntukRekap->where('pendidikan', 'S1')->count(),
            'S2' => $dataUntukRekap->where('pendidikan', 'S2')->count(),
            'Sertif_Sudah' => $dataUntukRekap->where('sertifikasi', 'Sudah')->count(),
        ];

        $gurus = $query->paginate(10)->withQueryString();
        $jurusans = Jurusan::all();

        return view('tu_kepegawaian.guru.index', compact('gurus', 'jurusans', 'rekap', 'isFiltered'));
    } 

    /**
     * TU menampilkan profil spesifik guru
     */
    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return view('tu_kepegawaian.guru.show', compact('guru'));
    }

    /**
     * TU melakukan update data guru
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        // Tambahkan logika update Anda di sini
        $guru->update($request->all());
        return back()->with('success', 'Data berhasil diperbarui');
    }
}