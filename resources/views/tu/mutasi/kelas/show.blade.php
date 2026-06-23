@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $rombel->nama)

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --secondary: #10B981;
        --info: #3B82F6;
        --light-bg: #F9FAFB;
        --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --border-radius: 12px;
    }

    body {
        background-color: var(--light-bg);
    }

    .page-header {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-section h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1F2937;
        margin: 0;
    }

    .page-subtitle {
        color: #6B7280;
        font-size: 16px;
        margin-top: 4px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary {
        background: #E5E7EB;
        color: #4B5563;
    }

    .btn-secondary:hover {
        background: #D1D5DB;
    }

    .siswa-table-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .siswa-table {
        width: 100%;
        border-collapse: collapse;
    }

    .siswa-table thead {
        background: #F9FAFB;
        border-bottom: 2px solid #E5E7EB;
    }

    .siswa-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #1F2937;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .siswa-table tbody tr {
        border-bottom: 1px solid #E5E7EB;
        transition: background-color 0.2s;
    }

    .siswa-table tbody tr:hover {
        background-color: #F9FAFB;
    }

    .siswa-table td {
        padding: 16px;
        color: #1F2937;
        font-size: 14px;
    }

    .siswa-table td.nama {
        font-weight: 600;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .action-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-top: 24px;
    }

    .action-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #1F2937;
    }

    .action-buttons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .action-btn {
        padding: 16px;
        border-radius: var(--border-radius);
        border: 2px solid transparent;
        background: white;
        box-shadow: var(--card-shadow);
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-align: center;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--hover-shadow);
    }

    .action-btn.lulus {
        border-color: var(--secondary);
    }

    .action-btn.lulus:hover {
        background: #D1FAE5;
        color: var(--secondary);
    }

    .action-btn.naik {
        border-color: var(--info);
    }

    .action-btn.naik:hover {
        background: #DBEAFE;
        color: var(--info);
    }

    .action-btn.info {
        border-color: #0EA5E9;
    }

    .action-btn.info:hover {
        background: #DBEAFE;
        color: #0EA5E9;
    }

    .action-btn.warning {
        border-color: #F59E0B;
    }

    .action-btn.warning:hover {
        background: #FEF3C7;
        color: #B45309;
    }

    .action-btn.danger {
        border-color: #EF4444;
    }

    .action-btn.danger:hover {
        background: #FEE2E2;
        color: #B91C1C;
    }

    .status-row.pindah {
        background: #EFF6FF;
    }

    .status-row.do {
        background: #FEF3C7;
    }

    .status-row.meninggal {
        background: #FEE2E2;
    }

    .status-badge {
        display: inline-block;
        margin-top: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        background: rgba(15, 23, 42, 0.08);
    }

    .action-icon {
        font-size: 24px;
    }

    .action-label {
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }

    .empty-icon {
        font-size: 48px;
        color: #D1D5DB;
        margin-bottom: 16px;
    }

    .empty-text {
        color: #6B7280;
        font-size: 16px;
    }

    .selected-count {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--primary);
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        z-index: 100;
    }

    @media (max-width: 768px) {
        .siswa-table {
            font-size: 12px;
        }

        .siswa-table th,
        .siswa-table td {
            padding: 12px 8px;
        }
        
        .action-buttons {
            width: 100%;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-title-section">
            <h1 class="page-title">Detail Siswa</h1>
            <p class="page-subtitle">{{ $rombel->nama }} - {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? 'Umum' }}</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('tu.mutasi.kelas', $rombel->kelas->jurusan->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert Info -->
    @php
        $tingkat = $rombel->kelas->tingkat ?? '';
        $isKelasAkhir = in_array($tingkat, ['XII', '12']);
    @endphp
    
    @if($isKelasAkhir)
        <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px; color: #92400E;">
            <p style="margin: 0; font-weight: 600;">
                <i class="fas fa-info-circle" style="margin-right: 8px;"></i> Informasi Penting
            </p>
            <p style="margin: 8px 0 0 0; font-size: 14px;">
                Siswa di kelas <strong>{{ $tingkat }}</strong> harus <strong>LULUS</strong>, bukan naik kelas. 
            </p>
        </div>
    @else
        <div style="background: #E0F2FE; border-left: 4px solid #0284C7; padding: 16px; border-radius: 8px; margin-bottom: 24px; color: #075985;">
            <p style="margin: 0; font-weight: 600;">
                <i class="fas fa-graduation-cap" style="margin-right: 8px;"></i> Kelas {{ $tingkat }}
            </p>
            <p style="margin: 8px 0 0 0; font-size: 14px;">
                Siswa dapat dinaikkan ke kelas berikutnya atau lulus dari sekolah.
            </p>
        </div>
    @endif

    <!-- Siswa Table -->
    @if($rombel->siswas->count() > 0)
        <div class="siswa-table-container">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rombel->siswas as $siswa)
                        @php
                            $mutasiStatus = optional($siswa->mutasiTerakhir)->status;
                            $mutasiLabel = optional($siswa->mutasiTerakhir)->status_label;
                        @endphp
                        <tr class="status-row {{ $mutasiStatus ? 'status-' . $mutasiStatus : '' }}">
                            <td>
                                <input class="form-check-input siswa-checkbox" type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" id="siswa{{ $siswa->id }}">
                            </td>
                            <td class="nama">
                                {{ $siswa->nama_lengkap }}
                                @if($mutasiLabel && $mutasiStatus !== 'lulus')
                                    <div class="status-badge">{{ $mutasiLabel }}</div>
                                @endif
                            </td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <h3 class="action-title">Aksi Massal untuk Siswa Terpilih</h3>
            <p style="margin-bottom: 16px; color: #475569;">Pilih siswa, lalu pilih status mutasi yang diinginkan. Untuk status selain <strong>Lulus</strong>, siswa tetap akan terlihat di rombel dengan tanda warna.</p>
            <div class="action-buttons-grid">
                <button type="button" class="action-btn lulus" onclick="submitForm('lulus')" @if(!$isKelasAkhir) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                    <i class="fas fa-graduation-cap action-icon"></i>
                    <span class="action-label">Lulus Siswa</span>
                    <small>Keluar dari sistem</small>
                </button>
                <button type="button" class="action-btn naik" onclick="submitForm('naik_kelas')" @if($isKelasAkhir) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                    <i class="fas fa-arrow-up action-icon"></i>
                    <span class="action-label">Naik Kelas</span>
                    <small>Pindah ke kelas berikutnya</small>
                </button>
                <button type="button" class="action-btn info" onclick="submitForm('pindah')">
                    <i class="fas fa-plane-departure action-icon"></i>
                    <span class="action-label">Pindah Sekolah</span>
                    <small>Tetap tampil di rombel</small>
                </button>
                <button type="button" class="action-btn warning" onclick="submitForm('do')">
                    <i class="fas fa-sign-out-alt action-icon"></i>
                    <span class="action-label">Keluar Sekolah</span>
                    <small>Data tetap ada di rombel</small>
                </button>
                <button type="button" class="action-btn danger" onclick="submitForm('meninggal')">
                    <i class="fas fa-heartbeat action-icon"></i>
                    <span class="action-label">Meninggal</span>
                    <small>Data tetap ada di rombel</small>
                </button>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <p class="empty-text">Tidak ada siswa di rombel ini.</p>
        </div>
    @endif

    <!-- Selected Counter -->
    <div class="selected-count" id="selectedCount">
        <i class="fas fa-check-circle"></i>
        <span id="countText">0 siswa terpilih</span>
    </div>
</div>

<!-- Visible Mutasi Form -->
<div class="mutasi-form-container" style="margin: 24px auto 0; max-width: 960px; background: white; border-radius: 16px; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08); padding: 24px;">
    <h3 style="margin-bottom: 16px; color: #1F2937;">Form Mutasi Siswa Terpilih</h3>
    <form id="mutasiForm" method="POST" action="{{ route('tu.mutasi.siswa.update') }}">
        @csrf
        <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">

        <div class="row g-3">
            <div class="col-md-4">
                <label for="actionSelect" class="form-label"><i class="fas fa-exchange-alt"></i> Status Mutasi <span class="text-danger">*</span></label>
                <select name="action" id="actionSelect" class="form-select" required onchange="updateStatusFields()">
                    <option value="">-- Pilih Status Mutasi --</option>
                    <option value="lulus">Lulus</option>
                    <option value="naik_kelas">Naik Kelas</option>
                    <option value="pindah">Pindah Sekolah</option>
                    <option value="do">Putus Sekolah (DO)</option>
                    <option value="meninggal">Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tanggal_mutasiForm" class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Mutasi <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_mutasi" id="tanggal_mutasiForm" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label for="keteranganForm" class="form-label"><i class="fas fa-comment"></i> Keterangan</label>
                <input type="text" name="keterangan" id="keteranganForm" class="form-control" placeholder="Catatan tambahan...">
            </div>
        </div>

        <div id="pindahFieldsForm" style="display: none; margin-top: 20px;">
            <h5 style="margin-bottom: 16px;">Data Pindah Sekolah</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="alasan_pindahForm" class="form-label">Alasan Pindah</label>
                    <input type="text" name="alasan_pindah" id="alasan_pindahForm" class="form-control" placeholder="Contoh: Pindah ke kota lain">
                </div>
                <div class="col-md-6">
                    <label for="tujuan_pindahForm" class="form-label">Sekolah Tujuan</label>
                    <input type="text" name="tujuan_pindah" id="tujuan_pindahForm" class="form-control" placeholder="Nama sekolah tujuan">
                </div>
            </div>
        </div>

        <div id="skFieldsForm" style="display: none; margin-top: 20px;">
            <h5 style="margin-bottom: 16px;">Surat Keputusan Keluar</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="no_sk_keluarForm" class="form-label">Nomor SK Keluar</label>
                    <input type="text" name="no_sk_keluar" id="no_sk_keluarForm" class="form-control" placeholder="Contoh: 001/SK/2026">
                </div>
                <div class="col-md-6">
                    <label for="tanggal_sk_keluarForm" class="form-label">Tanggal SK Keluar</label>
                    <input type="date" name="tanggal_sk_keluar" id="tanggal_sk_keluarForm" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Proses Mutasi
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Hidden form for quick top button actions -->
<form id="mutasiHiddenForm" method="POST" action="{{ route('tu.mutasi.siswa.update') }}" style="display: none;">
    @csrf
    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
    <input type="hidden" name="action" id="actionInput" value="">
    <input type="hidden" name="tanggal_mutasi" id="tanggal_mutasiInput" value="{{ now()->format('Y-m-d') }}">
    <input type="hidden" name="keterangan" id="keteranganInput" value="">
    <input type="hidden" name="alasan_pindah" id="alasanPindahInput" value="">
    <input type="hidden" name="tujuan_pindah" id="tujuanPindahInput" value="">
    <input type="hidden" name="no_sk_keluar" id="noSkKeluarInput" value="">
    <input type="hidden" name="tanggal_sk_keluar" id="tanggalSkKeluarInput" value="">
</form>

<script>
    // Data kelas dari server
    const kelasInfo = {
        tingkat: '{{ $rombel->kelas->tingkat ?? "" }}'
    };

    // Checkbox selection handling
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const countText = document.getElementById('countText');
        const selectedCountLabel = document.getElementById('selectedCountLabel');
        const mutasiForm = document.getElementById('mutasiForm');

        // Handle "Select All" checkbox
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                siswaCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });
        }

        // Handle individual checkboxes
        siswaCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(siswaCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(siswaCheckboxes).some(cb => cb.checked);

                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                }

                updateSelectedCount();
            });
        });

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.siswa-checkbox:checked');
            const count = checked.length;

            if (count > 0) {
                selectedCount.style.display = 'flex';
                countText.textContent = `${count} siswa terpilih`;
            } else {
                selectedCount.style.display = 'none';
            }

            if (selectedCountLabel) {
                selectedCountLabel.textContent = `${count} siswa terpilih`;
            }
        }

        function createHiddenStudentInputs(form) {
            form.querySelectorAll('input[name="siswa_ids[]"]').forEach(input => input.remove());
            const checked = document.querySelectorAll('.siswa-checkbox:checked');
            checked.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'siswa_ids[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });
        }

        if (mutasiForm) {
            mutasiForm.addEventListener('submit', function(event) {
                const checked = document.querySelectorAll('.siswa-checkbox:checked');
                if (checked.length === 0) {
                    showNotification('⚠️ Pilih siswa terlebih dahulu', 'warning');
                    event.preventDefault();
                    return;
                }
                createHiddenStudentInputs(this);
            });
        }

        // Initialize
        updateSelectedCount();
        if (typeof updateStatusFields === 'function') {
            updateStatusFields();
        }
    });

    // Form submission for action buttons still uses hidden form
    function submitForm(action) {
        const checkboxes = document.querySelectorAll('.siswa-checkbox:checked');
        if (checkboxes.length === 0) {
            showNotification('⚠️ Pilih siswa terlebih dahulu', 'warning');
            return;
        }

        const tingkat = kelasInfo.tingkat.toUpperCase();
        const isKelasAkhir = tingkat === 'XII' || tingkat === '12';

        if (action === 'naik_kelas') {
            if (isKelasAkhir) {
                showNotification('❌ Siswa kelas XII harus LULUS, bukan naik kelas!', 'error');
                return;
            }

            const actionText = 'naikkan kelas';
            if (confirm(`✅ Apakah Anda yakin ingin ${actionText} ${checkboxes.length} siswa yang dipilih?\n\nKelas: ${tingkat} → Kelas berikutnya`)) {
                prepareFormData(action, checkboxes, {});
                document.getElementById('mutasiHiddenForm').submit();
            }
        } else if (action === 'lulus') {
            if (!isKelasAkhir) {
                showNotification('❌ Hanya siswa kelas XII yang boleh lulus.', 'error');
                return;
            }

            const actionText = 'luluskan';
            if (confirm(`✅ Apakah Anda yakin ingin ${actionText} ${checkboxes.length} siswa yang dipilih?\n\nSiswa ini akan keluar dari sistem.`)) {
                prepareFormData(action, checkboxes, {});
                document.getElementById('mutasiHiddenForm').submit();
            }
        } else if (action === 'pindah' || action === 'do' || action === 'meninggal') {
            document.getElementById('actionSelect').value = action;
            updateStatusFields();
            document.getElementById('mutasiForm').scrollIntoView({ behavior: 'smooth', block: 'center' });

            let suggestion = 'Lengkapi form di bawah ini untuk melanjutkan mutasi.';
            if (action === 'pindah') {
                suggestion = 'Isi alasan pindah dan sekolah tujuan di form yang muncul.';
            } else if (action === 'do' || action === 'meninggal') {
                suggestion = 'Isi nomor SK dan tanggal SK keluar di form yang muncul.';
            }

            showNotification(`ℹ️ ${suggestion} Setelah lengkap, tekan tombol Proses Mutasi di form.`, 'info');
            return;
        }
    }

    function prepareFormData(action, selectedCheckboxes, extraFields) {
        const form = document.getElementById('mutasiHiddenForm');
        const visibleTanggal = document.getElementById('tanggal_mutasiForm')?.value;
        const visibleKeterangan = document.getElementById('keteranganForm')?.value;

        if (visibleTanggal && !('tanggal_mutasi' in extraFields)) {
            extraFields.tanggal_mutasi = visibleTanggal;
        }

        if (visibleKeterangan && !('keterangan' in extraFields)) {
            extraFields.keterangan = visibleKeterangan;
        }

        const hiddenFieldNames = ['keterangan', 'tanggal_mutasi', 'alasan_pindah', 'tujuan_pindah', 'no_sk_keluar', 'tanggal_sk_keluar'];

        form.querySelectorAll('input[name="siswa_ids[]"]').forEach(input => input.remove());

        selectedCheckboxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'siswa_ids[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });

        document.getElementById('actionInput').value = action;

        hiddenFieldNames.forEach(name => {
            const input = document.getElementById(name + 'Input');
            if (input) {
                input.value = extraFields[name] ?? '';
            }
        });
    }

    function updateStatusFields() {
        const status = document.getElementById('actionSelect')?.value;
        const pindahFields = document.getElementById('pindahFieldsForm');
        const skFields = document.getElementById('skFieldsForm');

        if (!pindahFields || !skFields) {
            return;
        }

        pindahFields.style.display = 'none';
        skFields.style.display = 'none';

        if (status === 'pindah') {
            pindahFields.style.display = 'block';
            skFields.style.display = 'block';
        } else if (status === 'do' || status === 'meninggal') {
            skFields.style.display = 'block';
        }
    }
    
    // Toast notification function
    function showNotification(message, type = 'info') {
        const bgColor = {
            'error': '#EF4444',
            'warning': '#F59E0B',
            'success': '#10B981',
            'info': '#3B82F6'
        }[type] || '#3B82F6';

        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: ${bgColor};
            color: white;
            padding: 14px 18px;
            border-radius: 8px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '1';
        }, 100);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
</script>
@endsection
