@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<style>
    /* ===================== STYLE DETAIL SISWA - RESPONSIVE ===================== */
    
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
    }

    /* Header Section */
    .detail-header {
        display: flex;
        align-items: start;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 15px;
    }

    .detail-header h2 {
        font-weight: bold;
        margin-bottom: 0.25rem;
        font-size: 28px;
        color: #1E293B;
    }

    .detail-header p {
        color: #64748B;
        margin-bottom: 0;
        font-size: 15px;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .header-actions .btn {
        white-space: nowrap;
        border-radius: 8px;
        font-size: 14px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .header-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Nav Tabs */
    .nav-tabs {
        border-bottom: 2px solid #E2E8F0;
        margin-bottom: 0;
    }

    .nav-tabs .nav-item {
        margin-bottom: -2px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #64748B;
        padding: 12px 20px;
        font-weight: 500;
        font-size: 15px;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        border-radius: 0;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(47, 83, 255, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        background-color: transparent;
        font-weight: 600;
    }

    /* Card Styles */
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 2rem;
    }

    .card-body h5 {
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 1.5rem;
        font-size: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #E2E8F0;
    }

    /* Table Styles */
    .table-borderless {
        margin-bottom: 0;
    }

    .table-borderless tr {
        transition: background-color 0.2s ease;
    }

    .table-borderless tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table-borderless td {
        padding: 12px 8px;
        vertical-align: top;
        font-size: 15px;
        color: #334155;
    }

    .table-borderless td:first-child {
        font-weight: 500;
        color: #64748B;
        width: 180px;
    }

    .table-borderless td:last-child {
        color: #1E293B;
        font-weight: 400;
    }

    /* Divider */
    hr {
        border-top: 2px solid #E2E8F0;
        margin: 2rem 0;
        opacity: 1;
    }

    /* Tab Content */
    .tab-content {
        animation: fadeIn 0.4s ease-in;
    }

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

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        background-color: var(--light-bg);
        border-bottom: 1px solid #E2E8F0;
        border-radius: 12px 12px 0 0;
    }

    .modal-title {
        font-weight: 600;
        color: #1E293B;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (max-width: 991px) */
    @media (max-width: 991px) {
        .detail-header h2 {
            font-size: 24px;
        }

        .detail-header p {
            font-size: 14px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table-borderless td:first-child {
            width: 160px;
        }

        .nav-tabs .nav-link {
            padding: 10px 16px;
            font-size: 14px;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Header */
        .detail-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
            margin-bottom: 1.25rem;
        }

        .detail-header h2 {
            font-size: 22px;
            margin-bottom: 0.5rem;
        }

        .detail-header p {
            font-size: 14px;
            margin-bottom: 0.75rem;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
        }

        /* Tabs */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        .nav-tabs::-webkit-scrollbar {
            height: 4px;
        }

        .nav-tabs::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 4px;
        }

        .nav-tabs .nav-item {
            flex-shrink: 0;
        }

        .nav-tabs .nav-link {
            padding: 10px 16px;
            font-size: 14px;
            white-space: nowrap;
        }

        /* Card */
        .card {
            margin-top: 1rem;
            border-radius: 12px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-body h5 {
            font-size: 16px;
            margin-bottom: 1.25rem;
            padding-bottom: 8px;
        }

        /* Table */
        .table-borderless {
            font-size: 14px;
        }

        .table-borderless tr {
            display: flex;
            flex-direction: column;
            padding: 10px 0;
            border-bottom: 1px solid #F1F5F9;
        }

        .table-borderless tr:last-child {
            border-bottom: none;
        }

        .table-borderless td {
            padding: 4px 0;
            width: 100% !important;
        }

        .table-borderless td:first-child {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 4px;
        }

        .table-borderless td:last-child {
            font-size: 14px;
            color: #1E293B;
            padding-left: 0;
        }

        /* Divider */
        hr {
            margin: 1.5rem 0;
        }

        /* Modal */
        .modal-dialog {
            margin: 10px;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        .detail-header h2 {
            font-size: 20px;
        }

        .detail-header p {
            font-size: 13px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-body h5 {
            font-size: 15px;
            margin-bottom: 1rem;
        }

        .table-borderless {
            font-size: 13px;
        }

        .table-borderless td:first-child {
            font-size: 12px;
        }

        .table-borderless td:last-child {
            font-size: 13px;
        }

        .nav-tabs .nav-link {
            padding: 9px 14px;
            font-size: 13px;
        }

        .header-actions .btn {
            font-size: 13px;
            padding: 9px 14px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .detail-header h2 {
            font-size: 30px;
        }

        .card-body {
            padding: 2.5rem;
        }

        .table-borderless td {
            font-size: 16px;
            padding: 14px 10px;
        }

        .table-borderless td:first-child {
            width: 200px;
        }
    }

    /* Print Styles */
    @media print {
        .header-actions,
        .nav-tabs,
        .btn-close {
            display: none !important;
        }

        .tab-pane {
            display: block !important;
            opacity: 1 !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
            margin-top: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        hr {
            border-top: 1px solid #000;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="detail-header">
        <div class="header-info">
            <h2>Detail Siswa</h2>
            <p>{{ $siswa->nama_lengkap }}</p>
        </div>
        <div class="ms-3">
            <a href="{{ route('kurikulum.data-siswa.edit', $siswa->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('kurikulum.siswa.cetak', $siswa->id) }}" class="btn btn-success me-2" target="_blank">
                <i class="fas fa-print"></i> Cetak
            </a>
            <a href="{{ route('kurikulum.rapor.show', $siswa->id) }}" class="btn btn-primary">
                <i class="fas fa-file-alt"></i> <span class="d-none d-sm-inline">Raport</span>
            </a>
        </div>
    </div>

    <!-- Flash Modal -->
    @if(session('success') || session('error'))
        <div class="modal fade" id="flashModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(session('success'))
                            <div class="text-success">{{ session('success') }}</div>
                        @else
                            <div class="text-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    var m = new bootstrap.Modal(document.getElementById('flashModal'));
                    m.show();
                } catch (e) {
                    var msg = {!! json_encode(session('success') ?? session('error')) !!};
                    if (msg) alert(msg);
                }
            });
        </script>
    @endif

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="siswaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" 
                    id="data-siswa-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#data-siswa" 
                    type="button" 
                    role="tab" 
                    aria-controls="data-siswa" 
                    aria-selected="true">
                Data Siswa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" 
                    id="data-orangtua-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#data-orangtua" 
                    type="button" 
                    role="tab" 
                    aria-controls="data-orangtua" 
                    aria-selected="false">
                Data Orang Tua
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="siswaTabsContent">
        <!-- Tab Data Siswa -->
        <div class="tab-pane fade show active" 
             id="data-siswa" 
             role="tabpanel" 
             aria-labelledby="data-siswa-tab">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Informasi Siswa</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>NIS</td>
                                <td>: {{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $siswa->nisn }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td>: {{ $siswa->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>: {{ $siswa->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>: {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: {{ $siswa->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>: {{ $siswa->agama }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->alamat }}</td>
                            </tr>
                            <tr>
                                <td>No HP</td>
                                <td>: {{ $siswa->no_hp }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Rombel</td>
                                <td>: {{ $siswa->rombel->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Diterima</td>
                                <td>: {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Data Orang Tua -->
        <div class="tab-pane fade" 
             id="data-orangtua" 
             role="tabpanel" 
             aria-labelledby="data-orangtua-tab">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Data Ayah</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->ayah->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->ayah->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->ayah->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->ayah->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <h5>Data Ibu</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->ibu->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->ibu->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->ibu->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->ibu->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <h5>Data Wali</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $siswa->wali->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: {{ $siswa->wali->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $siswa->wali->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $siswa->wali->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection