@extends('layouts.app')

@section('title', 'Riwayat Rapor - ' . ($siswa->nama_lengkap ?? 'Siswa'))

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3>
            <i class="fas fa-file-alt text-primary"></i> Riwayat Rapor
        </h3>
        <div>
            <a href="{{ route('tu.alumni.show', $siswa->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Profil
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $siswa->nama_lengkap ?? 'Siswa' }}</h5>
        </div>
        <div class="card-body">

            @if($raports->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-file-alt" style="font-size: 48px; color: #cbd5e1;"></i>
                    <h5 class="mt-3 text-muted">Belum ada rapor</h5>
                    <p class="text-muted">Belum ada rapor tersimpan untuk alumni ini.</p>
                </div>
            @else
                <div class="list-group">
                    @foreach($raports as $r)
                        <a href="{{ route('tu.alumni.raport.show', [
                            'siswa_id' => $siswa->id,
                            'semester' => $r->semester,
                            'tahun' => str_replace('/', '-', $r->tahun_ajaran)
                        ]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <strong>Semester {{ $r->semester ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">Tahun Ajaran: {{ $r->tahun_ajaran ?? '-' }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">Lihat</span>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection