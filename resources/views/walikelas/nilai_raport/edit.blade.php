@extends('layouts.app')

@section('title', 'Edit Rapor')

@section('content')
<style>
    /* ===================== STYLE EDIT RAPOR ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Header */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.85rem;
    }

    /* FIX: Tombol di header */
    .page-header .btn,
    .page-header a {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 100 !important;
    }

    /* Cards */
    .card-custom {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .card-custom:hover {
        box-shadow: var(--card-hover-shadow);
    }

    .card-header-custom {
        background: white;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .card-header-custom h5 {
        font-weight: 600;
        margin-bottom: 0;
        color: #1e293b;
    }

    .card-body-custom {
        padding: 1.25rem 1.5rem;
    }

    /* Tables */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom thead th {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 13px;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    .table-custom tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Forms */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 0.75rem;
        font-size: 14px;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    textarea.form-control {
        resize: vertical;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        pointer-events: auto !important;
        cursor: pointer !important;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        color: white;
    }

    .btn-primary:hover {
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
    }

    .btn-danger:hover {
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #13B497, #10b981);
        border: none;
    }

    .btn-outline-secondary {
        border: 1px solid #cbd5e1;
        color: #475569;
        background: transparent;
        pointer-events: auto !important;
        cursor: pointer !important;
    }

    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .btn-sm {
        padding: 0.3rem 0.8rem;
        font-size: 12px;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .info-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header { padding: 1.25rem; }
        .page-header h3 { font-size: 1.25rem; }
        .card-body-custom { padding: 1rem; }
        .info-grid { grid-template-columns: 1fr; }
        .table-custom thead th { font-size: 11px; padding: 0.5rem; }
        .table-custom tbody td { padding: 0.5rem; font-size: 12px; }
        .action-buttons { flex-direction: column; }
        .action-buttons .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="container-fluid py-3">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3>
                    <i class="fas fa-edit me-2"></i> Edit Rapor
                </h3>
                <div class="text-muted">
                    <i class="fas fa-user-graduate me-1"></i> {{ $siswa->nama_lengkap }}
                </div>
            </div>
            <a href="{{ route('walikelas.nilai_raport.show', [
                'siswa_id' => $siswa->id,
                'semester' => $semester,
                'tahun' => $tahun
            ]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('walikelas.nilai_raport.update', [
        'siswa_id' => $siswa->id,
        'semester' => $semester,
        'tahun' => $tahun
    ]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Semester & Tahun -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label">
                    <i class="fas fa-layer-group me-1"></i> Semester
                </label>
                <input type="text" class="form-control bg-light" value="{{ $semester }}" readonly>
                <input type="hidden" name="semester" value="{{ $semester }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">
                    <i class="fas fa-calendar-alt me-1"></i> Tahun Ajaran
                </label>
                <input type="text" class="form-control bg-light" value="{{ $tahun }}" readonly>
                <input type="hidden" name="tahun" value="{{ $tahun }}">
            </div>
        </div>

        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

        <!-- Identitas Siswa -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-id-card me-2 text-primary"></i> Identitas Siswa</h5>
            </div>
            <div class="card-body-custom">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Peserta Didik</span>
                        <span class="info-value">{{ $siswa->nama_lengkap }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kelas</span>
                        <span class="info-value">
                            @if(isset($rombelSaatLapor) && $rombelSaatLapor)
                                {{ $rombelSaatLapor->nama }}
                            @else
                                {{ $siswa->rombel->nama ?? '-' }}
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">NISN</span>
                        <span class="info-value">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Semester</span>
                        <span class="info-value">{{ $semester }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Sekolah</span>
                        <span class="info-value">SMK Negeri 1 Kawali</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tahun Pelajaran</span>
                        <span class="info-value">{{ $tahun }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelompok A - Mata Pelajaran Umum -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-book me-2 text-primary"></i> A. Kelompok Mata Pelajaran Umum</h5>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Mata Pelajaran</th>
                                <th width="120">Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokA as $mapel)
                            <tr>
                                <td>{{ $mapel->urutan }}</td>
                                <td>{{ $mapel->nama }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" 
                                           class="form-control" style="max-width: 100px;"
                                           value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" 
                                           min="0" max="100" step="0.01">
                                </td>
                                <td>
                                    <textarea name="nilai[{{ $mapel->id }}][deskripsi]" 
                                              class="form-control" rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kelompok B - Mata Pelajaran Kejuruan -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-laptop-code me-2 text-primary"></i> B. Kelompok Mata Pelajaran Kejuruan</h5>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Mata Pelajaran</th>
                                <th width="120">Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokB as $mapel)
                            <tr>
                                <td>{{ $mapel->urutan }}</td>
                                <td>{{ $mapel->nama }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" 
                                           class="form-control" style="max-width: 100px;"
                                           value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" 
                                           min="0" max="100" step="0.01">
                                </td>
                                <td>
                                    <textarea name="nilai[{{ $mapel->id }}][deskripsi]" 
                                              class="form-control" rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ekstrakurikuler -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-futbol me-2 text-primary"></i> C. Kegiatan Ekstrakurikuler</h5>
            </div>
            <div class="card-body-custom">
                <div id="ekstra-container">
                    @foreach($ekstra as $index => $e)
                        <div class="row g-2 mb-3 ekstra-row align-items-center">
                            <div class="col-md-4">
                                <input type="hidden" name="ekstra[{{ $index }}][id]" value="{{ $e->id }}">
                                <input type="text" name="ekstra[{{ $index }}][nama_ekstra]" class="form-control"
                                    placeholder="Nama Ekstrakurikuler" value="{{ $e->nama_ekstra }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="ekstra[{{ $index }}][predikat]" class="form-control"
                                    placeholder="Predikat" value="{{ $e->predikat ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="ekstra[{{ $index }}][keterangan]" class="form-control"
                                    placeholder="Keterangan" value="{{ $e->keterangan ?? '' }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-ekstra" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Ekstrakurikuler
                </button>
            </div>
        </div>

        <!-- Ketidakhadiran -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-calendar-times me-2 text-primary"></i> D. Ketidakhadiran</h5>
            </div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-thermometer-half text-warning me-1"></i> Sakit
                        </label>
                        <input type="number" name="hadir[sakit]" class="form-control"
                            value="{{ $kehadiran->sakit ?? 0 }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-file-alt text-info me-1"></i> Izin
                        </label>
                        <input type="number" name="hadir[izin]" class="form-control" 
                            value="{{ $kehadiran->izin ?? 0 }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-times-circle text-danger me-1"></i> Tanpa Keterangan
                        </label>
                        <input type="number" name="hadir[alpa]" class="form-control"
                            value="{{ $kehadiran->tanpa_keterangan ?? 0 }}" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kenaikan Kelas -->
        <div id="kenaikan-card" style="{{ strtolower($semester) === 'ganjil' ? 'display:none;' : '' }}">
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-arrow-up me-2 text-primary"></i> E. Kenaikan Kelas</h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            @php
                                $kStatus = strtolower(str_replace([' ', '_'], '', trim($kenaikan?->status ?? '')));
                            @endphp
                            <select name="kenaikan[status]" class="form-select" id="statusKenaikanSelect">
                                <option value="Naik Kelas" {{ in_array($kStatus, ['naik','naikkelas']) ? 'selected' : '' }}>Naik Kelas</option>
                                <option value="Tidak Naik" {{ in_array($kStatus, ['tidaknaik','tidak']) ? 'selected' : '' }}>Tidak Naik</option>
                                <option value="Lulus" {{ in_array($kStatus, ['lulus','lulusan']) ? 'selected' : '' }}>Lulus</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ke Kelas</label>
                            @php
                                $rombelSource = isset($rombelsFiltered) && $rombelsFiltered->count() > 0 ? $rombelsFiltered : $rombels;
                                $statusNorm = strtolower(str_replace([' ', '_'], '', trim($kenaikan?->status ?? '')));
                                $rombelDisabled = ($semester && strtolower($semester) === 'ganjil') || ($statusNorm !== 'naikkelas');
                            @endphp
                            <select name="kenaikan[rombel_tujuan_id]" class="form-select" id="rombelTujuanSelect" {{ $rombelDisabled ? 'disabled' : '' }}>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($rombelSource as $rombel)
                                    <option value="{{ $rombel->id }}" {{ ($kenaikan && $kenaikan->rombel_tujuan_id == $rombel->id) ? 'selected' : '' }}>
                                        {{ $rombel->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @if(isset($targetTingkat) && $targetTingkat)
                                <small class="text-muted">Menampilkan rombel untuk tingkat: {{ $targetTingkat }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="kenaikan[catatan]" class="form-control" rows="2">{{ $kenaikan?->catatan ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
            </button>
            <button type="button" id="btn-delete-rapor" class="btn btn-danger">
                <i class="fas fa-trash-alt me-2"></i> Hapus Rapor
            </button>
        </div>
    </form>

    <form id="form-delete-rapor" action="{{ route('walikelas.input_nilai_raport.delete', $siswa->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="tahun" value="{{ $tahun }}">
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FIX: Semua tombol bisa diklik
        const allBtns = document.querySelectorAll('.btn, .btn-outline-secondary, .btn-primary, .btn-danger, .btn-success');
        allBtns.forEach(btn => {
            btn.style.pointerEvents = 'auto';
            btn.style.cursor = 'pointer';
            btn.style.position = 'relative';
            btn.style.zIndex = '100';
        });
        
        // FIX khusus tombol kembali
        const backBtn = document.querySelector('a[href*="nilai_raport.show"]');
        if (backBtn) {
            backBtn.style.pointerEvents = 'auto';
            backBtn.style.cursor = 'pointer';
        }
        
        // Tambah ekstrakurikuler
        document.getElementById('add-ekstra')?.addEventListener('click', function () {
            const container = document.getElementById('ekstra-container');
            const index = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'row g-2 mb-3 ekstra-row align-items-center';
            newRow.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="ekstra[${index}][nama_ekstra]" class="form-control" placeholder="Nama Ekstrakurikuler">
                </div>
                <div class="col-md-2">
                    <input type="text" name="ekstra[${index}][predikat]" class="form-control" placeholder="Predikat">
                </div>
                <div class="col-md-5">
                    <input type="text" name="ekstra[${index}][keterangan]" class="form-control" placeholder="Keterangan">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });

        // Hapus ekstrakurikuler
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-ekstra')) {
                e.target.closest('.ekstra-row').remove();
            }
        });

        // Toggle rombel select
        function updateRombelState() {
            const statusEl = document.getElementById('statusKenaikanSelect');
            const rombelEl = document.getElementById('rombelTujuanSelect');
            const kenaikanCard = document.getElementById('kenaikan-card');
            if (!statusEl || !rombelEl) return;
            const statusNorm = (statusEl.value || '').toString().toLowerCase().replace(/\s|_/g, '');
            const semester = '{{$semester}}'.toString().toLowerCase();
            if (semester === 'ganjil' || statusNorm !== 'naikkelas') {
                rombelEl.disabled = true;
                if (kenaikanCard) kenaikanCard.style.display = 'none';
            } else {
                rombelEl.disabled = false;
                if (kenaikanCard) kenaikanCard.style.display = '';
            }
        }

        document.getElementById('statusKenaikanSelect')?.addEventListener('change', updateRombelState);
        updateRombelState();

        // Delete rapor confirmation
        document.getElementById('btn-delete-rapor')?.addEventListener('click', function() {
            if (confirm('Yakin ingin menghapus semua data raport untuk semester "' + '{{ $semester }}'" tahun "' + '{{ $tahun }}'"?')) {
                document.getElementById('form-delete-rapor').submit();
            }
        });
    });
</script>
@endsection