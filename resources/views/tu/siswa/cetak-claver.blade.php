@extends('layouts.app')

@section('title', 'Cetak Claver - Buku Induk Siswa')

@section('content')

<style>
/* ============================================================
   CSS KHUSUS CETAK CLAVER
   ============================================================ */

/* ---- HEADER ---- */
.page-header {
    background: linear-gradient(135deg, #4F46E5, #7C3AED);
    border-radius: 28px;
    padding: 34px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(79, 70, 229, 0.25);
}

.page-header::before {
    content: '';
    position: absolute;
    width: 240px;
    height: 240px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    top: -80px;
    right: -70px;
}

.page-header::after {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    bottom: -60px;
    left: -40px;
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.page-title {
    color: white;
    font-size: 34px;
    font-weight: 800;
    margin: 0;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.85);
    margin-top: 8px;
    font-size: 14px;
}

/* ---- STATISTIK ---- */
.header-stats {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    align-items: center;
}

.stat-card {
    background: rgba(255, 255, 255, 0.14);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 18px;
    padding: 14px 22px;
    color: white;
    min-width: 100px;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.22);
    transform: translateY(-2px);
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
}

.stat-label {
    font-size: 11px;
    opacity: 0.85;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ---- TOMBOL KEMBALI ---- */
.btn-back {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 12px 20px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    color: white;
}

/* ---- GLASS CARD ---- */
.glass-card {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 24px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    margin-bottom: 24px;
    overflow: hidden;
}

.card-header-modern {
    padding: 22px 28px;
    border-bottom: 1px solid #eef2ff;
}

.card-title-modern {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-title-modern i {
    color: #4F46E5;
}

.card-body-modern {
    padding: 28px;
}

/* ---- FORM FILTER ---- */
.filter-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.filter-grid .form-label {
    font-weight: 600;
    font-size: 13px;
    color: #374151;
    margin-bottom: 8px;
    display: block;
}

.filter-grid .form-label i {
    color: #4F46E5;
    margin-right: 4px;
}

.form-select-modern {
    width: 100%;
    border: 1.5px solid #dbe3ff;
    background: #f9fbff;
    border-radius: 14px;
    padding: 13px 16px;
    font-size: 14px;
    transition: all 0.25s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 40px;
}

.form-select-modern:focus {
    outline: none;
    border-color: #4F46E5;
    background: white;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
}

.form-select-modern:hover {
    border-color: #6366F1;
}

/* ---- TOMBOL MODERN ---- */
.btn-modern {
    border: none;
    border-radius: 16px;
    padding: 13px 24px;
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}

.btn-modern:active {
    transform: scale(0.97);
}

.btn-info-modern {
    background: #ffffff;
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.15);
}

.btn-info-modern:hover {
    background: #3B82F6;
    color: white;
}

.btn-primary-modern {
    background: #ffffff;
    color: #4F46E5;
    border: 1px solid rgba(79, 70, 229, 0.15);
}

.btn-primary-modern:hover {
    background: #4F46E5;
    color: white;
}

.btn-success-modern {
    background: #ffffff;
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.15);
}

.btn-success-modern:hover {
    background: #10B981;
    color: white;
}

.btn-outline-modern {
    background: #ffffff;
    color: #6B7280;
    border: 1px solid rgba(148, 163, 184, 0.25);
}

.btn-outline-modern:hover {
    background: #4F46E5;
    color: white;
    border-color: #4F46E5;
}

/* ---- BUTTON GROUP ---- */
.btn-action-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

/* ---- ALERT INFO ---- */
.alert-info-claver {
    background: #eff6ff;
    border-radius: 18px;
    padding: 18px 24px;
    border-left: 5px solid #3B82F6;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
    margin-top: 24px;
}

.alert-info-claver i {
    color: #3B82F6;
    font-size: 20px;
    margin-top: 2px;
}

.alert-info-claver strong {
    color: #1E3A5F;
}

.alert-info-claver .text-muted {
    color: #4B5563;
}

