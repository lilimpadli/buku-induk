<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index()
    {
        $waliKelas = WaliKelas::with(['user', 'kelas', 'rombel'])
            ->latest()
            ->paginate(10);
            
        return view('tu.wali-kelas.index', compact('waliKelas'));
    }

    public function create()
    {
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.create', compact('users', 'kelas', 'rombels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        WaliKelas::create($validated);
        
        return redirect()->route('tu.wali-kelas')->with('success', 'Wali kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $waliKelas = WaliKelas::with(['user', 'kelas', 'rombel'])->findOrFail($id);
        return view('tu.wali-kelas.show', compact('waliKelas'));
    }
    
    public function edit($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.edit', compact('waliKelas', 'users', 'kelas', 'rombels'));
    }
    
    public function update(Request $request, $id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $waliKelas->update($validated);
        
        return redirect()->route('tu.wali-kelas')->with('success', 'Data wali kelas berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $waliKelas->delete();
        
        return redirect()->route('tu.wali-kelas')->with('success', 'Data wali kelas berhasil dihapus');
    }
}