@extends('layouts.app')

@section('content')
<style>
    /* ===================== STYLE DETAIL GURU ===================== */
    
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
        max-width: 1000px;
        padding-top: 2rem;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 1.5rem !important;
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

    h5.mt-3 {
        font-size: 20px;
        color: #1E293B;
        font-weight: 600;
        margin-top: 2rem !important;
        margin-bottom: 1rem !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mt-3::before {
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

    /* Info Section */
    p {
        color: #475569;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    p strong {
        color: #334155;
        font-weight: 600;
    }

    hr {
        border: none;
        border-top: 1px solid #E2E8F0;
        margin: 2rem 0;
    }

    /* Table Styles */
    .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
    }

    .table-bordered {
        border: 1px solid #E2E8F0;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #E2E8F0;
    }

    .table-sm {
        font-size: 14px;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        padding: 12px 15px;
        border-bottom: 2px solid #E2E8F0;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #64748B !important;
        font-style: italic;
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

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .container > * {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3 {
            font-size: 24px;
        }
        
        h5.mt-3 {
            font-size: 18px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .table {
            font-size: 13px;
        }
        
        .table thead th,
        .table tbody td {
            padding: 8px 10px;
        }
        
        .container {
            max-width: 100%;
            padding: 0 1rem;
        }
    }
    
    @media (max-width: 576px) {
        h3 {
            font-size: 20px;
            padding-left: 12px;
        }
        
        h5.mt-3 {
            font-size: 16px;
        }
        
        .table {
            font-size: 12px;
        }
        
        .table thead th,
        .table tbody td {
            padding: 6px 8px;
        }
        
        .btn {
            padding: 0.3rem 0.8rem;
            font-size: 12px;
        }
    }
</style>

<div class="container">
    <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
        <!-- Foto Guru -->
        <div style="flex-shrink: 0;">
            @if($guru->user && $guru->user->photo)
                <img src="{{ asset('storage/' . $guru->user->photo) }}" 
                     alt="Foto {{ $guru->nama }}" 
                     style="width: 150px; height: 150px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            @else
                <div style="width: 150px; height: 150px; border-radius: 12px; background: linear-gradient(135deg, #2F53FF, #6366F1); display: flex; align-items: center; justify-content: center; color: white; font-size: 60px; font-weight: bold; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    {{ strtoupper(substr($guru->nama, 0, 1)) }}
                </div>
            @endif
        </div>

        <!-- Info Guru -->
        <div style="flex: 1;">
            <h3 style="margin-top: 0;">Detail Guru: {{ $guru->nama }}</h3>

            <p>
                <strong>Email:</strong> {{ $guru->email }} <br>
                <strong>NIP:</strong> {{ $guru->nip }} <br>

                @if(optional($guru->user)->role)
                    <strong>Role:</strong> {{ $guru->user->role }} <br>
                @endif

                @if(optional($guru->user)->name)
                    <strong>Login Name:</strong> {{ $guru->user->name }}
                @endif
            </p>
        </div>
    </div>

    <hr>

    <h5 class="mt-3">
        Rombel yang diampu di jurusan {{ $jurusan->nama }}
    </h5>

    <table class="table table-bordered table-sm mt-3">
        <thead class="table-light">
            <tr>
                <th>Rombel</th>
                <th>Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rombels as $r)
                <tr>
                    <td>{{ $r->nama }}</td>

                    <td>
                        {{ optional($r->kelas)->tingkat ?? '-' }}
                        {{ optional(optional($r->kelas)->jurusan)->kode ?? '' }}
                    </td>

                    <td class="text-center">
                        {{ $r->siswa_count ?? 0 }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('kaprog.kelas.show', $r->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Lihat Rombel
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        <i class="fas fa-inbox me-2"></i>
                        <em>Tidak ada rombel yang diampu.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('kaprog.guru.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>
@endsection