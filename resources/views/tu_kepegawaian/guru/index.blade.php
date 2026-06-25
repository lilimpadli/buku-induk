@extends('layouts.app')
@section('title', 'Daftar Guru TU Kepegawaian')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <h3 class="mb-0">Daftar Guru TU Kepegawaian</h3>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#templateGuruModal">
                <i class="fas fa-download"></i> Download Template
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importGuruModal">
                <i class="fas fa-upload"></i> Import Excel
            </button>
        </div>
    </div>

    <!-- MODAL TEMPLATE -->
    <div class="modal fade" id="templateGuruModal" tabindex="-1" aria-labelledby="templateGuruModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateGuruModalLabel">Download Template Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="templateGuruForm" method="GET" action="{{ route('tu_kepegawaian.guru.template') }}">
                    <div class="modal-body">
                        <p class="small text-muted">Pilih kolom yang akan disertakan pada file template Excel.</p>
                        <div class="row g-2">
                            @php
                                $templateFields = [
                                    'nama' => 'Nama',
                                    'nip' => 'NIP',
                                    'status_kepegawaian' => 'Status Kepegawaian',
                                    'pendidikan' => 'Pendidikan',
                                    'gelar_depan' => 'Gelar Depan',
                                    'gelar_belakang' => 'Gelar Belakang',
                                ];
                            @endphp
                            @foreach($templateFields as $key => $label)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fields[]" value="{{ $key }}" id="templateField_{{ $key }}" checked>
                                        <label class="form-check-label" for="templateField_{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT -->
    <div class="modal fade" id="importGuruModal" tabindex="-1" aria-labelledby="importGuruModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importGuruModalLabel">Import Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tu_kepegawaian.guru.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih kolom yang akan diimport</label>
                            <div class="row g-2">
                                @php
                                    $importFields = [
                                        'nama' => 'Nama',
                                        'nip' => 'NIP',
                                        'status_kepegawaian' => 'Status Kepegawaian',
                                        'pendidikan' => 'Pendidikan',
                                        'gelar_depan' => 'Gelar Depan',
                                        'gelar_belakang' => 'Gelar Belakang',
                                    ];
                                @endphp
                                @foreach($importFields as $key => $label)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_columns[]" value="{{ $key }}" id="importField_{{ $key }}" checked>
                                            <label class="form-check-label" for="importField_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <p class="small text-muted">Header Excel harus sesuai nama kolom di atas, atau gunakan nama default jika tidak berubah.</p>
                        @if(session('import_errors'))
                            <div class="alert alert-warning">
                                <ul class="mb-0">
                                    @foreach(session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABEL REKAP (Hanya muncul jika difilter) --}}
    @if(isset($isFiltered) && $isFiltered)
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">Tabel Keadaan Tenaga Pendidik</div>
        <div class="table-responsive">
            <table class="table table-bordered text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle">Total</th>
                        <th colspan="2">Jenis Kelamin</th>
                        <th colspan="3">Pendidikan</th>
                        <th colspan="2">Sertifikasi</th>
                    </tr>
                    <tr>
                        <th>L</th><th>P</th>
                        <th>D4</th><th>S1</th><th>S2</th>
                        <th>Sudah</th><th>Belum</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $rekap['Total'] ?? 0 }}</td>
                        <td>{{ $rekap['L'] ?? 0 }}</td>
                        <td>{{ $rekap['P'] ?? 0 }}</td>
                        <td>{{ $rekap['D4'] ?? 0 }}</td>
                        <td>{{ $rekap['S1'] ?? 0 }}</td>
                        <td>{{ $rekap['S2'] ?? 0 }}</td>
                        <td>{{ $rekap['Sertif_Sudah'] ?? 0 }}</td>
                        <td>{{ ($rekap['Total'] ?? 0) - ($rekap['Sertif_Sudah'] ?? 0) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- FORM FILTER --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('tu_kepegawaian.data-guru.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Cari Guru</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama/NIP..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                            <option value="Honorer" {{ request('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                            <option value="Guru Tetap Yayasan" {{ request('status_kepegawaian') == 'Guru Tetap Yayasan' ? 'selected' : '' }}>Guru Tetap Yayasan</option>
                            <option value="Guru Tidak Tetap" {{ request('status_kepegawaian') == 'Guru Tidak Tetap' ? 'selected' : '' }}>Guru Tidak Tetap</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">Semua Pendidikan</option>
                            <option value="S1" {{ request('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ request('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ request('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                            <option value="D4" {{ request('pendidikan') == 'D4' ? 'selected' : '' }}>D4</option>
                            <option value="D3" {{ request('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('tu_kepegawaian.data-guru.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-rotate-right"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL UTAMA --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="min-width: 160px;">Nama</th>
                        <th style="min-width: 140px;">NIP</th>
                        <th style="min-width: 100px;">Status</th>
                        <th style="width: 40px;">JK</th>
                        <th style="width: 80px;">Pendidikan</th>
                        <th style="min-width: 100px;">Gelar Depan</th>
                        <th style="min-width: 120px;">Gelar Belakang</th>
                        <th style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $guru)
                        <tr>
                            <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                            <td class="fw-semibold">{{ $guru->nama }}</td>
                            <td>{{ $guru->nip ?? '-' }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'PNS' => 'primary',
                                        'PPPK' => 'info',
                                        'Honorer' => 'warning',
                                        'Guru Tetap Yayasan' => 'success',
                                        'Guru Tidak Tetap' => 'secondary'
                                    ];
                                    $color = $statusColors[$guru->status_kepegawaian] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} text-white">
                                    {{ $guru->status_kepegawaian ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $guru->jenis_kelamin ?? '-' }}</td>
                            <td>
                                @if($guru->pendidikan)
                                    <span class="badge bg-secondary">{{ $guru->pendidikan }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $guru->gelar_depan ?? '-' }}</td>
                            <td>{{ $guru->gelar_belakang ?? '-' }}</td>
                            <td>
                                <a href="{{ route('tu_kepegawaian.data-guru.show', $guru->id) }}" 
                                   class="btn btn-sm btn-info text-white" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="fas fa-user-slash fa-2x d-block mb-2"></i>
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span class="text-muted small">
                Menampilkan {{ $gurus->firstItem() ?? 0 }} - {{ $gurus->lastItem() ?? 0 }} dari {{ $gurus->total() }} guru
            </span>
        </div>
        <div>
            {{ $gurus->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection