@extends('layouts.app')

@section('title', 'Detail Raport')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Raport</h3>
        <div>
            <a href="{{ route('siswa.raport') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('siswa.raport.pdf', [$semester, str_replace('/','-',$tahun)]) }}" class="btn btn-primary" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Siswa</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="20%">Nama Lengkap</th>
                    <td width="30%">{{ $siswa->nama_lengkap }}</td>
                    <th width="20%">NISN</th>
                    <td width="30%">{{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->rombel->nama ?? '-' }}</td>
                    <th>Jurusan</th>
                    <td>{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>{{ $semester }}</td>
                    <th>Tahun Ajaran</th>
                    <td>{{ $tahun }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Nilai Mata Pelajaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Nilai Mata Pelajaran</h5>
            
            <!-- Kelompok A -->
            <h6 class="mt-3 mb-3">A. Kelompok Mata Pelajaran Umum</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>KKM</th>
                            <th>Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $index => $nilai)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $nilai->mapel->nama }}</td>
                                <td class="text-center">{{ $nilai->mapel->kkm }}</td>
                                <td class="text-center">{{ $nilai->nilai_akhir }}</td>
                                <td>{{ $nilai->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data mata pelajaran kelompok A</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Kelompok B -->
            <h6 class="mt-4 mb-3">B. Kelompok Mata Pelajaran Kejuruan</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>KKM</th>
                            <th>Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $index => $nilai)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $nilai->mapel->nama }}</td>
                                <td class="text-center">{{ $nilai->mapel->kkm }}</td>
                                <td class="text-center">{{ $nilai->nilai_akhir }}</td>
                                <td>{{ $nilai->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data mata pelajaran kelompok B</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ekstrakurikuler -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Kegiatan Ekstrakurikuler</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Ekstrakurikuler</th>
                            <th>Predikat</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekstra as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_ekstra }}</td>
                                <td class="text-center">{{ $item->predikat ?? '-' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data ekstrakurikuler</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kehadiran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Ketidakhadiran</h5>
            <div class="table-responsive" style="width: 50%;">
                <table class="table table-bordered">
                    <tr>
                        <th>Sakit</th>
                        <td>{{ $kehadiran->sakit ?? 0 }} hari</td>
                    </tr>
                    <tr>
                        <th>Izin</th>
                        <td>{{ $kehadiran->izin ?? 0 }} hari</td>
                    </tr>
                    <tr>
                        <th>Tanpa Keterangan</th>
                        <td>{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Kenaikan Kelas -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Kenaikan Kelas</h5>
            <p><strong>Status:</strong> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
            @if(isset($kenaikan->rombelTujuan))
                <p><strong>Ke Kelas:</strong> {{ $kenaikan->rombelTujuan->nama }}</p>
            @endif
            <p><strong>Catatan:</strong> {{ $kenaikan->catatan ?? '-' }}</p>
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <p>Wali Kelas</p>
                    <br><br><br>
                    <p><strong>{{ $info->wali_kelas ?? '-' }}</strong></p>
                    <p>NIP. {{ $info->nip_wali ?? '-' }}</p>
                </div>
                <div class="col-md-6 text-center">
                    <p>Kepala Sekolah</p>
                    <br><br><br>
                    <p><strong>{{ $info->kepala_sekolah ?? '-' }}</strong></p>
                    <p>NIP. {{ $info->nip_kepsek ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection