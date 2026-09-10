@extends('layouts.app')

@section('title', 'Preview Claver')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;
    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;
    --info:#3B82F6;
    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E5E7EB;
    --text:#111827;
    --text-light:#6B7280;
    --shadow-sm:0 2px 8px rgba(15,23,42,.05);
    --shadow-md:0 10px 25px rgba(15,23,42,.08);
    --shadow-lg:0 18px 35px rgba(15,23,42,.12);
    --radius:20px;
    --transition:all .25s ease;
}

body{
    background:linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= GLASS CARD ================= */
.glass-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:24px;
    box-shadow:var(--shadow-md);
    margin-bottom:24px;
    overflow:hidden;
}

.card-header-modern{
    padding:18px 24px;
    border-bottom:1px solid #eef2ff;
    background:#f8faff;
}

.card-title-modern{
    margin:0;
    font-size:18px;
    font-weight:700;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:12px;
}

.letter-badge {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 18px;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
}

.count-badge {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
}

/* ================= TABLE ================= */
.table-responsive{
    overflow-x:auto;
}

.table-modern{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

.table-modern thead th{
    padding:14px 16px;
    font-size:13px;
    font-weight:700;
    color:#64748B;
    text-transform:uppercase;
    letter-spacing:.4px;
    border:1px solid #e5e7eb;
    background:#f8faff;
    vertical-align:middle;
    text-align:center;
}

.table-modern thead tr:first-child th {
    background: #eef2ff;
    color: var(--primary);
}

.table-modern tbody td{
    padding:14px 16px;
    border:1px solid #e5e7eb;
    vertical-align:middle;
    font-size:13px;
    text-align:center;
}

.table-modern tbody td.text-left{
    text-align:left;
}

.table-modern tbody tr:hover{
    background:#f8faff;
}

/* Warna Sel Sesuai Gambar Referensi */
.cell-masuk{
    background-color:#FEF9C3; /* Kuning */
    font-weight:600;
    color:#854D0E;
}
.cell-naik-1{
    background-color:#DCFCE7; /* Hijau */
    font-weight:600;
    color:#166534;
}
.cell-naik-2{
    background-color:#DBEAFE; /* Biru */
    font-weight:600;
    color:#1E40AF;
}
.cell-naik-3{
    background-color:#F3E8FF; /* Ungu */
    font-weight:600;
    color:#6B21A8;
}

/* ================= BUTTON ================= */
.btn-modern{
    border:1px solid rgba(148,163,184,.18);
    border-radius:14px;
    padding:12px 20px;
    font-weight:700;
    color:var(--text);
    background:#ffffff;
    box-shadow:var(--shadow-sm);
    transition:transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    white-space:nowrap;
    font-size:14px;
}

.btn-modern:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-md);
    background:#f8fafc;
}

.btn-primary-modern{ background:#ffffff; color:var(--danger); border-color:rgba(239,68,68,.15); }
.btn-success-modern{ background:#ffffff; color:var(--success); border-color:rgba(16,185,129,.15); }
.btn-outline-modern{ background:#ffffff; color:var(--primary); border:1px solid rgba(148,163,184,.25); }
.btn-outline-modern:hover{ background:var(--primary); color:white; border-color:var(--primary); }

/* ================= ALERT ================= */
.alert-modern{
    border:none;
    border-radius:18px;
    padding:18px 22px;
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
    box-shadow:var(--shadow-sm);
}
.alert-warning-modern{
    background:#FFF7ED;
    color:#EA580C;
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 style="font-weight:800; margin:0; display:flex; align-items:center; gap:12px; font-size:24px;">
            <i class="fas fa-clipboard-list" style="color:var(--primary);"></i> 
            Preview Buku Induk (Claver)
        </h2>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('tu.siswa.cetak-claver.index') }}" class="btn-modern btn-outline-modern">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.siswa.cetak-claver.pdf', request()->all()) }}" class="btn-modern btn-primary-modern" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
            <a href="{{ route('tu.siswa.cetak-claver.excel', request()->all()) }}" class="btn-modern btn-success-modern" target="_blank">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    @if($data->isEmpty())
        <div class="alert-modern alert-warning-modern">
            <i class="fas fa-exclamation-triangle" style="font-size:20px;"></i>
            Tidak ada data yang sesuai dengan filter yang dipilih.
        </div>
    @else
        @foreach($data as $huruf => $siswas)
            <div class="glass-card mb-4">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <div class="letter-badge">{{ $huruf }}</div>
                        Daftar Siswa Huruf {{ $huruf }}
                        <span class="count-badge ms-2">{{ count($siswas) }} Siswa</span>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:5%;">NO</th>
                                <th rowspan="2" style="width:25%;">NAMA SISWA</th>
                                <th rowspan="2" style="width:15%;">NOMOR INDUK SISWA</th>
                                <th colspan="4">TANGGAL</th>
                                <th rowspan="2" style="width:10%;">KET</th>
                            </tr>
                            <tr>
                                <th style="width:12.5%;">MULAI MASUK</th>
                                <th style="width:12.5%;">NAIK KELAS 1</th>
                                <th style="width:12.5%;">NAIK KELAS 2</th>
                                <th style="width:12.5%;">NAIK KELAS 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa['no'] }}</td>
                                    <td class="text-left" style="font-weight:600; color:var(--text);">{{ $siswa['nama_siswa'] }}</td>
                                    <td>{{ $siswa['nomor_induk'] }}</td>
                                    <td class="cell-masuk">{{ $siswa['tanggal_masuk'] }}</td>
                                    <td class="cell-naik-1">{{ $siswa['naik_kelas_1'] }}</td>
                                    <td class="cell-naik-2">{{ $siswa['naik_kelas_2'] }}</td>
                                    <td class="cell-naik-3">{{ $siswa['naik_kelas_3'] }}</td>
                                    <td>{{ $siswa['keterangan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection