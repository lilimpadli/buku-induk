@extends('layouts.app')

@section('title', 'Import Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Import Siswa (Excel)</h3>
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <p>Unggah file Excel (.xlsx/.xls/.csv) menggunakan format kolom header: <strong>nomor_induk, nis, nama_lengkap, jenis_kelamin, nama_rombel, nisn, email</strong>. Baris pertama dianggap header.</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('kurikulum.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih file Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control" required>
                </div>

                <button class="btn btn-primary">Import dan Buat Akun (password 12345678)</button>
            </form>
        </div>
    </div>
</div>
@endsection
