@extends('layouts.app')

@section('title', 'Dashboard Program Keahlian')

@section('content')
<style>
    /* ===================== STYLE DASHBOARD KAPROG ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h5.fw-bold {
        font-size: 24px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 8px !important;
    }

    h5.fw-bold::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card.border-0 {
        border: none !important;
    }

    .card.shadow-sm {
        box-shadow: var(--card-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-body.text-center.py-4 {
        padding: 1.5rem !important;
    }

    /* Stats Cards */
    h2.fw-bold {
        font-size: 2.2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0 !important;
    }

    /* Form Styles */
    .form-control {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 10px 12px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    .input-group .btn {
        border-radius: 0 8px 8px 0;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-outline-secondary {
        color: #64748B;
        border-color: #E2E8F0;
    }

    .btn-outline-secondary:hover {
        background-color: #F1F5F9;
        border-color: #CBD5E1;
    }

    .btn-link {
        text-decoration: none;
        font-weight: 600;
    }

    .btn-link.text-primary {
        color: var(--primary-color);
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table-hover > tbody > tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table thead th {
        border-bottom: 2px solid #E2E8F0;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 15px;
    }

    .table td, .table th {
        border-color: #E2E8F0;
        padding: 12px 15px;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid #E2E8F0;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .img-fluid.rounded {
        border-radius: 12px;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
    }

    small.text-muted {
        font-size: 13px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h5.fw-bold {
            font-size: 20px;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .form-control {
            padding: 8px 10px;
        }
        
        .table thead th,
        .table td, .table th {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .chart-container {
            height: 250px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h5 class="fw-bold mb-2">Dashboard Program Keahlian</h5>
        <p class="mb-1">Selamat Datang, <strong>{{ Auth::user()->name }}</strong></p>
        <p class="text-muted small mb-0">{{ $jurusan ? 'Program Keahlian: ' . $jurusan->nama : 'Program Keahlian: -' }}</p>
    </div>
    <div class="text-end">
        <small class="text-muted">Ringkasan per jurusan</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Total Siswa</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $totalSiswa }}</h2>
            </div>
        </div>
    </div>
   
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Jumlah Guru</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $totalGuru }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Jumlah Rombel</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $totalRombel ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Kelas Aktif</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $totalKelasAktif ?? 3 }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Chart Row -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Distribusi Siswa per Kelas</h6>
                <div class="chart-container">
                    <canvas id="kelasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Perbandingan Jurusan</h6>
                <div class="chart-container">
                    <canvas id="jurusanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SEARCH & FILTERS -->
<form method="GET" action="{{ route('kaprog.dashboard') }}">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari Data Siswa (nama / NIS)">
                <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <input type="hidden" name="kelas" id="kelasInput" value="{{ request('kelas', 'all') }}">
            <button type="button" class="btn btn-sm {{ request('kelas') == 'all' || !request('kelas') ? 'btn-primary' : 'btn-outline-secondary' }} filter-btn" data-kelas="all">Semua</button>
            <button type="button" class="btn btn-sm {{ request('kelas') == '10' ? 'btn-primary' : 'btn-outline-secondary' }} filter-btn" data-kelas="10">Kelas 10</button>
            <button type="button" class="btn btn-sm {{ request('kelas') == '11' ? 'btn-primary' : 'btn-outline-secondary' }} filter-btn" data-kelas="11">Kelas 11</button>
            <button type="button" class="btn btn-sm {{ request('kelas') == '12' ? 'btn-primary' : 'btn-outline-secondary' }} filter-btn" data-kelas="12">Kelas 12</button>
        </div>
    </div>
</form>

<!-- TABLE -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Daftar Siswa</h6>
            <small class="text-muted">Menampilkan siswa untuk jurusan: {{ $jurusan->nama ?? '-' }}</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="siswaTable">
                    @forelse ($siswas as $s)
                    @php
                        if (str_starts_with($s->kelas, 'XII')) $kelasNum = 12;
                        elseif (str_starts_with($s->kelas, 'XI')) $kelasNum = 11;
                        else $kelasNum = 10;
                    @endphp

                    <tr data-kelas="{{ $kelasNum }}">
                        <td>{{ $s->nama_lengkap }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->kelas }}</td>
                        <td>
                            <button class="btn btn-link text-primary fw-semibold lihat-btn" data-id="{{ $s->id }}">
                                LIHAT
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada siswa untuk jurusan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

{{-- ============================ --}}
{{--      MODAL DETAIL SISWA     --}}
{{-- ============================ --}}
<div class="modal fade" id="modalDetailSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="detailContent">Memuat data...</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ROUTE AJAX BENAR
    const detailRoute = "{{ route('kaprog.siswa.detail', ['id' => '__ID__']) }}";
    
    document.querySelectorAll('.lihat-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('modalDetailSiswa'));
            modal.show();
            document.getElementById('detailContent').innerHTML = "Memuat data...";
            
            // Replace ID di route
            let url = detailRoute.replace('__ID__', id);
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="${data.foto || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.nama_lengkap) + '&size=150'}" 
                                     class="img-fluid rounded mb-3" width="150">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr><th>Nama</th><td>${data.nama_lengkap}</td></tr>
                                    <tr><th>NIS</th><td>${data.nis}</td></tr>
                                    <tr><th>Kelas</th><td>${data.kelas}</td></tr>
                                    <tr><th>Jenis Kelamin</th><td>${data.jenis_kelamin}</td></tr>
                                    <tr><th>TTL</th><td>${data.tempat_lahir}, ${data.tanggal_lahir}</td></tr>
                                    <tr><th>Alamat</th><td>${data.alamat}</td></tr>
                                    <tr><th>No HP</th><td>${data.no_hp}</td></tr>
                                </table>
                            </div>
                        </div>
                    `;
                });
        });
    });

    // Filter buttons behavior: set hidden input and submit form
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const val = this.dataset.kelas;
            document.getElementById('kelasInput').value = val === 'all' ? '' : val;
            // submit the parent form
            this.closest('form').submit();
        });
    });
    
    // Chart.js - Distribusi Siswa per Kelas
    const kelasCtx = document.getElementById('kelasChart').getContext('2d');
    const kelasChart = new Chart(kelasCtx, {
        type: 'bar',
        data: {
            labels: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [
                    {{ $siswaKelas10 ?? 0 }},
                    {{ $siswaKelas11 ?? 0 }},
                    {{ $siswaKelas12 ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(47, 83, 255, 0.7)',
                    'rgba(99, 102, 241, 0.7)',
                    'rgba(16, 185, 129, 0.7)'
                ],
                borderColor: [
                    'rgba(47, 83, 255, 1)',
                    'rgba(99, 102, 241, 1)',
                    'rgba(16, 185, 129, 1)'
                ],
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
    
    // Chart.js - Perbandingan Jurusan
    const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
    const jurusanChart = new Chart(jurusanCtx, {
        type: 'doughnut',
        data: {
            labels: [
                'Teknik Informatika',
                'Teknik Mesin',
                'Teknik Elektro',
                'Akuntansi',
                'Perhotelan'
            ],
            datasets: [{
                data: [
                    {{ $jurusanTI ?? 25 }},
                    {{ $jurusanTM ?? 30 }},
                    {{ $jurusanTE ?? 20 }},
                    {{ $jurusanAK ?? 15 }},
                    {{ $jurusanPH ?? 10 }}
                ],
                backgroundColor: [
                    'rgba(47, 83, 255, 0.7)',
                    'rgba(99, 102, 241, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ],
                borderColor: [
                    'rgba(47, 83, 255, 1)',
                    'rgba(99, 102, 241, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endpush