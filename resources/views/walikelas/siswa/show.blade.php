@extends('layouts.app')

@section('title', 'Detail Siswa - ' . ($s->nama_lengkap ?? ''))

@section('content')
<style>
    /* ===================== STYLE DETAIL SISWA (SESUAI DASHBOARD) ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
    }

    /* Page Header - SAMA DENGAN DASHBOARD */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
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
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: 2px solid #667eea;
        padding: 1rem 1.5rem;
    }

    .card-header i {
        color: #667eea;
        margin-right: 8px;
    }

    /* Profile Section */
    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: var(--transition);
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-avatar-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        background: var(--primary-gradient);
        color: white;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
    }

    /* Info Row */
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-label {
        width: 160px;
        font-weight: 600;
        color: #4a5568;
    }

    .info-value {
        flex: 1;
        color: #2d3748;
    }

    /* Button Styles - SAMA DENGAN DASHBOARD */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 8px;
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
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .btn-danger-gradient {
        background: var(--danger-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        color: white;
    }

    /* Badge */
    .badge-custom {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .info-row {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 10px;
        }
        
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header - TANPA TOMBOL KEMBALI -->
    <div class="page-header fade-in">
        <div>
            <h3 class="mb-1">👤 Detail Siswa</h3>
            <div class="text-muted">Informasi lengkap data siswa</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri - Profil -->
        <div class="col-lg-4 fade-in" style="animation-delay: 0.1s;">
            <!-- Card Profil -->
            <div class="card text-center">
                <div class="card-body">
                    @if(!empty($s->foto) && file_exists(public_path('storage/' . $s->foto)))
                        <img src="{{ asset('storage/' . $s->foto) }}" class="profile-avatar mb-3" alt="{{ $s->nama_lengkap }}">
                    @else
                        <div class="profile-avatar-placeholder mx-auto mb-3">
                            {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">{{ $s->nama_lengkap }}</h5>
                    <div class="mb-2">
                        <span class="badge-custom bg-primary text-white">
                            <i class="fas fa-id-card me-1"></i> NIS: {{ $s->nis ?? '-' }}
                        </span>
                        <span class="badge-custom bg-info text-dark mt-1 mt-sm-0">
                            <i class="fas fa-qrcode me-1"></i> NISN: {{ $s->nisn ?? '-' }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-start">
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-graduation-cap me-2 text-primary"></i> Rombel</div>
                            <div class="info-value">{{ $s->rombel->nama ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-venus-mars me-2 text-primary"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $s->jenis_kelamin ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> Tanggal Diterima</div>
                            <div class="info-value">{{ $s->tanggal_diterima ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Kontak -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-phone-alt"></i> Kontak
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-mobile-alt me-2 text-primary"></i> No HP Siswa</div>
                        <div class="info-value">{{ $s->no_hp ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-father me-2 text-primary"></i> Telepon Ayah</div>
                        <div class="info-value">{{ $s->ayah->telepon ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-mother me-2 text-primary"></i> Telepon Ibu</div>
                        <div class="info-value">{{ $s->ibu->telepon ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user-friends me-2 text-primary"></i> Telepon Wali</div>
                        <div class="info-value">{{ $s->wali->telepon ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Detail Informasi -->
        <div class="col-lg-8">
            <!-- Informasi Pribadi -->
            <div class="card fade-in" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i> Informasi Pribadi
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $s->nama_lengkap }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jenis Kelamin</div>
                                <div class="info-value">{{ $s->jenis_kelamin ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tempat, Tanggal Lahir</div>
                                <div class="info-value">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Agama</div>
                                <div class="info-value">{{ $s->agama ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Kewarganegaraan</div>
                                <div class="info-value">{{ $s->kewarganegaraan ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Status Keluarga</div>
                                <div class="info-value">{{ $s->status_keluarga ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Anak Ke</div>
                                <div class="info-value">{{ $s->anak_ke ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Sekolah Asal</div>
                                <div class="info-value">{{ $s->sekolah_asal ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="card fade-in" style="animation-delay: 0.3s;">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt"></i> Alamat
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Dusun</div>
                        <div class="info-value">{{ $s->dusun ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">RT / RW</div>
                        <div class="info-value">{{ $s->rt ?? '-' }} / {{ $s->rw ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kelurahan</div>
                        <div class="info-value">{{ $s->kelurahan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kecamatan</div>
                        <div class="info-value">{{ $s->kecamatan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kode Pos</div>
                        <div class="info-value">{{ $s->kode_pos ?? '-' }}</div>
                    </div>
                    @if($s->catatan_wali_kelas)
                    <div class="info-row">
                        <div class="info-label">Catatan Wali Kelas</div>
                        <div class="info-value">{{ $s->catatan_wali_kelas }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="card fade-in" style="animation-delay: 0.4s;">
                <div class="card-header">
                    <i class="fas fa-family"></i> Data Orang Tua
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="fas fa-father text-primary me-2"></i> Ayah</h6>
                            <div class="info-row">
                                <div class="info-label">Nama</div>
                                <div class="info-value">{{ $s->ayah->nama ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pekerjaan</div>
                                <div class="info-value">{{ $s->ayah->pekerjaan ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pendidikan</div>
                                <div class="info-value">{{ $s->ayah->pendidikan ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ $s->ayah->alamat ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="fas fa-mother text-primary me-2"></i> Ibu</h6>
                            <div class="info-row">
                                <div class="info-label">Nama</div>
                                <div class="info-value">{{ $s->ibu->nama ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pekerjaan</div>
                                <div class="info-value">{{ $s->ibu->pekerjaan ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pendidikan</div>
                                <div class="info-value">{{ $s->ibu->pendidikan ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ $s->ibu->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($s->wali && $s->wali->nama)
                    <hr>
                    <h6 class="fw-bold mb-3"><i class="fas fa-user-friends text-primary me-2"></i> Wali</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Nama Wali</div>
                                <div class="info-value">{{ $s->wali->nama ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pekerjaan</div>
                                <div class="info-value">{{ $s->wali->pekerjaan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ $s->wali->alamat ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Telepon</div>
                                <div class="info-value">{{ $s->wali->telepon ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- BUTTON AKSI - Footer (HANYA 2 TOMBOL) -->
    <div class="card fade-in mt-3" style="animation-delay: 0.5s;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 action-buttons">
                <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-gradient">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <a href="{{ route('walikelas.siswa.exportPDF', $s->id) }}" class="btn btn-danger-gradient" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak Data Siswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection