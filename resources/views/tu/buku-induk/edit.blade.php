@extends('layouts.app')

@section('title', 'Edit Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --secondary: #7C3AED;
        --success: #10B981;
        --danger: #EF4444;
        --warning: #F59E0B;
        --info: #3B82F6;
        --bg: #F4F7FE;
        --border: #E5E7EB;
        --text: #111827;
        --text-light: #6B7280;
        --shadow-sm: 0 2px 8px rgba(15,23,42,.05);
        --shadow-md: 0 10px 25px rgba(15,23,42,.08);
        --radius: 20px;
    }

    body {
        background: linear-gradient(180deg, #f8faff 0%, #eef2ff 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 800;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .page-title i {
        color: var(--primary);
        font-size: 28px;
    }

    .btn-modern {
        border-radius: 14px;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background: white;
        color: var(--text);
        border: 1.5px solid var(--border);
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary), var(--primary));
        box-shadow: 0 8px 20px rgba(79, 70, 229, .35);
    }

    .main-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,.04);
    }

    .main-card .card-body {
        padding: 30px 36px;
    }

    .section-card {
        background: #fafcff;
        border-radius: 16px;
        padding: 22px 26px;
        margin-bottom: 20px;
        border: 1px solid #f1f5f9;
        transition: all .25s ease;
    }

    .section-card:hover {
        border-color: rgba(79, 70, 229, .15);
        box-shadow: var(--shadow-sm);
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        font-size: 18px;
    }

    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: var(--text);
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1.5px solid #E5E7EB;
        padding: 10px 14px;
        font-size: 14px;
        transition: border .2s ease, box-shadow .2s ease;
        background: white;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .12);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 12px;
        margin-top: 4px;
    }

    /* ================= FOTO UPLOAD ================= */
    .foto-upload-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
    }

    .foto-preview {
        width: 160px;
        height: 210px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        background: #f1f5f9;
        transition: all .3s ease;
        box-shadow: var(--shadow-sm);
    }

    .foto-preview:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .foto-placeholder {
        width: 160px;
        height: 210px;
        border-radius: 16px;
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px dashed #94a3b8;
        transition: all .3s ease;
    }

    .foto-placeholder i {
        font-size: 48px;
        color: #94a3b8;
    }

    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .upload-btn-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .btn-upload {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all .2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-upload:hover {
        background: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, .3);
    }

    .btn-remove-foto {
        background: #fee2e2;
        color: var(--danger);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 13px;
        transition: all .2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-remove-foto:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .foto-help-text {
        font-size: 12px;
        color: var(--text-light);
        text-align: center;
        margin: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px 24px;
    }

    .info-grid .form-group {
        margin-bottom: 0;
    }

    .info-grid .form-label {
        margin-bottom: 4px;
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 14px;
        padding: 14px 32px;
        font-weight: 700;
        font-size: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, .35);
        color: white;
    }

    .btn-batal {
        background: white;
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 14px;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-batal:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: stretch; }
        .main-card .card-body { padding: 20px 16px; }
        .section-card { padding: 16px 18px; }
        .info-grid { grid-template-columns: 1fr; }
        .foto-preview, .foto-placeholder { width: 120px; height: 160px; }
        .form-actions { flex-direction: column; }
        .btn-save, .btn-batal { width: 100%; justify-content: center; }
    }

    @media (max-width: 480px) {
        .main-card .card-body { padding: 14px 12px; }
        .section-card { padding: 14px 14px; }
        .foto-preview, .foto-placeholder { width: 100px; height: 140px; }
        .btn-save { font-size: 14px; padding: 12px 20px; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-edit"></i> Edit Buku Induk
        </h1>
        <a href="{{ route('tu.buku-induk.index') }}" class="btn-modern btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card">
        <div class="card-body">

            <form action="{{ route('tu.buku-induk.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- FOTO SISWA --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-camera text-primary"></i>
                        Foto Siswa
                    </div>

                    <div class="foto-upload-wrapper">
                        {{-- PREVIEW FOTO --}}
                        <div class="foto-placeholder" id="fotoPlaceholder" style="display: {{ isset($siswa->user) && isset($siswa->user->photo) && $siswa->user->photo ? 'none' : 'flex' }};">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        @php
                            $initialPhoto = isset($siswa->user) && isset($siswa->user->photo) && $siswa->user->photo ? $siswa->user->photo : null;
                            $initialPhotoPath = $initialPhoto ? (strpos($initialPhoto, 'foto-siswa/') === 0 ? $initialPhoto : 'foto-siswa/' . basename($initialPhoto)) : null;
                        @endphp
                        <img src="{{ $initialPhotoPath ? asset('storage/' . $initialPhotoPath) : '' }}" alt="{{ $siswa->nama_lengkap }}" class="foto-preview" id="fotoPreview" style="display: {{ $initialPhotoPath ? 'block' : 'none' }};">

                        {{-- UPLOAD BUTTON --}}
                        <div class="d-flex gap-3 flex-wrap justify-content-center">
                            <div class="upload-btn-wrapper">
                                <button type="button" class="btn-upload">
                                    <i class="fas fa-upload"></i> Pilih Foto
                                </button>
                                <input type="file" name="foto" id="fotoInput" accept="image/*">
                            </div>

                            <button type="button" class="btn-remove-foto" id="btnRemoveFoto" style="display: {{ isset($siswa->user) && isset($siswa->user->photo) && $siswa->user->photo ? 'inline-flex' : 'none' }};">
                                <i class="fas fa-trash"></i> Hapus Foto
                            </button>
                        </div>

                        <p class="foto-help-text">
                            <i class="fas fa-info-circle"></i> Format: JPG, PNG, JPEG, WebP. Maksimal 2MB. Ukuran: 3:4
                        </p>

                        <input type="hidden" name="remove_foto" id="removeFoto" value="0">

                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- A. DATA PRIBADI --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-user-circle text-primary"></i>
                        A. DATA PRIBADI SISWA
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}" required>
                            @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" name="nisn" id="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $siswa->nisn) }}">
                            @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                            @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                            @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="agama" class="form-label">Agama</label>
                            <select name="agama" id="agama" class="form-select @error('agama') is-invalid @enderror">
                                <option value="">Pilih</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}" {{ old('agama', $siswa->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                            @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control @error('kewarganegaraan') is-invalid @enderror" value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}" placeholder="WNI / WNA">
                            @error('kewarganegaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="dusun" class="form-label">Dusun</label>
                            <input type="text" name="dusun" id="dusun" class="form-control @error('dusun') is-invalid @enderror" value="{{ old('dusun', $siswa->dusun) }}">
                            @error('dusun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" value="{{ old('kelurahan', $siswa->kelurahan) }}">
                            @error('kelurahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan', $siswa->kecamatan) }}">
                            @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" name="rt" id="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $siswa->rt) }}">
                            @error('rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $siswa->rw) }}">
                            @error('rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $siswa->kode_pos) }}">
                            @error('kode_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- B. ORANG TUA --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-users text-success"></i>
                        B. DATA ORANG TUA / WALI
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="ayah_nama" class="form-label">Nama Ayah</label>
                            <input type="text" name="ayah[nama]" id="ayah_nama" class="form-control" value="{{ old('ayah.nama', $siswa->ayah->nama ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="ayah_pekerjaan" class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="ayah[pekerjaan]" id="ayah_pekerjaan" class="form-control" value="{{ old('ayah.pekerjaan', $siswa->ayah->pekerjaan ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="ibu_nama" class="form-label">Nama Ibu</label>
                            <input type="text" name="ibu[nama]" id="ibu_nama" class="form-control" value="{{ old('ibu.nama', $siswa->ibu->nama ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="ibu_pekerjaan" class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="ibu[pekerjaan]" id="ibu_pekerjaan" class="form-control" value="{{ old('ibu.pekerjaan', $siswa->ibu->pekerjaan ?? '') }}">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="alamat_orangtua" class="form-label">Alamat Orang Tua</label>
                            <textarea name="alamat_orangtua" id="alamat_orangtua" rows="2" class="form-control">{{ old('alamat_orangtua', $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="wali_nama" class="form-label">Nama Wali</label>
                            <input type="text" name="wali[nama]" id="wali_nama" class="form-control" value="{{ old('wali.nama', $siswa->wali->nama ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="wali_pekerjaan" class="form-label">Pekerjaan Wali</label>
                            <input type="text" name="wali[pekerjaan]" id="wali_pekerjaan" class="form-control" value="{{ old('wali.pekerjaan', $siswa->wali->pekerjaan ?? '') }}">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="alamat_wali" class="form-label">Alamat Wali</label>
                            <textarea name="wali[alamat]" id="alamat_wali" rows="2" class="form-control">{{ old('wali.alamat', $siswa->wali->alamat ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- C. PENDAFTARAN --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-pen-fancy text-warning"></i>
                        C. DATA PENDAFTARAN
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                            <input type="text" name="sekolah_asal" id="sekolah_asal" class="form-control" value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', $siswa->tanggal_diterima) }}">
                        </div>
                        <div class="form-group">
                            <label for="status_keluarga" class="form-label">Status Keluarga</label>
                            <input type="text" name="status_keluarga" id="status_keluarga" class="form-control" value="{{ old('status_keluarga', $siswa->status_keluarga) }}">
                        </div>
                        <div class="form-group">
                            <label for="anak_ke" class="form-label">Anak Ke-</label>
                            <input type="number" name="anak_ke" id="anak_ke" class="form-control" value="{{ old('anak_ke', $siswa->anak_ke) }}" min="1">
                        </div>
                        <div class="form-group">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="catatan_wali_kelas" class="form-label">Catatan Wali Kelas</label>
                            <textarea name="catatan_wali_kelas" id="catatan_wali_kelas" rows="2" class="form-control">{{ old('catatan_wali_kelas', $siswa->catatan_wali_kelas) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- D. DATA PKL --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-briefcase text-info"></i>
                        D. DATA PKL
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="pkl_nilai" class="form-label">Nilai PKL</label>
                            <input type="text" name="pkl_nilai" id="pkl_nilai" class="form-control @error('pkl_nilai') is-invalid @enderror" value="{{ old('pkl_nilai', $siswa->pkl_nilai) }}">
                            @error('pkl_nilai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="pkl_sertifikat" class="form-label">Sertifikat PKL</label>
                            <input type="text" name="pkl_sertifikat" id="pkl_sertifikat" class="form-control @error('pkl_sertifikat') is-invalid @enderror" value="{{ old('pkl_sertifikat', $siswa->pkl_sertifikat) }}">
                            @error('pkl_sertifikat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="pkl_nama_industri" class="form-label">Nama Industri</label>
                            <input type="text" name="pkl_nama_industri" id="pkl_nama_industri" class="form-control @error('pkl_nama_industri') is-invalid @enderror" value="{{ old('pkl_nama_industri', $siswa->pkl_nama_industri) }}">
                            @error('pkl_nama_industri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="pkl_alamat" class="form-label">Alamat Industri</label>
                            <textarea name="pkl_alamat" id="pkl_alamat" rows="2" class="form-control @error('pkl_alamat') is-invalid @enderror">{{ old('pkl_alamat', $siswa->pkl_alamat) }}</textarea>
                            @error('pkl_alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- E. IJAZAH / KELULUSAN --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-certificate text-success"></i>
                        E. IJAZAH / KELULUSAN
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="ijazah_nomor" class="form-label">Nomor Ijazah</label>
                            <input type="text" name="ijazah_nomor" id="ijazah_nomor" class="form-control @error('ijazah_nomor') is-invalid @enderror" value="{{ old('ijazah_nomor', $siswa->ijazah_nomor) }}">
                            @error('ijazah_nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="ijazah_tanggal" class="form-label">Tanggal Ijazah</label>
                            <input type="date" name="ijazah_tanggal" id="ijazah_tanggal" class="form-control @error('ijazah_tanggal') is-invalid @enderror" value="{{ old('ijazah_tanggal', $siswa->ijazah_tanggal) }}">
                            @error('ijazah_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="transkip_nomor" class="form-label">Nomor Transkip</label>
                            <input type="text" name="transkip_nomor" id="transkip_nomor" class="form-control @error('transkip_nomor') is-invalid @enderror" value="{{ old('transkip_nomor', $siswa->transkip_nomor) }}">
                            @error('transkip_nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="transkip_tanggal" class="form-label">Tanggal Transkip</label>
                            <input type="date" name="transkip_tanggal" id="transkip_tanggal" class="form-control @error('transkip_tanggal') is-invalid @enderror" value="{{ old('transkip_tanggal', $siswa->transkip_tanggal) }}">
                            @error('transkip_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lulus" class="form-label">Tanggal Lulus</label>
                            <input type="date" name="tanggal_lulus" id="tanggal_lulus" class="form-control @error('tanggal_lulus') is-invalid @enderror" value="{{ old('tanggal_lulus', $siswa->tanggal_lulus) }}">
                            @error('tanggal_lulus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_kelulusan" class="form-label">Status Kelulusan</label>
                            <select name="status_kelulusan" id="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror">
                                <option value="">Pilih</option>
                                <option value="Lulus" {{ old('status_kelulusan', $siswa->status_kelulusan) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="Tidak Lulus" {{ old('status_kelulusan', $siswa->status_kelulusan) == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                            @error('status_kelulusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- F. STATUS MUTASI --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-exchange-alt text-danger"></i>
                        F. STATUS MUTASI
                    </div>
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="status_mutasi" class="form-label">Status</label>
                            <select name="status_mutasi" id="status_mutasi" class="form-select">
                                <option value="aktif" {{ old('status_mutasi', $siswa->mutasiTerakhir->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="pindah" {{ old('status_mutasi', $siswa->mutasiTerakhir->status ?? '') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                                <option value="keluar" {{ old('status_mutasi', $siswa->mutasiTerakhir->status ?? '') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mutasi" class="form-label">Tanggal Mutasi</label>
                            <input type="date" name="tanggal_mutasi" id="tanggal_mutasi" class="form-control" value="{{ old('tanggal_mutasi', $siswa->mutasiTerakhir->tanggal_mutasi ?? '') }}">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="keterangan_mutasi" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan_mutasi" id="keterangan_mutasi" class="form-control" value="{{ old('keterangan_mutasi', $siswa->mutasiTerakhir->keterangan ?? '') }}" placeholder="Alasan mutasi...">
                        </div>
                        <div class="form-group">
                            <label for="tujuan_pindah" class="form-label">Sekolah Tujuan</label>
                            <input type="text" name="tujuan_pindah" id="tujuan_pindah" class="form-control" value="{{ old('tujuan_pindah', $siswa->mutasiTerakhir->tujuan_pindah ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_sk_keluar" class="form-label">No. SK Keluar</label>
                            <input type="text" name="no_sk_keluar" id="no_sk_keluar" class="form-control" value="{{ old('no_sk_keluar', $siswa->mutasiTerakhir->no_sk_keluar ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sk_keluar" class="form-label">Tanggal SK Keluar</label>
                            <input type="date" name="tanggal_sk_keluar" id="tanggal_sk_keluar" class="form-control" value="{{ old('tanggal_sk_keluar', $siswa->mutasiTerakhir->tanggal_sk_keluar ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- FORM ACTION --}}
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('tu.buku-induk.show', $siswa->id) }}" class="btn-batal">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== PREVIEW FOTO ==========
    const fotoInput = document.getElementById('fotoInput');
    const fotoPreview = document.getElementById('fotoPreview');
    const fotoPlaceholder = document.getElementById('fotoPlaceholder');
    const removeFotoInput = document.getElementById('removeFoto');
    const btnRemoveFoto = document.getElementById('btnRemoveFoto');

    function showPreview(url) {
        if (fotoPreview) {
            fotoPreview.src = url;
            fotoPreview.style.display = 'block';
        }
        if (fotoPlaceholder) {
            fotoPlaceholder.style.display = 'none';
        }
        if (btnRemoveFoto) {
            btnRemoveFoto.style.display = 'inline-flex';
        }
    }

    function showPlaceholder() {
        if (fotoPreview) {
            fotoPreview.src = '';
            fotoPreview.style.display = 'none';
        }
        if (fotoPlaceholder) {
            fotoPlaceholder.style.display = 'flex';
        }
        if (btnRemoveFoto) {
            btnRemoveFoto.style.display = 'none';
        }
    }

    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    showPreview(event.target.result);
                    removeFotoInput.value = '0';
                };
                reader.readAsDataURL(file);
            } else if (!fotoPreview.src) {
                showPlaceholder();
            }
        });
    }

    if (btnRemoveFoto) {
        btnRemoveFoto.addEventListener('click', function() {
            if (confirm('Yakin ingin menghapus foto siswa ini?')) {
                removeFotoInput.value = '1';
                if (fotoInput) fotoInput.value = '';
                showPlaceholder();
            }
        });
    }

    // ========== VALIDASI STATUS MUTASI ==========
    const statusMutasi = document.getElementById('status_mutasi');
    if (statusMutasi) {
        const fields = ['tanggal_mutasi', 'tujuan_pindah', 'no_sk_keluar', 'tanggal_sk_keluar'];

        function toggleMutasiFields() {
            const isActive = statusMutasi.value === 'aktif';
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.disabled = isActive;
                    if (isActive) el.value = '';
                }
            });
        }

        statusMutasi.addEventListener('change', toggleMutasiFields);
        toggleMutasiFields();
    }
});
</script>
@endpush

@endsection