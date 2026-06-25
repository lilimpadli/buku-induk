@extends('layouts.app')

@section('title', 'Import Guru')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .form-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .form-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1E293B;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.9rem;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-import {
        background: var(--primary-gradient);
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-import:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-download {
        background: #10B981;
        border: none;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
    }

    .btn-download:hover {
        background: #059669;
        transform: translateY(-2px);
        color: white;
    }

    .table-example {
        font-size: 0.8rem;
    }

    .table-example th {
        background-color: #F8FAFC;
        font-weight: 600;
        color: #475569;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .table-example td {
        font-size: 0.8rem;
    }

    .badge-required {
        background: #EF4444;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 600;
    }

    .badge-optional {
        background: #E2E8F0;
        color: #64748B;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
    }

    .alert-info-custom {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        color: #1E40AF;
    }

    .alert-info-custom i {
        color: #3B82F6;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .form-card .card-body {
            padding: 1rem;
        }

        .btn-import,
        .btn-download {
            width: 100%;
            justify-content: center;
        }

        .table-example {
            font-size: 0.65rem;
        }
        .table-example th,
        .table-example td {
            padding: 0.3rem 0.4rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-file-import me-2"></i> Import Guru</h3>
                <div class="text-muted">Upload file Excel untuk menambahkan banyak guru sekaligus</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.guru.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-upload"></i> Upload File</h5>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('errors') && count(session('errors')) > 0)
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i> Beberapa error saat import:</h6>
                    <ul class="mb-0">
                        @foreach(session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('kurikulum.guru.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-file-excel text-primary me-1"></i> Pilih file Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control @error('file') is-invalid @enderror" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format yang didukung: .xlsx, .xls, .csv</small>
                </div>

                <button type="submit" class="btn-import">
                    <i class="fas fa-upload me-2"></i> Import Guru
                </button>
            </form>
        </div>
    </div>

    <!-- INFORMASI -->
    <div class="card form-card mt-3">
        <div class="card-header">
            <h5><i class="fas fa-info-circle"></i> Panduan Format File</h5>
        </div>
        <div class="card-body">
            <div class="alert-info-custom mb-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Password default</strong> untuk akun baru adalah: <strong>12345678</strong>
                <br>
                <small>Ubah password setelah guru login pertama kali</small>
            </div>

            <h6 class="fw-semibold mb-2">Kolom yang harus ada di file Excel (header di baris pertama):</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-example">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Keterangan</th>
                            <th>Wajib</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>nama</code></td>
                            <td>Nama lengkap guru</td>
                            <td><span class="badge-required">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><code>nomor_induk</code></td>
                            <td>NIP / Nomor Induk</td>
                            <td><span class="badge-required">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><code>jenis_kelamin</code></td>
                            <td>L (Laki-laki) atau P (Perempuan)</td>
                            <td><span class="badge-optional">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>email</code></td>
                            <td>Email guru (untuk login)</td>
                            <td><span class="badge-optional">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>role</code></td>
                            <td>walikelas, guru, kaprog, tu, kurikulum</td>
                            <td><span class="badge-optional">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>rombel_id</code></td>
                            <td>ID rombel (jika wali kelas)</td>
                            <td><span class="badge-optional">Opsional</span></td>
                        </tr>
                        <tr>
                            <td><code>jurusan_id</code></td>
                            <td>ID jurusan</td>
                            <td><span class="badge-optional">Opsional</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <a href="{{ route('kurikulum.guru.import.template') }}" class="btn-download">
                    <i class="fas fa-download"></i> Download Template Excel
                </a>
            </div>
        </div>
    </div>

    <!-- CONTOH -->
    <div class="card form-card mt-3">
        <div class="card-header">
            <h5><i class="fas fa-table"></i> Contoh Format File</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-example">
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
                        <tr>
                            <td>Fatimah</td>
                            <td>198207152241010</td>
                            <td>P</td>
                            <td>fatimah@smkn1x.sch.id</td>
                            <td>kurikulum</td>
                            <td></td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <small class="text-muted">* Kolom kosong boleh dikosongkan, kolom wajib harus diisi</small>
        </div>
    </div>
</div>
@endsection