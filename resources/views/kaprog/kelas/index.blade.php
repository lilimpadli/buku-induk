@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kelas</h5>
            
        </div>
    </div>

    <div class="row g-3">
        @if(isset($jurusan) && isset($rombels))
            <div class="col-12 mb-3">
                <h6>Jurusan: <strong>{{ $jurusan->nama }}</strong></h6>
            </div>
            @foreach($rombels as $r)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $r->nama }}</h5>
                                <div class="text-muted small">Kelas: {{ $r->kelas->tingkat ?? '-' }}</div>
                                <div class="text-muted small">Siswa: {{ $r->siswa()->count() }}</div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('kaprog.kelas.show', $r->id) }}" class="btn btn-sm btn-primary rounded-pill">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif(isset($jurusans))
            @foreach($jurusans as $jr)
                <div class="col-12 mb-2">
                    <h6 class="mb-1">Jurusan: <strong>{{ $jr->nama }}</strong></h6>
                </div>

                @foreach($jr->kelas as $k)
                    @foreach($k->rombels as $r)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card shadow-sm p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $r->nama }}</h5>
                                        <div class="text-muted small">Kelas: {{ $k->tingkat }}</div>
                                        <div class="text-muted small">Siswa: {{ $r->siswa()->count() }}</div>
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('kaprog.kelas.show', $r->id) }}" class="btn btn-sm btn-primary rounded-pill">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        @else
            <div class="col-12">Tidak ada data kelas.</div>
        @endif
    </div>
</div>
@endsection
