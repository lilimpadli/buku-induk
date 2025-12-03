@extends('layouts.app')

@section('title', 'Raport Siswa')

@section('content')

<h4 class="mb-3">Dashboard Program Keahlian</h4>

<h5>Lihat Raport Per Program</h5>
<p class="text-muted">Lihat dan kelola raport siswa untuk program keahlian Anda</p>

<div class="card shadow-sm p-3">

    <!-- Filter -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input id="searchInput" type="text" class="form-control" placeholder="Cari berdasarkan Nama atau NIS...">
        </div>
        <div class="col-md-6">
            <select class="form-select">
                <option>XII</option>
                <option>XI</option>
                <option>X</option>
            </select>
        </div>
    </div>

    <!-- Tabel -->
    <table class="table table-bordered" id="siswaTable">
        <thead class="table-light">
            <tr>
                <th>NO.</th>
                <th>NIS</th>
                <th>NAMA SISWA</th>
                <th>KELAS</th>
                <th>AKSI</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>232410218</td>
                <td>Aditya Saputra Setiadi</td>
                <td>XII PPLG 2</td>
                <td><a href="#" class="btn btn-primary btn-sm">Lihat Siswa</a></td>
            </tr>

            <tr>
                <td>2</td>
                <td>232410219</td>
                <td>Lili Muhammad Padli</td>
                <td>XII PPLG 2</td>
                <td><a href="#" class="btn btn-primary btn-sm">Lihat Siswa</a></td>
            </tr>

            <tr>
                <td>3</td>
                <td>232410220</td>
                <td>Fitri Dewi Lestari</td>
                <td>XII PPLG 3</td>
                <td><a href="#" class="btn btn-primary btn-sm">Lihat Siswa</a></td>
            </tr>

            <tr>
                <td>4</td>
                <td>232410221</td>
                <td>Ihsan Nurfallah</td>
                <td>XII PPLG 2</td>
                <td><a href="#" class="btn btn-primary btn-sm">Lihat Siswa</a></td>
            </tr>

            <tr>
                <td>5</td>
                <td>232410222</td>
                <td>Raihani Salsabila Azzahra</td>
                <td>XII PPLG 2</td>
                <td><a href="#" class="btn btn-primary btn-sm">Lihat Siswa</a></td>
            </tr>
        </tbody>
    </table>

</div>

{{-- SCRIPT PENCARIAN --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const tableRows   = document.querySelectorAll('#siswaTable tbody tr');

    searchInput.addEventListener('keyup', function () {
        const q = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const nis  = row.children[1].textContent.toLowerCase();
            const nama = row.children[2].textContent.toLowerCase();

            if (nis.includes(q) || nama.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
