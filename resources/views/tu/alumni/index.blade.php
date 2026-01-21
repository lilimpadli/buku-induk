@extends('layouts.app')

@section('title', 'Data Alumni')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3>Data Alumni</h3>
    </div>

    <!-- Search Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('tu.alumni.index') }}" class="d-flex gap-2">
                <select name="tahun_ajaran" class="form-select" id="tahunAjaranSelect">
                    <option value="">-- Semua Tahun Ajaran --</option>
                    @foreach($tahunAjaranList as $tahun)
                        <option value="{{ $tahun }}" {{ $tahunSearch == $tahun ? 'selected' : '' }}>
                            Tahun Ajaran {{ $tahun }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if($tahunSearch)
                    <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Card Grid -->
    @if(empty($allJurusanCards))
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> Tidak ada jurusan atau alumni.
        </div>
    @else
        <div class="row g-4">
            @foreach($allJurusanCards as $cardKey => $card)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">
                                <small>{{ $card['tahun'] }}</small>
                            </h6>
                            <h5 class="card-title mb-3">
                                {{ $card['jurusan'] }}
                            </h5>
                            <p class="card-text text-secondary mb-3">
                                <i class="bi bi-people"></i>
                                <strong>{{ $card['count'] }} Alumni</strong>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top">
                            @if($card['count'] > 0)
                                <a href="{{ route('tu.alumni.by-jurusan', [$card['tahun'], $card['jurusan_id']]) }}" class="btn btn-sm btn-primary w-100">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary w-100" disabled>
                                    <i class="bi bi-lock"></i> Tidak Ada Data
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        transform: translateY(-2px);
    }
</style>
@endsection
