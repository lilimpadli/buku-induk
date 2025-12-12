@extends('layouts.app')

@section('title', 'Data Diri Siswa')

@section('content')
<div class="container mt-4 mb-4">
    <div class="row">

        <!-- Main Content -->
        <div class="col-md-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold">Data Diri Siswa</h3>

                @if ($siswa)
                    <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>

                    <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-danger" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>

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
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
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
                                <label class="form-label fw-semibold">Kelas</label>
                                <p class="form-control-plaintext">{{ $siswa->kelas }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Diterima</label>
                                <p class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d F Y') }}
                                </p>
                            </div>

                            <!-- DATA AYAH -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ayah</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->nama_ayah }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->pekerjaan_ayah }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ayah</label>
                                <p class="form-control-plaintext">{{ $siswa->telepon_ayah }}</p>
                            </div>

                            <!-- DATA IBU -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ibu</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->nama_ibu }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->pekerjaan_ibu }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ibu</label>
                                <p class="form-control-plaintext">{{ $siswa->telepon_ibu }}</p>
                            </div>

                            <!-- Alamat Orang Tua -->
                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Alamat Orang Tua</label>
                                <p class="form-control-plaintext">{{ $siswa->alamat_orangtua ?? '-' }}</p>
                            </div>

                            <!-- DATA WALI -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Wali (Opsional)</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->nama_wali }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Alamat Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->alamat_wali }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->telepon_wali }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                <p class="form-control-plaintext">{{ $siswa->pekerjaan_wali }}</p>
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
