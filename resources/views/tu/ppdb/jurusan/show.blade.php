@extends('layouts.app')

@section('title', 'PPDB - Detail Jurusan: ' . $jurusan->nama)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Jurusan: {{ $jurusan->nama }}</h5>
            <div>
                <a href="{{ route('kurikulum.ppdb.jurusan.pendaftar', $jurusan->id) }}" class="btn btn-sm btn-success me-2">
                    <i class="fas fa-list"></i> Lihat Isinya
                </a>
                <a href="{{ route('kurikulum.ppdb.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jurusan
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="mb-4">{{ $jurusan->deskripsi ?? 'Jurusan ini siap menerima pendaftar PPDB' }}</p>

            <!-- Sesi PPDB -->
            <div class="mb-5">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-calendar-alt"></i> Sesi PPDB
                </h6>
                <div class="row">
                    @forelse ($sesis as $i => $sesi)
                        <div class="col-md-4 mb-3">
                            @if($sesi->ppdb_count > 0)
                                <div class="card border-primary h-100">
                                    <div class="card-body">
                                        @php $stage = $i == 0 ? 'tahap1' : 'tahap2'; $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); @endphp
                                        <h6 class="card-title">Tahap {{ $i + 1 }}</h6>
                                        <p class="card-text small text-muted">
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">{{ $sesi->ppdb_count ?? 0 }} pendaftar</small>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('kurikulum.ppdb.jurusan.sesi.pendaftar', ['jurusanId' => $jurusan->id, 'sesiId' => $sesi->id]) }}" class="btn btn-sm btn-outline-primary">
                                                Lihat Semua Pendaftar Tahap {{ $i + 1 }}
                                            </a>
                                        </div>
                                      
                                    </div>
                                </div>
                            @else
                                <div class="card border-secondary h-100 opacity-50">
                                    <div class="card-body">
                                        @php $stage = $i == 0 ? 'tahap1' : 'tahap2'; $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); @endphp
                                        <h6 class="card-title">Tahap {{ $i + 1 }}</h6>
                                        <p class="card-text small text-muted">
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">{{ $sesi->ppdb_count ?? 0 }} pendaftar</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Tidak ada sesi PPDB untuk jurusan ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Jalur PPDB per Sesi (tabs) -->
            <div>
                <h6 class="text-primary mb-3">
                    <i class="fas fa-road"></i> Jalur PPDB
                </h6>

                {{-- Session pills --}}
                <ul class="nav nav-pills mb-3" id="sesiTabs" role="tablist">
                    @foreach($sesis as $i => $sesi)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($i==0) active @endif" id="tab-{{ $sesi->id }}" data-bs-toggle="pill" data-bs-target="#tab-content-{{ $sesi->id }}" type="button" role="tab" aria-controls="tab-content-{{ $sesi->id }}" aria-selected="{{ $i==0 ? 'true' : 'false' }}">
                                {{ $sesi->nama_sesi ?? 'Sesi ' . ($i+1) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($sesis as $i => $sesi)
                        <div class="tab-pane fade @if($i==0) show active @endif" id="tab-content-{{ $sesi->id }}" role="tabpanel" aria-labelledby="tab-{{ $sesi->id }}">
                            <div class="row">
                                @if(!empty($sesi->jalurs) && count($sesi->jalurs) > 0)
                                    @foreach($sesi->jalurs as $jalur)
                                        <div class="col-md-6 mb-3">
                                            @if(($jalur->ppdb_count ?? 0) > 0)
                                                <a href="{{ route('kurikulum.ppdb.jurusan.jalur.pendaftar', [$jurusan->id, $jalur->id]) }}" class="text-decoration-none">
                                                    <div class="card border-info h-100">
                                                        <div class="card-body">
                                                            <h6 class="card-title">{{ $jalur->nama_jalur }}</h6>
                                                            <p class="card-text small">{{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="badge bg-info">{{ $jalur->kuota }} kuota</span>
                                                                <small class="text-muted">{{ $jalur->ppdb_count ?? 0 }} pendaftar</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <div class="card border-secondary h-100 opacity-50">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $jalur->nama_jalur }}</h6>
                                                        <p class="card-text small">{{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="badge bg-secondary">{{ $jalur->kuota }} kuota</span>
                                                            <small class="text-muted">{{ $jalur->ppdb_count ?? 0 }} pendaftar</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info">Tidak ada jalur PPDB untuk sesi ini</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection