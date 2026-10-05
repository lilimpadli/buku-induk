<?php

namespace App\Http\Controllers\TU;

use App\Models\DataSiswa;
use App\Models\MutasiSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClaverExport;

class ClaverController extends Controller
{
    /**
     * Menampilkan form cetak Claver
     */
    public function index()
    {
        $tahunMasuk = DataSiswa::select('tanggal_diterima')
            ->whereNotNull('tanggal_diterima')
            ->distinct()
            ->orderBy('tanggal_diterima', 'desc')
            ->pluck('tanggal_diterima')
            ->map(function($date) {
                return $date ? $date->format('Y') : null;
            })
            ->filter()
            ->unique()
            ->values();

        $hurufAwal = DataSiswa::selectRaw('UPPER(LEFT(nama_lengkap, 1)) as huruf')
            ->whereNotNull('nama_lengkap')
            ->where('nama_lengkap', '!=', '')
            ->distinct()
            ->orderBy('huruf')
            ->pluck('huruf')
            ->filter()
            ->values();

        return view('tu.siswa.cetak-claver', compact('tahunMasuk', 'hurufAwal'));
    }

    /**
     * Preview data Claver
     */
    public function preview(Request $request)
    {
        $groupedData = $this->getData($request);
        
        return view('tu.siswa.claver-preview', [
            'data' => $groupedData,
            'filter' => $request->all(),
        ]);
    }

    /**
     * Generate data untuk Claver
     * 🔥 FIX 504: eager load mutasi biar gak N+1 query
     */
    public function getData(Request $request)
    {
        $query = DataSiswa::with([
            'rombel',
            'rombel.kelas',
            'mutasis' => function ($q) {
                $q->with(['rombelAsal.kelas', 'rombelTujuan.kelas'])
                  ->orderBy('tanggal_mutasi');
            }
        ])
        ->whereNotNull('nis')
        ->where('nis', '!=', '');

        // Filter berdasarkan huruf awal nama
        if ($request->filled('huruf')) {
            $query->whereRaw('UPPER(LEFT(nama_lengkap, 1)) = ?', [strtoupper($request->huruf)]);
        }

        // Filter berdasarkan tahun masuk
        if ($request->filled('tahun_masuk')) {
            $query->whereYear('tanggal_diterima', $request->tahun_masuk);
        }

        // Filter berdasarkan tingkat kelas
        if ($request->filled('tingkat')) {
            $query->whereHas('rombel.kelas', function($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        $siswas = $query->orderBy('nama_lengkap')->get();

        // Format data
        $data = [];
        $currentHuruf = '';
        $no = 1;

        foreach ($siswas as $siswa) {
            $huruf = strtoupper(substr($siswa->nama_lengkap, 0, 1));
            
            if ($huruf !== $currentHuruf) {
                $no = 1;
                $currentHuruf = $huruf;
            }

            // 🔥 FIX: pakai parse dari collection, gak query DB lagi
            $mutasi = $this->parseMutasiFromCollection($siswa->mutasis);

            $data[] = [
                'no' => $no++,
                'huruf' => $huruf,
                'nama_siswa' => strtoupper($siswa->nama_lengkap),
                'nomor_induk' => $siswa->nis,
                'tanggal_masuk' => $siswa->tanggal_diterima ? $this->formatTanggal($siswa->tanggal_diterima) : '-',
                'naik_kelas_1' => $mutasi['naik_xi'] ?? '',
                'naik_kelas_2' => $mutasi['naik_xii'] ?? '',
                'naik_kelas_3' => $mutasi['lulus'] ?? '',
                'keterangan' => $siswa->keterangan ?? $mutasi['keterangan'] ?? '',
                'tingkat' => $siswa->rombel->kelas->tingkat ?? 'X',
            ];
        }

        return collect($data)->groupBy('huruf')->sortKeys();
    }

    /**
     * 🔥 BARU: Parse mutasi dari collection (gak query DB)
     */
    private function parseMutasiFromCollection($mutasiList)
    {
        $result = [
            'naik_xi' => null,
            'naik_xii' => null,
            'lulus' => null,
            'keterangan' => null,
        ];

        if (!$mutasiList || $mutasiList->isEmpty()) {
            return $result;
        }

        foreach ($mutasiList as $mutasi) {
            $tanggal = $mutasi->tanggal_mutasi ? $this->formatTanggal($mutasi->tanggal_mutasi) : null;

            if ($mutasi->status == 'naik_kelas') {
                $asal = $mutasi->rombelAsal;
                if ($asal && $asal->kelas) {
                    $tingkat = $asal->kelas->tingkat;
                    
                    if (in_array($tingkat, ['X', '10'])) {
                        $result['naik_xi'] = $tanggal;
                    } elseif (in_array($tingkat, ['XI', '11'])) {
                        $result['naik_xii'] = $tanggal;
                    }
                }
            } elseif (in_array($mutasi->status, ['lulus', 'pindah', 'do', 'meninggal'])) {
                $result['lulus'] = $tanggal;
                $result['keterangan'] = $mutasi->keterangan ?? ucfirst($mutasi->status);
            }
        }

        return $result;
    }

    /**
     * Format tanggal ke format Indonesia
     */
    private function formatTanggal($date)
    {
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $dateObj = \Carbon\Carbon::parse($date);
        $bulanIndo = $bulan[$dateObj->format('F')];
        
        return $dateObj->format('d ') . $bulanIndo . $dateObj->format(' Y');
    }

    /**
     * Cetak PDF Claver
     * 🔥 FIX 504: naikkan memory & time limit + optimasi DomPDF
     */
    public function cetakPdf(Request $request)
    {
        // Naikkan batas memory & waktu khusus endpoint ini
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $groupedData = $this->getData($request);
        
        $pdf = Pdf::loadView('tu.siswa.claver-pdf', [
            'data' => $groupedData,
            'tahunAjaran' => $request->tahun_ajaran ?? '2024/2025',
        ]);

        $pdf->setPaper('A4', 'landscape');
        $pdf->setOptions([
            'defaultFont' => 'Times New Roman',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'dpi' => 96,
        ]);
        
        return $pdf->download('claver-buku-induk.pdf');
    }

    /**
     * Export Excel Claver
     */
    public function exportExcel(Request $request)
    {
        $groupedData = $this->getData($request);
        
        return Excel::download(new ClaverExport($groupedData), 'claver-buku-induk.xlsx');
    }
}