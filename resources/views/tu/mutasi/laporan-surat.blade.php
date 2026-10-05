@extends('layouts.app')

@section('title', 'Laporan Surat Mutasi')

@section('content')

<style>
    :root { --primary: #4F46E5; --secondary: #7C3AED; }
    body { background: linear-gradient(180deg, #F8FAFF 0%, #EEF2FF 100%); }

    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px; padding: 32px; margin-bottom: 24px;
        color: white; box-shadow: 0 18px 35px rgba(15,23,42,.12);
    }
    .hero-title { font-size: 28px; font-weight: 800; margin: 0 0 6px; }
    .hero-subtitle { font-size: 14px; opacity: .85; margin: 0; }
    .hero-stats { display: flex; gap: 16px; margin-top: 20px; flex-wrap: wrap; }
    .hero-stat { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2); border-radius: 16px; padding: 12px 20px; }
    .hero-stat-value { font-size: 24px; font-weight: 800; }
    .hero-stat-label { font-size: 11px; opacity: .85; text-transform: uppercase; margin-top: 4px; }

    .card-modern {
        background: white; border-radius: 20px; padding: 24px;
        box-shadow: 0 10px 25px rgba(15,23,42,.08);
        border: 1px solid #EEF2FF; margin-bottom: 20px;
    }

    .filter-grid { display: grid; grid-template-columns: 2fr 1fr auto; gap: 14px; }
    .form-control, .form-select {
        height: 46px; border-radius: 12px; border: 1.5px solid #E2E8F0;
        padding: 0 16px; font-size: 14px; background: #F8FAFF;
    }
    .form-control:focus, .form-select:focus { outline: none; border-color: var(--primary); background: white; }

    .table-modern { width: 100%; border-collapse: collapse; }
    .table-modern thead th {
        background: #F8FAFF; padding: 14px 16px; font-size: 12px; font-weight: 700;
        color: #475569; text-align: left; border-bottom: 2px solid #EEF2FF;
        text-transform: uppercase; letter-spacing: .5px;
    }
    .table-modern tbody td { padding: 14px 16px; border-bottom: 1px solid #F1F5F9; font-size: 14px; color: #334155; vertical-align: middle; }
    .table-modern tbody tr:hover { background: #F8FAFF; }

    .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
    .badge-pindah { background: #DBEAFE; color: #2563EB; }
    .badge-do { background: #FEF3C7; color: #B45309; }

    .btn-modern {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 0 18px; height: 46px; border-radius: 12px;
        font-weight: 700; font-size: 13px; text-decoration: none; transition: all .25s;
        border: none; cursor: pointer;
    }
    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; }
    .btn-primary:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,70,229,.3); }

    .btn-action {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 10px;
        background: #EEF2FF; color: var(--primary); text-decoration: none;
        transition: all .2s;
    }
    .btn-action:hover { background: var(--primary); color: white; }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <div class="hero-banner">
        <h1 class="hero-title"><i class="fas fa-envelope-open-text me-2"></i> Laporan Surat Mutasi</h1>
        <p class="hero-subtitle">Riwayat surat mutasi pindah & DO siswa</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $stats['total_pindah'] }}</div>
                <div class="hero-stat-label">Total Pindah</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $stats['total_do'] }}</div>
                <div class="hero-stat-label">Total DO</div>
            </div>
        </div>
    </div>

    <div class="card-modern">
        <form method="GET">
            <div class="filter-grid">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / NIS / NISN..." value="{{ request('search') }}">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah Sekolah</option>
                    <option value="do" {{ request('status') == 'do' ? 'selected' : '' }}>DO (Putus Sekolah)</option>
                </select>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-modern" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Siswa</th>
                        <th>NIS / NISN</th>
                        <th>Kelas Asal</th>
                        <th>Status</th>
                        <th>Tujuan / Alasan</th>
                        <th>No. Surat</th>
                        <th>Tanggal</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $i => $m)
                        <tr>
                            <td>{{ $mutasis->firstItem() + $i }}</td>
                            <td><strong>{{ $m->siswa->nama_lengkap ?? '-' }}</strong></td>
                            <td>{{ $m->siswa->nis ?? '-' }}<br><small class="text-muted">{{ $m->siswa->nisn ?? '-' }}</small></td>
                            <td>{{ $m->rombelAsal->nama ?? '-' }}</td>
                            <td>
                                @if($m->status === 'pindah')
                                    <span class="badge-status badge-pindah"><i class="fas fa-paper-plane"></i> Pindah</span>
                                @else
                                    <span class="badge-status badge-do"><i class="fas fa-sign-out-alt"></i> DO</span>
                                @endif
                            </td>
                            <td>
                                @if($m->status === 'pindah')
                                    {{ $m->tujuan_pindah ?? '-' }}<br>
                                    <small class="text-muted">{{ $m->alasan_pindah ?? '-' }}</small>
                                @else
                                    <small class="text-muted">{{ $m->keterangan ?? '-' }}</small>
                                @endif
                            </td>
                            <td><small>{{ $m->no_sk_keluar ?? '-' }}</small></td>
                            <td>{{ $m->tanggal_mutasi ? \Carbon\Carbon::parse($m->tanggal_mutasi)->format('d M Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('tu.mutasi.surat-show', $m->id) }}" class="btn-action" target="_blank" title="Lihat Surat">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px; color: #94A3B8;">
                                <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                Belum ada data surat mutasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutasis->hasPages())
            <div style="padding: 20px;">
                {{ $mutasis->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

</div>

@endsection