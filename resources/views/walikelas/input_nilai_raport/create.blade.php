@extends('layouts.app')

@section('title', 'Input Rapor')

@section('content')
<style>
    /* ===================== STYLE INPUT RAPOR ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Responsive Container */
    .report-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    h3.mb-4 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h3.mb-4::before {
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

    /* Section Headers */
    h5.mt-3, h5.mt-4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px !important;
        position: relative;
        padding-left: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #E2E8F0;
    }

    h5.mt-3::before, h5.mt-4::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        border-radius: 2px;
    }

    h5.text-primary {
        color: var(--primary-color) !important;
    }

    h5.text-primary::before {
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    }

    h5.text-success {
        color: var(--success-color) !important;
    }

    h5.text-success::before {
        background: linear-gradient(to bottom, #10B981, #059669);
    }

    h5.text-warning {
        color: var(--warning-color) !important;
    }

    h5.text-warning::before {
        background: linear-gradient(to bottom, #F59E0B, #D97706);
    }

    h5.text-danger {
        color: var(--danger-color) !important;
    }

    h5.text-danger::before {
        background: linear-gradient(to bottom, #EF4444, #DC2626);
    }

    h5.text-info {
        color: var(--info-color) !important;
    }

    h5.text-info::before {
        background: linear-gradient(to bottom, #3B82F6, #2563EB);
    }

    /* Form Styles */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 10px 12px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    /* Table Styles */
    .table {
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table-bordered {
        border: 1px solid #E2E8F0;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #E2E8F0;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 15px;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.02);
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }

    .btn-success:hover {
        background-color: #059669;
        border-color: #059669;
    }

    /* Label Styles */
    .fw-bold {
        color: #475569;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table, .row > div {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3.mb-4 {
            font-size: 22px;
            margin-bottom: 1.5rem !important;
        }
        
        h5.mt-3, h5.mt-4 {
            font-size: 15px;
            margin-top: 1rem !important;
            margin-bottom: 0.75rem !important;
        }
        
        .btn {
            padding: 0.6rem 1rem;
            font-size: 13px;
            width: 100%;
            display: block;
            text-align: center;
            white-space: normal;
            margin: 0.5rem 0 !important;
        }
        
        .form-control, .form-select {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .table {
            font-size: 12px;
        }

        .table thead th,
        .table tbody td {
            padding: 8px 10px;
            word-wrap: break-word;
            word-break: break-all;
        }

        .report-container {
            padding: 0 0.5rem;
        }

        .table-responsive {
            overflow-x: auto;
            display: block;
        }

        .row.mb-4 {
            margin-bottom: 1rem !important;
        }

        .col-md-3, .col-md-4, .col-md-6, .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 0.75rem;
        }

        .d-grid.gap-2 {
            display: flex !important;
            flex-direction: column;
            gap: 0.75rem !important;
        }

        .d-grid.gap-2 .btn {
            margin: 0 !important;
        }
    }
</style>

<div class="container-fluid mt-4">
    <div class="report-container">

    <h3 class="mb-4">Input Rapor — {{ $siswa->nama_lengkap }}</h3>

    <form action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}" method="POST" id="formRapor">
        @csrf

        {{-- ================== SEMESTER & TAHUN ================== --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="fw-bold">Semester</label>
                <select id="semesterSelect" name="semester" class="form-control" required>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" placeholder="2024/2025"
                       class="form-control" required>
            </div>
        </div>

        {{-- ================== NILAI MAPEL KELOMPOK A ================== --}}
        <h5 class="mt-3 text-primary">A. Kelompok Mata Pelajaran Umum</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="10%">Nilai Akhir <span class="text-danger">*</span></th>
                    <th>Capaian Kompetensi <span class="text-danger">*</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelompokA as $m)
                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>
                        <input type="number" name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100" class="form-control nilai-required" required>
                    </td>
                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2" class="form-control deskripsi-required" required></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================== NILAI MAPEL KELOMPOK B ================== --}}
        <h5 class="mt-3 text-primary">B. Kelompok Mata Pelajaran Kejuruan</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="10%">Nilai Akhir <span class="text-danger">*</span></th>
                    <th>Capaian Kompetensi <span class="text-danger">*</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelompokB as $m)
                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>
                        <input type="number" name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100" class="form-control nilai-required" required>
                    </td>
                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2" class="form-control deskripsi-required" required></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================== EKSTRA ================== --}}
        <h5 class="mt-4 text-success">C. Catatan Ekstrakurikuler <span class="text-danger">*</span></h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Ekstrakurikuler <span class="text-danger">*</span></th>
                    <th width="10%">Predikat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @for($i=0;$i<3;$i++)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>

                    {{-- nama ekstra --}}
                    <td>
                        <input type="text" class="form-control ekstra-required"
                               name="ekstra[{{ $i }}][nama_ekstra]"
                               placeholder="Contoh: Pramuka">
                    </td>

                    {{-- predikat --}}
                    <td>
                        <select name="ekstra[{{ $i }}][predikat]" class="form-control">
                            <option value="">-</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>

                    {{-- keterangan --}}
                    <td>
                        <textarea class="form-control" rows="2"
                                  name="ekstra[{{ $i }}][keterangan]"></textarea>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        {{-- ================== KEHADIRAN ================== --}}
        <h5 class="mt-4 text-warning">D. Ketidakhadiran <span class="text-danger">*</span></h5>

        <div class="row">
            <div class="col-md-3">
                <label>Sakit <span class="text-danger">*</span></label>
                <input type="number" class="form-control hadir-required" name="hadir[sakit]" min="0" required>
            </div>
            <div class="col-md-3">
                <label>Izin <span class="text-danger">*</span></label>
                <input type="number" class="form-control hadir-required" name="hadir[izin]" min="0" required>
            </div>
            <div class="col-md-3">
                <label>Tanpa Keterangan <span class="text-danger">*</span></label>
                <input type="number" class="form-control hadir-required" name="hadir[alpa]" min="0" required>
            </div>
        </div>

        {{-- ================== KENAIKAN KELAS ================== --}}
        <div id="kenaikan-section" style="display:none;">
            <h5 class="mt-4 text-danger">E. Kenaikan Kelas</h5>

            <div class="row mt-2">
            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control" name="kenaikan[status]" id="statusSelect">
                    <option value="Naik Kelas">Naik Kelas</option>
                    <option value="Tidak Naik">Tidak Naik</option>
                    <option value="Lulus" @php echo (isset($siswa) && isset($siswa->rombel) && isset($siswa->rombel->kelas) && $siswa->rombel->kelas->tingkat == 12) ? '' : 'disabled'; @endphp>Lulus</option>
                </select>
                @php
                    $currentTingkat = (isset($siswa) && isset($siswa->rombel) && isset($siswa->rombel->kelas)) ? $siswa->rombel->kelas->tingkat : null;
                @endphp
                @if($currentTingkat != 12)
                    <small class="text-muted">* Lulus hanya tersedia untuk Kelas 12</small>
                @endif
            </div>

            <div class="col-md-3">
                <label>Jurusan</label>
                <select id="jurusanSelect" class="form-control" disabled>
                    <option value="">-- Jurusan Siswa --</option>
                    @if(isset($jurusans))
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ isset($currentJurusanId) && $currentJurusanId == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-4" id="rombelTujuanGroup">
                <label>Rombel Tujuan</label>
                <select name="kenaikan[rombel_tujuan_id]" class="form-control" id="rombelSelect">
                    <option value="">-- Pilih Rombel --</option>
                    @php
                        $source = (isset($rombelsFiltered) && $rombelsFiltered->count() > 0) ? $rombelsFiltered : $rombels;
                    @endphp
                    @foreach($source as $r)
                        <option value="{{ $r->id }}">{{ $r->nama }} @if($r->kelas) ({{ $r->kelas->tingkat }} - {{ $r->kelas->jurusan->nama ?? '' }}) @endif</option>
                    @endforeach
                </select>
                @if(isset($targetTingkat) && $targetTingkat)
                    <small class="text-muted">Menampilkan rombel untuk tingkat: {{ $targetTingkat }}</small>
                @endif
            </div>
            </div>
        </div>

        <button class="btn btn-success mt-4" type="submit" id="btnSimpan">Simpan Semua Data</button>

    </form>

    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const semesterEl = document.getElementById('semesterSelect');
            const kenaikanSection = document.getElementById('kenaikan-section');
            const statusSelect = document.getElementById('statusSelect');
            const rombelTujuanGroup = document.getElementById('rombelTujuanGroup');
            const formRapor = document.getElementById('formRapor');
            const btnSimpan = document.getElementById('btnSimpan');

            // Toggle kenaikan section berdasarkan semester
            const updateVisibility = () => {
                if (!semesterEl || !kenaikanSection) return;
                const val = (semesterEl.value || '').toString().toLowerCase();
                if (val === 'genap') {
                    kenaikanSection.style.display = '';
                } else {
                    kenaikanSection.style.display = 'none';
                }
            };
            semesterEl?.addEventListener('change', updateVisibility);
            updateVisibility();

            // Toggle rombel selection berdasarkan status
            const updateRombelVisibility = () => {
                if (!statusSelect || !rombelTujuanGroup) return;
                const status = statusSelect.value;
                if (status === 'Lulus') {
                    rombelTujuanGroup.style.display = 'none';
                    // Clear rombel selection jika Lulus dipilih
                    document.getElementById('rombelSelect').value = '';
                } else {
                    rombelTujuanGroup.style.display = '';
                }
            };
            statusSelect?.addEventListener('change', updateRombelVisibility);
            updateRombelVisibility();

            // Validasi semua table harus diisi sebelum submit
            formRapor?.addEventListener('submit', function(e) {
                let allFilled = true;
                let firstEmpty = null;
                let errorMsg = '';

                // Validasi nilai (semua mata pelajaran)
                const nilaiInputs = document.querySelectorAll('input.nilai-required');
                nilaiInputs.forEach((input) => {
                    if (!input.value || input.value.trim() === '') {
                        allFilled = false;
                        input.classList.add('is-invalid');
                        input.style.borderColor = '#dc3545';
                        if (!firstEmpty) {
                            firstEmpty = input;
                            errorMsg = '❌ NILAI MATA PELAJARAN HARUS DIISI!';
                        }
                    } else {
                        input.classList.remove('is-invalid');
                        input.style.borderColor = '';
                    }
                });

                // Validasi deskripsi (Capaian Kompetensi)
                const deskripsiInputs = document.querySelectorAll('textarea.deskripsi-required');
                deskripsiInputs.forEach((textarea) => {
                    if (!textarea.value || textarea.value.trim() === '') {
                        allFilled = false;
                        textarea.classList.add('is-invalid');
                        textarea.style.borderColor = '#dc3545';
                        if (!firstEmpty) {
                            firstEmpty = textarea;
                            errorMsg = '❌ CAPAIAN KOMPETENSI HARUS DIISI!';
                        }
                    } else {
                        textarea.classList.remove('is-invalid');
                        textarea.style.borderColor = '';
                    }
                });

                // Validasi minimal 1 ekstrakurikuler harus diisi
                const ekstraInputs = document.querySelectorAll('input.ekstra-required');
                let ekstraCount = 0;
                ekstraInputs.forEach((input) => {
                    if (input.value && input.value.trim() !== '') {
                        ekstraCount++;
                    }
                });
                if (ekstraCount === 0) {
                    allFilled = false;
                    if (!firstEmpty) {
                        firstEmpty = ekstraInputs[0];
                        errorMsg = '❌ MINIMAL 1 EKSTRAKURIKULER HARUS DIISI!';
                    }
                }

                // Validasi kehadiran harus diisi
                const hadir_inputs = document.querySelectorAll('input.hadir-required');
                hadir_inputs.forEach((input) => {
                    if (input.value === '' || input.value === null) {
                        allFilled = false;
                        input.classList.add('is-invalid');
                        input.style.borderColor = '#dc3545';
                        if (!firstEmpty) {
                            firstEmpty = input;
                            errorMsg = '❌ DATA KETIDAKHADIRAN HARUS DIISI!';
                        }
                    } else {
                        input.classList.remove('is-invalid');
                        input.style.borderColor = '';
                    }
                });

                if (!allFilled) {
                    e.preventDefault();
                    alert('⚠️ SEMUA TABLE WAJIB DIISI!\n\n' + errorMsg + '\n\nMohon lengkapi semua data sebelum menyimpan.');
                    if (firstEmpty) {
                        firstEmpty.focus();
                        firstEmpty.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }
            });

            // Visual feedback saat user mengetik
            document.querySelectorAll('input.nilai-required').forEach((input) => {
                input.addEventListener('input', function() {
                    if (this.value && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.style.borderColor = '';
                        this.style.borderColor = '#28a745';
                    }
                });
                input.addEventListener('blur', function() {
                    if (!this.value || this.value.trim() === '') {
                        this.classList.add('is-invalid');
                        this.style.borderColor = '#dc3545';
                    }
                });
            });

            // Visual feedback untuk deskripsi (Capaian Kompetensi)
            document.querySelectorAll('textarea.deskripsi-required').forEach((textarea) => {
                textarea.addEventListener('input', function() {
                    if (this.value && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.style.borderColor = '';
                        this.style.borderColor = '#28a745';
                    }
                });
                textarea.addEventListener('blur', function() {
                    if (!this.value || this.value.trim() === '') {
                        this.classList.add('is-invalid');
                        this.style.borderColor = '#dc3545';
                    }
                });
            });

            // Visual feedback untuk ekstrakurikuler
            document.querySelectorAll('input.ekstra-required').forEach((input) => {
                input.addEventListener('input', function() {
                    if (this.value && this.value.trim() !== '') {
                        this.style.borderColor = '#28a745';
                    }
                });
                input.addEventListener('blur', function() {
                    if (!this.value || this.value.trim() === '') {
                        this.style.borderColor = '';
                    }
                });
            });

            // Visual feedback untuk kehadiran
            document.querySelectorAll('input.hadir-required').forEach((input) => {
                input.addEventListener('change', function() {
                    if (this.value !== '' && this.value !== null) {
                        this.classList.remove('is-invalid');
                        this.style.borderColor = '#28a745';
                    }
                });
                input.addEventListener('blur', function() {
                    if (this.value === '' || this.value === null) {
                        this.classList.add('is-invalid');
                        this.style.borderColor = '#dc3545';
                    }
                });
            });
        });
    </script>
@endpush