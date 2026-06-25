@extends('layouts.app')

@section('title', 'Data Diri - ' . $siswa->nama_lengkap)

@section('content')

<style>
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --border-radius: 12px;
        --transition: all 0.3s ease;
    }

    body {
        background-color: var(--light-bg);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #1F2937;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.3);
        color: white;
    }

    .btn-secondary-custom {
        background: #6B7280;
        color: white;
    }

    .btn-secondary-custom:hover {
        background: #4B5563;
        transform: translateY(-2px);
        color: white;
    }

    .card {
        border-radius: var(--border-radius);
        border: 1px solid #E5E7EB;
        box-shadow: var(--card-shadow);
        background: white;
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .card-header {
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        padding: 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .card-header h4 {
        margin: 0;
        color: #1F2937;
        font-size: 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 700;
        color: #6B7280;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: #1F2937;
        font-weight: 500;
    }

    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        width: fit-content;
        transition: var(--transition);
    }

    .photo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .photo-wrapper {
        width: 150px;
        height: 150px;
        margin: 0 auto 1rem;
        border-radius: 12px;
        overflow: hidden;
        border: 4px solid #E5E7EB;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--light-bg);
        color: #9CA3AF;
        font-size: 2.5rem;
    }

    .photo-placeholder span {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-custom {
            flex: 1;
            justify-content: center;
        }

        .card-body {
            padding: 1.25rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-circle"></i>
            Data Diri Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('siswa.dashboard') }}" class="btn-custom btn-secondary-custom">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn-custom btn-primary-custom" target="_blank">
                <i class="fas fa-download"></i>
                Unduh PDF
            </a>
        </div>
    </div>

    <!-- Data Pribadi -->
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="fas fa-user"></i>
                A. Data Pribadi Siswa
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="photo-container">
                        <div class="photo-wrapper">
                            @if(isset($siswa->user) && isset($siswa->user->photo))
                                <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" loading="lazy">
                            @else
                                <div class="photo-placeholder">
                                    <i class="fas fa-user"></i>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">NIS</span>
                            <span class="info-value">{{ $siswa->nis ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">NISN</span>
                            <span class="info-value">{{ $siswa->nisn ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $siswa->nama_lengkap ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">
                                @if($siswa->jenis_kelamin === 'L')
                                    Laki-laki
                                @elseif($siswa->jenis_kelamin === 'P')
                                    Perempuan
                                @else
                                    {{ $siswa->jenis_kelamin ?? '-' }}
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tempat Lahir</span>
                            <span class="info-value">{{ $siswa->tempat_lahir ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Lahir</span>
                            <span class="info-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Agama</span>
                            <span class="info-value">{{ $siswa->agama ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Kewarganegaraan</span>
                            <span class="info-value">{{ $siswa->kewarganegaraan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. HP</span>
                            <span class="info-value">{{ $siswa->no_hp ?? '-' }}</span>
                        </div>
                        <div style="grid-column: 1 / -1;" class="info-item">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">
                                {{ $siswa->dusun ? 'Dusun ' . $siswa->dusun : '' }}
                                {{ $siswa->rt ? ', RT ' . $siswa->rt : '' }}
                                {{ $siswa->rw ? ', RW ' . $siswa->rw : '' }}
                                {{ $siswa->kelurahan ? ', ' . $siswa->kelurahan : '' }}
                                {{ $siswa->kecamatan ? ', ' . $siswa->kecamatan : '' }}
                                {{ $siswa->kode_pos ? ', ' . $siswa->kode_pos : '' }}
                                {{ !($siswa->dusun || $siswa->rt || $siswa->rw || $siswa->kelurahan || $siswa->kecamatan || $siswa->kode_pos) ? '-' : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua / Wali -->
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="fas fa-users"></i>
                B. Data Orang Tua / Wali
            </h4>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Ayah</span>
                    <span class="info-value">{{ $siswa->ayah->nama ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pekerjaan Ayah</span>
                    <span class="info-value">{{ $siswa->ayah->pekerjaan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon Ayah</span>
                    <span class="info-value">{{ $siswa->ayah->telepon ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Ibu</span>
                    <span class="info-value">{{ $siswa->ibu->nama ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pekerjaan Ibu</span>
                    <span class="info-value">{{ $siswa->ibu->pekerjaan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon Ibu</span>
                    <span class="info-value">{{ $siswa->ibu->telepon ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Wali</span>
                    <span class="info-value">{{ $siswa->wali->nama ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pekerjaan Wali</span>
                    <span class="info-value">{{ $siswa->wali->pekerjaan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon Wali</span>
                    <span class="info-value">{{ $siswa->wali->telepon ?? '-' }}</span>
                </div>
                <div style="grid-column: 1 / -1;" class="info-item">
                    <span class="info-label">Alamat Orang Tua</span>
                    <span class="info-value">{{ $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '-' }}</span>
                </div>
                <div style="grid-column: 1 / -1;" class="info-item">
                    <span class="info-label">Alamat Wali</span>
                    <span class="info-value">{{ $siswa->wali->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pendaftaran -->
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="fas fa-file-alt"></i>
                C. Data Pendaftaran
            </h4>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Sekolah Asal</span>
                    <span class="info-value">{{ $siswa->sekolah_asal ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Diterima</span>
                    <span class="info-value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status Keluarga</span>
                    <span class="info-value">{{ $siswa->status_keluarga ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Anak Ke-</span>
                    <span class="info-value">{{ $siswa->anak_ke ?? '-' }}</span>
                </div>
                <div style="grid-column: 1 / -1;" class="info-item">
                    <span class="info-label">Catatan Wali Kelas</span>
                    <span class="info-value">{{ $siswa->catatan_wali_kelas ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Mutasi -->
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="fas fa-exchange-alt"></i>
                D. Status Mutasi
            </h4>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Status Saat Ini</span>
                    <span>
                        @if($siswa->mutasiTerakhir)
                            <span class="badge-custom" style="background-color: {{ $siswa->mutasiTerakhir->status_color ?? '#10B981' }}; color: white;">
                                {{ $siswa->mutasiTerakhir->status_label ?? 'Tidak Diketahui' }}
                            </span>
                        @else
                            <span class="badge-custom" style="background-color: var(--success-color); color: white;">
                                Aktif
                            </span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Mutasi</span>
                    <span class="info-value">
                        {{ $siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tanggal_mutasi 
                            ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->translatedFormat('d F Y') 
                            : '-' }}
                    </span>
                </div>
                @if($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->alasan_pindah)
                    <div class="info-item">
                        <span class="info-label">Alasan Pindah</span>
                        <span class="info-value">{{ $siswa->mutasiTerakhir->alasan_pindah }}</span>
                    </div>
                @endif
                @if($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tujuan_pindah)
                    <div class="info-item">
                        <span class="info-label">Sekolah Tujuan</span>
                        <span class="info-value">{{ $siswa->mutasiTerakhir->tujuan_pindah }}</span>
                    </div>
                @endif
                @if($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->no_sk_keluar)
                    <div class="info-item">
                        <span class="info-label">No. SK Keluar</span>
                        <span class="info-value">{{ $siswa->mutasiTerakhir->no_sk_keluar }}</span>
                    </div>
                @endif
                @if($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tanggal_sk_keluar)
                    <div class="info-item">
                        <span class="info-label">Tanggal SK Keluar</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->translatedFormat('d F Y') }}</span>
                    </div>
                @endif
                @if($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->keterangan)
                    <div style="grid-column: 1 / -1;" class="info-item">
                        <span class="info-label">Keterangan</span>
                        <span class="info-value">{{ $siswa->mutasiTerakhir->keterangan }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
