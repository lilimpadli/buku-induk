<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WaliKelasController extends Controller
{
    public function index()
    {
        $waliKelas = WaliKelas::with(['user', 'kelas', 'rombel'])
            ->whereHas('user', function($q) {
                $q->where('role', 'walikelas');
            })
            ->latest()
            ->paginate(10);
            
        return view('tu.wali-kelas.index', compact('waliKelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $rombels = Rombel::all();

        return view('tu.wali-kelas.create', compact('kelas', 'rombels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:100|unique:users,nomor_induk',
            'email' => 'nullable|email|unique:users,email',
            'kelas_id' => 'required|exists:kelas,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'nullable|string|size:9',
            'semester' => 'nullable|in:Ganjil,Genap',
            'status' => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        // create or find user by nomor_induk
        $user = User::firstWhere('nomor_induk', $validated['nomor_induk']);
        if (! $user) {
            $user = User::create([
                'name' => $validated['nama'],
                'nomor_induk' => $validated['nomor_induk'],
                'email' => $validated['email'] ?? null,
                'password' => Hash::make(Str::random(12)),
                'role' => 'walikelas',
            ]);
        }

        WaliKelas::create([
            'user_id' => $user->id,
            'kelas_id' => $validated['kelas_id'],
            'rombel_id' => $validated['rombel_id'],
            'tahun_ajaran' => $validated['tahun_ajaran'] ?? null,
            'semester' => $validated['semester'] ?? null,
            'status' => $validated['status'] ?? 'Aktif',
        ]);

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