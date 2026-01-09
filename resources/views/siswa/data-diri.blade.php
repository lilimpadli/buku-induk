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

    h3.fw-semibold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 20px;
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

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
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
        font-weight: 600;
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
        width: 80px;
        height: 2px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 1px;
    }

    /* Form Labels */
    .form-label.fw-semibold {
        color: #475569;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .form-control-plaintext {
        color: #334155;
        font-size: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #E2E8F0;
        border-radius: 0;
    }

    /* Buttons */
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
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    /* Empty State */
    .fa-user-slash {
        opacity: 0.5;
    }

    .text-muted.fw-semibold {
        color: #64748B !important;
    }

    /* Image Styling */
    .rounded.shadow {
        border-radius: 12px;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .rounded.shadow:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    /* Timestamp */
    small.text-muted {
        font-size: 12px;
        color: #94A3B8;
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
            padding: 1.5rem;
        }
        
        h3.fw-semibold {
            font-size: 24px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
    }
</style>

<div class="container mt-4 mb-4">
    <div class="row">

        <!-- Main Content -->
        <div class="col-md-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold">Data Diri Siswa</h3>

                @if ($siswa)
                    <div>
                        <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-1"></i> Edit Data
                        </a>

                        <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-danger" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                @else
                    <a href="{{ route('siswa.dataDiri.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Data
                    </a>
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

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">NIS</label>
                                <p class="form-control-plaintext">{{ $siswa->nis }}</p>
                            </div>

                            <div class="col-md-3">
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
                            <div class="col-12 mt-4">
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
                            <div class="col-12 mt-4">
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
                            <div class="col-12 mt-4">
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
                            <div class="col-12 mt-4">
                                <label class="form-label fw-semibold">Foto Siswa</label><br>
                                @if ($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" width="150" class="rounded shadow">
                                @else
                                    <p class="text-muted">Tidak ada foto</p>
                                @endif
                            </div>

                            <!-- TIMESTAMP -->
                            <div class="col-12 mt-4">
                                <small class="text-muted">
                                    Dibuat pada: {{ $siswa->created_at->format('d M Y H:i') }} |
                                    Diperbarui: {{ $siswa->updated_at->format('d M Y H:i') }}
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

            @else
                <!-- DATA KOSONG -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted fw-semibold">Data diri belum diisi</h5>
                        <p class="text-muted">Silakan lengkapi data diri Anda untuk melanjutkan</p>
                        <a href="{{ route('siswa.dataDiri.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Isi Data Sekarang
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection