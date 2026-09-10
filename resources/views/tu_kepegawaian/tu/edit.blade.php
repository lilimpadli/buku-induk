@extends('layouts.app')

@section('title', 'Ubah Data Pegawai / TU')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Ubah Data Pegawai / TU</h3>
        <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form ini mengupdate data pegawai (bukan user langsung) --}}
    <form action="{{ route('tu_kepegawaian.tu.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $pegawai->nama) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">NIP / Nomor Induk</label>
                <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $pegawai->nik) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">NUPTK</label>
                <input type="text" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Kontak</label>
                <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Jabatan / Role</label>
                <select name="jabatan" class="form-select" required>
                    <option value="tu" {{ old('jabatan', $pegawai->jabatan) == 'tu' ? 'selected' : '' }}>TU</option>
                    <option value="tu_kepegawaian" {{ old('jabatan', $pegawai->jabatan) == 'tu_kepegawaian' ? 'selected' : '' }}>TU Kepegawaian</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection