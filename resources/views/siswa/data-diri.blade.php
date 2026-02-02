@extends('layouts.app')

@section('title', 'Data Diri Siswa')

@section('content')
<style>
    /* ===================== STYLE DATA DIRI SISWA ===================== */
    
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

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    h3.fw-semibold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin: 0;
    }

    h3.fw-semibold::before {
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

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 2rem;
    }

    /* Section Headers */
    h5.border-bottom {
        font-size: 18px;
        color: #1E293B;
        font-weight: 700;
        padding-bottom: 12px;
        margin-bottom: 20px;
        border-bottom: 2px solid #E2E8F0;
        position: relative;
    }

    h5.border-bottom::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 1px;
    }

    /* Form Labels */
    .form-label.fw-semibold {
        color: #64748B;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-plaintext {
        color: #1E293B;
        font-size: 15px;
        font-weight: 500;
        padding: 10px 0;
        border-bottom: 1px solid #E2E8F0;
        border-radius: 0;
        word-break: break-word;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.6rem 1.3rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        font-size: 14px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn i {
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
    }

    .btn-danger {
        background: linear-gradient(135deg, #EF4444, #DC2626);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #DC2626, #B91C1C);
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #CBD5E1;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #64748B;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94A3B8;
        margin-bottom: 1.5rem;
    }

    /* Image Styling */
    .photo-container {
        display: inline-block;
        position: relative;
    }

    .rounded.shadow {
        border-radius: 12px;
        border: 3px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        object-fit: cover;
    }

    .rounded.shadow:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
    }

    /* Timestamp */
    .timestamp-info {
        background: #F1F5F9;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .timestamp-info small {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Data Grid Improvements */
    .data-row {
        margin-bottom: 1.5rem;
    }

    .data-section {
        margin-top: 2rem;
    }

    /* ============ MOBILE OPTIMIZATIONS ============ */
    @media (max-width: 768px) {
        /* Container & Layout */
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .col-md-10 {
            padding-left: 0;
            padding-right: 0;
        }

        /* Page Header Mobile */
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        h3.fw-semibold {
            font-size: 1.15rem;
            padding-left: 12px;
        }

        h3.fw-semibold::before {
            width: 4px;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
            gap: 0.5rem;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
            padding: 0.55rem 0.9rem;
            font-size: 0.85rem;
        }

        /* Card Mobile */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 1rem;
        }

        /* Section Headers Mobile */
        h5.border-bottom {
            font-size: 0.9rem;
            padding-bottom: 8px;
            margin-bottom: 0.85rem;
        }

        h5.border-bottom::after {
            width: 45px;
        }

        /* Form Fields Mobile */
        .form-label.fw-semibold {
            font-size: 0.65rem;
            margin-bottom: 3px;
        }

        .form-control-plaintext {
            font-size: 0.85rem;
            padding: 6px 0;
            line-height: 1.4;
        }

        /* Grid Layout Mobile - PERBAIKAN: Semua kolom jadi full width */
        .row.g-3 {
            gap: 0.6rem;
        }

        .col-md-3, 
        .col-md-4, 
        .col-md-6,
        .col-6 {
            width: 100% !important;
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Data Sections Mobile */
        .data-section {
            margin-top: 1.25rem;
        }

        .col-12.mt-4 {
            margin-top: 1.25rem !important;
        }

        .col-12.mt-2 {
            margin-top: 0.85rem !important;
        }

        /* Photo Mobile */
        .photo-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .rounded.shadow {
            width: 120px;
            height: 120px;
            border-width: 2px;
        }

        /* Timestamp Mobile */
        .timestamp-info {
            padding: 0.5rem 0.65rem;
            margin-top: 0.85rem;
        }

        .timestamp-info small {
            font-size: 0.65rem;
            line-height: 1.5;
            display: block;
        }

        /* Empty State Mobile */
        .empty-state {
            padding: 1.75rem 1rem;
        }

        .empty-state i {
            font-size: 2.75rem;
            margin-bottom: 0.85rem;
        }

        .empty-state h5 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 1.15rem;
        }

        .empty-state .btn {
            width: 100%;
            padding: 0.65rem 0.9rem;
        }
    }

    /* Extra Small Devices */
    @media (max-width: 400px) {
        h3.fw-semibold {
            font-size: 1.25rem;
        }

        .card-body {
            padding: 1rem;
        }

        h5.border-bottom {
            font-size: 0.95rem;
        }

        .form-control-plaintext {
            font-size: 0.85rem;
        }

        .btn {
            font-size: 0.85rem;
            padding: 0.6rem 0.9rem;
        }

        .rounded.shadow {
            width: 120px;
            height: 120px;
        }

        .empty-state i {
            font-size: 2.5rem;
        }
    }

    /* Tablet Optimization */
    @media (min-width: 769px) and (max-width: 991px) {
        .card-body {
            padding: 1.75rem;
        }

        h3.fw-semibold {
            font-size: 1.6rem;
        }

        .header-actions {
            flex-wrap: nowrap;
        }
    }

    /* Desktop Enhancements */
    @media (min-width: 992px) {
        .form-control-plaintext:hover {
            background-color: #F8FAFC;
        }

        .btn:active {
            transform: translateY(0);
        }
    }
</style>

<div class="container mt-4 mb-4">
    <div class="row">

        <!-- Main Content -->
        <div class="col-md-10 mx-auto">
            <div class="page-header">
                <h3 class="fw-semibold">Data Diri Siswa</h3>

                @if ($siswa)
                    <div class="header-actions">
                        <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-danger" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> 
                            <span class="d-none d-sm-inline">Export PDF</span>
                            <span class="d-inline d-sm-none">PDF</span>
                        </a>
                        
                        <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> 
                            <span class="d-none d-sm-inline">Edit Data</span>
                            <span class="d-inline d-sm-none">Edit</span>
                        </a>
                    </div>
                @else
                    <div class="header-actions">
                        <a href="{{ route('siswa.dataDiri.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                @endif
            </div>

            @if ($siswa)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">

                            <!-- IDENTITAS DASAR -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 fw-semibold">Identitas Siswa</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <p class="form-control-plaintext">{{ $siswa->nama_lengkap }}</p>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label fw-semibold">NIS</label>
                                <p class="form-control-plaintext">{{ $siswa->nis }}</p>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label fw-semibold">NISN</label>
                                <p class="form-control-plaintext">{{ $siswa->nisn }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <p class="form-control-plaintext">{{ $siswa->tempat_lahir }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <p class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d/m/Y') }}
                                </p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <p class="form-control-plaintext">{{ $siswa->jenis_kelamin }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Agama</label>
                                <p class="form-control-plaintext">{{ $siswa->agama }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status Keluarga</label>
                                <p class="form-control-plaintext">{{ $siswa->status_keluarga }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Anak ke</label>
                                <p class="form-control-plaintext">{{ $siswa->anak_ke }}</p>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">Alamat</label>
                                <p class="form-control-plaintext">{{ $siswa->alamat }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">No HP</label>
                                <p class="form-control-plaintext">{{ $siswa->no_hp }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Asal sekolah</label>
                                <p class="form-control-plaintext">{{ $siswa->sekolah_asal }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Diterima</label>
                                <p class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d/m/Y') }}
                                </p>
                            </div>

                            <!-- DATA AYAH -->
                            <div class="col-12 mt-4 data-section">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ayah</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->ayah->nama ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->ayah->telepon ?? '-' }}</p>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">Alamat Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->ayah->alamat ?? '-' }}</p>
                            </div>

                            <!-- DATA IBU -->
                            <div class="col-12 mt-4 data-section">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ibu</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->ibu->nama ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->ibu->telepon ?? '-' }}</p>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">Alamat Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->ibu->alamat ?? '-' }}</p>
                            </div>

                            <!-- DATA WALI -->
                            <div class="col-12 mt-4 data-section">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Wali (Opsional)</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->wali->nama ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->wali->pekerjaan ?? '-' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->wali->telepon ?? '-' }}</p>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">Alamat Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->wali->alamat ?? '-' }}</p>
                            </div>

                            <!-- FOTO -->
                            <div class="col-12 mt-4 data-section">
                                <label class="form-label fw-semibold">Foto Siswa</label><br>
                                @if ($siswa->foto)
                                    <div class="photo-container">
                                        <img src="{{ asset('storage/' . $siswa->foto) }}" width="150" height="150" class="rounded shadow" alt="Foto Siswa">
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada foto</p>
                                @endif
                            </div>

                            <!-- TIMESTAMP -->
                            <div class="col-12 mt-4">
                                <div class="timestamp-info">
                                    <small>
                                        <strong>Dibuat:</strong> {{ $siswa->created_at->format('d M Y H:i') }} • 
                                        <strong>Diperbarui:</strong> {{ $siswa->updated_at->format('d M Y H:i') }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @else
                <!-- DATA KOSONG -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="fas fa-user-slash"></i>
                            <h5>Data diri belum diisi</h5>
                            <p>Silakan lengkapi data diri Anda untuk melanjutkan</p>
                            <a href="{{ route('siswa.dataDiri.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Isi Data Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection