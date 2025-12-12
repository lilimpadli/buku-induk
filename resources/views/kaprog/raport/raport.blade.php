@extends('layouts.app')

@section('title', 'View Report Program Keahlian')

@section('content')

<h4 class="fw-bold mb-4">Dashboard Program Keahlian</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4" style="background-color: #f8f9fa;">
        
        <h5 class="fw-bold mb-1">Lihat Laport Per program</h5>
        <p class="text-muted mb-4">Lihat dan kelola Raport siswa untuk program keahlian anda.</p>

        <!-- Search & Filter -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan Nama atau NIS..." id="searchInput">
                </div>
            </div>
            <div class="col-md-6">
                <select class="form-select">
                    <option selected>Rekayasa Perangkat Lunak</option>
                    <option>Teknik Komputer Jaringan</option>
                    <option>Multimedia</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="border-bottom: 2px solid #dee2e6;">
                            <th class="text-muted fw-semibold" style="padding: 15px;">NO.</th>
                            <th class="text-muted fw-semibold" style="padding: 15px;">NIS</th>
                            <th class="text-muted fw-semibold" style="padding: 15px;">NAMA SISWA</th>
                            <th class="text-muted fw-semibold" style="padding: 15px;">Kelas</th>
                            <th class="text-muted fw-semibold" style="padding: 15px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTable">
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 18px;">1</td>
                            <td style="padding: 18px;">232410218</td>
                            <td style="padding: 18px;">Aditya Saputra Setiadi</td>
                            <td style="padding: 18px;">XII PPLG 2</td>
                            <td style="padding: 18px;">
                                <button class="btn btn-primary btn-sm px-4 rounded-pill">Lihat Siswa</button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 18px;">2</td>
                            <td style="padding: 18px;">232410219</td>
                            <td style="padding: 18px;">Lili Muhammad Padli</td>
                            <td style="padding: 18px;">XII PPLG 2</td>
                            <td style="padding: 18px;">
                                <button class="btn btn-primary btn-sm px-4 rounded-pill">Lihat Siswa</button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 18px;">3</td>
                            <td style="padding: 18px;">232410220</td>
                            <td style="padding: 18px;">Fitri Dewi Lestari</td>
                            <td style="padding: 18px;">XII PPLG 3</td>
                            <td style="padding: 18px;">
                                <button class="btn btn-primary btn-sm px-4 rounded-pill">Lihat Siswa</button>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 18px;">4</td>
                            <td style="padding: 18px;">232410221</td>
                            <td style="padding: 18px;">Ihsan Nurfallah</td>
                            <td style="padding: 18px;">XII PPLG 2</td>
                            <td style="padding: 18px;">
                                <button class="btn btn-primary btn-sm px-4 rounded-pill">Lihat Siswa</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 18px;">5</td>
                            <td style="padding: 18px;">232410222</td>
                            <td style="padding: 18px;">Raihani Salsabila Azzahra</td>
                            <td style="padding: 18px;">XII PPLG 2</td>
                            <td style="padding: 18px;">
                                <button class="btn btn-primary btn-sm px-4 rounded-pill">Lihat Siswa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link border-0" href="#"><</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link border-0 rounded-circle mx-1" href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border-0 rounded-circle mx-1" href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border-0 rounded-circle mx-1" href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">3</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link border-0" href="#">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border-0 rounded-circle mx-1" href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">10</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link border-0" href="#">></a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#siswaTable tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
