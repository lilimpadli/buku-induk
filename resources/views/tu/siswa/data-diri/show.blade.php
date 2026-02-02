@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-start justify-content-between">
        <div>
            <h2 class="fw-bold mb-1">Detail Siswa</h2>
            <p class="text-muted mb-4">{{ $siswa->nama_lengkap }}</p>
        </div>
        <div class="ms-3">
            <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('tu.siswa.exportPDF', $siswa->id) }}" class="btn btn-success me-2">
                <i class="fas fa-file-pdf"></i> Export
            </a>
            <a href="{{ route('tu.siswa.raport', $siswa->id) }}" class="btn btn-primary">
                <i class="fas fa-file-alt"></i> Raport
            </a>
        </div>
    </div>

    @if(session('success') || session('error'))
        <!-- Flash modal -->
        <div class="modal fade" id="flashModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(session('success'))
                            <div class="text-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @else
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    var m = new bootstrap.Modal(document.getElementById('flashModal'));
                    m.show();
                } catch (e) {
                    var msg = {!! json_encode(session('success') ?? session('error')) !!};
                    if (msg) alert(msg);
                }
            });
        </script>
    @endif

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="siswaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa" type="button" role="tab" aria-controls="data-siswa" aria-selected="true">
                <i class="fas fa-user me-1 d-none d-md-inline"></i>Data Siswa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab" data-bs-target="#data-orangtua" type="button" role="tab" aria-controls="data-orangtua" aria-selected="false">
                <i class="fas fa-users me-1 d-none d-md-inline"></i>Data Orang Tua
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="siswaTabsContent">
        <!-- Tab Data Siswa -->
        <div class="tab-pane fade show active" id="data-siswa" role="tabpanel" aria-labelledby="data-siswa-tab">
            <div class="card detail-card mt-3">
                <div class="card-body">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi Siswa</h5>
                    <table class="table table-borderless table-detail">
                        <tbody>
                            <tr>
                                <td>NIS</td>
                                <td>: {{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $siswa->nisn }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td>: {{ $siswa->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>: {{ $siswa->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>: {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: {{ $siswa->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>: {{ $siswa->agama }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->alamat }}</td>
                            </tr>
                            <tr>
                                <td>No HP</td>
                                <td>: {{ $siswa->no_hp }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Rombel</td>
                                <td>: {{ $siswa->rombel->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Diterima</td>
                                <td>: {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Data Orang Tua -->
        <div class="tab-pane fade" id="data-orangtua" role="tabpanel" aria-labelledby="data-orangtua-tab">
            <div class="card detail-card mt-3">
                <div class="card-body">
                    <h5><i class="fas fa-male me-2"></i>Data Ayah</h5>
                    <table class="table table-borderless table-detail">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->ayah->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->ayah->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->ayah->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->ayah->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr class="my-4">

                    <h5><i class="fas fa-female me-2"></i>Data Ibu</h5>
                    <table class="table table-borderless table-detail">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->ibu->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->ibu->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->ibu->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->ibu->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr class="my-4">

                    <h5><i class="fas fa-user-shield me-2"></i>Data Wali</h5>
                    <table class="table table-borderless table-detail">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->wali->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->wali->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->wali->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->wali->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection