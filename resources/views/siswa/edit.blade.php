@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-header bg-primary text-white py-3" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Lengkap Data Diri & Orang Tua</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('siswa.dataDiri.update') }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i> Data Siswa</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" value="{{ $siswa->nama_lengkap ?? '' }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NIS</label>
                        <input type="text" class="form-control" value="{{ $siswa->nis ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NISN</label>
                        <input type="text" class="form-control" value="{{ $siswa->nisn ?? '-' }}" disabled>
                    </div>
                </div>

                <hr>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <h5 class="text-success mb-3"><i class="fas fa-user-tie me-2"></i> Data Ayah</h5>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-control" name="nama_ayah" value="{{ $siswa->ayah->nama ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon Ayah</label>
                            <input type="text" class="form-control" name="telepon_ayah" value="{{ $siswa->ayah->telepon ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" class="form-control" name="pekerjaan_ayah" value="{{ $siswa->ayah->pekerjaan ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-danger mb-3"><i class="fas fa-user me-2"></i> Data Ibu</h5>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control" name="nama_ibu" value="{{ $siswa->ibu->nama ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon Ibu</label>
                            <input type="text" class="form-control" name="telepon_ibu" value="{{ $siswa->ibu->telepon ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" class="form-control" name="pekerjaan_ibu" value="{{ $siswa->ibu->pekerjaan ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary px-4 me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection