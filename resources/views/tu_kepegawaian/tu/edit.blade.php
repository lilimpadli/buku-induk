@extends('layouts.app')

@section('title', 'Ubah Akun TU')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Ubah Akun TU</h3>
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

    <form action="{{ route('tu_kepegawaian.tu.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nomor Induk</label>
                <input type="text" name="nomor_induk" value="{{ old('nomor_induk', $user->nomor_induk) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="tu" {{ old('role', $user->role) == 'tu' ? 'selected' : '' }}>TU</option>
                    <option value="tu_kepegawaian" {{ old('role', $user->role) == 'tu_kepegawaian' ? 'selected' : '' }}>TU Kepegawaian</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password baru</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ulangi Password baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection