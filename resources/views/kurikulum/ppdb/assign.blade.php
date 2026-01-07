@extends('layouts.app')

@section('title', 'PPDB - Assign Rombel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Data Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h4>{{ $entry->nama_lengkap }}</h4>
                            <p class="text-muted">NISN: {{ $entry->nisn ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-warning fs-6">Status: {{ $entry->status }}</span>
                        </div>
                    </div>

                    @if($entry->foto)
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <div class="mb-2">
                                <strong>Foto Pendaftar</strong>
                            </div>
                            <img src="{{ asset('storage/' . $entry->foto) }}" 
                                 alt="Foto {{ $entry->nama_lengkap }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 250px;">
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tempat, Tanggal Lahir</strong>
                            <div>{{ $entry->tempat_lahir ?? '-' }}, {{ $entry->tanggal_lahir ? date('d/m/Y', strtotime($entry->tanggal_lahir)) : '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Kelamin</strong>
                            <div>{{ $entry->jenis_kelamin ?? '-' }}</div>
                        </div>
                    </div>

                    <hr>
                    <h6>Informasi PPDB</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Jurusan</strong>
                            <div>{{ optional($entry->jurusan)->nama ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Sesi PPDB</strong>
                            <div>{{ optional($entry->sesi)->tahun_ajaran ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Jalur PPDB</strong>
                            <div>{{ optional($entry->jalur)->nama_jalur ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tahun Ajaran</strong>
                            <div>{{ $entry->tahun_ajaran ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Diterima</strong>
                            <div>{{ $entry->tanggal_diterima ? date('d/m/Y', strtotime($entry->tanggal_diterima)) : '-' }}</div>
                        </div>
                    </div>

                    <hr>
                    <h6>Alamat</h6>
                    <p>{{ $entry->alamat ?? '-' }}</p>

                    <hr>
                    <h6>Data Orang Tua</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Ayah</strong>
                            <p>Nama: {{ $entry->nama_ayah ?? '-' }}<br>
                            Pekerjaan: {{ $entry->pekerjaan_ayah ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Ibu</strong>
                            <p>Nama: {{ $entry->nama_ibu ?? '-' }}<br>
                            Pekerjaan: {{ $entry->pekerjaan_ibu ?? '-' }}</p>
                        </div>
                    </div>

                    <hr>
                    <h6>Dokumen</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>KK:</strong>
                                    @if($entry->kk)
                                        <span class="text-success">✓ <a href="{{ asset('storage/' . $entry->kk) }}" target="_blank">Lihat File</a></span>
                                    @else
                                        <span class="text-danger">✗ Tidak ada</span>
                                    @endif
                                </li>
                                <li><strong>Akta:</strong>
                                    @if($entry->akta)
                                        <span class="text-success">✓ <a href="{{ asset('storage/' . $entry->akta) }}" target="_blank">Lihat File</a></span>
                                    @else
                                        <span class="text-danger">✗ Tidak ada</span>
                                    @endif
                                </li>
                                <li><strong>Ijazah:</strong>
                                    @if($entry->ijazah)
                                        <span class="text-success">✓ <a href="{{ asset('storage/' . $entry->ijazah) }}" target="_blank">Lihat File</a></span>
                                    @else
                                        <span class="text-danger">✗ Tidak ada</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Foto:</strong>
                                    @if($entry->foto)
                                        <span class="text-success">✓ <a href="{{ asset('storage/' . $entry->foto) }}" target="_blank">Lihat File</a></span>
                                    @else
                                        <span class="text-danger">✗ Tidak ada</span>
                                    @endif
                                </li>
                                <li><strong>Bukti Jalur:</strong>
                                    @if($entry->bukti_jalur)
                                        <span class="text-success">✓ <a href="{{ asset('storage/' . $entry->bukti_jalur) }}" target="_blank">Lihat File</a></span>
                                    @else
                                        <span class="text-danger">✗ Tidak ada</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Assign ke Rombel</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kurikulum.ppdb.assign', $entry->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Pilih Rombel (Kelas X, sesuai jurusan) <span class="text-danger">*</span></label>
                            <select name="rombel_id" class="form-select @error('rombel_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Rombel --</option>
                                @foreach($rombels as $r)
                                    <option value="{{ $r->id }}" {{ old('rombel_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama }} 
                                        @if($r->kelas) ({{ optional($r->kelas)->tingkat }}) @endif
                                        @if($r->guru) - {{ optional($r->guru)->nama }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('rombel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Hanya menampilkan rombel Kelas X pada jurusan pendaftar.</small>
                            @if($rombels->isEmpty())
                                <div class="alert alert-warning mt-2">Tidak ada rombel Kelas X untuk jurusan ini. Buat rombel Kelas X terlebih dahulu atau pilih jurusan lain.</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIS (opsional)</label>
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" 
                                   value="{{ old('nis') }}" placeholder="Kosongkan untuk generate otomatis">
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jika dikosongkan, sistem akan generate NIS otomatis</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="createAccount" checked>
                                <label class="form-check-label" for="createAccount">
                                    Buat akun login untuk siswa
                                </label>
                            </div>
                            <small class="text-muted">Username dan password awal = NIS</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" {{ $rombels->isEmpty() ? 'disabled' : '' }}>
                                <i class="fas fa-save"></i> Simpan & Buat NIS
                            </button>
                            <a href="{{ route('kurikulum.ppdb.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
            <div class="card mt-3 border-success">
                <div class="card-body bg-light">
                    <h6 class="text-success">Informasi Akun Siswa</h6>
                    <p class="mb-0 small">{!! session('success') !!}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection