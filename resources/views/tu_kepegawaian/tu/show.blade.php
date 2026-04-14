@extends('layouts.app')

@section('title', 'Detail Akun TU: ' . $user->name)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Akun TU</h3>
        <div>
            <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('tu_kepegawaian.tu.edit', $user->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6">
                    <strong>Nama</strong>
                    <div>{{ $user->name }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Nomor Induk</strong>
                    <div>{{ $user->nomor_induk }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Email</strong>
                    <div>{{ $user->email ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Role</strong>
                    <div>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Terdaftar pada</strong>
                    <div>{{ optional($user->created_at)->format('d/m/Y H:i') ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection