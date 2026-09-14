<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiGuruExport;
use App\Models\Guru;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CetakAbsensiController extends Controller
{
    // ==========================================================
    // ABSENSI GURU
    // ==========================================================

    public function absensiKegiatan()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        $tahun = date('Y');
        $hari = strtoupper(now()->translatedFormat('l'));
        $tanggal = strtoupper(now()->translatedFormat('d F Y'));

        return view('tu_kepegawaian.guru.absensi_kegiatan', compact('gurus', 'tahun', 'hari', 'tanggal'));
    }

    public function absensiHarian(Request $request)
    {
        $status = $request->query('status', 'PPPK');

        $gurus = Guru::where('status_kepegawaian', $status)
                    ->orderBy('nama', 'asc')
                    ->get();

        $listStatus = Guru::select('status_kepegawaian')
                        ->whereNotNull('status_kepegawaian')
                        ->distinct()
                        ->get()
                        ->pluck('status_kepegawaian');

        $bulan = strtoupper(now()->translatedFormat('F'));
        $tahun = date('Y');

        return view('tu_kepegawaian.guru.absensi_harian', compact('gurus', 'bulan', 'tahun', 'status', 'listStatus'));
    }

    // ==========================================================
    // ABSENSI PEGAWAI (TU)
    // ==========================================================

    public function absensiHarianPegawai(Request $request)
    {
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        $bulan = strtoupper(now()->translatedFormat('F'));
        $tahun = date('Y');

        return view('tu_kepegawaian.tu.absensi_harian_pegawai', compact('pegawais', 'bulan', 'tahun'));
    }

    public function absensiKegiatanPegawai()
    {
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        $tahun = date('Y');
        $hari = strtoupper(now()->translatedFormat('l'));
        $tanggal = strtoupper(now()->translatedFormat('d F Y'));

        return view('tu_kepegawaian.tu.absensi_kegiatan_pegawai', compact('pegawais', 'tahun', 'hari', 'tanggal'));
    }

    // ==========================================================
    // ABSENSI KEGIATAN GABUNGAN (GURU + PEGAWAI)
    // - Kirim $gurus & $pegawais TERPISAH (untuk section di view)
    // - TIDAK ada deduplikasi (ELIN HERLINA Guru & Pegawai tetap muncul)
    // ==========================================================
    public function absensiKegiatanSemua()
    {
        // ═══ Helper: hapus gelar dari nama ═══
        $bersihkanNama = function ($nama) {
            if (empty($nama)) return '-';

            $gelar = [
                'S.Pd.I', 'S.Pd', 'M.Pd', 'S.Kom', 'M.Kom', 'S.E', 'M.M',
                'S.Sos', 'S.Ag', 'S.H', 'M.H', 'A.Md', 'A.Ma', 'S.Si', 'M.Si',
                'S.T', 'M.T', 'S.KM', 'M.KM', 'S.Farm', 'Apt', 'S.Psi', 'M.Psi',
                'S.IP', 'S.AN', 'S.Kep', 'Ns', 'S.Tr', 'M.Tr',
            ];

            $nama = ' ' . $nama . ' ';

            foreach ($gelar as $g) {
                $nama = preg_replace('/[,\s]+' . preg_quote($g, '/') . '\.?\s*/i', ' ', $nama);
            }

            $nama = preg_replace('/^(Drs\.|Dra\.|Ir\.|Hj\.|H\.|Prof\.)\s+/i', '', $nama);
            $nama = trim(preg_replace('/\s+/', ' ', $nama));

            return $nama ?: '-';
        };

        // ═══ Ambil data TERPISAH ═══
        $gurus    = Guru::orderBy('nama', 'asc')->get();
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        // ═══ Bersihkan nama (TANPA deduplikasi) ═══
        foreach ($gurus as $g) {
            $g->nama_bersih = $bersihkanNama($g->nama);
        }

        foreach ($pegawais as $p) {
            $p->nama_bersih = $bersihkanNama($p->nama);
        }

        // ═══ Opsional: $semuaOrang untuk keperluan lain ═══
        $semuaOrang = collect();

        foreach ($gurus as $g) {
            $semuaOrang->push([
                'nama' => $g->nama_bersih,
                'nip'  => $g->nip ?? '-',
                'tipe' => 'Guru',
            ]);
        }

        foreach ($pegawais as $p) {
            $semuaOrang->push([
                'nama' => $p->nama_bersih,
                'nip'  => $p->nip ?? '-',
                'tipe' => 'Pegawai',
            ]);
        }

        $semuaOrang = $semuaOrang->sortBy('nama')->values();

        // ═══ Tanggal ═══
        $tahun   = date('Y');
        $hari    = strtoupper(now()->translatedFormat('l'));
        $tanggal = strtoupper(now()->translatedFormat('d F Y'));

        // ═══ KIRIM SEMUA KE VIEW ═══
        return view('tu_kepegawaian.absensi_kegiatan_semua', compact(
            'gurus',
            'pegawais',
            'semuaOrang',
            'tahun',
            'hari',
            'tanggal'
        ));
    }

    // ==========================================================
    // HALAMAN TEST CETAK ABSENSI (LAMA)
    // ==========================================================
    public function index(Request $request)
    {
        $gurus = Guru::orderBy('nama')->get();

        $tahun = date('Y');
        $bulan = date('n');
        $tanggalObj = Carbon::createFromDate($tahun, $bulan, 1);
        $hari = strtoupper($tanggalObj->translatedFormat('l'));
        $tanggal = strtoupper($tanggalObj->translatedFormat('j F Y'));

        return view('tu_kepegawaian.guru.cetak_absensi', compact('gurus', 'tahun', 'hari', 'tanggal'));
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'guru_ids' => 'required|array|min:1',
            'guru_ids.*' => 'exists:gurus,id'
        ]);

        $gurus = Guru::whereIn('id', $request->guru_ids)
                     ->orderBy('nama', 'asc')
                     ->get();

        if ($gurus->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data guru yang dipilih.');
        }

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;
        $tanggalObj = Carbon::createFromDate($tahun, $bulan, 1);
        $hari = strtoupper($tanggalObj->translatedFormat('l'));
        $tanggal = strtoupper($tanggalObj->translatedFormat('j F Y'));

        return view('tu_kepegawaian.guru.cetak_absensi', compact('gurus', 'tahun', 'hari', 'tanggal'));
    }

    // ==========================================================
    // EXPORT EXCEL
    // ==========================================================
    public function exportExcel(Request $request)
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        $tahun = date('Y');
        $bulan = date('n');
        $tanggalObj = Carbon::createFromDate($tahun, $bulan, 1);
        $hari = strtoupper($tanggalObj->translatedFormat('l'));
        $tanggal = strtoupper($tanggalObj->translatedFormat('j F Y'));

        return Excel::download(new AbsensiGuruExport($gurus, $hari, $tanggal), 'absensi-kegiatan.xlsx');
    }

    public function previewExcel(Request $request)
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        $tahun = date('Y');
        $bulan = date('n');
        $tanggalObj = Carbon::createFromDate($tahun, $bulan, 1);
        $hari = strtoupper($tanggalObj->translatedFormat('l'));
        $tanggal = strtoupper($tanggalObj->translatedFormat('j F Y'));

        return view('tu_kepegawaian.guru.excel_absensi', [
            'gurus' => $gurus,
            'hari' => $hari,
            'tanggal' => $tanggal,
            'preview' => true,
        ]);
    }
}