@extends('layouts.app')

@section('title', 'Daftar Siswa')

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
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }
        
        .student-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .student-class {
            margin-left: 0;
            align-self: flex-start;
        }
    }
</style>

<div class="container mt-4">

    <h3 class="mb-3">Daftar Siswa</h3>

    <form method="GET" class="mb-3 d-flex gap-2" action="">
        <input type="text" name="q" value="{{ request('q', $search ?? '') }}" class="form-control" placeholder="Cari nama / NISN / No. Induk">
        <select name="jenis_kelamin" class="form-select" style="width:140px">
            <option value="">Semua</option>
            <option value="L" {{ (request('jenis_kelamin', $jenisKelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ (request('jenis_kelamin', $jenisKelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
        </select>
        <button class="btn btn-primary" type="submit">Filter</button>
        <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
    </form>

    <div class="card shadow">
        @if($siswa->count() > 0)
            <div class="list-group list-group-flush">
                    @foreach ($siswa as $s)
                    <a href="{{ route('walikelas.siswa.show', $s->id) }}"
                       class="list-group-item list-group-item-action">
                        <div class="student-info">
                            <div class="student-avatar">
                                @if($s->foto)
                                    <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}">
                                @else
                                    {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                @endif
                            </div>
                            <div class="student-details">
                                <strong>{{ $s->nama_lengkap }}</strong>
                                <small>NISN: {{ $s->nisn }}</small>
                            </div>
                            @if($s->rombel)
                                <div class="student-class">{{ $s->rombel->nama }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            {{-- menampilkan semua siswa, pagination dinonaktifkan --}}
        @else
            <div class="empty-state">
                <i class="fas fa-user-graduate"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar di kelas Anda.</p>
            </div>
        @endif
    </div>

</div>
@endsection