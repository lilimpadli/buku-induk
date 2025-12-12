@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">Detail Siswa</h3>
            <small class="text-muted">Informasi lengkap siswa</small>
        </div>
        <div>
            <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('walikelas.siswa.show', $s->id) }}?edit=1" class="btn btn-primary">Edit</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3 text-center">
                <div class="card-body">
                    @if(!empty($s->foto) && file_exists(public_path('storage/' . $s->foto)))
                        <img src="{{ asset('storage/' . $s->foto) }}" class="rounded-circle mb-3" width="140" height="140" style="object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&size=140" class="rounded-circle mb-3" width="140" height="140">
                    @endif

                    <h5 class="mb-0">{{ $s->nama_lengkap }}</h5>
                    <small class="text-muted">NIS: {{ $s->nis }} | NISN: {{ $s->nisn ?? '-' }}</small>

                    <hr>
                    <p class="mb-1"><strong>Kelas:</strong> {{ $s->kelas ?? '-' }}</p>
                    <p class="mb-0"><strong>Tanggal Diterima:</strong> {{ $s->tanggal_diterima ?? '-' }}</p>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Kontak</h6>
                    <p class="mb-1"><strong>No HP:</strong> {{ $s->no_hp ?? '-' }}</p>
                    <p class="mb-1"><strong>Telepon Ayah:</strong> {{ $s->telepon_ayah ?? '-' }}</p>
                    <p class="mb-1"><strong>Telepon Ibu:</strong> {{ $s->telepon_ibu ?? '-' }}</p>
                    <p class="mb-0"><strong>Telepon Wali:</strong> {{ $s->telepon_wali ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm mb-3 p-3">
                <h5>Informasi Pribadi</h5>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th>Nama Lengkap</th><td>{{ $s->nama_lengkap }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ $s->jenis_kelamin }}</td></tr>
                            <tr><th>Tempat, Tanggal Lahir</th><td>{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ?? '-' }}</td></tr>
                            <tr><th>Agama</th><td>{{ $s->agama ?? '-' }}</td></tr>
                            <tr><th>Status Keluarga</th><td>{{ $s->status_keluarga ?? '-' }}</td></tr>
                            <tr><th>Anak Ke</th><td>{{ $s->anak_ke ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th>Alamat</th><td>{{ $s->alamat ?? '-' }}</td></tr>
                            <tr><th>Sekolah Asal</th><td>{{ $s->sekolah_asal ?? '-' }}</td></tr>
                            <tr><th>Tanggal Diterima</th><td>{{ $s->tanggal_diterima ?? '-' }}</td></tr>
                            <tr><th>Rombel</th><td>{{ $s->rombel->nama ?? ($s->rombel_id ? 'Rombel #' . $s->rombel_id : '-') }}</td></tr>
                            <tr><th>Catatan Wali</th><td>{{ $s->catatan_wali_kelas ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm p-3">
                <h5>Data Orang Tua / Wali</h5>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th>Nama Ayah</th><td>{{ $s->nama_ayah ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Ayah</th><td>{{ $s->pekerjaan_ayah ?? '-' }}</td></tr>
                            <tr><th>Telepon Ayah</th><td>{{ $s->telepon_ayah ?? '-' }}</td></tr>
                            <tr><th>Nama Ibu</th><td>{{ $s->nama_ibu ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Ibu</th><td>{{ $s->pekerjaan_ibu ?? '-' }}</td></tr>
                            <tr><th>Telepon Ibu</th><td>{{ $s->telepon_ibu ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th>Alamat Orang Tua</th><td>{{ $s->alamat_orangtua ?? '-' }}</td></tr>
                            <tr><th>Nama Wali</th><td>{{ $s->nama_wali ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Wali</th><td>{{ $s->pekerjaan_wali ?? '-' }}</td></tr>
                            <tr><th>Alamat Wali</th><td>{{ $s->alamat_wali ?? '-' }}</td></tr>
                            <tr><th>Telepon Wali</th><td>{{ $s->telepon_wali ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
