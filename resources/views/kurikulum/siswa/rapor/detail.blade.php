@extends('layouts.app')

@section('title', 'Review Rapor')

@section('content')
<style>
    /* ===================== STYLE REVIEW RAPOR ===================== */
    
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

    .container {
        max-width: 1200px;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 20px !important;
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

    /* Header Buttons */
    .d-flex.justify-content-between {
        margin-bottom: 30px !important;
    }

    /* Table Styles */
    .table {
        margin-bottom: 25px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        background-color: white;
    }

    .table-bordered {
        border: 1px solid #E2E8F0;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #E2E8F0;
        padding: 12px 15px;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 15px;
    }

    .table tbody td {
        color: #334155;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.02);
    }

    .text-center {
        text-align: center;
    }

    /* Section Headers */
    h5.fw-bold {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin: 30px 0 15px 0;
        position: relative;
        padding-left: 15px;
    }

    h5.fw-bold::before {
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

    /* Button Styles */
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

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-warning:hover {
        background-color: #D97706;
        border-color: #D97706;
    }

    /* Signature Section */
    .row.mt-5 {
        margin-top: 50px !important;
    }

    .row.mt-5 p {
        margin-bottom: 10px;
        color: #475569;
        font-weight: 500;
    }

    .row.mt-5 b {
        color: #1E293B;
        font-weight: 600;
    }

    .row.mt-5 br {
        content: "";
        display: block;
        margin-bottom: 15px;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
    }

    b {
        color: #334155;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table, h5.fw-bold {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3 {
            font-size: 24px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
        }
        
        .d-flex.justify-content-between div {
            width: 100%;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
        
        .table-bordered th,
        .table-bordered td {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        h5.fw-bold {
            font-size: 16px;
        }
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Review Rapor</h3>
        <div>
            <a href="{{ route('kurikulum.rapor.show', $siswa->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('kurikulum.rapor.cetak', [
                $siswa->id,
                $semester,
                str_replace('/', '-', $tahun)
            ]) }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    {{-- Identitas --}}
    <table class="table table-bordered mb-4">
        <tr>
            <th width="30%">Nama Peserta Didik</th>
            <td>{{ strtoupper($siswa->nama_lengkap) }}</td>
            <th width="30%">Kelas</th>
            <td>{{ $rombelRaport->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>NISN</th>
            <td>{{ $siswa->nisn }}</td>
            <th>Semester</th>
            <td>{{ $semester }}</td>
        </tr>
        <tr>
            <th>Sekolah</th>
            <td>SMK NEGERI 1 X</td>
            <th>Tahun Pelajaran</th>
            <td>{{ $tahun }}</td>
        </tr>
    </table>

    {{-- A. Kelompok A --}}
    <h5 class="fw-bold mt-4">A. Kelompok Mata Pelajaran Umum</h5>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php $groupA = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A'); @endphp
            @if($groupA->isEmpty())
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                </tr>
            @else
                @foreach($groupA as $n)
                    <tr>
                        <td class="text-center">{{ $n->mapel->urutan }}</td>
                        <td>{{ $n->mapel->nama }}</td>
                        <td class="text-center">{{ $n->nilai_akhir }}</td>
                        <td>{{ $n->deskripsi }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- B. Kelompok B --}}
    <h5 class="fw-bold mt-4">B. Kelompok Mata Pelajaran Kejuruan</h5>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php $groupB = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B'); @endphp
            @if($groupB->isEmpty())
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                </tr>
            @else
                @foreach($groupB as $n)
                    <tr>
                        <td class="text-center">{{ $n->mapel->urutan }}</td>
                        <td>{{ $n->mapel->nama }}</td>
                        <td class="text-center">{{ $n->nilai_akhir }}</td>
                        <td>{{ $n->deskripsi }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- Ekstrakurikuler --}}
    <h5 class="fw-bold mt-4">C. Kegiatan Ekstrakurikuler</h5>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Nama Ekstrakurikuler</th>
                <th>Predikat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekstra as $i => $e)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $e->nama_ekstra }}</td>
                    <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                    <td>{{ $e->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Kehadiran --}}
    <h5 class="fw-bold mt-4">D. Ketidakhadiran</h5>
    <table class="table table-bordered" style="width: 50%">
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

    {{-- Kenaikan --}}
    @if(strtolower($semester) !== 'ganjil')
        <h5 class="fw-bold mt-4">E. Kenaikan Kelas</h5>
        <p><b>Status:</b> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
        @if(isset($kenaikan->rombelTujuan))
            <p><b>Ke Kelas:</b> {{ $kenaikan->rombelTujuan->nama }}</p>
        @endif
        <p><b>Catatan:</b> {{ $kenaikan->catatan ?? '-' }}</p>
    @endif

</div>
@endsection