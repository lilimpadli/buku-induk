@extends('layouts.app')

@section('title', 'Import Guru')

@section('content')

<style>
:root{
    --primary-blue:#4facfe;
    --secondary-blue:#00f2fe;
    --text-dark:#1e293b;
    --text-muted:#64748b;
    --soft-bg:#f4f7fe;
    --soft-border:#e2e8f0;

    --shadow-light:0 10px 30px rgba(15,23,42,.06);
    --shadow-hover:0 18px 40px rgba(47,83,255,.12);
}

body{
    background: var(--soft-bg);
}

/* HEADER */

.page-header{
    background: linear-gradient(135deg,var(--primary-blue) 0%,var(--secondary-blue) 100%);
    border-radius: 30px;
    padding: 34px;
    margin-bottom: 28px;
    color: white;
    box-shadow: var(--shadow-light);
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
}

.page-subtitle{
    margin: 0;
    opacity: .9;
    line-height: 1.7;
}

/* CARD */

.card-modern{
    background: white;
    border-radius: 28px;
    border: none;
    overflow: hidden;
    box-shadow: var(--shadow-light);
}

.card-modern .card-body{
    padding: 32px;
}

.section-title{
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 16px;
}

/* BUTTON */

.btn-modern{
    border: none;
    border-radius: 999px;
    padding: 13px 22px;
    min-height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 700;
    color: white;
    text-decoration: none;
    transition: all .25s ease;
}

.btn-modern:hover{
    transform: translateY(-2px);
    color: white;
}

.btn-primary-modern{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    box-shadow: 0 12px 28px rgba(79,172,254,.22);
}

.btn-secondary-modern{
    background: linear-gradient(135deg,#64748b,#475569);
    box-shadow: 0 12px 28px rgba(71,85,105,.18);
}

.btn-download-modern{
    background: linear-gradient(135deg,#10b981,#34d399);
    box-shadow: 0 12px 28px rgba(16,185,129,.18);
}

/* ALERT */

.alert-modern{
    border: none;
    border-radius: 20px;
    padding: 18px 20px;
    box-shadow: var(--shadow-light);
}

.alert-info-modern{
    background: rgba(59,130,246,.08);
    color: #1d4ed8;
}

.alert-warning-modern{
    background: rgba(245,158,11,.12);
    color: #92400e;
}

.alert-danger-modern{
    background: rgba(239,68,68,.1);
    color: #b91c1c;
}

.alert-light-modern{
    background: #f8fafc;
    border: 1px solid var(--soft-border);
}

/* FORM */

.form-label{
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.form-control{
    border-radius: 16px;
    border: 2px solid #e2e8f0;
    min-height: 54px;
    padding: 14px 18px;
    transition: .25s ease;
    box-shadow: none;
}

.form-control:focus{
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(79,172,254,.12);
}

/* TABLE */

.table-modern{
    overflow: hidden;
    border-radius: 18px;
}

.table-modern thead th{
    background: #eff6ff;
    border: none;
    color: var(--text-muted);
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 16px;
}

.table-modern tbody td{
    padding: 16px;
    border-color: #eef2f7;
    vertical-align: middle;
}

.table-modern tbody tr:hover{
    background: #f8fbff;
}

/* LIST */

.import-list li{
    margin-bottom: 10px;
    color: var(--text-muted);
    line-height: 1.7;
}

.import-list strong{
    color: var(--text-dark);
}
</style>

<div class="container-fluid py-4">

<!-- HEADER -->

<div class="page-header">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h1 class="page-title">
                Import Guru
            </h1>

            <p class="page-subtitle">
                Upload data guru menggunakan file Excel dengan format yang sudah ditentukan.
            </p>
        </div>

        <a href="{{ route('super_admin.manajemen-guru.index') }}"
           class="btn-modern btn-secondary-modern">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

    </div>

</div>

<!-- CARD -->

<div class="card-modern">

    <div class="card-body">

        <!-- FORMAT -->

        <h5 class="section-title">
            Format File Excel
        </h5>

        <p class="text-muted mb-3">
            Gunakan format file berikut agar proses import berjalan dengan baik:
        </p>

        <ul class="import-list">
            <li><strong>nama</strong> — Nama guru (required)</li>
            <li><strong>nomor_induk</strong> — Nomor induk / NIP (required)</li>
            <li><strong>jenis_kelamin</strong> — L atau P</li>
            <li><strong>email</strong> — Email guru (opsional)</li>
            <li><strong>role</strong> — guru / walikelas / kaprog / tu / kurikulum</li>
            <li><strong>rombel_id</strong> — ID rombel (opsional)</li>
            <li><strong>jurusan_id</strong> — ID jurusan (opsional)</li>
        </ul>

        <!-- INFO -->

        <div class="alert alert-modern alert-info-modern mt-4">
            <i class="fas fa-info-circle me-2"></i>

            <strong>Password default akun baru:</strong> 12345678

            <div class="small mt-1">
                Disarankan mengganti password setelah login pertama.
            </div>
        </div>

        <!-- ERROR -->

        @if(session('error'))

            <div class="alert alert-modern alert-danger-modern mt-4">
                {{ session('error') }}
            </div>

        @endif

        @if(session('errors') && count(session('errors')) > 0)

            <div class="alert alert-modern alert-warning-modern mt-4">

                <strong>Beberapa data gagal diimport:</strong>

                <ul class="mb-0 mt-2">
                    @foreach(session('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <!-- TEMPLATE -->

        <div class="alert alert-modern alert-light-modern mt-4">

            <strong>💡 Tips:</strong>

            Gunakan template resmi agar struktur file sesuai sistem.

            <div class="mt-3">

                <a href="{{ route('super_admin.manajemen-guru.import.template') }}"
                   class="btn-modern btn-download-modern">
                    <i class="fas fa-download"></i>
                    Download Template
                </a>

            </div>

        </div>

        <!-- FORM -->

        <form action="{{ route('super_admin.manajemen-guru.import') }}"
              method="POST"
              enctype="multipart/form-data"
              class="mt-4">

            @csrf

            <div class="mb-4">

                <label class="form-label">
                    Pilih File Excel
                </label>

                <input type="file"
                       name="file"
                       accept=".xlsx,.xls,.csv"
                       class="form-control"
                       required>

                @error('file')
                    <small class="text-danger d-block mt-2">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <button type="submit"
                    class="btn-modern btn-primary-modern">
                <i class="fas fa-upload"></i>
                Import Guru
            </button>

        </form>

        <!-- TABLE -->

        <hr class="my-5">

        <h5 class="section-title">
            Contoh Format File
        </h5>

        <div class="table-responsive mt-3">

            <table class="table table-modern align-middle">

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
                        <td>-</td>
                        <td>guru</td>
                        <td>-</td>
                        <td>2</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


</div>

@endsection