/* ---- RESPONSIVE ---- */
@media (max-width: 992px) {
    .filter-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 24px;
    }

    .page-title {
        font-size: 26px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-stats {
        width: 100%;
        justify-content: flex-start;
    }

    .stat-card {
        min-width: 80px;
        padding: 10px 16px;
    }

    .stat-number {
        font-size: 18px;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .btn-action-group .btn-modern {
        width: 100%;
        justify-content: center;
    }

    .card-body-modern {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 20px;
    }

    .stat-card {
        min-width: 60px;
        padding: 8px 12px;
    }

    .stat-number {
        font-size: 16px;
    }

    .stat-label {
        font-size: 9px;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- ==================== HEADER ==================== -->
    <div class="page-header">

        <div class="header-content">

            <div>
                <h1 class="page-title">
                    <i class="fas fa-book-open"></i> Cetak Claver
                </h1>
                <div class="page-subtitle">
                    <i class="fas fa-print"></i> Cetak Buku Induk Siswa (Claver) dalam format PDF atau Excel
                </div>
            </div>

            <div class="header-stats">
                <div class="stat-card">
                    <div class="stat-number" id="totalSiswa">{{ $totalSiswa ?? 0 }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="totalHuruf">{{ $hurufAwal->count() ?? 0 }}</div>
                    <div class="stat-label">Huruf Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="totalAngkatan">{{ $tahunMasuk->count() ?? 0 }}</div>
                    <div class="stat-label">Angkatan</div>
                </div>

                <a href="{{ route('tu.siswa.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>

    </div>

    <!-- ==================== FILTER CARD ==================== -->
    <div class="glass-card">

        <div class="card-header-modern">
            <h5 class="card-title-modern">
                <i class="fas fa-sliders-h"></i> Filter Data Cetak
            </h5>
        </div>

        <div class="card-body-modern">

            <form id="formClaver" method="GET">

                <div class="filter-grid">

                    <!-- Huruf Awal -->
                    <div>
                        <label class="form-label">
                            <i class="fas fa-font"></i> Huruf Awal Nama
                        </label>
                        <select name="huruf" class="form-select-modern">
                            <option value="">Semua Huruf</option>
                            @foreach($hurufAwal as $huruf)
                                <option value="{{ $huruf }}" {{ request('huruf') == $huruf ? 'selected' : '' }}>
                                    {{ $huruf }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun Masuk -->
                    <div>
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i> Tahun Masuk
                        </label>
                        <select name="tahun_masuk" class="form-select-modern">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunMasuk as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_masuk') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tingkat Kelas -->
                    <div>
                        <label class="form-label">
                            <i class="fas fa-layer-group"></i> Tingkat Kelas
                        </label>
                        <select name="tingkat" class="form-select-modern">
                            <option value="">Semua Tingkat</option>
                            <option value="X" {{ request('tingkat') == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ request('tingkat') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ request('tingkat') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                    </div>

                    <!-- Tahun Ajaran -->
                    <div>
                        <label class="form-label">
                            <i class="fas fa-calendar-check"></i> Tahun Ajaran
                        </label>
                        <select name="tahun_ajaran" class="form-select-modern">
                            <option value="2024/2025" {{ request('tahun_ajaran', '2024/2025') == '2024/2025' ? 'selected' : '' }}>
                                2024/2025
                            </option>
                            <option value="2023/2024" {{ request('tahun_ajaran') == '2023/2024' ? 'selected' : '' }}>
                                2023/2024
                            </option>
                            <option value="2022/2023" {{ request('tahun_ajaran') == '2022/2023' ? 'selected' : '' }}>
                                2022/2023
                            </option>
                        </select>
                    </div>

                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4">
                    <div class="btn-action-group">
                        <button type="submit" formaction="{{ route('tu.siswa.cetak-claver.preview') }}" class="btn-modern btn-info-modern">
                            <i class="fas fa-eye"></i> Preview Data
                        </button>
                        <button type="submit" formaction="{{ route('tu.siswa.cetak-claver.pdf') }}" class="btn-modern btn-primary-modern">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                        <button type="submit" formaction="{{ route('tu.siswa.cetak-claver.excel') }}" class="btn-modern btn-success-modern">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <a href="{{ route('tu.siswa.cetak-claver.index') }}" class="btn-modern btn-outline-modern">
                            <i class="fas fa-undo"></i> Reset Filter
                        </a>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <!-- ==================== INFO ALERT ==================== -->
    <div class="alert-info-claver">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>Informasi Penting:</strong>
            <span class="text-muted">
                Data Claver diambil dari <strong>data siswa</strong> dan <strong>riwayat mutasi</strong> (naik kelas/lulus).
                Pastikan data mutasi siswa sudah diisi dengan benar agar tanggal naik kelas tampil.
            </span>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formClaver');

    // Handle form submission - tentukan action dari tombol yang ditekan
    form.addEventListener('submit', function(e) {
        const submitter = e.submitter;
        if (submitter) {
            const action = submitter.getAttribute('formaction');
            if (action) {
                this.action = action;
            }
        }

        // PDF dan Excel buka di tab baru
        if (this.action.includes('pdf') || this.action.includes('excel')) {
            this.target = '_blank';
        } else {
            this.target = '_self';
        }
    });

    // Tombol Reset - clear semua filter
    document.querySelector('.btn-outline-modern')?.addEventListener('click', function(e) {
        if (this.textContent.includes('Reset')) {
            e.preventDefault();
            const form = document.getElementById('formClaver');
            form.querySelectorAll('select').forEach(el => {
                el.selectedIndex = 0;
            });
            form.action = '{{ route("tu.siswa.cetak-claver.index") }}';
            form.target = '_self';
            form.submit();
        }
    });
});
</script>

@endsection