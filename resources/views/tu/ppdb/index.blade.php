@extends('layouts.app')

@section('title','PPDB - Penugasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">PPDB - Pendaftar</h3>
    <form class="d-flex" method="GET" action="{{ route('tu.ppdb.index') }}">
        <input name="q" value="{{ $q ?? '' }}" class="form-control form-control-sm me-2" placeholder="Cari nama atau NISN">
        <button class="btn btn-primary btn-sm">Cari</button>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @forelse($ppdb as $p)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:72px;height:72px;flex:0 0 72px;">
                        @if($p->foto)
                            <img src="{{ asset('storage/' . $p->foto) }}" class="rounded" style="width:72px;height:72px;object-fit:cover;">
                        @else
                            <div class="bg-secondary rounded text-white d-flex align-items-center justify-content-center" style="width:72px;height:72px;">No</div>
                        @endif
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $p->nama_lengkap }}</h5>
                        <small class="text-muted">NISN: {{ $p->nisn ?? '-' }}</small>
                        <div class="mt-2"><strong>Jenis Kelamin:</strong> {{ $p->jenis_kelamin ?? '-' }}</div>
                        <div class="mt-1"><strong>Jurusan:</strong> {{ $p->jurusan_id ? optional($p->jurusan)->nama : '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between">
                <a href="{{ route('tu.ppdb.show', $p->id) }}" class="btn btn-sm btn-outline-primary">Assign ke Rombel</a>
                <small class="text-muted">{{ $p->created_at->format('d M Y') }}</small>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Tidak ada pendaftar baru untuk ditugaskan.</div>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $ppdb->links() }}</div>

@endsection
