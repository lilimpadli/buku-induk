<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('auth.siswa-reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('nomor_induk', $request->nomor_induk)
                    ->where('role', 'siswa')
                    ->first();

        if (!$user) {
            return back()->withErrors(['nomor_induk' => 'Nomor induk tidak ditemukan']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}