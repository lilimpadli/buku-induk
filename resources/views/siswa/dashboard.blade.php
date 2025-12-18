@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row g-3">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Dashboard Siswa</h3>
            <div>
                <a href="{{ route('siswa.dataDiri') }}" class="btn btn-outline-primary me-2">Data Diri</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
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