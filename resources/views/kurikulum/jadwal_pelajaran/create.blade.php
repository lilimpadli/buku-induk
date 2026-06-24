{{-- resources/views/kurikulum/jadwal_pelajaran/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jadwal Pelajaran')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-secondary-custom {
        background: #E2E8F0;
        border: none;
        color: #475569;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary-custom:hover {
        background: #CBD5E1;
        color: #1E293B;
    }

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .form-card .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #334155;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.8rem;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #EF4444;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #EF4444;
    }

    .text-muted-small {
        font-size: 0.7rem;
        color: #94A3B8;
        margin-top: 0.2rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.05rem;
        }
        .form-card .card-body {
            padding: 1rem;
        }
        .btn-gradient, .btn-secondary-custom {
            width: 100%;
            justify-content: center;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-plus-circle me-2"></i> Tambah Jadwal Pelajaran</h3>
                <div class="text-muted">Tambahkan data jadwal pelajaran baru</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.jadwal-pelajaran.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card form-card">
        <div class="card-body">
            <form action="{{ route('kurikulum.jadwal-pelajaran.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" id="tahun_ajaran_id" name="tahun_ajaran_id">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->is_current ? '(Berjalan)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                        <select class="form-select @error('semester_id') is-invalid @enderror" id="semester_id" name="semester_id">
                            <option value="">Pilih Semester</option>
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}" {{ old('semester_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->label }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="rombel_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select @error('rombel_id') is-invalid @enderror" id="rombel_id" name="rombel_id">
                            <option value="">Pilih Kelas</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}" {{ old('rombel_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('rombel_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('mata_pelajaran_id') is-invalid @enderror" id="mata_pelajaran_id" name="mata_pelajaran_id">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mataPelajarans as $mp)
                                <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                    {{ $mp->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="guru_id" class="form-label">Guru Pengajar <span class="text-danger">*</span></label>
                        <select class="form-select @error('guru_id') is-invalid @enderror" id="guru_id" name="guru_id">
                            <option value="">Pilih Guru</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                        <select class="form-select @error('hari') is-invalid @enderror" id="hari" name="hari">
                            <option value="">Pilih Hari</option>
                            @foreach($hariList as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>
                                    {{ $h }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="jam_pelajaran_id" class="form-label">Jam Pelajaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('jam_pelajaran_id') is-invalid @enderror" id="jam_pelajaran_id" name="jam_pelajaran_id">
                            <option value="">Pilih Jam</option>
                            @foreach($jamPelajarans as $jp)
                                <option value="{{ $jp->id }}" {{ old('jam_pelajaran_id') == $jp->id ? 'selected' : '' }}>
                                    {{ $jp->kode_jam }} ({{ $jp->waktu }})
                                </option>
                            @endforeach
                        </select>
                        @error('jam_pelajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="jam_ke" class="form-label">Jam Ke- <span class="text-danger">*</span></label>
                        <input type="number"
                               class="form-control @error('jam_ke') is-invalid @enderror"
                               id="jam_ke"
                               name="jam_ke"
                               placeholder="Contoh: 1, 2, 3"
                               value="{{ old('jam_ke', 1) }}">
                        @error('jam_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted-small">Urutan jam pada hari tersebut</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ruang_kelas_id" class="form-label">Ruang Kelas</label>
                        <select class="form-select @error('ruang_kelas_id') is-invalid @enderror" id="ruang_kelas_id" name="ruang_kelas_id">
                            <option value="">Pilih Ruang (Opsional)</option>
                            @foreach($ruangKelas as $rk)
                                <option value="{{ $rk->id }}" {{ old('ruang_kelas_id') == $rk->id ? 'selected' : '' }}>
                                    {{ $rk->kode_ruang }} - {{ $rk->nama_ruang }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruang_kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="is_active" class="form-label">Status Aktif</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan"
                              name="keterangan"
                              rows="2"
                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn-gradient">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.jadwal-pelajaran.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
    }, 3000);
</script>
@endsection