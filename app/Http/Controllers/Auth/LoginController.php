<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_induk' => 'required',
            'password' => 'required'
        ], [
            'nomor_induk.required' => 'Nomor induk (NIS/NIP) wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        $credentials = [
            'nomor_induk' => $request->nomor_induk,
            'password'    => $request->password,
        ];

        // Login
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Redirect sesuai role
           return match ($user->role) {
    'siswa'        => redirect()->route('siswa.dashboard'),
    'guru'         => redirect()->route('guru.dashboard'),
    'walikelas'    => redirect()->route('walikelas.dashboard'),
    'kaprog'       => redirect()->route('kaprog.dashboard'),
    'tu'           => redirect()->route('tu.dashboard'),
    'kurikulum'    => redirect()->route('kurikulum.dashboard'),
    'calon_siswa'  => redirect()->route('calon.dashboard'),
    default        => redirect()->route('dashboard'),
};

        }

        // Jika gagal login
        return back()->withErrors([
            'nomor_induk' => 'Nomor induk atau password salah!'
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
