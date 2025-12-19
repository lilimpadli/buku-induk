<?php

namespace App\Http\Controllers\Kaprog;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KaprogDashboardController extends Controller
{
    /**
     * Display the Kaprog dashboard.
     */
    public function index()
    {
        // Basic stats for the dashboard. Keep it simple and non-destructive.
        $totalSiswa = DataSiswa::count();
        $totalKelas = Kelas::count();

        // Graduation rate is application-specific; default to 95 if unknown.
        $graduationRate = 95;

        // Recent siswa list for quick access
        $recentSiswa = DataSiswa::latest()->limit(6)->get();

        return view('kaprog.dashboard', compact('totalSiswa', 'totalKelas', 'graduationRate', 'recentSiswa'));
    }

    /**
     * Show detail for a siswa (simple fallback view).
     */
    public function detail($id)
    {
        $siswa = DataSiswa::find($id);

        if (! $siswa) {
            return redirect()->route('kaprog.dashboard')
                ->with('error', 'Siswa tidak ditemukan');
        }

        return view('kaprog.siswa.detail', compact('siswa'));
    }
}
