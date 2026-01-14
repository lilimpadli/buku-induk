@extends('layouts.app')

@section('title', 'Detail Raport')

@section('content')
<style>
    /* ===================== STYLE DETAIL RAPORT ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 20px;
    }

    h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
    }

    .card-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table-bordered {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        overflow: hidden;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #E2E8F0;
    }

    .table th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 15px;
    }

    .table td {
        padding: 12px 15px;
        color: #334155;
        font-size: 14px;
    }

    .table-light {
        background-color: #F1F5F9 !important;
    }

    /* Section Headers */
    h6.mt-3.mb-3,
    h6.mt-4.mb-3 {
        font-size: 16px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 15px !important;
        position: relative;
        padding-left: 12px;
    }

    h6.mt-3.mb-3::before,
    h6.mt-4.mb-3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        color: #64748B;
        border-color: #E2E8F0;
    }

    .btn-outline-secondary:hover {
        background-color: #F1F5F9;
        border-color: #CBD5E1;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    /* Text alignment */
    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #64748B !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        h3 {
            font-size: 24px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .table th,
        .table td {
            padding: 8px 10px;
            font-size: 13px;
        }
    }
</style>

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
                    <td>{{ $rombelRaport->nama ?? ($siswa->rombel->nama ?? '-') }}</td>
                    <th>Jurusan</th>
                    <td>{{ optional($kelasRaport->jurusan)->nama ?? ($siswa->rombel->kelas->jurusan->nama ?? '-') }}</td>
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
                            <th>Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $index => $nilai)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $nilai->mapel->nama }}</td>
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
                            <th>Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $index => $nilai)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $nilai->mapel->nama }}</td>
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
    @if(strtolower($semester) !== 'ganjil')
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
    @endif

</div>
@endsection