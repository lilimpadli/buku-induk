@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Jurusan</h2>
            <p class="text-muted mb-0">Perbarui informasi jurusan agar nama dan kode tetap konsisten di seluruh sistem.</p>
        </div>
    </div>

    <div class="card dashboard-panel border-0 overflow-hidden">
        <div class="card-header py-4 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h3 class="mb-1">Ubah Detail Jurusan</h3>
                    <p class="text-muted mb-0">Update kode dan nama jurusan untuk menjaga standar data akademik.</p>
                </div>
                <div class="text-muted small">Perubahan akan langsung tersimpan setelah submit.</div>
            </div>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                    <strong>Periksa kembali data formulir.</strong>
                    <ul class="mb-0 mt-2 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('super_admin.manajemen-jurusan.update', $jurusan->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12">
                    <label for="kode" class="form-label">Kode Jurusan</label>
                    <input type="text" class="form-control form-control-modern @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $jurusan->kode) }}" required>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="nama" class="form-label">Nama Jurusan</label>
                    <input type="text" class="form-control form-control-modern @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $jurusan->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-2">
                        <a href="{{ route('super_admin.manajemen-jurusan.index') }}" class="btn btn-secondary btn-secondary-modern">Batal</a>
                        <button type="submit" class="btn btn-primary btn-primary-modern">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-panel {
    border-radius: 24px;
    box-shadow: 0 22px 60px rgba(15, 23, 42, 0.08);
    border: 1px solid rgba(15, 23, 42, 0.06);
    overflow: hidden;
}
.dashboard-panel .card-header {
    background: linear-gradient(180deg, rgba(221, 235, 255, 0.72), rgba(255, 255, 255, 0.72));
    border-bottom: 1px solid rgba(15, 23, 42, 0.06);
}
.form-label {
    font-size: .95rem;
    font-weight: 600;
    color: #1f2937;
}
.form-control-modern {
    border-radius: 18px;
    border: 1px solid rgba(56, 118, 255, 0.16);
    background: #fbfdff;
    min-height: 50px;
    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
}
.form-control-modern:focus {
    border-color: rgba(56, 118, 255, 0.35);
    box-shadow: 0 0 0 0.13rem rgba(56, 118, 255, 0.18);
    background: #ffffff;
}
.form-control-modern.is-invalid {
    border-color: #dc3545;
    background: #fff5f6;
}
.invalid-feedback {
    display: block;
    margin-top: .35rem;
}
.btn-primary-modern {
    border-radius: 18px;
    background: linear-gradient(135deg, #336df1 0%, #1f5ed0 100%);
    border: none;
    box-shadow: 0 14px 30px rgba(51, 109, 241, 0.18);
    padding: .85rem 1.5rem;
}
.btn-primary-modern:hover, .btn-primary-modern:focus {
    background: linear-gradient(135deg, #2756cc 0%, #164eb3 100%);
}
.btn-secondary-modern {
    border-radius: 18px;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background: #f8fafc;
    color: #334155;
    padding: .82rem 1.4rem;
}
.btn-secondary-modern:hover, .btn-secondary-modern:focus {
    background: #edf2f7;
    color: #1f2937;
}
@media (max-width: 575.98px) {
    .dashboard-panel .card-header,
    .dashboard-panel .card-body {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endpush