@extends('layouts.app')

@section('title', 'Detail Alumni')

@section('content')
<style>
    /* ===================== STYLE DETAIL ALUMNI ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
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
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: clamp(16px, 3vw, 18px);
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
    }

    .card-title::before {
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

    /* Heading Styles */
    h5.mb-3 {
        font-size: clamp(14px, 3vw, 16px);
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-3::before {
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

    /* Photo Styles */
    .photo-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .photo-container:hover {
        box-shadow: var(--hover-shadow);
    }

    .photo-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .photo-placeholder {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        text-align: center;
        border-radius: 16px;
    }

    .photo-placeholder i {
        font-size: clamp(3rem, 8vw, 4rem);
        opacity: 0.5;
    }

    .photo-placeholder p {
        font-size: clamp(12px, 3vw, 14px);
        margin-top: 1rem;
    }

    /* Button Styles */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: clamp(12px, 2.5vw, 14px);
        white-space: nowrap;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
        color: white;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        color: white;
    }

    .btn-info {
        background-color: var(--info-color);
        border: none;
        color: white;
    }

    .btn-info:hover {
        background-color: #2563EB;
        color: white;
    }

    /* Row Styles */
    .data-row {
        margin-bottom: 1rem;
    }

    .data-label {
        font-weight: 600;
        color: #64748B;
        font-size: clamp(11px, 2.3vw, 13px);
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .data-value {
        color: #334155;
        font-size: clamp(13px, 2.8vw, 15px);
        word-wrap: break-word;
    }

    /* Section Divider */
    hr {
        border: none;
        border-top: 2px solid #E2E8F0;
        margin: 1.5rem 0;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 12px;
        font-size: clamp(11px, 2.3vw, 12px);
        font-weight: 600;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .badge.bg-success {
        background: var(--success-color) !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-buttons .btn {
            width: 100%;
            justify-content: center;
            padding: 0.6rem 1rem;
        }

        .data-row {
            margin-bottom: 0.75rem;
        }

        .data-label {
            margin-bottom: 0.2rem;
        }

        hr {
            margin: 1rem 0;
        }

        h5.mb-3 {
            margin-bottom: 0.75rem !important;
            padding-left: 12px;
        }

        h5.mb-3::before {
            width: 3px;
        }

        /* Photo at top on mobile */
        .col-md-4 {
            order: -1;
        }

        .photo-container {
            margin-bottom: 1rem;
        }

        .photo-container img {
            height: auto !important;
            max-height: 300px;
        }

        .photo-placeholder {
            min-height: 250px;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .action-buttons .btn {
            padding: 0.5rem 1rem;
            font-size: 13px;
        }

        .photo-container img {
            height: 350px !important;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .container {
            max-width: 1140px;
            margin: 0 auto;
        }

        .card-body {
            padding: 1.75rem;
        }

        .photo-container img {
            height: 400px !important;
        }
    }

    /* Large Desktop */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
    }

    /* Extra Large Screens */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }
    }

    /* Landscape on Mobile */
    @media (max-width: 767px) and (orientation: landscape) {
        .photo-container {
            margin-bottom: 0.75rem;
        }

        .photo-container img {
            max-height: 250px;
        }

        .photo-placeholder {
            min-height: 200px;
        }

        .card-body {
            padding: 0.75rem;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background-color: white;
        }

        .action-buttons,
        .btn {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .photo-container {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container mt-4">
    <div class="action-buttons">
        <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn btn-primary btn-sm" target="_blank">
            <i class="fas fa-book"></i> Buku Induk
        </a>
        <a href="{{ route('tu.alumni.raport.list', $siswa->id) }}" class="btn btn-info btn-sm">
            <i class="fas fa-file-alt"></i> Raport
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Data Pribadi -->
                    <h5 class="mb-3">Data Pribadi</h5>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">NIS:</p>
                                <p class="data-value">{{ $siswa->nis }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">NISN:</p>
                                <p class="data-value">{{ $siswa->nisn ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Nama Lengkap:</p>
                                <p class="data-value">{{ $siswa->nama_lengkap }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Jenis Kelamin:</p>
                                <p class="data-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Agama:</p>
                                <p class="data-value">{{ $siswa->agama ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">No. HP:</p>
                                <p class="data-value">{{ $siswa->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="data-row">
                                <p class="data-label">Tempat, Tanggal Lahir:</p>
                                <p class="data-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="data-row">
                                <p class="data-label">Alamat:</p>
                                <p class="data-value">{{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sekolah -->
                    <hr>
                    <h5 class="mb-3">Data Sekolah</h5>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Status Kelulusan:</p>
                                <p class="data-value"><span class="badge bg-success">LULUS</span></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Rombel Terakhir:</p>
                                <p class="data-value">{{ optional($siswa->rombel)->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Tingkat Kelas:</p>
                                <p class="data-value">{{ optional($siswa->rombel->kelas)->tingkat ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="data-row">
                                <p class="data-label">Jurusan:</p>
                                <p class="data-value">{{ optional($siswa->rombel->kelas->jurusan)->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    @if($siswa->ayah || $siswa->ibu || $siswa->wali)
                        <hr>
                        <h5 class="mb-3">Data Orang Tua / Wali</h5>

                        @if($siswa->ayah)
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Ayah:</p>
                                        <p class="data-value">{{ $siswa->ayah->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Pekerjaan Ayah:</p>
                                        <p class="data-value">{{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Telepon Ayah:</p>
                                        <p class="data-value">{{ $siswa->ayah->telepon ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($siswa->ibu)
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Ibu:</p>
                                        <p class="data-value">{{ $siswa->ibu->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Pekerjaan Ibu:</p>
                                        <p class="data-value">{{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Telepon Ibu:</p>
                                        <p class="data-value">{{ $siswa->ibu->telepon ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($siswa->wali)
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Wali:</p>
                                        <p class="data-value">{{ $siswa->wali->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Pekerjaan Wali:</p>
                                        <p class="data-value">{{ $siswa->wali->pekerjaan ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="data-row">
                                        <p class="data-label">Telepon Wali:</p>
                                        <p class="data-value">{{ $siswa->wali->telepon ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            @if($siswa->foto)
                <div class="photo-container">
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_lengkap }}" style="height: 400px; object-fit: cover;">
                </div>
            @else
                <div class="photo-placeholder">
                    <div>
                        <i class="fas fa-image"></i>
                        <p>Foto tidak tersedia</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection