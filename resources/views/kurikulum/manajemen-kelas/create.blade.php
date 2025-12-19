@extends('layouts.app')

@section('title', 'Tambah Rombel')

@section('content')
<div class="container-fluid">

    <!-- JUDUL -->
    <h3 class="fw-bold mb-1">Tambah Rombel</h3>
    <p class="text-muted mb-3">
        Tambah data rombel baru.
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('kurikulum.kelas.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <!-- Kelas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->jurusan->nama ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Rombel -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Rombel</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: RPL 1, TKJ 2"
                            value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Wali Kelas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Wali Kelas</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('kurikulum.kelas.index') }}" class="btn btn-light px-4 me-2">Batal</a>
                    <button class="btn btn-primary px-4">Simpan</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection