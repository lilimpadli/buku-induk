@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="container-fluid">

    <!-- JUDUL -->
    <h3 class="fw-bold mb-1">Edit Rombel</h3>
    <p class="text-muted mb-3">
        Edit data rombel.
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('kurikulum.kelas.update', $rombel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <!-- Tingkat -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tingkat</label>
                        <select name="tingkat" class="form-select" required>
                            <option value="">Pilih Tingkat</option>
                            @foreach($tingkats as $t)
                                <option value="{{ $t }}" {{ $t == $rombel->kelas->tingkat ? 'selected' : '' }}>
                                    Kelas {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Konsentrasi Keahlian -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Konsentrasi Keahlian</label>
                        <select name="jurusan_id" class="form-select" required>
                            <option value="">Pilih Konsentrasi Keahlian</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ $j->id == $rombel->kelas->jurusan_id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Nama Rombel -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Rombel</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: RPL 1, TKJ 2"
                            value="{{ old('nama', $rombel->nama) }}" required>
                    </div>

                    <!-- Wali Kelas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Wali Kelas</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ $guru->id == $rombel->guru_id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
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