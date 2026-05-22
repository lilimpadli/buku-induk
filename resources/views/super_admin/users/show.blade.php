@extends('layouts.app')

@section('title', 'Detail User')

@push('styles')
<style>
.page-header{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    border-radius: 28px;
    padding: 30px 28px;
    color: white;
    box-shadow: 0 24px 48px rgba(47,83,255,0.14);
    margin-bottom: 28px;
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
}

.page-subtitle{
    color: rgba(255,255,255,0.88);
    margin: 0;
    font-size: 0.98rem;
    line-height: 1.7;
}

.card-modern{
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(15,23,42,0.08);
    border: none;
    overflow: hidden;
}

.card-modern .card-body{
    padding: 28px;
}

.detail-section{
    margin-bottom: 28px;
}

.detail-section:last-child{
    margin-bottom: 0;
}

.section-title{
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

.detail-row{
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 24px;
    padding: 16px 0;
    border-bottom: 1px solid #f1f5f9;
}

.detail-row:last-child{
    border-bottom: none;
}

.detail-label{
    font-weight: 700;
    color: #475569;
    font-size: 0.95rem;
}

.detail-value{
    color: #1e293b;
    font-size: 1rem;
}

.badge-role{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: 999px;
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
    box-shadow: 0 10px 24px rgba(47,83,255,0.12);
}

.btn-modern{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    border-radius: 999px;
    padding: 12px 28px;
    min-height: 48px;
    font-weight: 700;
    color: white;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    cursor: pointer;
    font-size: 1rem;
    text-decoration: none;
}

.btn-modern:hover{
    transform: translateY(-1px);
    box-shadow: 0 18px 40px rgba(47,83,255,0.15);
    text-decoration: none;
    color: white;
}

.btn-primary-modern{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
}

.btn-warning-modern{
    background: linear-gradient(135deg,#F59E0B 0%,#FB923C 100%);
}

.btn-danger-modern{
    background: linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
}

.btn-secondary-modern{
    background: #94a3b8;
}

.btn-secondary-modern:hover{
    box-shadow: 0 18px 40px rgba(148,163,184,0.15);
}

.btn-group{
    display: flex;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 768px) {
    .detail-row{
        grid-template-columns: 1fr;
    }
    
    .page-title{
        font-size: 1.5rem;
    }
}

.info-section{
    background: #f0f4ff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 24px;
    border-left: 4px solid #667eea;
}

.info-section p{
    margin: 0;
    color: #475569;
    font-size: 0.95rem;
}

.info-section strong{
    color: #1e293b;
}

.associated-item{
    background: #f8fafc;
    border-radius: 12px;
    padding: 16px;
    border-left: 4px solid #38BDF8;
}

.associated-item p{
    margin: 0;
    color: #475569;
    font-size: 0.95rem;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="page-title">Detail User</h1>
                <p class="page-subtitle">Informasi lengkap pengguna sistem.</p>
            </div>
        </div>
    </div>

    <div class="card-modern" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body">
            <div class="info-section">
                <p><strong>ID User:</strong> {{ $user->id }}</p>
            </div>

            <div class="detail-section">
                <div class="section-title">Informasi Dasar</div>
                
                <div class="detail-row">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $user->name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Nomor Induk</div>
                    <div class="detail-value">
                        {{ $user->nomor_induk ?? '-' }}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Role/Peran</div>
                    <div class="detail-value">
                        <span class="badge-role">{{ $user->role }}</span>
                    </div>
                </div>
            </div>

            @if($user->guru || $user->siswa)
                <div class="detail-section">
                    <div class="section-title">Data Terkait</div>
                    
                    @if($user->guru)
                        <div class="associated-item">
                            <p><strong>Data Guru:</strong> {{ $user->guru->nama }}</p>
                            @if($user->guru->nip)
                                <p><strong>NIP:</strong> {{ $user->guru->nip }}</p>
                            @endif
                        </div>
                    @endif

                    @if($user->siswa)
                        <div class="associated-item" style="margin-top: 12px;">
                            <p><strong>Data Siswa:</strong> {{ $user->siswa->nama_lengkap }}</p>
                            @if($user->siswa->nisn)
                                <p><strong>NISN:</strong> {{ $user->siswa->nisn }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <div class="detail-section">
                <div class="section-title">Waktu</div>
                
                <div class="detail-row">
                    <div class="detail-label">Dibuat</div>
                    <div class="detail-value">{{ $user->created_at->format('d M Y H:i:s') }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Terakhir Diperbarui</div>
                    <div class="detail-value">{{ $user->updated_at->format('d M Y H:i:s') }}</div>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('super_admin.users.edit', $user->id) }}" class="btn-modern btn-primary-modern">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('super_admin.users.destroy', $user->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-danger-modern"
                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
               <a href="{{ url()->previous() }}" class="btn-modern btn-secondary-modern">
    <i class="fas fa-arrow-left"></i>
    Kembali
</a>
            </div>
        </div>
    </div>
</div>
@endsection
