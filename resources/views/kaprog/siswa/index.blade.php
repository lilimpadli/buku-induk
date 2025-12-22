@extends('layouts.app')

@section('title','Daftar Siswa')

@section('content')
<style>
    /* ===================== STYLE DAFTAR SISWA ===================== */
    
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

    h3.page-title {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h3.page-title::before {
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
    .content-card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        background-color: #ffffff;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .content-card:hover {
        box-shadow: var(--hover-shadow);
    }

    /* Tab Styles */
    .nav-tabs {
        border-bottom: none;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        padding: 12px 20px;
        margin-right: 5px;
        color: #64748B;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(47, 83, 255, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: white;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
    }

    .tab-content {
        border-radius: 0 0 16px 16px;
        background-color: white;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Table Styles */
    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table thead th {
        border: none;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 15px 10px;
    }

    .table tbody tr {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table tbody td {
        border: none;
        padding: 15px 10px;
        vertical-align: middle;
    }

    .table tbody td:first-child {
        border-radius: 8px 0 0 8px;
    }

    .table tbody td:last-child {
        border-radius: 0 8px 8px 0;
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 6px;
        padding: 6px 15px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-pane {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3.page-title {
            font-size: 24px;
        }
        
        .nav-tabs .nav-link {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .table-responsive {
            border-radius: 8px;
        }
    }
</style>

<div class="container mt-4">
    <div class="content-card">
        <h3 class="page-title">Daftar Siswa - Kaprog</h3>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-X" data-bs-toggle="tab" href="#pane-X" role="tab" aria-controls="pane-X" aria-selected="true">Kelas X</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-XI" data-bs-toggle="tab" href="#pane-XI" role="tab" aria-controls="pane-XI" aria-selected="false">Kelas XI</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-XII" data-bs-toggle="tab" href="#pane-XII" role="tab" aria-controls="pane-XII" aria-selected="false">Kelas XII</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            @foreach(['X','XI','XII'] as $t)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $t }}" role="tabpanel" aria-labelledby="tab-{{ $t }}">
                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIS / NISN</th>
                                <th scope="col">Rombel</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $list = $studentsByTingkat[$t] ?? collect(); @endphp
                            @forelse($list as $i => $s)
                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>{{ $s->nis }} / {{ $s->nisn }}</td>
                                <td>{{ optional($s->rombel)->nama ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kaprog.siswa.show', $s->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye-fill"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-user-graduate"></i>
                                        <h5>Tidak ada siswa pada angkatan {{ $t }}</h5>
                                        <p>Belum ada siswa yang terdaftar untuk angkatan ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection