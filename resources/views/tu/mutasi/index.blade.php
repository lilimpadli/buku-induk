@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<style>
    :root {
        --primary: #2F53FF;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
    }

    .jurusan-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 25px;
    }

    .jurusan-tab {
        border: 1px solid #CBD5E1;
        background: #F8FAFC;
        color: #1E293B;
        padding: 10px 16px;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
    }

    .jurusan-tab.active {
        background: var(--primary);
        color: white;
        border-color: transparent;
    }

    .kelas-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .jurusan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .jurusan-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary);
        display: flex;
        flex-direction: column;
    }

    .jurusan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .jurusan-card-header,
    .jurusan-card-body,
    .jurusan-card-footer {
        padding: 20px;
    }

    .jurusan-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .jurusan-card-title {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .jurusan-card-code {
        display: inline-block;
        background: #E2E8F0;
        color: #475569;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .jurusan-card-badge {
        background: var(--info);
        color: white;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .jurusan-card-body {
        padding-top: 0;
    }

    .jurusan-card-description {
        color: #475569;
        margin: 0;
        line-height: 1.6;
    }

    .jurusan-card-footer {
        margin-top: auto;
        padding-top: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        border-top: 1px solid #E2E8F0;
    }

    .jurusan-card-footer .btn {
        flex: 1;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .kelas-card {
        display: none;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary);
    }

    .kelas-card.active {
        display: block;
    }

    .kelas-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary);
    }

    .kelas-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .kelas-card-header {
        background: linear-gradient(135deg, var(--primary) 0%, #6366F1 100%);
        color: white;
        padding: 20px;
    }

    .kelas-card-title {
        font-size: 20px;
        font-weight: bold;
        margin: 0;
    }

    .kelas-card-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin: 5px 0 0 0;
    }

    .kelas-card-body {
        padding: 20px;
    }

    .rombel-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 15px;
    }

    .rombel-item {
        background: #F8FAFC;
        padding: 12px 15px;
        border-radius: 8px;
        border-left: 3px solid var(--info);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rombel-name {
        font-weight: 600;
        color: #1E293B;
    }

    .rombel-count {
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .kelas-card-footer {
        border-top: 1px solid #E2E8F0;
        padding-top: 15px;
    }

    .btn-group-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .btn-action {
        padding: 10px;
        font-size: 13px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-naik {
        background: var(--success);
        color: white;
    }

    .btn-naik:hover {
        background: #059669;
    }

    .btn-lulus {
        background: var(--primary);
        color: white;
    }

    .btn-lulus:hover {
        background: #1E40AF;
    }

    .btn-mutasi-lain {
        background: var(--warning);
        color: white;
        grid-column: 1 / -1;
    }

    .btn-mutasi-lain:hover {
        background: #D97706;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #1E293B;
        margin: 0;
    }

    /* Modal Siswa */
    .modal-header {
        background: linear-gradient(135deg, var(--primary) 0%, #6366F1 100%);
        color: white;
        border: none;
    }

    .modal-title {
        font-weight: 600;
    }

    .siswa-checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 400px;
        overflow-y: auto;
        padding: 15px 0;
    }

    .siswa-item {
        display: flex;
        align-items: center;
        padding: 12px;
        background: #F8FAFC;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }

    .siswa-item input[type="checkbox"] {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .siswa-info {
        flex: 1;
    }

    .siswa-nama {
        font-weight: 600;
        color: #1E293B;
    }

    .siswa-nis {
        font-size: 12px;
        color: #64748B;
    }

    .mutasi-options {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #E2E8F0;
    }

    .kelas-card-actions {
        margin-bottom: 15px;
    }

    .btn-view-siswa {
        background: #4F46E5;
        color: white;
        width: 100%;
    }

    .btn-view-siswa:hover {
        background: #4338CA;
    }

    .class-student-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 12px;
        background: #F8FAFC;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        margin-bottom: 10px;
    }

    .mutasi-options label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .mutasi-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 15px;
    }

    .mutasi-buttons button {
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-mutasi-naik {
        background: var(--success);
        color: white;
    }

    .btn-mutasi-naik:hover {
        background: #059669;
    }

    .btn-mutasi-lulus {
        background: var(--primary);
        color: white;
    }

    .btn-mutasi-lulus:hover {
        background: #1E40AF;
    }

    .btn-mutasi-do {
        background: var(--warning);
        color: white;
    }

    .btn-mutasi-do:hover {
        background: #D97706;
    }

    .btn-mutasi-pindah {
        background: #EC4899;
        color: white;
    }

    .btn-mutasi-pindah:hover {
        background: #BE185D;
    }

    .btn-mutasi-meninggal {
        background: var(--danger);
        color: white;
        grid-column: 1 / -1;
    }

    .btn-mutasi-meninggal:hover {
        background: #DC2626;
    }
</style>

<div class="container-fluid mt-4">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-exchange-alt text-primary"></i> Mutasi Siswa
        </h1>
        <a href="{{ route('tu.mutasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mutasi Individual
        </a>
    </div>

    @php
        $jurusanGroups = $classes->sortBy(function($kelas) { return optional($kelas->jurusan)->nama ?? ''; })
            ->groupBy(function($kelas) { return $kelas->jurusan_id ?? 'umum'; });
    @endphp

    <div class="jurusan-grid">
        @forelse($jurusanGroups as $jurusanId => $jurusanClasses)
            @php
                $jurusan = $jurusanClasses->first()->jurusan;
            @endphp
            <div class="jurusan-card">
                <div class="jurusan-card-header">
                    <div>
                        <h3 class="jurusan-card-title">{{ optional($jurusan)->nama ?? 'Umum' }}</h3>
                        <span class="jurusan-card-code">Kode: {{ optional($jurusan)->kode ?? '-' }}</span>
                    </div>
                    <span class="jurusan-card-badge">Total Kelas: {{ $jurusanClasses->count() }}</span>
                </div>

                <div class="jurusan-card-body">
                    <p class="jurusan-card-description">Lihat kelas untuk jurusan ini dan lakukan mutasi siswa per kelas.</p>
                </div>

                <div class="jurusan-card-footer">
                    <a href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-info-circle me-1"></i> Detail
                    </a>
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Lebih
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}">
                                <i class="fa fa-search me-2"></i> Lihat Kelas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Tidak ada jurusan tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal untuk Pilih Siswa -->
<div class="modal fade" id="siswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Siswa untuk Mutasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllSiswa">
                        <label class="form-check-label" for="selectAllSiswa">
                            <strong>Pilih Semua Siswa</strong>
                        </label>
                    </div>
                </div>

                <div class="siswa-checkbox-group" id="siswaList"></div>

                <div class="mutasi-options" id="mutasiOptions">
                    <label for="mutasiType">Pilih Jenis Mutasi:</label>
                    <div class="mutasi-buttons">
                        <button type="button" class="btn-mutasi-naik" id="btnNaikKelas" style="display: none;">
                            <i class="fas fa-arrow-up me-1"></i> Naik Kelas
                        </button>
                        <button type="button" class="btn-mutasi-lulus" id="btnLulus" style="display: none;">
                            <i class="fas fa-graduation-cap me-1"></i> Lulus
                        </button>
                        <button type="button" class="btn-mutasi-do" id="btnDO" style="display: none;">
                            <i class="fas fa-ban me-1"></i> Putus Sekolah
                        </button>
                        <button type="button" class="btn-mutasi-pindah" id="btnPindah" style="display: none;">
                            <i class="fas fa-map-marker me-1"></i> Pindah Sekolah
                        </button>
                        <button type="button" class="btn-mutasi-meninggal" id="btnMeninggal" style="display: none;">
                            <i class="fas fa-cross me-1"></i> Meninggal Dunia
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Daftar Siswa Kelas -->
<div class="modal fade" id="classStudentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classStudentsModalLabel">Daftar Siswa Kelas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3"><strong>Jumlah siswa:</strong> <span id="classStudentsCount">0 siswa</span></p>
                <div class="siswa-checkbox-group" id="classStudentsList"></div>
            </div>
        </div>
    </div>
</div>

<script>
let currentKelasId = null;
let currentMutasiType = null;

function openSiswaModal(button, mutasiType) {
    const kelasCard = button.closest('.kelas-card');
    currentKelasId = kelasCard.dataset.kelasId;
    currentMutasiType = mutasiType;

    const kelasName = kelasCard.dataset.kelasName;

    // Get siswa list from pre-built data
    const siswas = @json($allStudents);
    const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(currentKelasId));

    // Build siswa list HTML
    let siswaHTML = '';
    kelasStudents.forEach(siswa => {
        siswaHTML += `
            <div class="siswa-item">
                <input type="checkbox" class="form-check-input siswa-checkbox" value="${siswa.id}">
                <div class="siswa-info">
                    <div class="siswa-nama">${siswa.nama_lengkap}</div>
                    <div class="siswa-nis">NIS: ${siswa.nis} | Rombel: ${siswa.rombel_name}</div>
                </div>
            </div>
        `;
    });

    document.getElementById('siswaList').innerHTML = siswaHTML;
    document.getElementById('selectAllSiswa').checked = false;
    document.getElementById('selectAllSiswa').indeterminate = false;

    // Show/hide buttons based on mutasi type
    document.getElementById('btnNaikKelas').style.display = mutasiType === 'naik_kelas' ? 'block' : 'none';
    document.getElementById('btnLulus').style.display = mutasiType === 'lulus' ? 'block' : 'none';
    document.getElementById('btnDO').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
    document.getElementById('btnPindah').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
    document.getElementById('btnMeninggal').style.display = mutasiType === 'lainnya' ? 'block' : 'none';

    // Update modal title
    const modalTitle = document.querySelector('#siswaModal .modal-title');
    modalTitle.textContent = `Pilih Siswa - ${kelasName} (${mutasiType.replace(/_/g, ' ').toUpperCase()})`;

    const modal = new bootstrap.Modal(document.getElementById('siswaModal'));
    modal.show();

    // Setup event listeners
    setupCheckboxListeners();
}

function openClassStudents(button) {
    const kelasCard = button.closest('.kelas-card');
    const kelasId = kelasCard.dataset.kelasId;
    const kelasName = kelasCard.dataset.kelasName;
    const siswas = @json($allStudents);
    const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(kelasId));

    let studentHtml = '';
    if (kelasStudents.length === 0) {
        studentHtml = '<p class="text-muted">Belum ada siswa di kelas ini.</p>';
    } else {
        kelasStudents.forEach(siswa => {
            studentHtml += `
                <div class="class-student-item">
                    <div class="siswa-nama">${siswa.nama_lengkap}</div>
                    <div class="siswa-nis">NIS: ${siswa.nis}</div>
                    <div class="text-muted">Rombel: ${siswa.rombel_name}</div>
                </div>
            `;
        });
    }

    document.getElementById('classStudentsModalLabel').textContent = `Siswa Kelas ${kelasName}`;
    document.getElementById('classStudentsCount').textContent = `${kelasStudents.length} siswa`;
    document.getElementById('classStudentsList').innerHTML = studentHtml;

    const modal = new bootstrap.Modal(document.getElementById('classStudentsModal'));
    modal.show();
}

function filterJurusan(jurusan) {
    document.querySelectorAll('.jurusan-tab').forEach(tab => {
        tab.classList.toggle('active', tab.dataset.jurusan === jurusan);
    });
    document.querySelectorAll('.kelas-card').forEach(card => {
        card.classList.toggle('active', card.dataset.jurusan === jurusan);
    });
}

function initJurusanTabs() {
    document.querySelectorAll('.jurusan-tab').forEach(tab => {
        tab.addEventListener('click', () => filterJurusan(tab.dataset.jurusan));
    });
}

document.addEventListener('DOMContentLoaded', initJurusanTabs);

function setupCheckboxListeners() {
    const selectAllCheckbox = document.getElementById('selectAllSiswa');
    const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');

    selectAllCheckbox.onchange = function() {
        siswaCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    };

    siswaCheckboxes.forEach(checkbox => {
        checkbox.onchange = function() {
            const allChecked = Array.from(siswaCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(siswaCheckboxes).some(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        };
    });
}

// Button listeners for mutasi actions
document.getElementById('btnNaikKelas').addEventListener('click', () => executeMutasi('naik_kelas'));
document.getElementById('btnLulus').addEventListener('click', () => executeMutasi('lulus'));
document.getElementById('btnDO').addEventListener('click', () => executeMutasi('do'));
document.getElementById('btnPindah').addEventListener('click', () => executeMutasi('pindah'));
document.getElementById('btnMeninggal').addEventListener('click', () => executeMutasi('meninggal'));

function executeMutasi(status) {
    const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox:checked');
    const siswaIds = Array.from(siswaCheckboxes).map(cb => cb.value);

    if (siswaIds.length === 0) {
        alert('Pilih minimal 1 siswa');
        return;
    }

    if (status === 'pindah') {
        // For pindah, ask for additional info
        const alasan = prompt('Masukkan alasan pindah sekolah:');
        if (!alasan) return;
        
        const tujuan = prompt('Masukkan nama sekolah tujuan:');
        if (!tujuan) return;

        submitBulkMutasi(siswaIds, status, { alasan_pindah: alasan, tujuan_pindah: tujuan });
    } else {
        // For other mutations
        submitBulkMutasi(siswaIds, status);
    }
}

function submitBulkMutasi(siswaIds, status, additionalData = {}) {
    const payload = {
        siswa_ids: siswaIds,
        status: status,
        kelas_id: currentKelasId,
        ...additionalData
    };

    fetch('{{ route("tu.mutasi.bulk") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}
</script>
@endsection
