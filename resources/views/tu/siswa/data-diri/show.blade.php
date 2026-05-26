@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Detail Siswa</h2>
            <p class="text-muted mb-0">{{ $siswa->nama_lengkap }}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('tu.siswa.exportPDF', $siswa->id) }}" class="btn btn-success btn-sm me-2">
                <i class="fas fa-file-pdf me-1"></i> Export
            </a>
            <a href="{{ route('tu.siswa.raport', $siswa->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-file-alt me-1"></i> Raport
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            <i class="fas fa-{{ session('success') ? 'check-circle' : 'exclamation-circle' }} me-2"></i>
            {{ session('success') ?? session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-3" id="siswaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa" type="button" role="tab" aria-controls="data-siswa" aria-selected="true">
                <i class="fas fa-user me-2"></i>Data Siswa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab" data-bs-target="#data-orangtua" type="button" role="tab" aria-controls="data-orangtua" aria-selected="false">
                <i class="fas fa-users me-2"></i>Data Orang Tua
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="siswaTabsContent">
        <!-- Data Siswa Tab -->
        <div class="tab-pane fade show active" id="data-siswa" role="tabpanel" aria-labelledby="data-siswa-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title text-primary mb-4">
                        <i class="fas fa-info-circle me-2"></i>Informasi Siswa
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="text-end pe-3">NIS</th>
                                        <td class="fw-medium">{{ $siswa->nis }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">NISN</th>
                                        <td class="fw-medium">{{ $siswa->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Nama Lengkap</th>
                                        <td class="fw-medium">{{ $siswa->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Tempat Lahir</th>
                                        <td>{{ $siswa->tempat_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Tanggal Lahir</th>
                                        <td>{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Jenis Kelamin</th>
                                        <td>{{ $siswa->jenis_kelamin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="text-end pe-3">Agama</th>
                                        <td>{{ $siswa->agama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Kewarganegaraan</th>
                                        <td>{{ $siswa->kewarganegaraan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Alamat</th>
                                        <td class="text-break">{{ 
                                            collect([
                                                'Dusun ' . ($siswa->dusun ?? ''),
                                                'RT/RW ' . ($siswa->rt ?? '-') . '/' . ($siswa->rw ?? '-'),
                                                $siswa->kelurahan ?? '',
                                                $siswa->kecamatan ?? '',
                                                $siswa->kode_pos ?? ''
                                            ])
                                            ->filter()
                                            ->join(', ')
                                        }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">No HP</th>
                                        <td>{{ $siswa->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Kelas</th>
                                        <td>{{ $siswa->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Rombel</th>
                                        <td>{{ $siswa->rombel->nama ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="text-end pe-3">Tanggal Diterima</th>
                                    <td>{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua Tab -->
        <div class="tab-pane fade" id="data-orangtua" role="tabpanel" aria-labelledby="data-orangtua-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Data Ayah -->
                    <div class="mb-4">
                        <h5 class="card-title text-primary mb-3">
                            <i class="fas fa-male me-2"></i>Data Ayah
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-end pe-3 w-25">Nama</th>
                                        <td class="fw-medium">{{ $siswa->ayah->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Pekerjaan</th>
                                        <td>{{ $siswa->ayah->pekerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Telepon</th>
                                        <td>{{ $siswa->ayah->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Alamat</th>
                                        <td>{{ $siswa->ayah->alamat ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <div class="mb-4">
                        <h5 class="card-title text-primary mb-3">
                            <i class="fas fa-female me-2"></i>Data Ibu
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-end pe-3 w-25">Nama</th>
                                        <td class="fw-medium">{{ $siswa->ibu->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Pekerjaan</th>
                                        <td>{{ $siswa->ibu->pekerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Telepon</th>
                                        <td>{{ $siswa->ibu->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Alamat</th>
                                        <td>{{ $siswa->ibu->alamat ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Data Wali -->
                    <div>
                        <h5 class="card-title text-primary mb-3">
                            <i class="fas fa-user-shield me-2"></i>Data Wali
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-end pe-3 w-25">Nama</th>
                                        <td class="fw-medium">{{ $siswa->wali->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Pekerjaan</th>
                                        <td>{{ $siswa->wali->pekerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Telepon</th>
                                        <td>{{ $siswa->wali->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end pe-3">Alamat</th>
                                        <td>{{ $siswa->wali->alamat ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection