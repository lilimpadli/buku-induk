<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSiswa;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;
use App\Models\KenaikanKelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WaliKelasSiswaExport;

class WaliKelasSiswaController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->query('q');
    $jenisKelamin = $request->query('jenis_kelamin');
    
    // CARI LANGSUNG KE TABEL GURUS
    $guru = DB::table('gurus')->where('user_id', $user->id)->first();
    
    if (!$guru) {
        return view('walikelas.siswa.index', [
            'siswa' => collect(),
            'search' => $search,
            'jenisKelamin' => $jenisKelamin
        ]);
    }
    
    // CARI ROMBEL BERDASARKAN guru_id
    $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
    
    if (!$rombel) {
        return view('walikelas.siswa.index', [
            'siswa' => collect(),
            'search' => $search,
            'jenisKelamin' => $jenisKelamin
        ]);
    }
    
    // AMBIL SISWA LANGSUNG DARI rombel_id
    $query = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel'])
        ->where('rombel_id', $rombel->id);
    
    if ($search) {
        $like = '%' . $search . '%';
        $query->where(function($q) use ($like) {
            $q->where('nama_lengkap', 'like', $like)
              ->orWhere('nisn', 'like', $like)
              ->orWhere('nis', 'like', $like);
        });
    }
    
    if ($jenisKelamin && in_array($jenisKelamin, ['Laki-laki', 'Perempuan'])) {
        $query->where('jenis_kelamin', $jenisKelamin);
    }
    
    $siswa = $query->orderBy('nama_lengkap')->paginate(15);
    
    return view('walikelas.siswa.index', compact('siswa', 'search', 'jenisKelamin'));
}

    // Detail siswa
    public function show($id)
    {
        $s = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('walikelas.siswa.show', compact('s'));
    }

public function dashboard()
{
    $user = Auth::user();
    $guru = DB::table('gurus')->where('user_id', $user->id)->first();
    
    if (!$guru) {
        return view('walikelas.dashboard', [
            'total' => 0,
            'byGender' => ['Laki-laki' => 0, 'Perempuan' => 0],
            'recentGrouped' => collect(),
            'kehadiran' => ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0, 'persentase_kehadiran' => 0],
            'rataNilaiPerMapel' => collect(),
            'chartData' => (object) ['labels' => [], 'values' => []]
        ]);
    }
    
    $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
    
    if (!$rombel) {
        return view('walikelas.dashboard', [
            'total' => 0,
            'byGender' => ['Laki-laki' => 0, 'Perempuan' => 0],
            'recentGrouped' => collect(),
            'kehadiran' => ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0, 'persentase_kehadiran' => 0],
            'rataNilaiPerMapel' => collect(),
            'chartData' => (object) ['labels' => [], 'values' => []]
        ]);
    }
    
    $total = DataSiswa::where('rombel_id', $rombel->id)->count();
    
    $byGender = [
        'Laki-laki' => DataSiswa::where('rombel_id', $rombel->id)->where('jenis_kelamin', 'Laki-laki')->count(),
        'Perempuan' => DataSiswa::where('rombel_id', $rombel->id)->where('jenis_kelamin', 'Perempuan')->count()
    ];
    
    $recent = DataSiswa::with('rombel')
        ->where('rombel_id', $rombel->id)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    
    $recentGrouped = $recent->groupBy(function($siswa) {
        return $siswa->rombel ? $siswa->rombel->nama : 'Tidak ada rombel';
    });
    
    // === DATA KEHADIRAN BULAN INI ===
    $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
    $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
    $siswaIds = DataSiswa::where('rombel_id', $rombel->id)->pluck('id');
    
    $absensis = \App\Models\Absensi::whereIn('siswa_id', $siswaIds)
        ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
        ->get();
    
    $kehadiran = [
        'hadir' => $absensis->where('status', 'hadir')->count(),
        'sakit' => $absensis->where('status', 'sakit')->count(),
        'izin' => $absensis->where('status', 'izin')->count(),
        'alpha' => $absensis->where('status', 'alpha')->count(),
    ];
    
    $totalAbsensi = array_sum($kehadiran);
    $kehadiran['persentase_kehadiran'] = $totalAbsensi > 0 ? round(($kehadiran['hadir'] / $totalAbsensi) * 100, 1) : 0;
    
    // === DATA NILAI RATA-RATA PER MAPEL (DENGAN TRY-CATCH) ===
    try {
        // Coba ambil data nilai - coba beberapa kemungkinan nama kolom
        $columnName = 'nama_mapel';
        
        // Cek apakah kolom 'nama' ada
        $columns = DB::getSchemaBuilder()->getColumnListing('mata_pelajarans');
        if (in_array('nama', $columns)) {
            $columnName = 'nama';
        } elseif (in_array('mata_pelajaran', $columns)) {
            $columnName = 'mata_pelajaran';
        } elseif (in_array('nama_mata_pelajaran', $columns)) {
            $columnName = 'nama_mata_pelajaran';
        }
        
        $rataNilaiPerMapel = DB::table('nilai_raports')
            ->join('mata_pelajarans', 'nilai_raports.mapel_id', '=', 'mata_pelajarans.id')
            ->whereIn('nilai_raports.siswa_id', $siswaIds)
            ->select("mata_pelajarans.$columnName as nama_mapel", DB::raw('AVG(nilai_raports.nilai_angka) as rata_rata'))
            ->groupBy("mata_pelajarans.$columnName")
            ->orderBy('rata_rata', 'desc')
            ->limit(6)
            ->get();
        
        $chartData = (object) [
            'labels' => $rataNilaiPerMapel->pluck('nama_mapel')->toArray(),
            'values' => $rataNilaiPerMapel->pluck('rata_rata')->map(function($val) {
                return round($val, 2);
            })->toArray()
        ];
    } catch (\Exception $e) {
        // Jika error, set data kosong
        $rataNilaiPerMapel = collect();
        $chartData = (object) ['labels' => [], 'values' => []];
    }
    
    return view('walikelas.dashboard', compact(
        'total', 'byGender', 'recentGrouped', 'kehadiran', 'rataNilaiPerMapel', 'chartData'
    ));
}

    // Export data siswa ke PDF (untuk wali kelas)
    public function exportPdf($id)
    {
        $s = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);

        $pdf = Pdf::loadView('siswa.pdf', ['siswa' => $s])
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Data Siswa - ' . ($s->nama_lengkap ?? $s->nis) . '.pdf');
    }

    // Export data siswa ke Excel (untuk wali kelas)
    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        
        // Cari guru berdasarkan user_id
        $guru = DB::table('gurus')->where('user_id', $user->id)->first();
        
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }
        
        // Cari rombel berdasarkan guru_id
        $rombel = DB::table('rombels')->where('guru_id', $guru->id)->first();
        
        if (!$rombel) {
            return back()->with('error', 'Rombel tidak ditemukan');
        }
        
        // Ambil semua siswa di rombel ini
        $siswa = DataSiswa::where('rombel_id', $rombel->id)->get();
        
        // Export langsung dengan parameter rombel_id
        return Excel::download(new WaliKelasSiswaExport($rombel->id, $rombel->nama), 'Daftar_Siswa_' . $rombel->nama . '.xlsx');
    }
}