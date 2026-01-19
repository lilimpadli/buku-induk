<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data guru berdasarkan user login
        $guru = Guru::where('user_id', $user->id)->first();

        // Kalau data guru belum ada, arahkan ke profil
        if (!$guru) {
            return redirect()
                ->route('guru.profile')
                ->with('error', 'Silakan lengkapi profil guru terlebih dahulu.');
        }

        // SEMENTARA cuma kirim data guru & user
        return view('guru.dashboard', compact('guru', 'user'));
    }
}
