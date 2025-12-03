@extends('layouts.app')

@section('title', 'Catatan Wali Kelas')

@section('content')
<div class="container mt-4">
    <h3>Catatan Wali Kelas</h3>

    <div class="card shadow">
        <div class="card-body">
            @if (isset($siswa->catatan_wali_kelas) && !empty($siswa->catatan_wali_kelas))
                <div class="alert alert-info">
                    <p>{{ $siswa->catatan_wali_kelas }}</p>
                    <small class="text-muted">Diperbarui pada: {{ $siswa->updated_at->format('d F Y H:i') }}</small>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Catatan</h5>
                    <p class="text-muted">Belum ada catatan dari wali kelas untuk Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection