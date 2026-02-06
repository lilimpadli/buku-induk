@extends('layouts.app')

@section('title', 'Import Guru')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Import Guru (Excel)</h3>
        <a href="{{ route('kurikulum.guru.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Format File Excel</h5>
            <p>Unggah file Excel (.xlsx/.xls/.csv) dengan kolom-kolom berikut (dengan header di baris pertama):</p>
            <ul>
                <li><strong>nama</strong> - Nama guru (required)</li>
                <li><strong>nomor_induk</strong> - Nomor induk/NIP (required)</li>
                <li><strong>jenis_kelamin</strong> - L atau P</li>
                <li><strong>email</strong> - Email guru (opsional)</li>
                <li><strong>role</strong> - Role user: walikelas, kaprog, tu, kurikulum (default: walikelas)</li>
                <li><strong>rombel_id</strong> - ID rombel (opsional)</li>
                <li><strong>jurusan_id</strong> - ID jurusan (opsional)</li>
            </ul>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Password default</strong> untuk akun baru adalah: <strong>12345678</strong>
                <br>
                <small>Ubah password setelah guru login pertama kali</small>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('errors') && count(session('errors')) > 0)
                <div class="alert alert-warning alert-dismissible fade show mt-3">
                    <h6>Beberapa error saat import:</h6>
                    <ul class="mb-0">
                        @foreach(session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            <div class="alert alert-light border border-secondary mt-4">
                <strong>💡 Tips:</strong> Gunakan template di bawah ini sebagai referensi untuk format file Anda.
                <br>
                <a href="{{ route('kurikulum.guru.import.template') }}" class="btn btn-sm btn-outline-secondary mt-2">
                    <i class="fas fa-download"></i> Download Template Excel
                </a>
            </div>

            <form action="{{ route('kurikulum.guru.import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih file Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control" required>
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Import Guru
                    </button>
                </div>
            </form>
            <hr class="my-4">

            <h5 class="card-title mb-3">Contoh Format File</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>nama</th>
                            <th>nomor_induk</th>
                            <th>jenis_kelamin</th>
                            <th>email</th>
                            <th>role</th>
                            <th>rombel_id</th>
                            <th>jurusan_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Abdullah</td>
                            <td>198201030221006</td>
                            <td>L</td>
                            <td>abdullah@smkn1x.sch.id</td>
                            <td>walikelas</td>
                            <td>44</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Abu Bakar</td>
                            <td>198205102231008</td>
                            <td>L</td>
                            <td></td>
                            <td>guru</td>
                            <td></td>
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
