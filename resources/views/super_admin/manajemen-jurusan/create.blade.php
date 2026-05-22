@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')

<div class="container-fluid py-4">

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tambah Jurusan</h2>
        <p class="text-muted mb-0">
            Tambahkan jurusan baru agar data sekolah tetap rapi dan mudah dikelola.
        </p>
    </div>

</div>

<div class="card dashboard-panel border-0 overflow-hidden">

    <div class="card-header py-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h3 class="mb-1 fw-bold">Form Jurusan</h3>
                <p class="text-muted mb-0">
                    Lengkapi informasi jurusan dengan benar sebelum menyimpan.
                </p>
            </div>

            <div class="text-muted small">
                Semua field wajib diisi
            </div>
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

        <form action="{{ route('super_admin.manajemen-jurusan.store') }}"
              method="POST"
              class="row g-4">

            @csrf

            <div class="col-12">
                <label for="kode" class="form-label">
                    Nama Singkat Jurusan
                </label>

                <input type="text"
                       class="form-control form-control-modern @error('kode') is-invalid @enderror"
                       id="kode"
                       name="kode"
                       value="{{ old('kode') }}"
                       placeholder="Contoh: RPL"
                       required>

                @error('kode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <label for="nama" class="form-label">
                    Nama Jurusan
                </label>

                <input type="text"
                       class="form-control form-control-modern @error('nama') is-invalid @enderror"
                       id="nama"
                       name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Rekayasa Perangkat Lunak"
                       required>

                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-2">

                    <a href="{{ route('super_admin.manajemen-jurusan.index') }}"
                       class="btn btn-secondary btn-secondary-modern">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary btn-primary-modern">
                        Simpan
                    </button>

                </div>
            </div>

        </form>

    </div>
</div>

</div>
@endsection

@push('styles')

<style>
.dashboard-panel{
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(15,23,42,.08);
    border: 1px solid rgba(15,23,42,.05);
    overflow: hidden;
}

.dashboard-panel .card-header{
    background: linear-gradient(
        180deg,
        rgba(221,235,255,.72),
        rgba(255,255,255,.92)
    );
    border-bottom: 1px solid rgba(15,23,42,.06);
}

.form-label{
    font-size: .95rem;
    font-weight: 700;
    color: #1E293B;
    margin-bottom: .6rem;
}

.form-control-modern{
    border-radius: 18px;
    border: 1px solid rgba(56,118,255,.16);
    background: #FBFDFF;
    min-height: 54px;
    padding: .9rem 1rem;
    transition: all .25s ease;
}

.form-control-modern:focus{
    border-color: rgba(56,118,255,.35);
    box-shadow: 0 0 0 .15rem rgba(56,118,255,.15);
    background: #fff;
}

.form-control-modern.is-invalid{
    border-color: #dc3545;
    background: #fff5f6;
}

.invalid-feedback{
    display: block;
    margin-top: .35rem;
}

.btn-primary-modern{
    border-radius: 18px;
    background: linear-gradient(135deg,#336df1 0%,#1f5ed0 100%);
    border: none;
    padding: .85rem 1.6rem;
    font-weight: 600;
    box-shadow: 0 14px 28px rgba(51,109,241,.18);
    transition: all .25s ease;
}

.btn-primary-modern:hover{
    transform: translateY(-2px);
    background: linear-gradient(135deg,#295ed6 0%,#1c4fb8 100%);
}

.btn-secondary-modern{
    border-radius: 18px;
    border: 1px solid rgba(148,163,184,.25);
    background: #F8FAFC;
    color: #334155;
    padding: .82rem 1.4rem;
    font-weight: 600;
    transition: all .25s ease;
}

.btn-secondary-modern:hover{
    background: #EDF2F7;
    color: #1F2937;
    transform: translateY(-1px);
}

.alert{
    border-radius: 20px;
}

@media (max-width: 575.98px){

    .dashboard-panel .card-header,
    .dashboard-panel .card-body{
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }

    .btn-primary-modern,
    .btn-secondary-modern{
        width: 100%;
    }
}
</style>

@endpush
