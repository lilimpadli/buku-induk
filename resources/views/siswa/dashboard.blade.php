@extends('layouts.app')

@section('content')

<style>
    /* ===================== STYLE DASHBOARD SISWA ===================== */

    .dashboard-title {
        font-size: 26px;
        font-weight: 700;
    }

    .subtitle {
        margin-top: -5px;
        font-size: 14px;
        color: #6c757d;
    }

    /* Kartu nilai */
    .nilai-card {
        border-radius: 15px;
        transition: 0.2s;
        background: white;
    }
    .nilai-card:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 14px rgba(0,0,0,0.09);
    }

    .nilai-title {
        font-weight: 600;
        font-size: 14px;
        color: #555;
    }

    .nilai-angka {
        font-size: 32px;
        font-weight: 700;
        color: #2F53FF;
        line-height: 1.0;
    }

    .predikat {
        font-size: 12px;
    }

    /* Card catatan */
    .catatan-box {
        height: 240px;
        overflow-y: auto;
    }

    .catatan-item {
        padding: 6px 0;
        border-bottom: 1px dashed #ddd;
        font-size: 13px;
    }

    .catatan-item:last-child {
        border-bottom: none;
    }

</style>

<div class="container-fluid">

    <h3 class="dashboard-title">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}!</h3>
    <p class="subtitle">Ringkasan Nilai dan catatan terbaru dari wali kelas Anda</p>

    <!-- ========================= NILAI RINGKASAN ========================= -->
    <h5 class="fw-bold mt-4 mb-3">Ringkasan Nilai Terbaru</h5>

    <div class="row g-3">

        @if(isset($ringkasanNilai) && count($ringkasanNilai) > 0)
            @foreach($ringkasanNilai as $mapel => $nilai)
                <div class="col-md-3">
                    <div class="card nilai-card shadow-sm p-3">
                        <span class="nilai-title">{{ $mapel }}</span>

                        <div class="nilai-angka mt-1">{{ $nilai['angka'] }}</div>
                        <small>/ 100</small>

                        <p class="text-success predikat mt-1">{{ $nilai['predikat'] }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada nilai terbaru.</p>
        @endif

        <!-- ========================= CATATAN WALI KELAS ========================= -->
        <div class="col-md-3">
            <div class="card shadow-sm p-3 h-100">
                <h6 class="fw-bold">Catatan Wali Kelas</h6>

                <div class="catatan-box mt-2">

                  

                </div>

                <a href="" class="btn btn-primary btn-sm w-100 mt-2">
                    Lihat Semua Catatan
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="rounded-circle mb-3" width="110" height="110" alt="Foto Siswa">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width:110px;height:110px;color:white;font-weight:600;">{{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'S' }}</div>
                    @endif
                    <h5 class="card-title mb-0">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h5>
                    <small class="text-muted d-block">NIS: {{ $siswa->nis ?? '-' }} | NISN: {{ $siswa->nisn ?? '-' }}</small>
                    <hr>
                    <p class="mb-1"><strong>Profil lengkap:</strong></p>
                    @if(isset($missing) && count($missing) > 0)
                        <p class="text-danger small">Masih ada {{ count($missing) }} field kosong</p>
                        <button class="btn btn-sm btn-outline-warning" onclick="location.href='{{ route('siswa.dataDiri.edit') }}'">Lengkapi Sekarang</button>
                    @else
                        <p class="text-success small">Semua data penting terisi</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Raport</h6>
                            <p class="small text-muted">Ringkasan tahun ajaran yang tersedia</p>
                            @if(!empty($raportYears) && count($raportYears) > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($raportYears as $year)
                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>{{ $year }}</div>
                                            <div>
                                                <a href="{{ route('siswa.raport.show', ['semester' => 'Ganjil', 'tahun' => str_replace('/','-',$year)]) }}" class="btn btn-sm btn-outline-primary me-1">Ganjil</a>
                                                <a href="{{ route('siswa.raport.show', ['semester' => 'Genap', 'tahun' => str_replace('/','-',$year)]) }}" class="btn btn-sm btn-outline-primary">Genap</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted small">Belum ada data raport. Silakan hubungi wali kelas.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Kontak Orang Tua</h6>
                            <p class="small text-muted">Informasi kontak dan alamat orang tua/wali</p>
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th width="35%">Nama Ayah</th>
                                        <td>{{ $siswa->ayah->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Ayah</th>
                                        <td>{{ $siswa->ayah->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td>{{ $siswa->ibu->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Ibu</th>
                                        <td>{{ $siswa->ibu->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Orang Tua</th>
                                        <td>{{ $siswa->ayah->alamat ?? ($siswa->ibu->alamat ?? '-') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-sm btn-primary">Edit Kontak</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Informasi Lainnya</h6>
                            <p class="mb-0 small text-muted">Anda dapat mengakses raport, mengunduh PDF data diri, atau menghubungi wali kelas jika ada masalah data.</p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('siswa.raport') }}" class="btn btn-outline-primary">Lihat Semua Raport</a>
                                <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-outline-danger" target="_blank">Unduh Data Diri (PDF)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
