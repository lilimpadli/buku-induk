@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<style>
    /* ===================== STYLE DETAIL SISWA ===================== */
    
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

    h3.mb-0 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 5px !important;
    }

    h3.mb-0::before {
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

    .card.shadow-sm {
        box-shadow: var(--card-shadow);
    }

    /* Section Headers */
    h5, h6 {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
    }

    h5::before, h6::before {
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

    /* Profile Image */
    .rounded-circle {
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .rounded-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* Student Name */
    h5.mb-0 {
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 5px !important;
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

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table-borderless th,
    .table-borderless td {
        border: none;
        padding: 0.5rem 0;
    }

    .table-borderless th {
        color: #64748B;
        font-weight: 600;
        font-size: 14px;
        width: 40%;
    }

    .table-borderless td {
        color: #334155;
        font-size: 14px;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
    }

    strong {
        color: #475569;
        font-weight: 600;
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
        
        h3.mb-0 {
            font-size: 24px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .table-borderless th,
        .table-borderless td {
            font-size: 13px;
        }
    }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">Detail Siswa</h3>
            <small class="text-muted">Informasi lengkap siswa</small>
        </div>
        <div>
            <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-secondary">Kembali</a>
            @if(auth()->check())
                @php $role = auth()->user()->role; @endphp
                @if($role == 'walikelas')
                    <a href="{{ route('walikelas.siswa.exportPDF', $s->id) }}" class="btn btn-danger" target="_blank">Export PDF</a>
                @elseif($role == 'guru')
                    <a href="{{ route('guru.siswa.exportPDF', $s->id) }}" class="btn btn-danger" target="_blank">Export PDF</a>
                @endif
            @endif
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
                    <p class="mb-1"><strong>Telepon Ayah:</strong> {{ $s->ayah->telepon ?? '-' }}</p>
                    <p class="mb-1"><strong>Telepon Ibu:</strong> {{ $s->ibu->telepon ?? '-' }}</p>
                    <p class="mb-0"><strong>Telepon Wali:</strong> {{ $s->wali->telepon ?? '-' }}</p>
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
                            <tr><th>Nama Ayah</th><td>{{ $s->ayah->nama ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Ayah</th><td>{{ $s->ayah->pekerjaan ?? '-' }}</td></tr>
                            <tr><th>Telepon Ayah</th><td>{{ $s->ayah->telepon ?? '-' }}</td></tr>
                            <tr><th>Alamat Ayah</th><td>{{ $s->ayah->alamat ?? '-' }}</td></tr>
                            <tr><th>Nama Ibu</th><td>{{ $s->ibu->nama ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Ibu</th><td>{{ $s->ibu->pekerjaan ?? '-' }}</td></tr>
                            <tr><th>Telepon Ibu</th><td>{{ $s->ibu->telepon ?? '-' }}</td></tr>
                            <tr><th>Alamat Ibu</th><td>{{ $s->ibu->alamat ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th>Nama Wali</th><td>{{ $s->wali->nama ?? '-' }}</td></tr>
                            <tr><th>Pekerjaan Wali</th><td>{{ $s->wali->pekerjaan ?? '-' }}</td></tr>
                            <tr><th>Alamat Wali</th><td>{{ $s->wali->alamat ?? '-' }}</td></tr>
                            <tr><th>Telepon Wali</th><td>{{ $s->wali->telepon ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection