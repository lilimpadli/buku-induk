@extends('layouts.app')

@section('title', 'Data Pribadi Saya')

@section('content')
<style>
    /* ===================== STYLE DATA PRIBADI KURIKULUM ===================== */
    
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

    /* Profile Placeholder */
    .bg-secondary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
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
        color: white;
    }

    .btn-warning:hover {
        background-color: #D97706;
        border-color: #D97706;
        color: white;
    }

    /* Alert Styles */
    .alert {
        border-radius: 8px;
        border: none;
        font-size: 14px;
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
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
    h5.mb-0 {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 0.5rem !important;
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
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
    }
</style>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="mb-3">
                        @if(isset($user) && $user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width:120px;height:120px;color:white;font-size:28px;font-weight:700;">
                                {{ $guru && $guru->nama ? strtoupper(substr($guru->nama,0,1)) : 'K' }}
                            </div>
                        @endif
                    </div>

                    <h5 class="mb-0">{{ $guru->nama ?? '-' }}</h5>
                    <p class="text-muted mb-1">NIP: {{ $guru->nip ?? '-' }}</p>
                    <p class="text-muted small">{{ $user->username ?? '-' }}</p>

                    <div class="mt-3">
                        <a href="{{ route('kurikulum.data-pribadi.edit') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Informasi Singkat</h6>
                    <p class="mb-1"><strong>Tempat, Tgl Lahir:</strong> {{ $guru->tempat_lahir ?? '-' }}, {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d-m-Y') : '-' }}</p>
                    <p class="mb-1"><strong>Jenis Kelamin:</strong> 
                        @if($guru->jenis_kelamin == 'L')
                            Laki-laki
                        @elseif($guru->jenis_kelamin == 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                    <p class="mb-0"><strong>Alamat:</strong> {{ $guru->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Profil</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th>Nama</th><td>{{ $guru->nama ?? '-' }}</td></tr>
                                <tr><th>NIP</th><td>{{ $guru->nip ?? '-' }}</td></tr>
                                <tr><th>Email</th><td>{{ $guru->email ?? '-' }}</td></tr>
                                <tr><th>Telepon</th><td>{{ $guru->telepon ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th>Tempat Lahir</th><td>{{ $guru->tempat_lahir ?? '-' }}</td></tr>
                                <tr><th>Tanggal Lahir</th><td>{{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d F Y') : '-' }}</td></tr>
                                <tr><th>Jenis Kelamin</th><td>
                                    @if($guru->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($guru->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </td></tr>
                                <tr><th>Umur</th><td>{{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->age . ' tahun' : '-' }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="card-title">Alamat Lengkap</h6>
                    <p class="mb-0">{{ $guru->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
