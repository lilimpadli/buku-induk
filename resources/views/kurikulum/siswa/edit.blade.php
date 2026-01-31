@extends('layouts.app')

@section('title', 'Ubah Password Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Ubah Password Siswa</h3>
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow" style="border-radius: 15px;">
        <div class="card-body">
            <h5 class="mb-4">{{ $siswa->nama_lengkap }}</h5>

            <form method="POST" action="{{ route('kurikulum.data-siswa.update', $siswa->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">NIS / Nomor Induk</label>
                    <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>
                </div>

                <hr>

                <h6 class="mb-3">Ubah Password</h6>

                <div class="mb-3">
                    <label class="form-label" for="password">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah" value="{{ old('password') }}">
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
