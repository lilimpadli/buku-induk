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
                'siswa'        => redirect()->route('dashboard.siswa'),
                'walikelas'    => redirect()->route('dashboard.walikelas'),
                'kaprog'       => redirect()->route('dashboard.kaprog'),
                'tu'           => redirect()->route('dashboard.tu'),
                'kurikulum'    => redirect()->route('dashboard.kurikulum'),
                'calon_siswa'  => redirect()->route('dashboard.calon'),
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
