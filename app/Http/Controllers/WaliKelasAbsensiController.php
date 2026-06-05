<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DataSiswa;
use App\Models\Absensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;      // <-- TAMBAHKAN INI
use App\Exports\AbsensiRekapExport;  

class WaliKelasAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = DB::table('gurus')->where('user_id', $user->id)->first();
        
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
        
        if (!$rombel) {
            return back()->with('error', 'Rombel tidak ditemukan');
        }
        
        $siswa = DataSiswa::where('rombel_id', $rombel->id)->orderBy('nama_lengkap')->get();
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();
        
        $existingAbsensi = Absensi::where('tanggal', $tanggal)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id');
        
        return view('walikelas.absensi.index', compact('siswa', 'tanggal', 'existingAbsensi'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'in:hadir,sakit,izin,alpha',
        ]);
        
        $user = Auth::user();
        $tanggal = $request->tanggal;
        
        foreach ($request->absensi as $siswaId => $status) {
            Absensi::updateOrCreate(
                ['siswa_id' => $siswaId, 'tanggal' => $tanggal],
                ['status' => $status, 'input_by' => $user->id]
            );
        }
        
        return redirect()->route('walikelas.absensi.index', ['tanggal' => $tanggal])
            ->with('success', 'Absensi berhasil disimpan');
    }
    
    public function rekap(Request $request)
    {
        $user = Auth::user();
        $guru = DB::table('gurus')->where('user_id', $user->id)->first();
        
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
        
        if (!$rombel) {
            return back()->with('error', 'Rombel tidak ditemukan');
        }
        
        $siswa = DataSiswa::where('rombel_id', $rombel->id)->orderBy('nama_lengkap')->get();
        $bulan = $request->bulan ?? Carbon::now()->month;
        $semester = $request->semester ?? (Carbon::now()->month <= 6 ? 1 : 2);
        
        if ($semester == 1) {
            $startDate = Carbon::create(Carbon::now()->year, 7, 1);
            $endDate = Carbon::create(Carbon::now()->year, 12, 31);
        } else {
            $startDate = Carbon::create(Carbon::now()->year, 1, 1);
            $endDate = Carbon::create(Carbon::now()->year, 6, 30);
        }
        
        if ($bulan && $bulan != 'all') {
            $startDate = Carbon::create(null, (int)$bulan, 1)->startOfMonth();
            $endDate = Carbon::create(null, (int)$bulan, 1)->endOfMonth();
        }
        
        $rekap = [];
        foreach ($siswa as $s) {
            $absensi = Absensi::where('siswa_id', $s->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
            
            $hadir = $absensi->where('status', 'hadir')->count();
            $sakit = $absensi->where('status', 'sakit')->count();
            $izin = $absensi->where('status', 'izin')->count();
            $alpha = $absensi->where('status', 'alpha')->count();
            $total = $hadir + $sakit + $izin + $alpha;
            $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
            
            $rekap[] = (object) [
                'siswa' => $s,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase,
            ];
        }
        
        return view('walikelas.absensi.rekap', compact('rekap', 'bulan', 'semester'));
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        $guru = DB::table('gurus')->where('user_id', $user->id)->first();
        
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
        
        if (!$rombel) {
            return back()->with('error', 'Rombel tidak ditemukan');
        }
        
        $siswa = DataSiswa::where('rombel_id', $rombel->id)->orderBy('nama_lengkap')->get();
        
        // Filter berdasarkan request
        $bulan = $request->bulan;
        $semester = $request->semester ?? 1;
        
        if ($semester == 1) {
            $startDate = Carbon::create(Carbon::now()->year, 7, 1);
            $endDate = Carbon::create(Carbon::now()->year, 12, 31);
        } else {
            $startDate = Carbon::create(Carbon::now()->year, 1, 1);
            $endDate = Carbon::create(Carbon::now()->year, 6, 30);
        }
        
        if ($bulan && $bulan != 'all') {
            $startDate = Carbon::create(null, (int)$bulan, 1)->startOfMonth();
            $endDate = Carbon::create(null, (int)$bulan, 1)->endOfMonth();
        }
        
        // Kumpulkan data rekap
        $rekapData = [];
        foreach ($siswa as $s) {
            $absensi = Absensi::where('siswa_id', $s->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
            
            $hadir = $absensi->where('status', 'hadir')->count();
            $sakit = $absensi->where('status', 'sakit')->count();
            $izin = $absensi->where('status', 'izin')->count();
            $alpha = $absensi->where('status', 'alpha')->count();
            $total = $hadir + $sakit + $izin + $alpha;
            $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
            
            $rekapData[] = [
                'Nama Siswa' => $s->nama_lengkap,
                'NIS' => $s->nis ?? '-',
                'Hadir' => $hadir,
                'Sakit' => $sakit,
                'Izin' => $izin,
                'Alpha' => $alpha,
                'Total' => $total,
                'Persentase' => $persentase . '%',
            ];
        }
        
        // Export ke Excel
        return Excel::download(new AbsensiRekapExport($rekapData, $rombel->nama, $bulan, $semester), 'Rekap_Absensi_' . $rombel->nama . '.xlsx');
    }
}