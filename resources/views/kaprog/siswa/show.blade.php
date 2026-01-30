@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<style>
    /* ===================== STYLE DETAIL SISWA ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        background-color: #ffffff;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-body.d-flex {
        padding: 1.25rem;
    }

    /* Section Headers */
    h5.mb-0 {
        font-size: 28px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0 !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-0::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    h6.card-title {
        font-size: 20px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
        display: flex;
        align-items: center;
    }

    h6.card-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    h6.card-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    /* Profile Card Styles */
    .profile-card {
        text-align: center;
    }

    .profile-card img {
        border: 3px solid #e9ecef;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    .table-sm {
        font-size: 14px;
    }

    .table thead th {
        border: none;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 15px 10px;
    }

    .table td, .table th {
        border: none;
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table tbody td:first-child {
        border-radius: 8px 0 0 8px;
        font-weight: 600;
        color: #475569;
        width: 30%;
    }

    .table tbody td:last-child {
        border-radius: 0 8px 8px 0;
    }

    /* Info List Styles */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 12px 15px;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .info-list li .label {
        font-weight: 600;
        color: #475569;
        width: 30%;
    }

    .info-list li .value {
        color: #1E293B;
        width: 70%;
        text-align: right;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        box-shadow: 0 4px 6px rgba(47, 83, 255, 0.25);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 8px rgba(47, 83, 255, 0.35);
    }

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    .btn-block {
        width: 100%;
        justify-content: center;
    }

    /* Form Styles */
    .form-control {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    /* Alert Styles */
    .alert-info {
        background-color: rgba(47, 83, 255, 0.1);
        border-color: rgba(47, 83, 255, 0.2);
        color: var(--primary-color);
        border-radius: 8px;
    }

    /* Tab Styles */
    .nav-tabs {
        border-bottom: none;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        padding: 12px 20px;
        margin-right: 5px;
        color: #64748B;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(47, 83, 255, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: white;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
    }

    .tab-content {
        border-radius: 0 0 16px 16px;
        background-color: white;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
        font-size: 14px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .card-body.d-flex {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start !important;
        }

        h5.mb-0 {
            font-size: 24px;
            margin-bottom: 0.5rem !important;
        }

        h6.card-title {
            font-size: 18px;
        }

        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }

        .table thead th,
        .table td, .table th {
            padding: 8px 10px;
            font-size: 13px;
        }

        .profile-name {
            font-size: 20px;
        }
    }
</style>

<div class="container mt-4">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $siswa->nama_lengkap }}</h5>
                <small class="text-muted">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }}</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('kaprog.raport.siswa') }}?siswa_id={{ $siswa->id }}" class="btn btn-primary btn-sm">Lihat Raport</a>
                <a href="{{ route('kaprog.siswa.export-data-diri', $siswa->id) }}" class="btn btn-success btn-sm" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Export Data Diri
                </a>
                <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    @if($siswa->foto)
                        <img src="/storage/{{ $siswa->foto }}" class="img-fluid rounded-circle mb-3" alt="Foto Siswa" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; font-size: 60px; font-weight: bold;">
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="card-title mb-1">{{ $siswa->nama_lengkap }}</h5>
                    <p class="text-muted mb-0">NIS: {{ $siswa->nis }}</p>
                    <p class="text-muted">NISN: {{ $siswa->nisn }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="infoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">Data Pribadi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="academic-tab" data-bs-toggle="tab" href="#academic" role="tab" aria-controls="academic" aria-selected="false">Data Akademik</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="infoTabsContent">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <ul class="info-list">
                                <li>
                                    <span class="label">Jenis Kelamin</span>
                                    <span class="value">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Tempat Lahir</span>
                                    <span class="value">{{ $siswa->tempat_lahir ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Tanggal Lahir</span>
                                    <span class="value">{{ $siswa->tanggal_lahir ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Agama</span>
                                    <span class="value">{{ $siswa->agama ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Alamat</span>
                                    <span class="value">{{ $siswa->alamat ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">No. HP</span>
                                    <span class="value">{{ $siswa->no_hp ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                            <ul class="info-list">
                                <li>
                                    <span class="label">Sekolah Asal</span>
                                    <span class="value">{{ $siswa->sekolah_asal ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Tanggal Diterima</span>
                                    <span class="value">{{ $siswa->tanggal_diterima ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Rombel</span>
                                    <span class="value">{{ optional($siswa->rombel)->nama ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="label">Kelas</span>
                                    <span class="value">{{ optional($siswa->rombel->kelas)->tingkat ?? '-' }} - {{ optional($siswa->rombel->kelas->jurusan)->nama ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-tabs" id="familyTabs" role="tablist">
                @if($siswa->ayah)
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="father-tab" data-bs-toggle="tab" href="#father" role="tab" aria-controls="father" aria-selected="true">Data Ayah</a>
                </li>
                @endif
                @if($siswa->ibu)
                <li class="nav-item {{ !$siswa->ayah ? 'active' : '' }}" role="presentation">
                    <a class="nav-link {{ !$siswa->ayah ? 'active' : '' }}" id="mother-tab" data-bs-toggle="tab" href="#mother" role="tab" aria-controls="mother" aria-selected="{{ !$siswa->ayah ? 'true' : 'false' }}">Data Ibu</a>
                </li>
                @endif
                @if($siswa->wali)
                <li class="nav-item {{ !$siswa->ayah && !$siswa->ibu ? 'active' : '' }}" role="presentation">
                    <a class="nav-link {{ !$siswa->ayah && !$siswa->ibu ? 'active' : '' }}" id="guardian-tab" data-bs-toggle="tab" href="#guardian" role="tab" aria-controls="guardian" aria-selected="{{ !$siswa->ayah && !$siswa->ibu ? 'true' : 'false' }}">Data Wali</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="familyTabsContent">
                @if($siswa->ayah)
                <div class="tab-pane fade show active" id="father" role="tabpanel" aria-labelledby="father-tab">
                    <ul class="info-list">
                        <li>
                            <span class="label">Nama</span>
                            <span class="value">{{ $siswa->ayah->nama ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Pekerjaan</span>
                            <span class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Alamat</span>
                            <span class="value">{{ $siswa->ayah->alamat ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">No. HP</span>
                            <span class="value">{{ $siswa->ayah->no_hp ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
                @endif
                @if($siswa->ibu)
                <div class="tab-pane fade {{ !$siswa->ayah ? 'show active' : '' }}" id="mother" role="tabpanel" aria-labelledby="mother-tab">
                    <ul class="info-list">
                        <li>
                            <span class="label">Nama</span>
                            <span class="value">{{ $siswa->ibu->nama ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Pekerjaan</span>
                            <span class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Alamat</span>
                            <span class="value">{{ $siswa->ibu->alamat ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">No. HP</span>
                            <span class="value">{{ $siswa->ibu->no_hp ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
                @endif
                @if($siswa->wali)
                <div class="tab-pane fade {{ !$siswa->ayah && !$siswa->ibu ? 'show active' : '' }}" id="guardian" role="tabpanel" aria-labelledby="guardian-tab">
                    <ul class="info-list">
                        <li>
                            <span class="label">Nama</span>
                            <span class="value">{{ $siswa->wali->nama ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Pekerjaan</span>
                            <span class="value">{{ $siswa->wali->pekerjaan ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">Alamat</span>
                            <span class="value">{{ $siswa->wali->alamat ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="label">No. HP</span>
                            <span class="value">{{ $siswa->wali->no_hp ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($siswa->catatan_wali_kelas)
    <div class="card mt-3">
        <div class="card-body">
            <h6 class="card-title"><i class="fas fa-sticky-note"></i> Catatan Wali Kelas</h6>
            <div class="alert alert-info">
                <pre style="white-space: pre-wrap; font-family: inherit;">{{ $siswa->catatan_wali_kelas }}</pre>
            </div>
        </div>
    </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h6 class="card-title"><i class="fas fa-edit"></i> Lapor / Catatan</h6>
            <form id="lapor-form" method="POST" action="{{ route('kaprog.kelas.siswa.lapor', $siswa->id) }}">
                @csrf
                <div class="mb-3">
                    <textarea name="lapor" id="lapor-text" class="form-control" rows="4" placeholder="Tulis laporan atau catatan..."></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Kirim Lapor</button>
            </form>
        </div>
    </div>
</div>
@endsection