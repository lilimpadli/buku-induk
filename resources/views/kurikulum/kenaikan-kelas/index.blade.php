@extends('layouts.app')

@section('title', 'Kenaikan Kelas')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* FIX: Responsive layout */
    * {
        box-sizing: border-box;
    }

    .container-fluid {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 0 20px;
    }

    @media (max-width: 1200px) {
        .container-fluid {
            padding: 0 15px;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 12px;
        }
    }

    .gradient-header {
        background: var(--primary-gradient);
        border-radius: var(--border-radius);
        padding: 2rem 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .gradient-header::before {
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

    .gradient-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        font-size: clamp(1.2rem, 5vw, 1.8rem);
    }

    .gradient-header p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
        position: relative;
        z-index: 1;
        font-size: clamp(0.8rem, 4vw, 1rem);
    }

    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        transition: var(--transition);
        width: 100%;
    }

    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        color: white;
        border: none;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-success-gradient {
        background: var(--success-gradient);
        color: white;
        border: none;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-success-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(19, 180, 151, 0.5);
        color: white;
    }

    .result-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
        width: 100%;
    }

    .result-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #667eea;
        padding: 1rem 1.5rem;
    }

    .result-card .card-header h5 {
        font-weight: 700;
        margin: 0;
        color: #1E293B;
        font-size: clamp(1rem, 4vw, 1.2rem);
    }

    /* FIX: Tabel responsif */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .result-card .table {
        width: 100%;
        margin-bottom: 0;
        min-width: 600px;
    }

    .result-card .table thead {
        background-color: #F8FAFC;
    }

    .result-card .table th {
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
        border-bottom: none;
        padding: 1rem;
        white-space: nowrap;
    }

    .result-card .table td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #E2E8F0;
        font-size: 14px;
        word-break: break-word;
    }

    .result-card .table tbody tr {
        transition: var(--transition);
    }

    .result-card .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-naik {
        background: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-tidak-naik {
        background: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .summary-badge {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .summary-badge span {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .summary-total {
        background: #667eea;
        color: white;
    }

    .summary-naik {
        background: #13B497;
        color: white;
    }

    .summary-tidak {
        background: #F5576C;
        color: white;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* FIX: Grid responsive untuk filter */
    @media (max-width: 992px) {
        .filter-card .row {
            gap: 15px;
        }
        
        .filter-card .col-md-4,
        .filter-card .col-md-3,
        .filter-card .col-md-2 {
            width: 100%;
        }
        
        .btn-gradient {
            width: 100%;
            white-space: normal;
        }
        
        .btn-success-gradient {
            width: 100%;
            white-space: normal;
            margin-top: 15px;
        }
        
        .card-footer {
            flex-direction: column;
            gap: 15px;
        }
        
        .summary-badge {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .gradient-header {
            padding: 1.2rem 1rem;
        }
        
        .gradient-header h3 {
            font-size: 1.2rem;
        }
        
        .result-card .card-header {
            flex-direction: column;
            gap: 12px;
        }
        
        .result-card .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
        }
        
        .result-card .table th,
        .result-card .table td {
            padding: 0.7rem;
            font-size: 11px;
        }
        
        .summary-badge {
            justify-content: center;
            margin-top: 10px;
        }
        
        .badge-naik, .badge-tidak-naik {
            font-size: 10px;
            padding: 0.2rem 0.6rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 10px;
        }
        
        .result-card .table td {
            font-size: 10px;
        }
        
        .result-card .table th {
            font-size: 10px;
            padding: 0.5rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="gradient-header">
        <h3><i class="fas fa-arrow-up me-2"></i> Kenaikan Kelas</h3>
        <p class="mb-0">Proses kenaikan kelas otomatis berdasarkan nilai rapor yang memenuhi KKM</p>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> Tahun Ajaran
                    </label>
                    <select id="tahunAjaran" class="form-select">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }} @if($ta->is_active) (Aktif) @endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-layer-group me-1"></i> Semester
                    </label>
                    <select id="semester" class="form-select">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap" selected>Genap</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-school me-1"></i> Rombel (Opsional)
                    </label>
                    <select id="rombel" class="form-select">
                        <option value="">-- Semua Rombel --</option>
                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}">{{ $r->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="previewBtn" class="btn btn-gradient w-100">
                        <i class="fas fa-eye me-1"></i> Preview
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Container -->
    <div id="resultContainer" class="mt-4" style="display: none;">
        <div class="card result-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5><i class="fas fa-users me-2 text-primary"></i> Daftar Siswa</h5>
                    <div id="summaryBadge" class="summary-badge"></div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th width="5%">No</th>
                                <th>NIS / NISN</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                    Klik Preview untuk melihat data siswa
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="small text-muted">
                    <i class="fas fa-info-circle me-1"></i> Hanya siswa dengan status "Naik Kelas" yang dapat diproses
                </div>
                <button id="processBtn" class="btn btn-success-gradient" disabled>
                    <i class="fas fa-arrow-up me-1"></i> Proses Kenaikan Kelas
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let siswaData = [];

document.getElementById('previewBtn').addEventListener('click', function() {
    const tahunAjaranId = document.getElementById('tahunAjaran').value;
    const semester = document.getElementById('semester').value;
    const rombelId = document.getElementById('rombel').value;

    if (!tahunAjaranId) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Pilih tahun ajaran terlebih dahulu!',
            confirmButtonColor: '#667eea'
        });
        return;
    }

    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="loading-spinner"></span> Memuat...';

    fetch('{{ route("kurikulum.kenaikan-kelas.preview") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tahun_ajaran_id: tahunAjaranId,
            semester: semester,
            rombel_id: rombelId || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            siswaData = data.data;
            renderTable(data);
            document.getElementById('resultContainer').style.display = 'block';
            
            // Scroll ke hasil
            document.getElementById('resultContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Gagal memuat data',
                confirmButtonColor: '#667eea'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Gagal terhubung ke server',
            confirmButtonColor: '#667eea'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-eye me-1"></i> Preview';
    });
});

function renderTable(data) {
    const tbody = document.getElementById('siswaTableBody');
    tbody.innerHTML = '';
    
    if (!data.data || data.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                    Tidak ada data siswa
                </td>
            </tr>
        `;
        return;
    }
    
    data.data.forEach((item, index) => {
        const row = tbody.insertRow();
        const isNaik = item.naik;
        const isDisabled = !isNaik;
        
        row.innerHTML = `
            <td>
                <input type="checkbox" class="siswaCheckbox form-check-input" value="${item.siswa.id}" ${isDisabled ? 'disabled' : ''}>
            </td>
            <td><span class="fw-semibold">${index + 1}</span></td>
            <td>
                <div class="small">
                    <div><strong>NIS:</strong> ${item.siswa.nis || '-'}</div>
                    <div class="text-muted"><strong>NISN:</strong> ${item.siswa.nisn || '-'}</div>
                </div>
            </td>
            <td>
                <div class="fw-semibold">${item.siswa.nama_lengkap}</div>
            </td>
            <td>${item.siswa.rombel?.nama || '-'}</td>
            <td>
                ${isNaik 
                    ? '<span class="badge-naik"><i class="fas fa-check-circle me-1"></i> Naik Kelas</span>' 
                    : '<span class="badge-tidak-naik"><i class="fas fa-times-circle me-1"></i> Tidak Naik</span>'}
            </td>
            <td><small class="text-muted">${item.alasan || '-'}</small></td>
        `;
    });
    
    document.getElementById('summaryBadge').innerHTML = `
        <span class="summary-total"><i class="fas fa-users me-1"></i> Total: ${data.total_siswa}</span>
        <span class="summary-naik"><i class="fas fa-check-circle me-1"></i> Naik: ${data.total_naik}</span>
        <span class="summary-tidak"><i class="fas fa-times-circle me-1"></i> Tidak Naik: ${data.total_tidak_naik}</span>
    `;
    
    document.getElementById('checkAll').checked = false;
    document.getElementById('processBtn').disabled = data.total_naik === 0;
    if (data.total_naik === 0) {
        document.getElementById('processBtn').innerHTML = '<i class="fas fa-arrow-up me-1"></i> Proses Kenaikan Kelas (0 siswa)';
    } else {
        document.getElementById('processBtn').innerHTML = `<i class="fas fa-arrow-up me-1"></i> Proses Kenaikan Kelas (0 siswa)`;
    }
    
    document.querySelectorAll('.siswaCheckbox').forEach(cb => {
        cb.addEventListener('change', updateProcessButton);
    });
}

function updateProcessButton() {
    const checked = document.querySelectorAll('.siswaCheckbox:checked').length;
    document.getElementById('processBtn').innerHTML = `<i class="fas fa-arrow-up me-1"></i> Proses Kenaikan Kelas (${checked} siswa)`;
    document.getElementById('processBtn').disabled = checked === 0;
}

document.getElementById('checkAll').addEventListener('change', function(e) {
    document.querySelectorAll('.siswaCheckbox:not(:disabled)').forEach(cb => {
        cb.checked = e.target.checked;
    });
    updateProcessButton();
});

document.getElementById('processBtn').addEventListener('click', function() {
    const checkedSiswas = Array.from(document.querySelectorAll('.siswaCheckbox:checked')).map(cb => cb.value);
    
    if (checkedSiswas.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Tidak ada siswa yang dipilih!',
            confirmButtonColor: '#667eea'
        });
        return;
    }
    
    Swal.fire({
        title: 'Konfirmasi',
        text: `Proses kenaikan kelas untuk ${checkedSiswas.length} siswa?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#13B497',
        cancelButtonColor: '#F5576C',
        confirmButtonText: 'Ya, Proses!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            processKenaikan(checkedSiswas);
        }
    });
});

function processKenaikan(checkedSiswas) {
    const btn = document.getElementById('processBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="loading-spinner"></span> Memproses...';
    
    fetch('{{ route("kurikulum.kenaikan-kelas.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tahun_ajaran_id: document.getElementById('tahunAjaran').value,
            semester: document.getElementById('semester').value,
            siswa_ids: checkedSiswas
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: '#13B497'
            });
            // Refresh preview
            document.getElementById('previewBtn').click();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan',
                confirmButtonColor: '#667eea'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Gagal terhubung ke server',
            confirmButtonColor: '#667eea'
        });
    })
    .finally(() => {
        btn.disabled = false;
        updateProcessButton();
    });
}
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection