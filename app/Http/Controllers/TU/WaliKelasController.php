<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index()
    {
        $waliKelas = User::where('role', 'walikelas')->paginate(10);
        return view('tu.wali-kelas.index', compact('waliKelas'));
    }

    public function create()
    {
        return view('tu.wali-kelas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'walikelas';
        
        User::create($validated);
        
        return redirect()->route('tu.wali-kelas')->with('success', 'Wali kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $waliKelas = User::findOrFail($id);
        return view('tu.wali-kelas.show', compact('waliKelas'));
    }
}