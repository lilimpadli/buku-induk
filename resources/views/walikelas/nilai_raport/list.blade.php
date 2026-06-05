@extends('layouts.app')

@section('title', 'Riwayat Rapor - ' . ($siswa->nama_lengkap ?? ''))

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* FIX: Tombol di header */
    .page-header .btn,
    .page-header a {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 100 !important;
    }

    .student-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .student-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .student-avatar-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        background: var(--primary-gradient);
        color: white;
    }

    .report-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }

    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .report-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #667eea;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #ffffff;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-outline-gradient:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateY(-2px);
    }

    .btn-danger-gradient {
        background: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-danger-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    /* Badge Styles */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .student-avatar, .student-avatar-placeholder {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
        
        .btn-gradient, .btn-outline-gradient, .btn-danger-gradient {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        
        .report-card .card-body {
            padding: 1rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .action-buttons {
            justify-content: flex-start !important;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header fade-in">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-history me-2"></i> Riwayat Rapor
                </h3>
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Pilih raport berdasarkan semester dan tahun ajaran
                </div>
            </div>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-outline-gradient" style="cursor: pointer; z-index: 100;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Info Siswa -->
    <div class="card student-card fade-in">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="student-avatar">
                    @else
                        <div class="student-avatar-placeholder mx-auto">
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-user-graduate me-2 text-primary"></i> {{ $siswa->nama_lengkap }}
                    </h5>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge bg-primary">
                            <i class="fas fa-qrcode me-1"></i> NIS: {{ $siswa->nis ?? '-' }}
                        </span>
                        <span class="badge bg-info text-dark">
                            <i class="fas fa-id-card me-1"></i> NISN: {{ $siswa->nisn ?? '-' }}
                        </span>
                        <span class="badge bg-secondary">
                            <i class="fas fa-graduation-cap me-1"></i> Rombel: {{ $siswa->rombel->nama ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List Raport -->
    <div class="row g-4">
        @forelse($raports as $r)
            <div class="col-md-6 col-lg-4 fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="card report-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="report-icon me-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">
                                    <i class="fas fa-layer-group me-1 text-primary"></i> Semester {{ $r->semester }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i> Tahun Ajaran {{ $r->tahun_ajaran }}
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2 action-buttons">
                            <a href="{{ route('walikelas.nilai_raport.show', [
                                'siswa_id' => $siswa->id,
                                'semester' => $r->semester,
                                'tahun' => $r->tahun_ajaran
                            ]) }}" class="btn btn-outline-gradient flex-grow-1" style="cursor: pointer;">
                                <i class="fas fa-eye me-2"></i> Lihat
                            </a>
                            <a href="{{ route('walikelas.nilai_raport.pdf', [$siswa->id, $r->semester, str_replace('/', '-', $r->tahun_ajaran)]) }}" 
                               target="_blank" class="btn btn-danger-gradient" style="cursor: pointer;">
                                <i class="fas fa-file-pdf me-2"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-file-alt fa-4x mb-3 opacity-50"></i>
                    <h5>Belum ada raport</h5>
                    <p class="text-muted">Belum ada raport tersimpan untuk siswa ini.</p>
                    <a href="{{ route('walikelas.input_nilai_raport.create', $siswa->id) }}" class="btn btn-gradient mt-3">
                        <i class="fas fa-pen me-2"></i> Input Raport
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix semua tombol
        const allBtns = document.querySelectorAll('.btn, .btn-gradient, .btn-outline-gradient, .btn-danger-gradient, a');
        allBtns.forEach(btn => {
            btn.style.pointerEvents = 'auto';
            btn.style.cursor = 'pointer';
            btn.style.position = 'relative';
            btn.style.zIndex = '100';
        });
    });
</script>
@endsection