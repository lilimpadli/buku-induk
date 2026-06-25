@extends('layouts.app')

@section('title', 'Edit Data Siswa - ' . $siswa->nama_lengkap)

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.9rem;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-save {
        background: var(--primary-gradient);
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-cancel {
        background: #64748B;
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-cancel:hover {
        background: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1E293B;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.3rem;
        border-bottom: 2px solid #E2E8F0;
    }

    .section-title:first-of-type {
        margin-top: 0;
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

        .btn-save,
        .btn-cancel {
            width: 100%;
            margin-bottom: 8px;
            justify-content: center;
        }

        .border-top {
            text-align: center;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-md-6 {
            padding-left: 8px;
            padding-right: 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-user-edit me-2"></i> Edit Data Siswa</h3>
                <div class="text-muted">{{ $siswa->nama_lengkap }}</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.siswa.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-pen"></i> Form Edit Data Siswa</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kurikulum.siswa.data-diri.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-title">Identitas Siswa</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-user text-primary me-1"></i> Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-id-card text-primary me-1"></i> NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-id-card text-primary me-1"></i> NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-phone text-primary me-1"></i> No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-pray text-primary me-1"></i> Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-users text-primary me-1"></i> Rombel</label>
                        <select name="rombel_id" class="form-select">
                            <option value="">Pilih Rombel</option>
                            @foreach($rombels ?? [] as $r)
                                <option value="{{ $r->id }}" {{ (old('rombel_id', $siswa->rombel_id) == $r->id) ? 'selected' : '' }}>{{ $r->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-globe text-primary me-1"></i> Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Dusun</label>
                        <input type="text" name="dusun" class="form-control" value="{{ old('dusun', $siswa->dusun) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt', $siswa->rt) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw', $siswa->rw) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $siswa->kode_pos) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kelurahan / Desa</label>
                        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $siswa->kelurahan) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $siswa->kecamatan) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-calendar-plus text-primary me-1"></i> Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', $siswa->tanggal_diterima) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-envelope text-primary me-1"></i> Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                    </div>
                </div>

                <div class="section-title">Data Ayah</div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="ayah_nama" class="form-control" value="{{ old('ayah_nama', $siswa->ayah->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="ayah_pekerjaan" class="form-control" value="{{ old('ayah_pekerjaan', $siswa->ayah->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="ayah_telepon" class="form-control" value="{{ old('ayah_telepon', $siswa->ayah->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="ayah_alamat" class="form-control" value="{{ old('ayah_alamat', $siswa->ayah->alamat ?? '') }}">
                    </div>
                </div>

                <div class="section-title">Data Ibu</div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="ibu_nama" class="form-control" value="{{ old('ibu_nama', $siswa->ibu->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="ibu_pekerjaan" class="form-control" value="{{ old('ibu_pekerjaan', $siswa->ibu->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="ibu_telepon" class="form-control" value="{{ old('ibu_telepon', $siswa->ibu->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="ibu_alamat" class="form-control" value="{{ old('ibu_alamat', $siswa->ibu->alamat ?? '') }}">
                    </div>
                </div>

                <div class="section-title">Data Wali</div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="wali_nama" class="form-control" value="{{ old('wali_nama', $siswa->wali->nama ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="wali_pekerjaan" class="form-control" value="{{ old('wali_pekerjaan', $siswa->wali->pekerjaan ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="wali_telepon" class="form-control" value="{{ old('wali_telepon', $siswa->wali->telepon ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="wali_alamat" class="form-control" value="{{ old('wali_alamat', $siswa->wali->alamat ?? '') }}">
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.siswa.data-diri.show', $siswa->id) }}" class="btn btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection