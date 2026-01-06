@extends('layouts.app')

@section('title', 'Nilai Raport')

@section('content')
<style>
    /* ===================== STYLE NILAI RAPORT ===================== */
    
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

    p {
        color: #64748B;
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

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
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

    .student-details {
        flex: 1;
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
        display: block;
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

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 10px;
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
        
        p {
            margin-left: 0;
            margin-bottom: 20px;
        }
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }
        
        .student-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .text-end {
            margin-top: 15px;
            align-self: flex-start;
        }
    }

    /* Kelas Header */
    .kelas-header {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
        padding: 10px 20px;
        background: linear-gradient(135deg, rgba(47, 83, 255, 0.1), rgba(99, 102, 241, 0.1));
        border-radius: 12px;
        border-left: 4px solid var(--primary-color);
    }

    .kelas-section {
        margin-bottom: 30px;
    }

    .kelas-section:last-child {
        margin-bottom: 0;
    }

</style>

<div class="container mt-4">
    <h3>Nilai Raport Siswa</h3>
    <p>Pilih siswa untuk melihat daftar raport berdasarkan semester.</p>

    <form method="GET" class="mb-3 d-flex gap-2" action="">
        <input type="text" name="q" value="{{ request('q', $search ?? '') }}" class="form-control" placeholder="Cari nama / NIS / NISN">
        <button class="btn btn-primary" type="submit">Cari</button>
        <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-outline-secondary">Reset</a>
    </form>

    <div class="card shadow">
        @if($siswas->count() > 0)
            @foreach($siswas as $kelas => $siswaList)
                <div class="kelas-section mb-4">
                    <h5 class="kelas-header">{{ $kelas }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach ($siswaList as $siswa)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
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
                                        <small>
                                            NIS: {{ $siswa->nis }} |
                                            NISN: {{ $siswa->nisn }}
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    {{-- Tombol List Raport --}}
                                    <a href="{{ route('walikelas.nilai_raport.list', $siswa->id) }}"
                                       class="btn btn-secondary btn-sm">
                                        <i class="fas fa-file-alt me-1"></i> Semua Raport
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h5>Tidak ada siswa</h5>
                <p>Belum ada siswa yang terdaftar di kelas Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection