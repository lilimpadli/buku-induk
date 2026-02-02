@extends('layouts.app')

@section('title','Daftar Siswa - Kaprog')

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

    h3.mb-3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h3.mb-3::before {
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
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    /* Filter Button Styles */
    .btn-group .btn {
        border-radius: 8px;
        margin-right: 5px;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }

    /* List Group Styles */
    .list-group {
        border-radius: 16px;
    }

    .list-group-flush > .list-group-item {
        border-width: 0 0 1px;
        border-color: #E2E8F0;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .list-group-flush > .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-flush > .list-group-item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .list-group-flush > .list-group-item:hover {
        background-color: rgba(47, 83, 255, 0.03);
        padding-left: 25px;
    }

    .list-group-flush > .list-group-item:hover::before {
        transform: scaleY(1);
    }

    .list-group-item-action {
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .list-group-item-action:hover {
        color: var(--primary-color);
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .list-group-item:hover .student-avatar {
        transform: scale(1.1);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .student-details small {
        color: #64748B;
        font-size: 14px;
    }

    .student-class {
        margin-left: auto;
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .student-gender {
        margin-right: 15px;
        color: #64748B;
        font-size: 14px;
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

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }



    /* Responsive */
    @media (max-width: 768px) {
        h3.mb-3 {
            font-size: 24px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .mb-3 {
            overflow-x: auto;
        }
        
        .btn-group {
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .btn-group .btn {
            flex: 1;
            min-width: 80px;
            font-size: 12px;
            padding: 0.3rem 0.75rem;
        }
        
        .card-body form.row {
            flex-direction: column;
        }
        
        .col-md-6, .col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .input-group {
            width: 100%;
        }
        
        .col-md-3 .btn {
            width: 100%;
        }
        
        .list-group-flush > .list-group-item {
            padding: 12px;
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .student-info {
            width: 100%;
            flex-direction: row;
            gap: 10px;
        }
        
        .student-details {
            flex: 1;
        }
        
        .student-class {
            margin-left: 0;
            margin-top: 8px;
            align-self: flex-start;
        }
        
        .student-gender {
            margin-right: 0;
            margin-bottom: 8px;
        }
        
        .student-actions {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
        
        .student-actions .btn-group {
            width: 100%;
        }
        
        .student-actions .btn-group .btn {
            flex: 1;
            font-size: 12px;
        }
        
        .form-control, .form-select {
            font-size: 14px;
            padding: 8px 10px;
        }

        .pagination {
            flex-wrap: wrap;
            gap: 4px;
        }

        .pagination .page-link {
            padding: 6px 10px;
            min-width: 36px;
            height: 36px;
            font-size: 12px;
        }
    }
    
    @media (max-width: 576px) {
        h3.mb-3 {
            font-size: 20px;
            padding-left: 12px;
        }
        
        h3.mb-3::before {
            width: 4px;
        }
        
        .btn-group {
            width: 100%;
            flex-direction: column;
            gap: 6px;
        }
        
        .btn-group .btn {
            width: 100%;
        }
        
        .list-group-flush > .list-group-item {
            padding: 10px;
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .student-details strong {
            font-size: 14px;
        }
        
        .student-details small {
            font-size: 12px;
        }
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-3">Daftar Siswa - Kaprog</h3>
        @if(isset($jurusanId) && $jurusanId)
        <a href="{{ route('kaprog.export.angkatan', $jurusanId) }}" class="btn btn-success">
            <i class="fas fa-file-excel me-2"></i> Export Per Angkatan
        </a>
        @endif
    </div>

    <div class="mb-3">
        @php $currentTingkat = request()->query('tingkat', ''); @endphp
        <div class="btn-group" role="group">
            <a href="{{ request()->url() }}?tingkat=X" class="btn btn-sm {{ $currentTingkat == 'X' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas X</a>
            <a href="{{ request()->url() }}?tingkat=XI" class="btn btn-sm {{ $currentTingkat == 'XI' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas XI</a>
            <a href="{{ request()->url() }}?tingkat=XII" class="btn btn-sm {{ $currentTingkat == 'XII' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas XII</a>
            <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
        </div>
    </div>

    <div class="card mb-3" style="border-radius: 16px; border: none; box-shadow: var(--card-shadow);">
        <div class="card-body">
            <form method="GET" action="{{ route('kaprog.siswa.index') }}" class="row g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="background:white;border:1px solid #E2E8F0;"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN..." value="{{ $search ?? '' }}" style="border:1px solid #E2E8F0;">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="rombel" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Rombel --</option>
                        @foreach(($allRombels ?? collect()) as $r)
                            @php
                                $rombelNama = $r->nama ?? null;
                                $tingkatVal = optional($r->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formattedRombel = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : ($rombelNama ?? '');
                            @endphp
                            <option value="{{ $r->id }}" {{ (isset($filterRombel) && $filterRombel == $r->id) ? 'selected' : '' }}>
                                {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @php
        // Merge paginated results from all tingkats
        $currentTingkat = request()->query('tingkat', '');
        
        if ($currentTingkat && $currentTingkat !== 'all' && isset($studentsByTingkat[$currentTingkat])) {
            $siswas = $studentsByTingkat[$currentTingkat];
        } else {
            // Combine all tingkats (take first 15)
            $allSiswas = collect();
            foreach(['X','XI','XII'] as $t) {
                if ($studentsByTingkat[$t] instanceof \Illuminate\Pagination\Paginator || 
                    $studentsByTingkat[$t] instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                    $allSiswas = $allSiswas->merge($studentsByTingkat[$t]->items());
                } else {
                    $allSiswas = $allSiswas->merge($studentsByTingkat[$t] ?? collect());
                }
            }
            // Create a paginator for the merged collection
            $perPage = 15;
            $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $siswas = new \Illuminate\Pagination\LengthAwarePaginator(
                $allSiswas->forPage($page, $perPage)->values(),
                $allSiswas->count(),
                $perPage,
                $page,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }
    @endphp

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        @if($siswas->count() > 0)
            <div class="list-group list-group-flush">
                @foreach ($siswas as $siswa)
                    <a href="{{ route('kaprog.siswa.show', $siswa->id) }}" class="list-group-item list-group-item-action">
                        <div class="student-info">
                            <div class="student-avatar">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                @else
                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                @endif
                            </div>
                            <div class="student-details">
                                <strong>{{ $siswa->nama_lengkap }}</strong>
                                <small>NIS: {{ $siswa->nis }}</small>
                            </div>
                    
                            @php
                                $rombel = $siswa->rombel ?? null;
                                $rombelNama = $rombel->nama ?? null;
                                $tingkatVal = optional($rombel->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formatted = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : null;
                            @endphp
                            @if($rombel)
                                <div class="student-class">
                                    @if($tingkatVal)
                                        {{ $tingkatVal }} {{ $formatted }}
                                    @else
                                        {{ $formatted }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            
            @if($siswas instanceof \Illuminate\Pagination\Paginator || $siswas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-body" style="border-top: 1px solid #E2E8F0; text-align: center;">
                    {{ $siswas->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-user-graduate"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan select per_page berfungsi
    const perPageSelect = document.querySelector('select[name="per_page"]');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endsection