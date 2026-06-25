@extends('layouts.app')

@section('title', 'Review Rapor')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background-color: #f7fafc; font-family: 'Inter', sans-serif; }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .btn-pdf {
        background: var(--success-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(19, 180, 151, 0.5);
        color: white;
    }

    .table-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
        background: white;
    }

    .table-card .card-header {
        background: #f8fafc;
        padding: 0.8rem 1.5rem;
        border-bottom: 2px solid #667eea;
        font-weight: 700;
        font-size: 0.95rem;
        color: #1E293B;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-card .card-header i {
        color: #667eea;
    }

    .table-card .card-body {
        padding: 0;
    }

    .table {
        margin-bottom: 0;
    }

    .table-bordered {
        border: 1px solid #E2E8F0;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #E2E8F0;
        padding: 10px 15px;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.7rem 1rem;
    }

    .table tbody td {
        color: #334155;
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-semester {
        background: var(--primary-gradient);
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-status.naik { background: var(--success-gradient); color: white; }
    .badge-status.tidak { background: linear-gradient(135deg, #F093FB 0%, #F5576C 100%); color: white; }
    .badge-status.lulus { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .badge-status.belum { background: #E2E8F0; color: #64748B; }

    .info-row {
        display: flex;
        padding: 6px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 150px;
        font-weight: 600;
        color: #475569;
        flex-shrink: 0;
        font-size: 0.8rem;
    }

    .info-value {
        flex: 1;
        color: #1E293B;
        font-size: 0.85rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }

        .btn-gradient, .btn-outline-gradient, .btn-pdf {
            width: 100%;
            justify-content: center;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 12px;
        }

        .info-row {
            flex-direction: column;
            padding: 8px 0;
        }

        .info-label {
            width: 100%;
            font-size: 0.7rem;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.8rem;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 6px 8px;
            font-size: 0.7rem;
        }

        .table-card .card-header {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-file-alt me-2"></i> Review Rapor</h3>
                <div class="text-muted">{{ $siswa->nama_lengkap }} - Semester {{ $semester }} - {{ $tahun }}</div>
            </div>
            <div class="d-flex gap-2 mt-2 mt-sm-0 flex-wrap">
                <a href="{{ route('kurikulum.rapor.show', $siswa->id) }}" class="btn-outline-gradient">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('kurikulum.rapor.cetak', [$siswa->id, $semester, str_replace('/', '-', $tahun)]) }}" 
                   class="btn-pdf" target="_blank">
                    <i class="fas fa-print"></i> Cetak PDF
                </a>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-id-card"></i> Identitas Peserta Didik
        </div>
        <div class="card-body">
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Nama</div>
                            <div class="info-value"><strong>{{ $siswa->nama_lengkap }}</strong></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">NISN</div>
                            <div class="info-value">{{ $siswa->nisn }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Kelas</div>
                            <div class="info-value">{{ $rombelRaport->nama ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Semester</div>
                            <div class="info-value"><span class="badge-semester">{{ $semester }}</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Tahun</div>
                            <div class="info-value">{{ $tahun }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Sekolah</div>
                            <div class="info-value">SMK NEGERI 1 KAWALI</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-book"></i> A. Kelompok Mata Pelajaran Umum
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Mata Pelajaran</th>
                            <th width="15%">Nilai</th>
                            <th width="40%">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $groupA = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A'); @endphp
                        @if($groupA->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
                            </tr>
                        @else
                            @foreach($groupA as $n)
                                <tr>
                                    <td class="text-center">{{ $n->mapel->urutan }}</td>
                                    <td>{{ $n->mapel->nama }}</td>
                                    <td class="text-center"><span class="badge-semester">{{ $n->nilai_akhir }}</span></td>
                                    <td>{{ $n->deskripsi }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-laptop-code"></i> B. Kelompok Mata Pelajaran Kejuruan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Mata Pelajaran</th>
                            <th width="15%">Nilai</th>
                            <th width="40%">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $groupB = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B'); @endphp
                        @if($groupB->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
                            </tr>
                        @else
                            @foreach($groupB as $n)
                                <tr>
                                    <td class="text-center">{{ $n->mapel->urutan }}</td>
                                    <td>{{ $n->mapel->nama }}</td>
                                    <td class="text-center"><span class="badge-semester">{{ $n->nilai_akhir }}</span></td>
                                    <td>{{ $n->deskripsi }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-futbol"></i> C. Ekstrakurikuler
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Nama Ekstrakurikuler</th>
                            <th width="20%">Predikat</th>
                            <th width="35%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekstra as $i => $e)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $e->nama_ekstra }}</td>
                                <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                                <td>{{ $e->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-calendar-check"></i> D. Ketidakhadiran
        </div>
        <div class="card-body">
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Sakit</div>
                            <div class="info-value"><strong>{{ $kehadiran->sakit ?? 0 }}</strong> hari</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Izin</div>
                            <div class="info-value"><strong>{{ $kehadiran->izin ?? 0 }}</strong> hari</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Tanpa Keterangan</div>
                            <div class="info-value"><strong>{{ $kehadiran->tanpa_keterangan ?? 0 }}</strong> hari</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(strtolower($semester) !== 'ganjil')
    <div class="table-card">
        <div class="card-header">
            <i class="fas fa-arrow-up"></i> E. Kenaikan Kelas
        </div>
        <div class="card-body">
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @php
                                    $status = $kenaikan->status ?? 'Belum Ditentukan';
                                    $statusClass = match(strtolower($status)) {
                                        'naik kelas' => 'naik',
                                        'tidak naik' => 'tidak',
                                        'lulus' => 'lulus',
                                        default => 'belum'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">{{ $status }}</span>
                            </div>
                        </div>
                    </div>
                    @if(isset($kenaikan->rombelTujuan))
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Ke Kelas</div>
                            <div class="info-value">{{ $kenaikan->rombelTujuan->nama }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Catatan</div>
                            <div class="info-value">{{ $kenaikan->catatan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection