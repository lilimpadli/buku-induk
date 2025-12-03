@extends('layouts.app')

@section('title', 'Tambah Data Diri Siswa')

@section('content')
<div class="container mt-3">
    <div class="row">

        <!-- Main Content -->
        <div class="col-md-9">
            <h3 class="mb-4">Tambah Data Diri</h3>

            <div class="card shadow">
                <div class="card-body">

                    <form method="POST" action="{{ route('siswa.dataDiri.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- WAJIB ADA (untuk sesuai database) -->
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="row g-3">

                            <!-- Nama Lengkap, NIS, NISN -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">NIS</label>
                                <input type="text" value="{{ auth()->user()->nomor_induk }}" class="form-control" disabled>
                                <input type="hidden" name="nis" value="{{ auth()->user()->nomor_induk }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">NISN</label>
                                <input type="text" name="nisn" class="form-control" required>
                            </div>

                            <!-- TTL dan Jenis Kelamin -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option disabled selected>-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Agama, Status Keluarga, Anak Ke -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Agama</label>
                                <input type="text" name="agama" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status Keluarga</label>
                                <input type="text" name="status_keluarga" class="form-control" placeholder="Contoh: Anak Kandung" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Anak ke</label>
                                <input type="number" name="anak_ke" class="form-control" required>
                            </div>

                            <!-- Alamat, No HP -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">No HP</label>
                                <input type="text" name="no_hp" class="form-control" required>
                            </div>

                            <!-- Sekolah Asal, Kelas, Tanggal Diterima -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Sekolah Asal</label>
                                <input type="text" name="sekolah_asal" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Kelas</label>
                                <input type="text" name="kelas" class="form-control" placeholder="Contoh: XI MM 1" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Diterima</label>
                                <input type="date" name="tanggal_diterima" class="form-control" required>
                            </div>

                            <!-- Data Ayah -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2">Data Ayah</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ayah</label>
                                <input type="text" name="telepon_ayah" class="form-control">
                            </div>

                            <!-- Data Ibu -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2">Data Ibu</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Ibu</label>
                                <input type="text" name="telepon_ibu" class="form-control">
                            </div>

                            <!-- Data Wali -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2">Data Wali (Opsional)</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Wali</label>
                                <input type="text" name="nama_wali" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Alamat Wali</label>
                                <input type="text" name="alamat_wali" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telepon Wali</label>
                                <input type="text" name="telepon_wali" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                <input type="text" name="pekerjaan_wali" class="form-control">
                            </div>

                            <!-- Foto -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Foto Siswa</label>
                                <input type="file" name="foto" class="form-control">
                            </div>

                        </div>

                        <!-- Tombol -->
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('siswa.dataDiri') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
