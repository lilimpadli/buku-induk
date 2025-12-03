@extends('layouts.app')

@section('title', 'Edit Data Diri Siswa')

@section('content')
<div class="container mt-4 mb-4">
    <div class="row">

        <div class="col-md-10 mx-auto">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold">Edit Data Diri</h3>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="POST" action="{{ route('siswa.dataDiri.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <!-- Identitas Siswa -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 fw-semibold">Identitas Siswa</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control"
                                    value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">NIS</label>
                                <input type="text" class="form-control" value="{{ $siswa->nis }}" disabled>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">NISN</label>
                                <input type="text" name="nisn" class="form-control"
                                    value="{{ old('nisn', $siswa->nisn) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki"   {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan"   {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Agama, Status Keluarga, Anak Ke -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Agama</label>
                                <input type="text" name="agama" class="form-control"
                                    value="{{ old('agama', $siswa->agama) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status Keluarga</label>
                                <input type="text" name="status_keluarga" class="form-control"
                                    value="{{ old('status_keluarga', $siswa->status_keluarga) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Anak Ke</label>
                                <input type="number" name="anak_ke" class="form-control"
                                    value="{{ old('anak_ke', $siswa->anak_ke) }}">
                            </div>

                            <!-- Kontak -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No HP</label>
                                <input type="text" name="no_hp" class="form-control"
                                    value="{{ old('no_hp', $siswa->no_hp) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sekolah Asal</label>
                                <input type="text" name="sekolah_asal" class="form-control"
                                    value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kelas</label>
                                <input type="text" name="kelas" class="form-control"
                                    value="{{ old('kelas', $siswa->kelas) }}" placeholder="Contoh: XI MM 1">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Diterima</label>
                                <input type="date" name="tanggal_diterima" class="form-control"
                                    value="{{ old('tanggal_diterima', $siswa->tanggal_diterima) }}">
                            </div>

                            <!-- Alamat -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                            </div>

                            <!-- Data Ayah -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ayah</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control"
                                    value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" class="form-control"
                                    value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ayah</label>
                                <input type="text" name="telepon_ayah" class="form-control"
                                    value="{{ old('telepon_ayah', $siswa->telepon_ayah) }}">
                            </div>

                            <!-- Data Ibu -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Ibu</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control"
                                    value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" class="form-control"
                                    value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ibu</label>
                                <input type="text" name="telepon_ibu" class="form-control"
                                    value="{{ old('telepon_ibu', $siswa->telepon_ibu) }}">
                            </div>

                            <!-- Data Wali -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Data Wali</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Wali</label>
                                <input type="text" name="nama_wali" class="form-control"
                                    value="{{ old('nama_wali', $siswa->nama_wali) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Telepon Wali</label>
                                <input type="text" name="telepon_wali" class="form-control"
                                    value="{{ old('telepon_wali', $siswa->telepon_wali) }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Alamat Wali</label>
                                <textarea name="alamat_wali" class="form-control" rows="2">{{ old('alamat_wali', $siswa->alamat_wali) }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                <input type="text" name="pekerjaan_wali" class="form-control"
                                    value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}">
                            </div>

                            <!-- Foto -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2 fw-semibold">Foto Siswa</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Upload Foto Baru</label>
                                <input type="file" name="foto" class="form-control">
                            </div>

                            <div class="col-md-6">
                                @if($siswa->foto)
                                    <p class="fw-semibold">Foto Saat Ini:</p>
                                    <img src="{{ asset('storage/foto_siswa/' . $siswa->foto) }}"
                                        class="img-thumbnail" width="150">
                                @endif
                            </div>

                        </div>

                        <!-- Tombol -->
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('siswa.dataDiri') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
