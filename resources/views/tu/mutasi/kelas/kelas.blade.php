@extends('layouts.app')

@section('title', 'Kelas Jurusan - ' . ($jurusan->nama ?? 'Umum'))

@section('content')
<style>
    :root {
        --primary: #2F53FF;
        --secondary: #6366F1;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #1E293B;
        margin: 0;
    }

    .kelas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .kelas-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        border-top: 4px solid var(--primary);
    }

    .kelas-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .kelas-card-body {
        padding: 20px;
    }

    .kelas-card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .kelas-card-info {
        color: #475569;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .rombel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .rombel-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        border-top: 4px solid var(--secondary);
    }

    .rombel-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .rombel-card-body {
        padding: 20px;
    }

    .rombel-card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .rombel-card-meta {
        color: #475569;
        font-size: 13px;
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-primary, .btn-secondary {
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 600;
    }

    .btn-secondary {
        border: 1px solid #E2E8F0;
        color: #475569;
        background: white;
    }

    .btn-secondary:hover {
        background: #F8FAFC;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748B;
    }
</style>

<div class="container-fluid mt-4">
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelas Jurusan</h1>
            <p class="text-muted mb-0">{{ $jurusan->nama ?? 'Umum' }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('tu.mutasi.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('tu.kelas.index', ['jurusan' => $jurusan->id]) }}" class="btn btn-primary">Lihat Semua Kelas</a>
        </div>
    </div>

    @php
        $rombels = $jurusan->kelas->flatMap(function($kelas) {
            return $kelas->rombels->map(function($rombel) use ($kelas) {
                $rombel->kelas = $kelas;
                return $rombel;
            });
        });
    @endphp

    <div class="rombel-grid">
        @forelse($rombels as $rombel)
            <div class="rombel-card">
                <div class="rombel-card-body">
                    <h2 class="rombel-card-title">{{ $rombel->nama }}</h2>
                    <p class="rombel-card-meta">
                        Kelas: {{ $rombel->kelas->tingkat ?? '-' }} {{ $jurusan->nama }}<br>
                        Total Siswa: {{ $rombel->siswas->count() }}<br>
                        Wali Rombel: {{ optional($rombel->guru)->nama ?? '-' }}
                    </p>
                    <a href="{{ route('tu.mutasi.kelas.show', $rombel->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> Detail Siswa
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <p>Tidak ada rombel untuk jurusan ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection