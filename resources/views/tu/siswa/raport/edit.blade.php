@extends('layouts.app')

@section('title', 'Edit Rapor')

@section('content')
    <style>
        /* ===================== STYLE EDIT RAPOR ===================== */

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

        .container {
            max-width: 1200px;
        }

        h3 {
            font-size: 28px;
            color: #1E293B;
            position: relative;
            padding-left: 15px;
            margin-bottom: 20px !important;
        }

        h3::before {
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
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background-color: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            padding: 1rem 1.5rem;
        }

        .card-header h5 {
            font-size: 18px;
            color: #1E293B;
            font-weight: 600;
            margin-bottom: 0;
            position: relative;
            padding-left: 15px;
        }

        .card-header h5::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-bordered {
            border: 1px solid #E2E8F0;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #E2E8F0;
            padding: 12px 15px;
        }

        .table thead th {
            background-color: #F8FAFC;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
        }

        .table tbody td {
            color: #334155;
            font-size: 14px;
        }

        /* Form Styles */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.2rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            color: #64748B;
            border-color: #E2E8F0;
        }

        .btn-outline-secondary:hover {
            background-color: #F1F5F9;
            border-color: #CBD5E1;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #DC2626;
            border-color: #DC2626;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 14px;
        }

        /* Label Styles */
        label {
            color: #475569;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h3 {
                font-size: 24px;
            }

            .card-body {
                padding: 1.25rem;
            }

            .btn {
                padding: 0.4rem 1rem;
                font-size: 14px;
            }

            .form-control,
            .form-select {
                padding: 8px 10px;
            }

            .table-bordered th,
            .table-bordered td {
                padding: 8px 10px;
                font-size: 13px;
            }
        }
    </style>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Edit Rapor — {{ $siswa->nama_lengkap }}</h3>
            <a href="{{ $backRoute ?? route('tu.nilai_raport.show', ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun' => $tahun]) }}"
                class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form
            action="{{ $formAction ?? route('tu.nilai_raport.update', ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun' => $tahun]) }}"
            method="POST">
            @csrf
            @method('PUT')

            <!-- Semester & Tahun (lihat, tidak bisa diubah di edit) -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="fw-bold">Semester</label>
                    <input type="text" class="form-control" value="{{ $semester }}" readonly>
                    <input type="hidden" name="semester" value="{{ $semester }}">
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Tahun Ajaran</label>
                    <input type="text" class="form-control" value="{{ $tahun }}" readonly>
                    <input type="hidden" name="tahun_ajaran" value="{{ $tahun }}">
                </div>
            </div>

            <!-- Tambahkan input hidden untuk parameter -->
            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
            <!-- Identitas Siswa -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Identitas Siswa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Peserta Didik</th>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <th width="30%">Kelas</th>
                            <td>{{ $rombelRaport->nama ?? $siswa->rombel->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $siswa->nisn }}</td>
                            <th>Semester</th>
                            <td>{{ $semester }}</td>
                        </tr>
                        <tr>
                            <th>Sekolah</th>
                            <td>SMK NEGERI 1 X</td>
                            <th>Tahun Pelajaran</th>
                            <td>{{ $tahun }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Kelompok A -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>A. Kelompok Mata Pelajaran Umum</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokA as $mapel)
                                <tr>
                                    <td>{{ $mapel->urutan }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" class="form-control"
                                            value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" min="0" max="100">
                                    </td>
                                    <td>
                                        <textarea name="nilai[{{ $mapel->id }}][deskripsi]" class="form-control"
                                            rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kelompok B -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>B. Kelompok Mata Pelajaran Kejuruan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokB as $mapel)
                                <tr>
                                    <td>{{ $mapel->urutan }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" class="form-control"
                                            value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" min="0" max="100">
                                    </td>
                                    <td>
                                        <textarea name="nilai[{{ $mapel->id }}][deskripsi]" class="form-control"
                                            rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>C. Kegiatan Ekstrakurikuler</h5>
                </div>
                <div class="card-body">
                    @php $oldEkstra = old('ekstra'); @endphp
                    <div id="ekstra-container">
                        @if(is_array($oldEkstra) && count($oldEkstra) > 0)
                            @foreach($oldEkstra as $index => $e)
                                <div class="row mb-3 ekstra-row">
                                    <div class="col-md-4">
                                        <input type="text" name="ekstra[{{ $index }}][nama_ekstra]" class="form-control"
                                            placeholder="Nama Ekstrakurikuler" value="{{ $e['nama_ekstra'] ?? '' }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="ekstra[{{ $index }}][predikat]" class="form-control"
                                            placeholder="Predikat" value="{{ $e['predikat'] ?? '' }}">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="ekstra[{{ $index }}][keterangan]" class="form-control"
                                            placeholder="Keterangan" value="{{ $e['keterangan'] ?? '' }}">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($ekstra as $index => $e)
                                <div class="row mb-3 ekstra-row">
                                    <div class="col-md-4">
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
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" id="add-ekstra" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
                    </button>
                </div>
            </div>

            <!-- Kehadiran -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>D. Ketidakhadiran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Sakit</label>
                            <input type="number" name="hadir[sakit]" class="form-control"
                                value="{{ $kehadiran->sakit ?? 0 }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label>Izin</label>
                            <input type="number" name="hadir[izin]" class="form-control" value="{{ $kehadiran->izin ?? 0 }}"
                                min="0">
                        </div>
                        <div class="col-md-4">
                            <label>Tanpa Keterangan</label>
                            <input type="number" name="hadir[alpa]" class="form-control"
                                value="{{ $kehadiran->tanpa_keterangan ?? 0 }}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <div id="kenaikan-card" style="{{ strtolower($semester) === 'ganjil' ? 'display:none;' : '' }}">
                <!-- Kenaikan Kelas -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>E. Kenaikan Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Status</label>
                                @php
                                    $kStatus = strtolower(str_replace([' ', '_'], '', trim($kenaikan->status ?? '')));
                                @endphp
                                <select name="kenaikan[status]" class="form-control" id="statusKenaikanSelect">
                                    <option value="Naik Kelas" {{ in_array($kStatus, ['naik', 'naikkelas']) ? 'selected' : '' }}>Naik Kelas</option>
                                    <option value="Tidak Naik" {{ in_array($kStatus, ['tidaknaik', 'tidak']) ? 'selected' : '' }}>Tidak Naik</option>
                                    <option value="Lulus" {{ in_array($kStatus, ['lulus', 'lulusan']) ? 'selected' : '' }}>
                                        Lulus</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Ke Kelas</label>
                                @php
                                    $rombelSource = isset($rombelsFiltered) && $rombelsFiltered->count() > 0 ? $rombelsFiltered : $rombels;
                                    $statusNorm = strtolower(str_replace([' ', '_'], '', trim($kenaikan->status ?? '')));
                                    $rombelDisabled = ($semester && strtolower($semester) === 'ganjil') || ($statusNorm !== 'naikkelas');
                                @endphp
                                <select name="kenaikan[rombel_tujuan_id]" class="form-control" id="rombelTujuanSelect" {{ $rombelDisabled ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($rombelSource as $rombel)
                                        <option value="{{ $rombel->id }}" {{ ($kenaikan->rombel_tujuan_id == $rombel->id) ? 'selected' : '' }}>
                                            {{ $rombel->nama }} @if(isset($rombel->kelas)) ({{ $rombel->kelas->tingkat }} -
                                            {{ $rombel->kelas->jurusan->nama ?? '' }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($targetTingkat) && $targetTingkat)
                                    <small class="text-muted">Menampilkan rombel untuk tingkat: {{ $targetTingkat }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <label>Catatan</label>
                            <textarea name="kenaikan[catatan]" class="form-control"
                                rows="2">{{ $kenaikan->catatan ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Info Rapor -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Informasi Rapor</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Wali Kelas</label>
                                <input type="text" name="info[wali_kelas]" class="form-control"
                                    value="{{ $info->wali_kelas ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label>NIP Wali Kelas</label>
                                <input type="text" name="info[nip_wali]" class="form-control"
                                    value="{{ $info->nip_wali ?? '' }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Kepala Sekolah</label>
                                <input type="text" name="info[kepsek]" class="form-control"
                                    value="{{ $info->kepala_sekolah ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label>NIP Kepala Sekolah</label>
                                <input type="text" name="info[nip_kepsek]" class="form-control"
                                    value="{{ $info->nip_kepsek ?? '' }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Tanggal Rapor</label>
                                <input type="date" name="info[tanggal_rapor]" class="form-control"
                                    value="{{ $info->tanggal_rapor ?? date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <button type="button" class="btn btn-danger ms-2" id="delete-rapor">
                    <i class="fas fa-trash"></i> Hapus Rapor
                </button>
            </div>
        </form>

        <form id="form-delete-rapor"
            action="{{ $deleteAction ?? route('tu.nilai_raport.destroy', ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun' => $tahun]) }}"
            method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tambah ekstrakurikuler
            document.getElementById('add-ekstra').addEventListener('click', function () {
                const container = document.getElementById('ekstra-container');
                const index = container.children.length;

                const newRow = document.createElement('div');
                newRow.className = 'row mb-3 ekstra-row';
                newRow.innerHTML = `
                        <div class="col-md-4">
                            <input type="text" name="ekstra[${index}][nama_ekstra]" 
                                   class="form-control" 
                                   placeholder="Nama Ekstrakurikuler">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ekstra[${index}][predikat]" 
                                   class="form-control" 
                                   placeholder="Predikat">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="ekstra[${index}][keterangan]" 
                                   class="form-control" 
                                   placeholder="Keterangan">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                                <i class="fas fa-trash"></i>
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

            // Toggle rombel select enabled state based on status and semester
            function updateRombelState() {
                const statusEl = document.getElementById('statusKenaikanSelect');
                const rombelEl = document.getElementById('rombelTujuanSelect');
                if (!statusEl || !rombelEl) return;
                const statusNorm = (statusEl.value || '').toString().toLowerCase().replace(/\s|_/g, '');
                const semester = '{{$semester}}'.toString().toLowerCase();
                const kenaikanCard = document.getElementById('kenaikan-card');
                if (semester === 'ganjil' || statusNorm !== 'naikkelas') {
                    rombelEl.disabled = true;
                    if (kenaikanCard) kenaikanCard.style.display = 'none';
                } else {
                    rombelEl.disabled = false;
                    if (kenaikanCard) kenaikanCard.style.display = '';
                }
            }

            document.getElementById('statusKenaikanSelect')?.addEventListener('change', updateRombelState);
            // initial state
            updateRombelState();
        });

        // Konfirmasi hapus rapor
        document.getElementById('delete-rapor').addEventListener('click', function () {
            if (confirm('Yakin ingin menghapus seluruh rapor untuk siswa ini (semester & tahun yang dipilih)?')) {
                document.getElementById('form-delete-rapor').submit();
            }
        });
    </script>
@endpush