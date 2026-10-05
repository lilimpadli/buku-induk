@extends('layouts.app')

@section('title', 'Surat DO - ' . ($mutasi->siswa->nama_lengkap ?? 'Siswa'))

@section('content')

<style>
    @page { size: A4 portrait; margin: 2.5cm; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-size: 12pt; color: #000; line-height: 1.5; background: #e5e7eb; }

    .print-wrapper {
        font-family: 'Times New Roman', Times, serif;
        width: 210mm;
        min-height: 297mm;
        margin: 20px auto;
        padding: 2.5cm;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .controls { display: flex; gap: 10px; margin-bottom: 15px; }
    .controls .btn {
        border-radius: 6px; font-weight: 600; padding: 8px 16px; font-size: 10pt;
        display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; border: 1px solid #d1d5db;
        font-family: system-ui, sans-serif; cursor: pointer;
    }
    .btn-secondary { background: white; color: #111827; }
    .btn-primary { background: #2563eb; color: white; border-color: #2563eb; }

    /* KOP — pakai TABLE */
    .kop-surat {
        width: 100%;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    /* JUDUL */
    .title-surat {
        text-align: center;
        font-size: 13pt;
        font-weight: bold;
        margin-bottom: 4px;
        text-decoration: underline;
        letter-spacing: 1px;
    }
    .nomor-surat {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 40px;
    }

    /* ISI */
    .content { font-size: 12pt; line-height: 1.6; }
    .content p { text-align: justify; margin-bottom: 15px; }
    .content p.indent { text-indent: 40px; }

    .info-table {
        width: 100%;
        margin: 15px 0 25px 40px;
        border-collapse: collapse;
    }
    .info-table td {
        vertical-align: top;
        padding: 4px 0;
        line-height: 1.5;
    }
    .info-table .label { width: 180px; }
    .info-table .colon { width: 20px; text-align: center; }

    /* TTD */
    .signature {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin-top: 40px;
    }
    .signature-box {
        text-align: center;
        width: 280px;
    }
    .signature .place-date {
        text-align: left;
        font-size: 12pt;
        margin-bottom: 2px;
    }
    .signature .jabatan {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 0;
    }
    .signature .nama-ttd {
        font-weight: bold;
        text-decoration: underline;
        font-size: 12pt;
    }
    .signature .nip {
        font-size: 11pt;
        margin-top: 2px;
    }

    @media print {
        *, *::before, *::after { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        nav, header, footer, .navbar, .sidebar, .main-header, .main-sidebar, .controls,
        .mobile-header, .user-info, .dropdown-menu, .logout-section, .sidebar-header, .sidebar-content { display: none !important; }
        body { background: white !important; }
        .print-wrapper { width: 100% !important; margin: 0 !important; padding: 2.5cm !important; box-shadow: none !important; min-height: auto !important; }
        main { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
    }
</style>

<div class="print-wrapper">
    <div>
        <!-- TOMBOL -->
        <div class="controls">
            <a href="{{ route('tu.mutasi.laporan-surat') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <!-- KOP SURAT (pakai TABLE) -->
        <table class="kop-surat">
            <tr>
                <td style="width: 120px; vertical-align: middle; padding-right: 12px;">
                    <img src="{{ asset('images/Logo Jawa Barat.jpeg') }}" alt="Logo"
                         style="width: 100px; height: auto; display: block;"
                         onerror="this.style.display='none'">
                </td>
                <td style="vertical-align: middle; text-align: center; line-height: 1.15;">
                    <div style="font-size: 14pt; font-weight: normal;">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div style="font-size: 14pt; font-weight: normal;">DINAS PENDIDIKAN</div>
                    <div style="font-size: 14pt; font-weight: normal;">CABANG DINAS PENDIDIKAN WILAYAH XIII</div>
                    <div style="font-size: 16pt; font-weight: bold; letter-spacing: 1px;">SMK NEGERI 1 KAWALI</div>
                    <div style="font-size: 9pt; margin-top: 2px;">Jalan Talagasari No. 35 Telp. (0265) 791727 Fax. (0265) 2797676</div>
                    <div style="font-size: 9pt;">e-mail : smkn1kawali@gmail.com</div>
                    <div style="font-size: 9pt;">Kawali - 46253</div>
                </td>
            </tr>
        </table>

        <!-- JUDUL -->
        <div class="title-surat">SURAT KETERANGAN KELUAR SISWA</div>
        <div class="nomor-surat">No. {{ $mutasi->no_sk_keluar ?? '-' }}</div>

        <!-- ISI -->
        <div class="content">
            <p>Yang bertandatangan di bawah ini, Kepala SMK Negeri 1 Kawali Kabupaten Ciamis menerangkan dengan sesungguhnya bahwa :</p>

            <table class="info-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td>{{ strtoupper($mutasi->siswa->nama_lengkap ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="colon">:</td>
<td>{{ $mutasi->siswa->jenisKelamin->nama ?? $mutasi->siswa->jenis_kelamin ?? '-' }}</td>                </tr>
                <tr>
                    <td class="label">Agama</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->agama->nama ?? $mutasi->siswa->agama_lainnya ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">NIS/NISN</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->nis ?? '-' }} / {{ $mutasi->siswa->nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="colon">:</td>
                    <td>
                        {{ $mutasi->siswa->tempat_lahir ?? '-' }},
                        {{ $mutasi->siswa->tanggal_lahir ? \Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="colon">:</td>
                    <td>{{ $rombel->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Program Keahlian</td>
                    <td class="colon">:</td>
                    <td>{{ $rombel->kelas->jurusan->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Orang Tua / Wali</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->nama_ayah ?? $mutasi->siswa->nama_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Keluar / Pindah</td>
                    <td class="colon">:</td>
                    <td>Keluar (DO)</td>
                </tr>
                <tr>
                    <td class="label">Alasan</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->keterangan ?? '-' }}</td>
                </tr>
            </table>

            <p>Demikian Surat Keterangan ini dibuat, untuk digunakan sebagaimana mestinya.</p>
        </div>
    </div>

        <!-- TTD -->
    <div>
        <div class="signature">
            <div class="signature-box">
                <div class="place-date">Kawali, {{ $mutasi->tanggal_mutasi ? \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->translatedFormat('d F Y') : '-' }}</div>
                <div class="jabatan">KEPALA SMK NEGERI 1 KAWALI</div>
                <div style="height: 80px;"></div>
                <div class="nama-ttd">DEDE FAJRIADI, S.Pd., M.Pd.</div>
                <div class="nip">Penata Tk.1/ III.d</div>
            </div>
        </div>
    </div>
</div>

@endsection