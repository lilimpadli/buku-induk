@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Data Siswa: {{ $siswa->nama_lengkap }}</h3>
        <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('tu.siswa.update', $siswa->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Data Pribadi -->
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 fw-semibold">Data Pribadi</h5>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ $siswa->nama_lengkap }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ $siswa->nisn }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ $siswa->tempat_lahir }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ $siswa->tanggal_lahir }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ $siswa->agama }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status Keluarga</label>
                        <input type="text" name="status_keluarga" class="form-control" value="{{ $siswa->status_keluarga }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Anak ke</label>
                        <input type="number" name="anak_ke" class="form-control" value="{{ $siswa->anak_ke }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ $siswa->alamat }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $siswa->no_hp }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" class="form-control" value="{{ $siswa->sekolah_asal }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" placeholder="Contoh: X MM 1" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" class="form-control" value="{{ $siswa->tanggal_diterima }}">
                    </div>

                    <!-- Data Ayah -->
                    <div class="col-12 mt-4">
                        <h5 class="border-bottom pb-2 fw-semibold">Data Ayah</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control" value="{{ $siswa->nama_ayah }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $siswa->pekerjaan_ayah }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Telepon Ayah</label>
                        <input type="text" name="telepon_ayah" class="form-control" value="{{ $siswa->telepon_ayah }}">
                    </div>

                    <!-- Data Ibu -->
                    <div class="col-12 mt-4">
                        <h5 class="border-bottom pb-2 fw-semibold">Data Ibu</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control" value="{{ $siswa->nama_ibu }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $siswa->pekerjaan_ibu }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Telepon Ibu</label>
                        <input type="text" name="telepon_ibu" class="form-control" value="{{ $siswa->telepon_ibu }}">
                    </div>

                    <!-- Data Wali -->
                    <div class="col-12 mt-4">
                        <h5 class="border-bottom pb-2 fw-semibold">Data Wali (Opsional)</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control" value="{{ $siswa->nama_wali }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Telepon Wali</label>
                        <input type="text" name="telepon_wali" class="form-control" value="{{ $siswa->telepon_wali }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" class="form-control" value="{{ $siswa->pekerjaan_wali }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Wali</label>
                        <textarea name="alamat_wali" class="form-control" rows="2">{{ $siswa->alamat_wali }}</textarea>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection