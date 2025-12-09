@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="container-fluid">

    <!-- JUDUL -->
    <h3 class="fw-bold mb-1">Edit Kelas</h3>
    <p class="text-muted mb-3">
        Kelola data siswa dengan mudah. Anda dapat menambah, mengubah, dan menghapus data kelas.
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('kurikulum.kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <!-- Kelas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Masukan kelas"
                            value="{{ old('kelas', $kelas->kelas) }}">
                    </div>

                    <!-- Jurusan -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" placeholder="Masukan jurusan"
                            value="{{ old('jurusan', $kelas->jurusan) }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Rombel -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Rombel</label>
                        <input type="text" name="rombel" class="form-control" placeholder="Masukan rombel"
                            value="{{ old('rombel', $kelas->rombel) }}">
                    </div>

                    <!-- Wali Kelas -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Wali Kelas</label>
                        <input type="text" name="wali_kelas" class="form-control" placeholder="Masukan wali kelas"
                            value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
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