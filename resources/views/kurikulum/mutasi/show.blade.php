@extends('layouts.app')

@section('title', 'Detail Mutasi Siswa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-eye text-primary"></i> Detail Data Mutasi Siswa
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- Kartu Utama -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Mutasi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIS Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nis }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NISN Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">Nama Lengkap Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nama_lengkap }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status Mutasi</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $mutasi->status_color }} fs-6">
                                    {{ $mutasi->status_label }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Mutasi</label>
                            <p class="form-control-plaintext">{{ $mutasi->tanggal_mutasi->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <p class="form-control-plaintext">
                                {{ $mutasi->keterangan ?? '<em class="text-muted">Tidak ada keterangan</em>' }}
                            </p>
                        </div>
                    </div>

                    <!-- Data Spesifik Sesuai Status -->
                    @if($mutasi->status === 'pindah')
                        <hr>
                        <h5 class="mb-3">
                            <i class="fas fa-arrow-right text-info"></i> Data Pindah Sekolah
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alasan Pindah</label>
                                <p class="form-control-plaintext">{{ $mutasi->alasan_pindah ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sekolah Tujuan</label>
                                <p class="form-control-plaintext">{{ $mutasi->tujuan_pindah ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']))
                        <hr>
                        <h5 class="mb-3">
                            <i class="fas fa-file-contract text-warning"></i> Surat Keputusan Keluar
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor SK Keluar</label>
                                <p class="form-control-plaintext">{{ $mutasi->no_sk_keluar ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal SK Keluar</label>
                                <p class="form-control-plaintext">
                                    {{ $mutasi->tanggal_sk_keluar ? $mutasi->tanggal_sk_keluar->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('kurikulum.mutasi.edit', $mutasi) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                    <a href="{{ route('kurikulum.mutasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <form action="{{ route('kurikulum.mutasi.destroy', $mutasi) }}" method="POST" style="display: inline;"
                        onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Kartu Data Siswa -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Data Siswa</h6>
                </div>
                <div class="card-body">
                    <p><strong>Jenis Kelamin:</strong> {{ $mutasi->siswa->jenis_kelamin }}</p>
                    <p><strong>Tempat Lahir:</strong> {{ $mutasi->siswa->tempat_lahir }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ $mutasi->siswa->tanggal_lahir ? (\Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->format('d F Y')) : '-' }}</p>
                    <p><strong>Agama:</strong> {{ $mutasi->siswa->agama ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ Str::limit($mutasi->siswa->alamat ?? '-', 50) }}</p>
                </div>
            </div>

            <!-- Kartu Timeline -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Timeline Sistem</h6>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Dibuat:</strong><br>
                        <small class="text-muted">{{ $mutasi->created_at->format('d F Y, H:i') }}</small>
                    </p>
                    <p>
                        <strong>Terakhir Diubah:</strong><br>
                        <small class="text-muted">{{ $mutasi->updated_at->format('d F Y, H:i') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
