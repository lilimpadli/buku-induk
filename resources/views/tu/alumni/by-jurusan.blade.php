@extends('layouts.app')

@section('title', 'Alumni - ' . ($namaJurusan ?? 'Jurusan'))

@section('content')

<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #6366F1;
        --secondary: #7C3AED;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
    }

    body { background: linear-gradient(180deg, #F8FAFF 0%, #EEF2FF 100%); }

    /* HERO */
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px;
        padding: 40px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 35px rgba(15,23,42,.12);
    }
    .hero-banner::before,
    .hero-banner::after {
        content: ''; position: absolute; border-radius: 50%;
        background: rgba(255,255,255,.08); pointer-events: none;
    }
    .hero-banner::before { width: 300px; height: 300px; top: -120px; right: -80px; }
    .hero-banner::after { width: 200px; height: 200px; bottom: -80px; left: -60px; background: rgba(255,255,255,.05); }

    .hero-content {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between;
        align-items: center; gap: 24px; flex-wrap: wrap;
    }

    .hero-title { font-size: 32px; font-weight: 800; color: white; margin: 0 0 8px; letter-spacing: -.5px; }
    .hero-subtitle { color: rgba(255,255,255,.85); font-size: 15px; margin: 0; }
    .hero-stats { display: flex; gap: 16px; margin-top: 24px; flex-wrap: wrap; }
    .hero-stat {
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 16px; padding: 14px 22px; min-width: 120px; color: white;
    }
    .hero-stat-value { font-size: 26px; font-weight: 800; line-height: 1.1; }
    .hero-stat-label { font-size: 11px; opacity: .85; text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

    .btn-hero {
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.25);
        color: white; border-radius: 14px;
        padding: 12px 22px; font-weight: 700; font-size: 14px;
        display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; transition: all .25s; cursor: pointer;
    }
    .btn-hero:hover { background: white; color: var(--primary); border-color: white; transform: translateY(-2px); }

    /* FILTER */
    .filter-card {
        background: white; border-radius: 24px; padding: 24px;
        margin-bottom: 28px; border: 1px solid #EEF2FF;
        box-shadow: 0 10px 25px rgba(15,23,42,.08);
    }
    .filter-title {
        font-size: 16px; font-weight: 700; color: #1E293B;
        margin-bottom: 18px; display: flex; align-items: center; gap: 10px;
    }
    .filter-title i { color: var(--primary); }
    .filter-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 14px; }
    .form-select-modern {
        width: 100%; height: 46px; border-radius: 12px;
        border: 1.5px solid #E2E8F0; padding: 0 16px; font-size: 14px;
        background: #F8FAFF; transition: all .2s;
    }
    .form-select-modern:focus {
        outline: none; border-color: var(--primary);
        background: white; box-shadow: 0 0 0 4px rgba(79,70,229,.08);
    }

    /* ROMBEL CARD */
    .rombel-card {
        background: white; border-radius: 22px;
        border: 1px solid #EEF2FF; box-shadow: 0 10px 25px rgba(15,23,42,.08);
        overflow: hidden; margin-bottom: 20px;
        transition: all .25s;
    }
    .rombel-card:hover { box-shadow: 0 15px 35px rgba(15,23,42,.12); }

    .rombel-header-modern {
        padding: 18px 22px;
        background: linear-gradient(135deg, #F8FAFF 0%, #EEF2FF 100%);
        border-bottom: 1px solid #EEF2FF;
        display: flex; justify-content: space-between; align-items: center;
        cursor: pointer; transition: all .2s;
    }
    .rombel-header-modern:hover { background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%); }

    .rombel-title-modern {
        display: flex; align-items: center; gap: 12px;
        font-weight: 800; color: #1E293B; font-size: 16px;
    }

    .rombel-title-modern i.collapse-icon {
        color: var(--primary);
        transition: transform .3s;
    }

    .rombel-badge-modern {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white; padding: 6px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 6px;
        box-shadow: 0 4px 12px rgba(79,70,229,.25);
    }

    /* TABLE */
    .table-modern { width: 100%; border-collapse: collapse; }

    .table-modern thead th {
        background: #F8FAFF;
        color: #64748B;
        font-weight: 700;
        font-size: 11px;
        padding: 14px 18px;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 2px solid #EEF2FF;
        text-align: left;
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        font-size: 14px;
        color: #334155;
    }

    .table-modern tbody tr:hover { background: #F8FAFF; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* STUDENT INFO */
    .student-info-modern {
        display: flex; align-items: center; gap: 12px;
    }
    .student-avatar-modern {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px; flex-shrink: 0;
        overflow: hidden;
    }
    .student-avatar-modern img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .student-name-modern { font-weight: 700; color: #1E293B; }

    .btn-detail-modern {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white; border: none; border-radius: 10px;
        padding: 8px 14px; font-weight: 700; font-size: 12px;
        display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; transition: all .25s; cursor: pointer;
    }
    .btn-detail-modern:hover { color: white; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(79,70,229,.3); }

    /* EMPTY */
    .empty-state {
        background: white; border-radius: 24px; padding: 70px 24px;
        text-align: center; box-shadow: 0 10px 25px rgba(15,23,42,.08);
    }
    .empty-icon {
        width: 90px; height: 90px;
        background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        color: var(--primary); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 22px; font-size: 40px;
    }
    .empty-title { font-size: 22px; font-weight: 800; color: #1E293B; margin-bottom: 8px; }
    .empty-desc { font-size: 14px; color: #64748B; max-width: 400px; margin: 0 auto 24px; }

    @media (max-width: 768px) {
        .hero-banner { padding: 26px; }
        .hero-title { font-size: 24px; }
        .filter-grid { grid-template-columns: 1fr; }
        .table-modern thead th, .table-modern tbody td { padding: 10px 12px; font-size: 12px; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HERO -->
    <div class="hero-banner">
        <div class="hero-content">
            <div>
                <h1 class="hero-title">
                    <i class="fas fa-users me-2"></i> Alumni {{ $namaJurusan ?? 'Jurusan' }}
                </h1>
                <p class="hero-subtitle">
                    Tahun Ajaran: {{ $tahun ?? 'Semua Tahun' }}
                </p>
                <div class="hero-stats">
                    @php
                        $totalAlumni = 0;
                        foreach ($groupedAlumni as $g) {
                            $totalAlumni += count($g['students'] ?? []);
                        }
                    @endphp
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $totalAlumni }}</div>
                        <div class="hero-stat-label">Total Alumni</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ count($groupedAlumni) }}</div>
                        <div class="hero-stat-label">Rombel</div>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('tu.alumni.index') }}" class="btn-hero">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <div class="filter-title">
            <i class="fas fa-filter"></i> Filter Tahun Ajaran
        </div>
        <form method="GET" action="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}">
            <div class="filter-grid">
                <select name="tahun" class="form-select-modern" id="tahun">
                    <option value="Semua Tahun" {{ ($tahun ?? 'Semua Tahun') === 'Semua Tahun' ? 'selected' : '' }}>
                        Semua Tahun Ajaran
                    </option>
                    @forelse($tahunAjaranList ?? [] as $t)
                        <option value="{{ $t }}" {{ ($tahun ?? '') === $t ? 'selected' : '' }}>
                            Tahun Ajaran {{ $t }}
                        </option>
                    @empty
                        <option value="">Belum ada data</option>
                    @endforelse
                </select>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-hero" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; padding: 0 20px; flex: 1;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if(($tahun ?? '') && ($tahun ?? '') !== 'Semua Tahun')
                        <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}" class="btn-hero" style="padding: 0 16px;">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- LIST ROMBEL -->
    @php
        if (!isset($groupedAlumni) || is_null($groupedAlumni)) {
            $groupedAlumni = [];
        }
    @endphp

    @if(!empty($groupedAlumni) && count($groupedAlumni) > 0)
        @foreach($groupedAlumni as $compositeKey => $groupData)
            <div class="rombel-card">
                <div class="rombel-header-modern" onclick="toggleCollapse(this)">
                    <div class="rombel-title-modern">
                        <i class="fas fa-chevron-down collapse-icon"></i>
                        {{ $groupData['display_name'] ?? 'Kelas - Rombel' }}
                    </div>
                    <span class="rombel-badge-modern">
                        <i class="fas fa-users"></i>
                        {{ count($groupData['students'] ?? []) }} Siswa
                    </span>
                </div>

                <div class="rombel-body" style="display: block;">
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>Nama Siswa</th>
                                    <th style="width:15%;">NIS</th>
                                    <th style="width:15%;">NISN</th>
                                    <th style="width:12%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupData['students'] ?? [] as $index => $siswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="student-info-modern">
                                                <div class="student-avatar-modern">
                                                    @if($siswa->foto)
                                                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                                    @else
                                                        {{ strtoupper(substr($siswa->nama_lengkap ?? 'U', 0, 1)) }}
                                                    @endif
                                                </div>
                                                <span class="student-name-modern">{{ $siswa->nama_lengkap ?? 'Tidak Diketahui' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $siswa->nis ?? '-' }}</td>
                                        <td>{{ $siswa->nisn ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('tu.alumni.show', $siswa->id ?? 0) }}" class="btn-detail-modern">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="empty-title">Tidak Ada Data Alumni</h3>
            <p class="empty-desc">
                Tidak ada alumni untuk jurusan <strong>{{ $namaJurusan ?? 'ini' }}</strong> pada tahun ajaran <strong>{{ $tahun ?? 'yang dipilih' }}</strong>.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('tu.alumni.index') }}" class="btn-hero" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                @if(($tahun ?? '') && ($tahun ?? '') !== 'Semua Tahun')
                    <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}" class="btn-hero">
                        <i class="fas fa-undo"></i> Tampilkan Semua Tahun
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
function toggleCollapse(element) {
    const body = element.nextElementSibling;
    const icon = element.querySelector('.collapse-icon');

    if (body.style.display === 'none') {
        body.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    } else {
        body.style.display = 'none';
        icon.style.transform = 'rotate(-90deg)';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('tahun');
    if (select) {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});
</script>

@endsection