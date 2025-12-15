@extends('layouts.app')

@section('title', 'Dashboard Program Keahlian')

@section('content')

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

<!-- STATS CARDS -->
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
                            <button 
    class="btn btn-link text-primary fw-semibold lihat-btn"
    data-id="{{ $s->id }}">
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
                            <img src="${data.foto ?? '/default.png'}" 
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
</script>
@endpush
