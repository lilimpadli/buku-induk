@extends('layouts.app')

@section('title', 'Input Rapor - ' . ($siswa->nama_lengkap ?? ''))

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
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

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: 2px solid #667eea;
        padding: 1rem 1.5rem;
    }

    .form-card .card-header i {
        color: #667eea;
        margin-right: 8px;
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    .info-student {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-student .info-row {
        display: flex;
        padding: 0.5rem 0;
    }

    .info-student .info-label {
        width: 120px;
        font-weight: 600;
        color: #4a5568;
    }

    .info-student .info-value {
        flex: 1;
        color: #2d3748;
    }

    .table-nilai {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }

    .table-nilai th,
    .table-nilai td {
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
        vertical-align: middle;
    }

    .table-nilai th {
        background: #f8fafc;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .table-nilai td {
        font-size: 0.875rem;
    }

    .table-nilai input,
    .table-nilai textarea,
    .table-nilai select {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .table-nilai input:focus,
    .table-nilai textarea:focus,
    .table-nilai select:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .table-nilai input.is-invalid,
    .table-nilai textarea.is-invalid {
        border-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.05);
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .required-star {
        color: #dc3545;
        font-size: 0.875rem;
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
        
        .form-card .card-body {
            padding: 1rem;
        }
        
        .table-nilai {
            font-size: 0.75rem;
        }
        
        .table-nilai th,
        .table-nilai td {
            padding: 0.5rem;
        }
        
        .table-nilai input,
        .table-nilai textarea,
        .table-nilai select {
            font-size: 0.75rem;
            padding: 0.4rem;
        }
        
        .info-student .info-row {
            flex-direction: column;
        }
        
        .info-student .info-label {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        .btn-gradient,
        .btn-outline-gradient {
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }
        
        .d-flex.justify-content-between .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header fade-in">
        <div>
            <h3 class="mb-1">📝 Input Rapor</h3>
            <div class="text-muted">Isi nilai raport untuk siswa</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Info Siswa -->
            <div class="info-student fade-in">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #667eea;">
                        @else
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary-gradient); 
                                        display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">
                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Nama Lengkap</div>
                                    <div class="info-value"><strong>{{ $siswa->nama_lengkap }}</strong></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">NIS / NISN</div>
                                    <div class="info-value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Rombel</div>
                                    <div class="info-value">{{ $siswa->rombel->nama ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Jenis Kelamin</div>
                                    <div class="info-value">{{ $siswa->jenis_kelamin ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}" method="POST" id="formRapor">
                @csrf

                <!-- Semester & Tahun Ajaran -->
                <div class="form-card fade-in">
                    <div class="card-header">
                        <i class="fas fa-calendar-alt"></i> Semester & Tahun Ajaran
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Semester <span class="required-star">*</span>
                                </label>
                                <select id="semesterSelect" name="semester" class="form-select" required>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Tahun Ajaran <span class="required-star">*</span>
                                </label>
                                <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kelompok A -->
                <div class="form-card fade-in">
                    <div class="card-header">
                        <i class="fas fa-book-open"></i> A. Kelompok Mata Pelajaran Umum
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-nilai">
                                <thead>
                                    <tr><th width="5%">No</th><th>Mata Pelajaran</th><th width="15%">Nilai Akhir <span class="required-star">*</span></th><th>Capaian Kompetensi <span class="required-star">*</span></th></tr>
                                </thead>
                                <tbody>
                                    @foreach($kelompokA as $m)
                                    <tr><td class="text-center">{{ $m->urutan }}</td><td>{{ $m->nama }}</td>
                                    <td><input type="number" name="nilai[{{ $m->id }}][nilai_akhir]" min="0" max="100" class="nilai-required" required></td>
                                    <td><textarea name="nilai[{{ $m->id }}][deskripsi]" rows="2" class="deskripsi-required" required></textarea></td></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kelompok B -->
                <div class="form-card fade-in">
                    <div class="card-header">
                        <i class="fas fa-laptop-code"></i> B. Kelompok Mata Pelajaran Kejuruan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-nilai">
                                <thead>
                                    <tr><th width="5%">No</th><th>Mata Pelajaran</th><th width="15%">Nilai Akhir <span class="required-star">*</span></th><th>Capaian Kompetensi <span class="required-star">*</span></th></tr>
                                </thead>
                                <tbody>
                                    @foreach($kelompokB as $m)
                                    <tr><td class="text-center">{{ $m->urutan }}</td><td>{{ $m->nama }}</td>
                                    <td><input type="number" name="nilai[{{ $m->id }}][nilai_akhir]" min="0" max="100" class="nilai-required" required></td>
                                    <td><textarea name="nilai[{{ $m->id }}][deskripsi]" rows="2" class="deskripsi-required" required></textarea></td></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ekstrakurikuler -->
                <div class="form-card fade-in">
                    <div class="card-header">
                        <i class="fas fa-futbol"></i> C. Catatan Ekstrakurikuler
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-nilai">
                                <thead>
                                    <tr><th width="5%">No</th><th>Nama Ekstrakurikuler <span class="required-star">*</span></th><th width="15%">Predikat</th><th>Keterangan</th></tr>
                                </thead>
                                <tbody>
                                    @for($i=1; $i<=3; $i++)
                                    <tr><td class="text-center">{{ $i }}</td>
                                    <td><input type="text" name="ekstra[{{ $i }}][nama_ekstra]" class="ekstra-required" placeholder="Contoh: Pramuka"></td>
                                    <td><select name="ekstra[{{ $i }}][predikat]" class="form-select"><option value="">-</option><option value="A">A</option><option value="B">B</option><option value="C">C</option></select></td>
                                    <td><textarea name="ekstra[{{ $i }}][keterangan]" rows="2"></textarea></td></tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kehadiran -->
                <div class="form-card fade-in">
                    <div class="card-header">
                        <i class="fas fa-calendar-check"></i> D. Ketidakhadiran
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label fw-semibold">Sakit <span class="required-star">*</span></label><input type="number" name="hadir[sakit]" class="form-control hadir-required" min="0" value="0" required></div>
                            <div class="col-md-4 mb-3"><label class="form-label fw-semibold">Izin <span class="required-star">*</span></label><input type="number" name="hadir[izin]" class="form-control hadir-required" min="0" value="0" required></div>
                            <div class="col-md-4 mb-3"><label class="form-label fw-semibold">Tanpa Keterangan <span class="required-star">*</span></label><input type="number" name="hadir[alpa]" class="form-control hadir-required" min="0" value="0" required></div>
                        </div>
                    </div>
                </div>

                <!-- Kenaikan Kelas -->
                <div class="form-card fade-in" id="kenaikanSection" style="display: none;">
                    <div class="card-header">
                        <i class="fas fa-chart-line"></i> E. Kenaikan Kelas
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="kenaikan[status]" class="form-select" id="statusSelect">
                                    <option value="Naik Kelas">Naik Kelas</option>
                                    <option value="Tidak Naik">Tidak Naik</option>
                                    <option value="Lulus" {{ isset($siswa->rombel->kelas->tingkat) && $siswa->rombel->kelas->tingkat == 12 ? '' : 'disabled' }}>Lulus</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3" id="rombelTujuanGroup">
                                <label class="form-label fw-semibold">Rombel Tujuan</label>
                                <select name="kenaikan[rombel_tujuan_id]" class="form-select" id="rombelSelect">
                                    <option value="">-- Pilih Rombel --</option>
                                    @foreach($rombels as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUTTON ACTION: Kembali + Simpan -->
                <div class="d-flex justify-content-between align-items-center mt-4 gap-3">
                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-outline-gradient">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <button type="submit" class="btn btn-gradient" id="btnSimpan">
                        <i class="fas fa-save"></i> Simpan Semua Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const semesterEl = document.getElementById('semesterSelect');
        const kenaikanSection = document.getElementById('kenaikanSection');
        const statusSelect = document.getElementById('statusSelect');
        const rombelTujuanGroup = document.getElementById('rombelTujuanGroup');
        const formRapor = document.getElementById('formRapor');

        const updateVisibility = () => {
            if (!semesterEl || !kenaikanSection) return;
            const val = (semesterEl.value || '').toString().toLowerCase();
            kenaikanSection.style.display = val === 'genap' ? '' : 'none';
        };
        semesterEl?.addEventListener('change', updateVisibility);
        updateVisibility();

        const updateRombelVisibility = () => {
            if (!statusSelect || !rombelTujuanGroup) return;
            rombelTujuanGroup.style.display = statusSelect.value === 'Lulus' ? 'none' : '';
        };
        statusSelect?.addEventListener('change', updateRombelVisibility);
        updateRombelVisibility();

        formRapor?.addEventListener('submit', function(e) {
            let allFilled = true;
            let firstEmpty = null;

            document.querySelectorAll('.nilai-required, .deskripsi-required, .hadir-required').forEach(el => {
                if (!el.value || el.value.trim() === '') {
                    allFilled = false;
                    el.classList.add('is-invalid');
                    if (!firstEmpty) firstEmpty = el;
                } else {
                    el.classList.remove('is-invalid');
                }
            });

            let ekstraCount = 0;
            document.querySelectorAll('.ekstra-required').forEach(el => {
                if (el.value && el.value.trim() !== '') ekstraCount++;
            });

            if (ekstraCount === 0) {
                allFilled = false;
                alert('⚠️ Minimal 1 ekstrakurikuler harus diisi!');
                e.preventDefault();
                return false;
            }

            if (!allFilled) {
                alert('⚠️ Semua data wajib diisi!');
                e.preventDefault();
                if (firstEmpty) firstEmpty.focus();
                return false;
            }
        });
    });
</script>
@endpush
@endsection