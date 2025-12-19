@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-1">Detail Siswa</h2>
    <p class="text-muted mb-4">{{ $siswa->nama_lengkap }}</p>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="siswaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa" type="button" role="tab" aria-controls="data-siswa" aria-selected="true">Data Siswa</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab" data-bs-target="#data-orangtua" type="button" role="tab" aria-controls="data-orangtua" aria-selected="false">Data Orang Tua</button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="siswaTabsContent">
        <!-- Tab Data Siswa -->
        <div class="tab-pane fade show active" id="data-siswa" role="tabpanel" aria-labelledby="data-siswa-tab">
            <div class="card shadow-sm border-0 mt-3" style="border-radius: 15px;">
                <div class="card-body">
                    <h5>Informasi Siswa</h5>
                    <table class="table table-borderless">
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
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Data Orang Tua -->
        <div class="tab-pane fade" id="data-orangtua" role="tabpanel" aria-labelledby="data-orangtua-tab">
            <div class="card shadow-sm border-0 mt-3" style="border-radius: 15px;">
                <div class="card-body">
                    <h5>Data Ayah</h5>
                    <table class="table table-borderless">
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
                    </table>

                    <hr>

                    <h5>Data Ibu</h5>
                    <table class="table table-borderless">
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
                    </table>

                    <hr>

                    <h5>Data Wali</h5>
                    <table class="table table-borderless">
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
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('kurikulum.data-siswa.edit', $siswa->id) }}" class="btn btn-primary">Edit Siswa</a>
    </div>
</div>
@endsection