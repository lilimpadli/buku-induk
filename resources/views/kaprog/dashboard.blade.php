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
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">352</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Jumlah Kelas</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">9</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-2">Tingkat Kelulusan</p>
                <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">95%</h2>
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
                    <tr data-kelas="11">
                        <td>Aditya Saputra Setiadi</td>
                        <td>232410218</td>
                        <td>XI RPL 2</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                    <tr data-kelas="12">
                        <td>Rafli Trian Kirana</td>
                        <td>232410219</td>
                        <td>XII RPL 1</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                    <tr data-kelas="10">
                        <td>Fitri Dewi Lestari</td>
                        <td>232410220</td>
                        <td>X RPL 3</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                    <tr data-kelas="11">
                        <td>Firda Syfa Maulida</td>
                        <td>232410221</td>
                        <td>XI RPL 2</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                    <tr data-kelas="12">
                        <td>Iksan Gazzan Sopyan</td>
                        <td>232410222</td>
                        <td>XII RPL 2</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                    <tr data-kelas="10">
                        <td>Raihani Salsabila Azzahra</td>
                        <td>232410223</td>
                        <td>X RPL 2</td>
                        <td><a href="#" class="text-primary fw-semibold">LIHAT</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <nav class="mt-3">
            <ul class="pagination pagination-sm justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">10</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </nav>

    </div>
</div>

@endsection

@push('scripts')
<script>
// Global state untuk filter
let currentFilter = 'all';
let currentSearch = '';

// Fungsi untuk menampilkan/menyembunyikan row berdasarkan filter dan search
function applyFilters() {
    const rows = document.querySelectorAll('#siswaTable tr');
    
    rows.forEach(row => {
        const kelas = row.dataset.kelas;
        const text = row.textContent.toLowerCase();
        
        const matchesFilter = (currentFilter === 'all' || kelas === currentFilter);
        const matchesSearch = (currentSearch === '' || text.includes(currentSearch));
        
        row.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
    });
}

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline-secondary');
        });
        this.classList.remove('btn-outline-secondary');
        this.classList.add('btn-primary');

        currentFilter = this.dataset.kelas;
        applyFilters();
    });
});

document.getElementById('searchInput').addEventListener('keyup', function() {
    currentSearch = this.value.toLowerCase();
    applyFilters();
});
</script>
@endpush