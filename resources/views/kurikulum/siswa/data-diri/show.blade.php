@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-edit:hover {
        background: #D97706;
        transform: translateY(-2px);
        color: white;
    }

    .btn-cetak {
        background: #13B497;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-cetak:hover {
        background: #0e9a7e;
        transform: translateY(-2px);
        color: white;
    }

    .btn-rapor {
        background: #667eea;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-rapor:hover {
        background: #5a67d8;
        transform: translateY(-2px);
        color: white;
    }

    .info-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .info-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .info-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .info-card .card-body {
        padding: 1.2rem 1.5rem;
    }

    .info-row {
        display: flex;
        padding: 0.5rem 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 180px;
        font-weight: 600;
        color: #64748B;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .info-value {
        flex: 1;
        color: #1E293B;
        font-size: 0.9rem;
    }

    .badge-gender {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-gender.laki {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-gender.perempuan {
        background: #FCE7F3;
        color: #DB2777;
    }

    .nav-tabs {
        border-bottom: 2px solid #E2E8F0;
        margin-bottom: 1.5rem;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #64748B;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        font-size: 0.85rem;
        border-bottom: 2px solid transparent;
        transition: var(--transition);
        border-radius: 0;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        border-bottom: 2px solid #667eea;
        background: transparent;
        font-weight: 600;
    }

    .tab-content {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .info-row {
            flex-direction: column;
            padding: 0.6rem 0;
        }

        .info-label {
            width: 100%;
            font-size: 0.75rem;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.85rem;
        }

        .info-card .card-header {
            padding: 0.6rem 1rem;
        }

        .info-card .card-body {
            padding: 0.8rem 1rem;
        }

        .btn-back,
        .btn-edit,
        .btn-cetak,
        .btn-rapor {
            width: 100%;
            justify-content: center;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }

        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .nav-tabs .nav-link {
            white-space: nowrap;
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-user me-2"></i> Detail Siswa</h3>
                <div class="text-muted">{{ $siswa->nama_lengkap }}</div>
            </div>
            <div class="d-flex gap-2 mt-2 mt-sm-0 flex-wrap">
                <a href="{{ route('kurikulum.siswa.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('kurikulum.siswa.data-diri.edit', $siswa->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('kurikulum.siswa.cetak', $siswa->id) }}" class="btn-cetak" target="_blank">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="{{ route('kurikulum.rapor.show', $siswa->id) }}" class="btn-rapor">
                    <i class="fas fa-file-alt"></i> Raport
                </a>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs" id="siswaTabs">
        <li class="nav-item">
            <button class="nav-link active" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa">
                <i class="fas fa-user me-1"></i> Data Siswa
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab" data-bs-target="#data-orangtua">
                <i class="fas fa-users me-1"></i> Data Orang Tua
            </button>
        </li>
    </ul>

    <div class="tab-content" id="siswaTabsContent">
        <div class="tab-pane fade show active" id="data-siswa">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-id-card"></i> Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">NIS</div>
                        <div class="info-value"><strong>{{ $siswa->nis }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NISN</div>
                        <div class="info-value">{{ $siswa->nisn ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $siswa->nama_lengkap }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tempat, Tanggal Lahir</div>
                        <div class="info-value">
                            {{ $siswa->tempat_lahir ?? '-' }}
                            @if($siswa->tanggal_lahir)
                                , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            <span class="badge-gender {{ strtolower($siswa->jenis_kelamin) == 'laki-laki' ? 'laki' : 'perempuan' }}">
                                {{ $siswa->jenis_kelamin ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Agama</div>
                        <div class="info-value">{{ $siswa->agama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kelas / Rombel</div>
                        <div class="info-value">{{ optional($siswa->rombel)->nama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $siswa->alamat ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">No HP</div>
                        <div class="info-value">{{ $siswa->no_hp ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tanggal Diterima</div>
                        <div class="info-value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="data-orangtua">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-tie"></i> Data Ayah</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $siswa->ayah->nama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Pekerjaan</div>
                        <div class="info-value">{{ $siswa->ayah->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $siswa->ayah->telepon ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $siswa->ayah->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-tie"></i> Data Ibu</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $siswa->ibu->nama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Pekerjaan</div>
                        <div class="info-value">{{ $siswa->ibu->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $siswa->ibu->telepon ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $siswa->ibu->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-tie"></i> Data Wali</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $siswa->wali->nama ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Pekerjaan</div>
                        <div class="info-value">{{ $siswa->wali->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $siswa->wali->telepon ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $siswa->wali->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection