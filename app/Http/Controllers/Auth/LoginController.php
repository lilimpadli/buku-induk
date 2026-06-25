<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Validasi input
        $request->validate([
            'nomor_induk' => 'required',
            'password' => 'required'
        ], [
            'nomor_induk.required' => 'Nomor induk (NIS/NIP) wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // Cari user berdasarkan nomor_induk (case-insensitive)
        $user = \App\Models\User::whereRaw('LOWER(nomor_induk) = ?', [strtolower($request->nomor_induk)])
            ->first();

        // Validasi user dan password
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            // Login successful
            Auth::login($user, $request->boolean('remember'));
            return $this->redirectByRole($user);
        }

        // Jika gagal login
        return back()->withErrors([
            'nomor_induk' => 'Nomor induk atau password salah!'
        ])->onlyInput('nomor_induk');
    }

    /**
     * Redirect based on role
     */
    private function redirectByRole($user)
    {
        return match ($this->normalizeRole($user->role)) {
            'siswa'        => redirect()->route('siswa.dashboard'),
            'guru'         => redirect()->route('guru.dashboard'),
            'walikelas'    => redirect()->route('walikelas.dashboard'),
            'kaprog'       => redirect()->route('kaprog.dashboard'),
            'tu'           => redirect()->route('tu.dashboard'),
            'tu_kepegawaian' => redirect()->route('tu_kepegawaian.dashboard'),
            'kurikulum'    => redirect()->route('kurikulum.dashboard'),
            'super_admin'  => redirect()->route('super_admin.dashboard'),
            'calon_siswa'  => redirect()->route('calon.dashboard'),
            default        => redirect()->route('dashboard'),
        };
    }

    private function normalizeRole($role)
    {
        return Str::of($role)
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->__toString();
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
