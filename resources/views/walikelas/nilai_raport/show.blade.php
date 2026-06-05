@extends('layouts.app')

@section('title', 'Review Rapor - ' . ($siswa->nama_lengkap ?? ''))

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.85rem;
    }

    /* Tombol di header */
    .page-header .btn,
    .page-header a {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 100 !important;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .info-card:hover {
        box-shadow: var(--card-hover-shadow);
    }

    .info-card .card-header {
        background: white;
        padding: 0.875rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        color: #1e293b;
    }

    .info-card .card-header i {
        color: #667eea;
        margin-right: 8px;
    }

    .info-card .card-body {
        padding: 1.25rem;
    }

    .info-row {
        display: flex;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8fafc;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 140px;
        font-weight: 500;
        color: #64748b;
        font-size: 13px;
    }

    .info-value {
        flex: 1;
        color: #1e293b;
        font-size: 13px;
        font-weight: 500;
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
    }

    .table-nilai {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-nilai th,
    .table-nilai td {
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
        vertical-align: middle;
    }

    .table-nilai th {
        background: #f8fafc;
        font-weight: 600;
        font-size: 12px;
        color: #475569;
        text-align: center;
    }

    .table-nilai td {
        color: #334155;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        pointer-events: auto !important;
        cursor: pointer !important;
        text-decoration: none;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
    }

    .btn-gradient:hover {
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1.5px solid #ffffff;
        color: white;
    }

    .btn-outline-gradient:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .btn-warning-gradient {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        color: white;
    }

    .btn-warning-gradient:hover {
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        color: white;
    }

    /* Badges */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-warning { background: #fed7aa; color: #9b2c1d; }
    .badge-info { background: #e0f2fe; color: #0369a1; }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.4s ease forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header { padding: 1.25rem; }
        .page-header h3 { font-size: 1.25rem; }
        .info-row { flex-direction: column; }
        .info-label { width: 100%; margin-bottom: 4px; }
        .btn { padding: 0.4rem 0.8rem; font-size: 12px; }
        .table-nilai th, .table-nilai td { padding: 0.5rem; font-size: 11px; }
    }
</style>

<div class="container-fluid py-3">
    <!-- Header -->
    <div class="page-header fade-in">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="fas fa-file-alt me-2"></i> Review Rapor
                </h3>
                <div class="text-muted">
                    <i class="fas fa-user-graduate me-1"></i> {{ $siswa->nama_lengkap ?? '' }}
                </div>
            </div>
            <div class="mt-2 mt-md-0 d-flex gap-2 flex-wrap">
                <a href="{{ route('walikelas.nilai_raport.list', $siswa->id) }}" class="btn btn-outline-gradient">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('walikelas.nilai_raport.edit', ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun' => $tahun]) }}" class="btn btn-warning-gradient">
                    <i class="fas fa-edit me-2"></i> Edit Rapor
                </a>
                <a href="{{ route('walikelas.nilai_raport.pdf', [$siswa->id, $semester, str_replace('/', '-', $tahun)]) }}" class="btn btn-gradient" target="_blank">
                    <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Identitas Siswa -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-id-card"></i> Identitas Siswa
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user me-2 text-primary"></i> Nama Peserta Didik</div>
                        <div class="info-value"><strong>{{ strtoupper($siswa->nama_lengkap ?? '-') }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-qrcode me-2 text-primary"></i> NISN</div>
                        <div class="info-value">{{ $siswa->nisn ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-graduation-cap me-2 text-primary"></i> Kelas / Rombel</div>
                        <div class="info-value">{{ $rombelRaport->nama ?? $siswa->rombel->nama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> Semester / Tahun</div>
                        <div class="info-value">{{ $semester ?? '-' }} / {{ $tahun ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelompok A - Mata Pelajaran Umum -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-book-open"></i> A. Kelompok Mata Pelajaran Umum
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-nilai">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Mata Pelajaran</th>
                            <th width="15%">Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $noA = 1; @endphp
                        @foreach($nilaiRaports as $n)
                            @if($n->mapel && ($n->mapel->kelompok == 'A' || $n->mapel->kelompok == 'Umum'))
                            <tr>
                                <td class="text-center">{{ $noA++ }}</td>
                                <td>{{ $n->mapel->nama }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $n->nilai_akhir ?? '-' }}</span>
                                </td>
                                <td>{{ $n->deskripsi ?? '-' }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kelompok B - Mata Pelajaran Kejuruan -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-laptop-code"></i> B. Kelompok Mata Pelajaran Kejuruan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-nilai">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Mata Pelajaran</th>
                            <th width="15%">Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $noB = 1; @endphp
                        @foreach($nilaiRaports as $n)
                            @if($n->mapel && ($n->mapel->kelompok == 'B' || $n->mapel->kelompok == 'Kejuruan'))
                            <tr>
                                <td class="text-center">{{ $noB++ }}</td>
                                <td>{{ $n->mapel->nama }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $n->nilai_akhir ?? '-' }}</span>
                                </td>
                                <td>{{ $n->deskripsi ?? '-' }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ekstrakurikuler -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-futbol"></i> C. Kegiatan Ekstrakurikuler
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-nilai">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Ekstrakurikuler</th>
                            <th width="15%">Predikat</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekstra as $i => $e)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $e->nama_ekstra ?? '-' }}</td>
                            <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                            <td>{{ $e->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Tidak ada data ekstrakurikuler
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ketidakhadiran -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-calendar-times"></i> D. Ketidakhadiran
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-thermometer-half text-warning me-2"></i> Sakit</div>
                        <div class="info-value">{{ $kehadiran->sakit ?? 0 }} hari</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-file-alt text-info me-2"></i> Izin</div>
                        <div class="info-value">{{ $kehadiran->izin ?? 0 }} hari</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-times-circle text-danger me-2"></i> Tanpa Keterangan</div>
                        <div class="info-value">{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kenaikan Kelas -->
    @if(isset($semester) && strtolower($semester) !== 'ganjil')
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-chart-line"></i> E. Kenaikan Kelas
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-flag-checkered me-2 text-primary"></i> Status</div>
                        <div class="info-value">
                            @php
                                $status = $kenaikan->status ?? 'Belum Ditentukan';
                                $badgeClass = '';
                                if ($status == 'Naik Kelas') $badgeClass = 'badge-success';
                                elseif ($status == 'Lulus') $badgeClass = 'badge-primary';
                                else $badgeClass = 'badge-warning';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                        </div>
                    </div>
                </div>
                @if(isset($kenaikan->rombelTujuan) && $kenaikan->rombelTujuan)
                <div class="col-md-4">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-graduation-cap me-2 text-primary"></i> Kelas Tujuan</div>
                        <div class="info-value">{{ $kenaikan->rombelTujuan->nama }}</div>
                    </div>
                </div>
                @endif
                <div class="col-md-12">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-pencil-alt me-2 text-primary"></i> Catatan</div>
                        <div class="info-value">{{ $kenaikan->catatan ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informasi Rapor -->
    <div class="info-card fade-in">
        <div class="card-header">
            <i class="fas fa-info-circle"></i> F. Informasi Raport
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-chalkboard-user me-2 text-primary"></i> Wali Kelas</div>
                        <div class="info-value">{{ $info->wali_kelas ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card me-2 text-primary"></i> NIP Wali Kelas</div>
                        <div class="info-value">{{ $info->nip_wali ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-building me-2 text-primary"></i> Kepala Sekolah</div>
                        <div class="info-value">{{ $info->kepala_sekolah ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card me-2 text-primary"></i> NIP Kepala Sekolah</div>
                        <div class="info-value">{{ $info->nip_kepsek ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> Tanggal Rapor</div>
                        <div class="info-value">{{ $info->tanggal_rapor ?? date('d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix semua tombol
        const allBtns = document.querySelectorAll('.btn, .btn-gradient, .btn-outline-gradient, .btn-warning-gradient, a');
        allBtns.forEach(btn => {
            btn.style.pointerEvents = 'auto';
            btn.style.cursor = 'pointer';
            btn.style.position = 'relative';
            btn.style.zIndex = '100';
        });
    });
</script>
@endsection