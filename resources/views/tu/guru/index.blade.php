@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Guru</h3>
    </div>

    <!-- FILTER CARD -->
    <div class="card mb-3" style="border: 1px solid #E2E8F0; border-radius: 8px;">
        <div class="card-body" style="background-color: #F8FAFC;">
            <form method="GET" action="{{ route('tu.guru.index') }}" class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Guru</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:white;border:1px solid #E2E8F0;"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIP, atau email..." value="{{ $search ?? '' }}" style="border:1px solid #E2E8F0;">
                    </div>
                </div>

                <!-- Filter Jurusan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Jurusan</label>
                    <select name="jurusan" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('tu.guru.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>NIP</th>
                            <th>Mengajar (Kelas / Rombel)</th>
                            <th>Email</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $g)
                            <tr>
                                <td>{{ $loop->iteration + ($gurus->currentPage()-1) * $gurus->perPage() }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ optional($g->user)->nomor_induk }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>
                                    @if($g->rombels && $g->rombels->count())
                                        <ul class="mb-0">
                                            @foreach($g->rombels as $r)
                                                <li>
                                                    @php
                                                        $kelas = $r->kelas;
                                                    @endphp
                                                    {{ $kelas?->tingkat ? $kelas->tingkat . ' - ' . ($kelas->jurusan->nama ?? '') : '-' }} / {{ $r->nama }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $g->email }}</td>
                                <td>
                                    <a href="{{ route('tu.guru.show', $g->id) }}" class="btn btn-sm btn-primary" title="Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Belum ada guru</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $gurus->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
