@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<style>
    /* ===================== STYLE DETAIL KELAS ===================== */
    
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

    .card-body {
        padding: 1.5rem;
    }

    .card-body.d-flex {
        padding: 1.25rem;
    }

    /* Section Headers */
    h5.mb-0 {
        font-size: 20px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0 !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-0::before {
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

    h6.card-title {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
    }

    h6.card-title::before {
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

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table-sm {
        font-size: 14px;
    }

    .table thead th {
        border-bottom: 2px solid #E2E8F0;
        color: #475569;
        font-weight: 600;
        padding: 12px 15px;
    }

    .table td, .table th {
        border-color: #E2E8F0;
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
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

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid #E2E8F0;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #E2E8F0;
        padding: 1.5rem;
    }

    /* Table in Modal */
    .modal-body .table-sm th {
        width: 30%;
        color: #475569;
        font-weight: 600;
    }

    .modal-body .table-sm td {
        color: #334155;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
        font-size: 14px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .card-body.d-flex {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        h5.mb-0 {
            font-size: 18px;
            margin-bottom: 0.5rem !important;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .table thead th,
        .table td, .table th {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .modal-body .table-sm th {
            width: 40%;
        }
    }
</style>

<div class="container mt-4">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $rombel->nama }}</h5>
                <small class="text-muted">Kelas: {{ $rombel->kelas->tingkat ?? '-' }} - Jurusan: {{ $rombel->kelas->jurusan->nama ?? '-' }}</small>
            </div>
            <a href="{{ route('kaprog.kelas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Daftar Siswa ({{ $siswa->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->rombel->nama ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-detail-siswa" data-id="{{ $s->id }}">Lihat</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-user-slash me-2"></i>Tidak ada siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function showSiswaDetail(data) {
        const modalBody = document.getElementById('siswaDetailBody');
        modalBody.innerHTML = `
            <table class="table table-sm">
                <tbody>
                    <tr><th>Nama</th><td>${data.nama_lengkap || '-'}</td></tr>
                    <tr><th>NIS</th><td>${data.nis || '-'}</td></tr>
                    <tr><th>NISN</th><td>${data.nisn || '-'}</td></tr>
                    <tr><th>Tempat, Tanggal Lahir</th><td>${data.tempat_lahir || '-'}, ${data.tanggal_lahir || '-'}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>${data.jenis_kelamin || '-'}</td></tr>
                    <tr><th>Agama</th><td>${data.agama || '-'}</td></tr>
                    <tr><th>Alamat</th><td>${data.alamat || '-'}</td></tr>
                    <tr><th>No HP</th><td>${data.no_hp || '-'}</td></tr>
                    <tr><th>Sekolah Asal</th><td>${data.sekolah_asal || '-'}</td></tr>
                    <tr><th>Tanggal Diterima</th><td>${data.tanggal_diterima || '-'}</td></tr>
                    <tr><th>Nama Ayah</th><td>${data.nama_ayah || '-'}</td></tr>
                    <tr><th>Pekerjaan Ayah</th><td>${data.pekerjaan_ayah || '-'}</td></tr>
                    <tr><th>Nama Ibu</th><td>${data.nama_ibu || '-'}</td></tr>
                    <tr><th>Pekerjaan Ibu</th><td>${data.pekerjaan_ibu || '-'}</td></tr>
                </tbody>
            </table>
        `;
        // show modal
        const modal = new bootstrap.Modal(document.getElementById('siswaDetailModal'));
        modal.show();
    }

    document.querySelectorAll('.btn-detail-siswa').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            fetch(`{{ url('kaprog/siswa') }}/${id}/detail`)
                .then(r => r.json())
                .then(data => showSiswaDetail(data))
                .catch(err => {
                    console.error(err);
                    alert('Gagal mengambil data siswa');
                });
        });
    });
});
</script>

<!-- Modal -->
<div class="modal fade" id="siswaDetailModal" tabindex="-1" aria-labelledby="siswaDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siswaDetailModalLabel">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="siswaDetailBody">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush