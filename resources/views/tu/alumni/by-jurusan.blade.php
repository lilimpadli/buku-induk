@extends('layouts.app')

@section('title', 'Alumni - ' . $namaJurusan)

@section('content')
<div class="container py-4">
    <!-- Back Button & Filter -->
    <div class="mb-4">
        <div class="row align-items-end gap-2">
            <div class="col-auto">
                <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId]) }}" class="d-flex gap-2">
                    <select name="tahun" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit();">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <option value="Semua Tahun" {{ $tahun === 'Semua Tahun' ? 'selected' : '' }}>Semua Tahun Ajaran</option>
                        @forelse($tahunAjaranList as $t)
                            <option value="{{ $t }}" {{ $tahun === $t ? 'selected' : '' }}>
                                Tahun Ajaran {{ $t }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h3 class="mb-1">Alumni {{ $namaJurusan }}</h3>
        <small class="text-muted">Tahun Ajaran: {{ $tahun }}</small>
    </div>

    <div class="card shadow-sm">
        @if(count($alumni) > 0)

            {{-- DESKTOP TABLE --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 30%">Nama Siswa</th>
                            <th style="width: 12%">NIS</th>
                            <th style="width: 12%">NISN</th>
                            <th style="width: 15%">Kelas</th>
                            <th style="width: 15%">Rombel</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($data['siswa']->foto)
                                            <img src="{{ asset('storage/' . $data['siswa']->foto) }}" class="rounded-circle" width="32" height="32" alt="{{ $data['siswa']->nama_lengkap }}" style="object-fit: cover;">
                                        @else
                                            <div class="avatar-initials rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                        <strong>{{ $data['siswa']->nama_lengkap }}</strong>
                                    </div>
                                </td>
                                <td>{{ $data['siswa']->nis }}</td>
                                <td>{{ $data['siswa']->nisn }}</td>
                                <td><span class="badge bg-secondary">{{ $data['kelas'] }}</span></td>
                                <td>{{ $data['rombel'] }}</td>
                                <td>
                                    <a href="{{ route('tu.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE CARD LIST --}}
            <div class="d-md-none">
                @foreach($alumni as $index => $data)
                    <div class="mobile-card {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3 min-width-0">
                                {{-- Avatar --}}
                                @if($data['siswa']->foto)
                                    <img src="{{ asset('storage/' . $data['siswa']->foto) }}" class="rounded-circle flex-shrink-0" width="44" height="44" alt="{{ $data['siswa']->nama_lengkap }}" style="object-fit: cover;">
                                @else
                                    <div class="avatar-initials-mobile rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0">
                                        {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- Info --}}
                                <div class="min-width-0">
                                    <div class="fw-semibold text-truncate">{{ $data['siswa']->nama_lengkap }}</div>
                                    <div class="text-muted" style="font-size: 13px;">
                                        <span class="badge bg-secondary me-1">{{ $data['kelas'] }}</span>
                                        {{ $data['rombel'] }}
                                    </div>
                                </div>
                            </div>

                            {{-- Detail Button --}}
                            <a href="{{ route('tu.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary flex-shrink-0">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>

                        <div class="mobile-meta mt-2 ms-0 ms-sm-4 ps-0 ps-sm-3" style="margin-left: 60px;">
                            <div class="d-flex flex-wrap gap-x-3 gap-y-1">
                                <span><span class="text-muted">NIS:</span> {{ $data['siswa']->nis }}</span>
                                <span><span class="text-muted">NISN:</span> {{ $data['siswa']->nisn }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="alert alert-info m-0">
                <i class="bi bi-info-circle"></i> Tidak ada alumni untuk jurusan ini pada tahun ajaran {{ $tahun }}.
            </div>
        @endif
    </div>
</div>

<style>
    /* ===== DESKTOP TABLE ===== */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        border-radius: 8px;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 15px;
        border: none;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.04);
    }

    /* ===== SHARED AVATAR ===== */
    .avatar-initials {
        width: 32px;
        height: 32px;
        font-size: 12px;
        font-weight: 600;
    }

    .avatar-initials-mobile {
        width: 44px;
        height: 44px;
        font-size: 16px;
        font-weight: 600;
        color: #475569;
    }

    /* ===== MOBILE CARD ===== */
    .mobile-card {
        padding: 14px 16px;
        border-color: #E2E8F0;
    }

    .mobile-card:last-child {
        border-bottom: none;
    }

    .mobile-meta {
        font-size: 13px;
        color: #64748B;
    }

    .mobile-meta .text-muted {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
        color: #94A3B8;
    }

    /* ===== UTILITY ===== */
    .min-width-0 {
        min-width: 0;
    }

    .gap-x-3 {
        column-gap: 1rem;
    }
</style>
@endsection