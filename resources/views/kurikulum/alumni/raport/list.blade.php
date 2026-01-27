@extends('layouts.app')

@section('title', 'Riwayat Rapor Alumni')

@section('content')
<style>
    /* ===================== STYLE RIWAYAT RAPOR ALUMNI ===================== */
    
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
        margin-bottom: 10px !important;
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

    p.text-muted {
        color: #64748B !important;
        margin-left: 20px;
        margin-bottom: 25px;
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

    /* Report Info */
    .report-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .report-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .list-group-item:hover .report-icon {
        transform: scale(1.1);
    }

    .report-details {
        flex: 1;
    }

    .report-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .report-details small {
        color: #64748B;
        font-size: 14px;
        display: block;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        transition: all 0.3s ease;
    }

    .list-group-item:hover .badge {
        transform: scale(1.05);
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

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3 {
            font-size: 24px;
        }
        
        p.text-muted {
            margin-left: 0;
            margin-bottom: 20px;
        }
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }
        
        .report-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .badge {
            align-self: flex-start;
            margin-top: 10px;
        }
    }
</style>

<div class="container mt-4">

    <h3>Riwayat Rapor — {{ $siswa->nama_lengkap }}</h3>
    <p class="text-muted">Pilih raport berdasarkan semester dan tahun ajaran</p>

    <div class="card shadow">
        @forelse ($raports as $r)
            <div class="list-group list-group-flush">
                <a href="{{ route('kurikulum.alumni.raport.show', [
                        'siswa_id' => $siswa->id,
                        'semester' => $r->semester,
                        'tahun' => str_replace('/', '-', $r->tahun_ajaran)
                    ]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">

                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="report-details">
                            <strong>Semester: {{ $r->semester ?? '-' }}</strong>
                            <small>Tahun Ajaran: {{ $r->tahun_ajaran ?? '-' }}</small>
                        </div>
                    </div>

                    <span class="badge bg-primary">Lihat Rapor</span>

                </a>
            </div>
        @empty

            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h5>Belum ada raport</h5>
                <p>Belum ada raport tersimpan untuk alumni ini.</p>
            </div>

        @endforelse

    </div>
</div>
@endsection
