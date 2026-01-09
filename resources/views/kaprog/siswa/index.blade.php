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

        <!-- Search & Filter Section -->
        <div class="card mb-3" style="border: 1px solid #E2E8F0; border-radius: 8px;">
            <div class="card-body" style="background-color: #F8FAFC;">
                <form method="GET" action="{{ route('kaprog.siswa.index') }}" class="row g-3">
                    <!-- Search Box -->
                    <div class="col-md-5">
                        <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Siswa</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: white; border: 1px solid #E2E8F0;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Nama, NIS, atau NISN..." 
                                value="{{ $search }}"
                                style="border: 1px solid #E2E8F0;"
                            >
                        </div>
                    </div>

                    <!-- Filter Tingkat -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Tingkat</label>
                        <select name="tingkat" class="form-select" style="border: 1px solid #E2E8F0;">
                            <option value="">-- Semua Tingkat --</option>
                            <option value="X" {{ $filterTingkat == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ $filterTingkat == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ $filterTingkat == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                    </div>

                    <!-- Filter Rombel -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Rombel</label>
                        <select name="rombel" class="form-select" style="border: 1px solid #E2E8F0;">
                            <option value="">-- Semua Rombel --</option>
                            @foreach($allRombels as $rombel)
                                @php
                                    $rombelNama = $rombel->nama ?? null;
                                    $tingkatVal = optional($rombel->kelas)->tingkat ?? null;
                                    $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                    $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                    $formattedRombel = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : ($rombelNama ?? '');
                                @endphp
                                <option value="{{ $rombel->id }}" {{ $filterRombel == $rombel->id ? 'selected' : '' }}>
                                    {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(to right, #2F53FF, #6366F1); border: none;">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-secondary w-100" style="background-color: #E2E8F0; color: #475569; border: none;">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

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
                    @php $list = $studentsByTingkat[$t] ?? collect(); @endphp
                    @if($list->count() > 0)
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
                            @foreach($list as $i => $s)
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
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h5>Tidak ada siswa di Kelas {{ $t }}</h5>
                        <p>Tidak ada siswa yang sesuai dengan pencarian atau filter yang Anda pilih.</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection