@extends('layouts.app')

@section('title', 'Edit Data Siswa')

@section('content')

<div class="container-fluid">

    <!-- JUDUL -->
    <h2 class="fw-bold mb-1">Edit Data Siswa</h2>
    <p class="text-muted mb-4">Ubah data siswa.</p>

    <!-- FORM -->
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">
            <form action="{{ route('kurikulum.data-siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $siswa->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->nomor_induk }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" name="nisn" id="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                        </div>

                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" name="agama" id="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}">
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', $siswa->tanggal_diterima) }}">
                        </div>

                        <div class="mb-3">
                            <label for="rombel_id" class="form-label">Rombel</label>
                            <select name="rombel_id" id="rombel_id" class="form-control">
                                <option value="">Pilih Rombel</option>
                                @foreach($rombels as $rombel)
                                <option value="{{ $rombel->id }}" {{ old('rombel_id', $siswa->rombel_id) == $rombel->id ? 'selected' : '' }}>{{ $rombel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection