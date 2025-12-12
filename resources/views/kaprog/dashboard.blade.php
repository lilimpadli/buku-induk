@extends('layouts.app')

@section('title', 'Dashboard Program Keahlian')

@section('content')

<h5 class="fw-bold mb-2">Dashboard Program Keahlian</h5>
<p class="mb-1">Selamat Datang, <strong>{{ Auth::user()->name }}</strong></p>
<p class="text-muted small mb-4">Berikut adalah ringkasan data penting untuk program keahlian Anda</p>

<!-- STATS CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Total Siswa Aktif</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalSiswa }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Jumlah Kelas</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalKelas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Jumlah Guru</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalGuru }}</h2>
            </div>
        </div>
    </div>
</div>


<!-- SEARCH & FILTERS -->
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari Data Siswa" id="searchInput">
            <button class="btn btn-primary">
                <i class="fa-solid fa-search"></i>
            </button>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <button class="btn btn-primary btn-sm filter-btn" data-kelas="all">Semua</button>
        <button class="btn btn-outline-secondary btn-sm filter-btn" data-kelas="10">Kelas 10</button>
        <button class="btn btn-outline-secondary btn-sm filter-btn" data-kelas="11">Kelas 11</button>
        <button class="btn btn-outline-secondary btn-sm filter-btn" data-kelas="12">Kelas 12</button>
    </div>
</div>


<!-- TABLE -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Daftar Siswa</h6>

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
                    @foreach ($siswas as $s)
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
                    @endforeach
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
</script>
@endpush
