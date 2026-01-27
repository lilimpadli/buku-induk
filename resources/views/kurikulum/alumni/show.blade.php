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
        font-size: 18px;
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
        font-size: 16px;
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
        font-size: 4rem;
        opacity: 0.5;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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
    }

    /* Row Styles */
    .row {
        margin-bottom: 1.5rem;
    }

    .col-md-6 p:first-child,
    .col-md-12 p:first-child {
        font-weight: 600;
        color: #64748B;
        font-size: 13px;
        margin-bottom: 0.5rem;
    }

    .col-md-6 p:last-child,
    .col-md-12 p:last-child {
        color: #334155;
        font-size: 14px;
    }

    /* Section Divider */
    hr {
        border: none;
        border-top: 2px solid #E2E8F0;
        margin: 2rem 0;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 12px;
        font-size: 12px;
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

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }

        .row {
            flex-direction: column;
        }
    }
</style>

<div class="container mt-4">
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('kurikulum.alumni.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('kurikulum.alumni.buku-induk.show', $siswa->id) }}" class="btn btn-primary btn-sm" target="_blank">
            <i class="fas fa-book"></i> Buku Induk
        </a>
        <a href="{{ route('kurikulum.alumni.raport.list', $siswa->id) }}" class="btn btn-info btn-sm">
            <i class="fas fa-file-alt"></i> Raport
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Data Pribadi -->
                    <h5 class="mb-3">Data Pribadi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>NIS:</strong></p>
                            <p>{{ $siswa->nis }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>NISN:</strong></p>
                            <p>{{ $siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama Lengkap:</strong></p>
                            <p>{{ $siswa->nama_lengkap }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jenis Kelamin:</strong></p>
                            <p>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Agama:</strong></p>
                            <p>{{ $siswa->agama ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. HP:</strong></p>
                            <p>{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Tempat, Tanggal Lahir:</strong></p>
                            <p>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Alamat:</strong></p>
                            <p>{{ $siswa->alamat ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Data Sekolah -->
                    <hr>
                    <h5 class="mb-3">Data Sekolah</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status Kelulusan:</strong></p>
                            <p><span class="badge bg-success">LULUS</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rombel Terakhir:</strong></p>
                            <p>{{ optional($siswa->rombel)->nama ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tingkat Kelas:</strong></p>
                            <p>{{ optional($siswa->rombel->kelas)->tingkat ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jurusan:</strong></p>
                            <p>{{ optional($siswa->rombel->kelas->jurusan)->nama ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    @if($siswa->ayah || $siswa->ibu || $siswa->wali)
                        <hr>
                        <h5 class="mb-3">Data Orang Tua / Wali</h5>

                        @if($siswa->ayah)
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Ayah:</strong></p>
                                    <p>{{ $siswa->ayah->nama }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Pekerjaan Ayah:</strong></p>
                                    <p>{{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Telepon Ayah:</strong></p>
                                    <p>{{ $siswa->ayah->telepon ?? '-' }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siswa->ibu)
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Ibu:</strong></p>
                                    <p>{{ $siswa->ibu->nama }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Pekerjaan Ibu:</strong></p>
                                    <p>{{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Telepon Ibu:</strong></p>
                                    <p>{{ $siswa->ibu->telepon ?? '-' }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siswa->wali)
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Wali:</strong></p>
                                    <p>{{ $siswa->wali->nama }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Pekerjaan Wali:</strong></p>
                                    <p>{{ $siswa->wali->pekerjaan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Telepon Wali:</strong></p>
                                    <p>{{ $siswa->wali->telepon ?? '-' }}</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($siswa->foto)
                <div class="photo-container">
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_lengkap }}" style="height: 400px; object-fit: cover;">
                </div>
            @else
                <div class="photo-placeholder">
                    <div>
                        <i class="fas fa-image"></i>
                        <p class="mt-3">Foto tidak tersedia</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
