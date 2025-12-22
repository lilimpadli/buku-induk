@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="container mt-4">
</div>
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h3 class="mb-0">Dashboard Wali Kelas</h3>
            <p class="text-muted small">Ringkasan cepat data siswa dan aksi cepat</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-primary me-2">Kelola Siswa</a>
            <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-primary">Input Nilai Raport</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Total Siswa</div>
                        <div class="h3 mb-0">{{ number_format($total ?? 0) }}</div>
                        <small class="text-muted">Jumlah siswa di kelas Anda</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white me-3">
                        <i class="fas fa-venus-mars fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-muted">Distribusi Jenis Kelamin</div>
                        @php
                            $male = $byGender['Laki-laki'] ?? 0;
                            $female = $byGender['Perempuan'] ?? 0;
                            $sum = max(1, $male + $female);
                            $malePct = round($male / $sum * 100);
                            $femalePct = 100 - $malePct;
                        @endphp
                        <div class="d-flex gap-3 align-items-center my-2">
                            <div class="text-primary"><strong>{{ $male }}</strong> L</div>
                            <div class="text-danger"><strong>{{ $female }}</strong> P</div>
                        </div>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $malePct }}%"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $femalePct }}%"></div>
                        </div>
                        <small class="text-muted">{{ $malePct }}% laki-laki — {{ $femalePct }}% perempuan</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Aksi Cepat</div>
                        <div class="mt-2 d-flex gap-2">
                            <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Siswa</a>
                            <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-sm btn-success">Input Nilai</a>
                        </div>
                    </div>
                    <div class="text-muted">
                        <i class="fas fa-bolt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title mb-3">Siswa Terbaru</h6>
                    @if(!empty($recent) && $recent->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent as $r)
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="avatar me-3">
                                        @if($r->foto)
                                            <img src="{{ asset('storage/' . $r->foto) }}" alt="" class="rounded-circle" style="width:48px;height:48px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-weight:700;">{{ strtoupper(substr($r->nama_lengkap,0,1)) }}</div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $r->nama_lengkap }}</div>
                                        <div class="small text-muted">NIS: {{ $r->nis ?? '-' }} • {{ $r->created_at ? $r->created_at->format('Y-m-d') : '-' }}</div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('walikelas.siswa.show', $r->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada siswa baru.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-3">
            <div class="card shadow-sm h-100 p-3">
                <h6 class="card-title">Ringkasan Rombel</h6>
                <p class="small text-muted">Statistik singkat rombel Anda</p>
                <div class="d-flex flex-column gap-2 mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ number_format($total ?? 0) }}</strong>
                            <div class="small text-muted">Siswa Terdaftar</div>
                        </div>
                        <div class="text-primary">&bull;</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $male ?? 0 }}</strong>
                            <div class="small text-muted">Laki-laki</div>
                        </div>
                        <div class="text-danger">&bull;</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $female ?? 0 }}</strong>
                            <div class="small text-muted">Perempuan</div>
                        </div>
                        <div class="text-warning">&bull;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .hover-card:hover { transform: translateY(-5px); transition: .2s; }
</style>
<style>
    .stat-card{ border-radius:12px; background:#fff; }
    .stat-icon{ width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center; }
    .stat-icon i{ transform:translateY(1px); }
    .avatar img{ border-radius:6px; }
    .list-group-item{ border-radius:10px; margin-bottom:8px; }
    .list-group-item:last-child{ margin-bottom:0; }
</style>