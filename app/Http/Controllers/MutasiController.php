<?php

namespace App\Http\Controllers;

use App\Models\Mutasi; // Pastikan Model Mutasi sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $allowedRoles = ['tu', 'tu_kepegawaian'];
            if ($user && in_array(strtolower($user->role), $allowedRoles)) {
                return $next($request);
            }
            abort(403, 'Akses ditolak!');
        });
    }

    public function index()
    {
        // Tambahkan die() ini untuk memastikan controller ini yang sedang diakses
        die('Controller MutasiController sedang diakses!'); 
        
        $mutasis = Mutasi::with('pegawai')->latest()->get(); 
        return view('tu.mutasi.index', compact('mutasis'));
    }

    public function create()
    {
        // Logika untuk menampilkan form tambah mutasi
        return view('tu.mutasi.create'); 
    }

    public function laporan()
    {
        // Logika untuk menampilkan atau generate laporan
        return view('tu.mutasi.laporan');
    }

    public function bulk(Request $request)
    {
        // Ini contoh logika sederhana untuk menerima data
        $siswaIds = $request->input('siswa_ids');
        $kelasId = $request->input('kelas_id');
        
        // Lakukan logika simpan data mutasi ke database di sini
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diproses'
        ]);
    }

    public function upAll(Request $request)
    {
        // Contoh logika dasar
        return response()->json([
            'success' => true,
            'naik_kelas' => 10,
            'lulus' => 5
        ]);
    }
}