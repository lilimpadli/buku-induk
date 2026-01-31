@extends('layouts.app')

@section('title', 'Edit Data Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-1">Edit Data Siswa</h2>
    <p class="text-muted mb-4">Ubah data lengkap siswa (identitas & data orang tua).</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 mt-3" style="border-radius: 15px;">
        <div class="card-body">
            <form action="{{ route('kurikulum.data-siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5>Identitas Siswa</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelas (label)</label>
                        <input type="text" name="kelas_label" class="form-control" value="{{ old('kelas_label', $siswa->kelas) }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Rombel</label>
                        @if(isset($rombels) && $rombels->count())
                            <select name="rombel_id" class="form-select">
                                <option value="">Pilih Rombel</option>
                                @foreach($rombels as $r)
                                    <option value="{{ $r->id }}" {{ (old('rombel_id', $siswa->rombel_id) == $r->id) ? 'selected' : '' }}>{{ $r->nama }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" name="rombel_nama" class="form-control" value="{{ old('rombel_nama', $siswa->rombel->nama ?? '') }}">
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', $siswa->tanggal_diterima) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                    </div>
                </div>

                <hr>
                <h5>Data Ayah</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="ayah_nama" class="form-control" value="{{ old('ayah_nama', $siswa->ayah->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="ayah_pekerjaan" class="form-control" value="{{ old('ayah_pekerjaan', $siswa->ayah->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="ayah_telepon" class="form-control" value="{{ old('ayah_telepon', $siswa->ayah->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Ayah</label>
                        <input type="text" name="ayah_alamat" class="form-control" value="{{ old('ayah_alamat', $siswa->ayah->alamat ?? '') }}">
                    </div>
                </div>

                <hr>
                <h5>Data Ibu</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="ibu_nama" class="form-control" value="{{ old('ibu_nama', $siswa->ibu->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="ibu_pekerjaan" class="form-control" value="{{ old('ibu_pekerjaan', $siswa->ibu->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="ibu_telepon" class="form-control" value="{{ old('ibu_telepon', $siswa->ibu->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Ibu</label>
                        <input type="text" name="ibu_alamat" class="form-control" value="{{ old('ibu_alamat', $siswa->ibu->alamat ?? '') }}">
                    </div>
                </div>

                <hr>
                <h5>Data Wali</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Wali</label>
                        <input type="text" name="wali_nama" class="form-control" value="{{ old('wali_nama', $siswa->wali->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="wali_pekerjaan" class="form-control" value="{{ old('wali_pekerjaan', $siswa->wali->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="wali_telepon" class="form-control" value="{{ old('wali_telepon', $siswa->wali->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Wali</label>
                        <input type="text" name="wali_alamat" class="form-control" value="{{ old('wali_alamat', $siswa->wali->alamat ?? '') }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('kurikulum.data-siswa.show', $siswa->id) }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
