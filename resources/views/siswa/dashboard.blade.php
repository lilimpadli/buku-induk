@extends('layouts.app')

@section('content')

<style>
    /* ===================== STYLE DASHBOARD SISWA ===================== */
    
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

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
    }

    .subtitle {
        font-size: 15px;
        color: #64748B;
        margin-bottom: 25px;
    }

    /* Section Headers */
    h5.fw-bold {
        font-size: 18px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 20px;
    }

    h5.fw-bold::before {
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

    /* Kartu nilai */
    .nilai-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }
    
    .nilai-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .nilai-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
        border-color: rgba(47, 83, 255, 0.2);
    }

    .nilai-title {
        font-weight: 600;
        font-size: 15px;
        color: #334155;
        margin-bottom: 8px;
    }

    .nilai-angka {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.1;
        margin-bottom: 5px;
    }

    .nilai-angka small {
        font-size: 16px;
        color: #94A3B8;
        font-weight: 500;
    }

    .predikat {
        font-size: 13px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 8px;
    }

    .predikat.text-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    /* Card catatan */
    .catatan-box {
        height: 240px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #CBD5E1 #F1F5F9;
    }

    .catatan-box::-webkit-scrollbar {
        width: 6px;
    }

    .catatan-box::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 3px;
    }

    .catatan-box::-webkit-scrollbar-thumb {
        background-color: #CBD5E1;
        border-radius: 3px;
    }

    .catatan-item {
        padding: 10px 0;
        border-bottom: 1px dashed #E2E8F0;
        font-size: 14px;
        color: #475569;
        transition: all 0.2s;
    }

    .catatan-item:hover {
        padding-left: 5px;
        color: var(--primary-color);
    }

    .catatan-item:last-child {
        border-bottom: none;
    }

    /* Profile Card */
    .card.shadow-sm {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card.shadow-sm:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 0.5rem;
    }

    .card-body hr {
        border-color: #E2E8F0;
        margin: 1rem 0;
    }

    /* Profile Image */
    .rounded-circle {
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .rounded-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.4rem 1rem;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-warning {
        color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-outline-warning:hover {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-outline-danger {
        color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-outline-danger:hover {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    /* Table Styles */
    .table-borderless th {
        color: #64748B;
        font-weight: 600;
        font-size: 14px;
        padding: 0.5rem 0;
    }

    .table-borderless td {
        color: #334155;
        padding: 0.5rem 0;
    }

    /* List Group */
    .list-group-flush .d-flex {
        padding: 0.75rem 0;
        border-bottom: 1px solid #E2E8F0;
        transition: all 0.2s;
    }

    .list-group-flush .d-flex:hover {
        background-color: rgba(47, 83, 255, 0.05);
        padding-left: 10px;
        margin: 0 -10px;
        border-radius: 8px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .container-fluid > * {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 24px;
        }
        
        .nilai-angka {
            font-size: 28px;
        }
        
        .card-body {
            padding: 1.25rem;
        }
    }
</style>

<div class="container-fluid">

    <h3 class="dashboard-title">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}!</h3>

    <p class="subtitle">
        Kelas kamu:
        @if($siswa && $siswa->rombel)
            @php
                $tingkat = strtoupper($siswa->rombel->kelas->tingkat ?? '');
                $rombelNama = $siswa->rombel->nama ?? '';

                // Format rombel: if like "rpl1" -> "RPL 1", otherwise use title case (e.g. "Gim")
                $rombelDisplay = '';
                if(!empty($rombelNama)){
                    if(preg_match('/^([a-zA-Z]+)\s*([0-9]+)$/', $rombelNama, $m)){
                        $rombelDisplay = strtoupper($m[1]) . ' ' . $m[2];
                    } else {
                        $rombelDisplay = ucwords(strtolower($rombelNama));
                    }
                }

                $kelasDisplay = trim(  ' ' . $rombelDisplay);
            @endphp
            {{ $kelasDisplay ?: '-' }}
        @else
            -
        @endif
    </p>

    <p class="subtitle">Wali kelas kamu: {{ $siswa && $siswa->rombel && $siswa->rombel->guru ? $siswa->rombel->guru->nama : 'Belum ditentukan' }}</p>

    <!-- ========================= NILAI RINGKASAN ========================= -->
    <h5 class="fw-bold mt-4 mb-3">Ringkasan Nilai Terbaru</h5>

    <div class="row g-3">

        @if(isset($ringkasanNilai) && count($ringkasanNilai) > 0)
            @foreach($ringkasanNilai as $mapel => $nilai)
                <div class="col-md-3">
                    <div class="card nilai-card shadow-sm p-3">
                        <span class="nilai-title">{{ $mapel }}</span>

                        <div class="nilai-angka mt-1">{{ $nilai['angka'] }} <small>/ 100</small></div>

                        <p class="text-success predikat mt-1">{{ $nilai['predikat'] }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div>
                        Belum ada nilai terbaru.
                    </div>
                </div>
            </div>
        @endif

        <!-- ========================= CATATAN WALI KELAS ========================= -->
      

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="rounded-circle mb-3" width="110" height="110" alt="Foto Siswa">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width:110px;height:110px;color:white;font-weight:600;">{{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'S' }}</div>
                    @endif
                    <h5 class="card-title mb-0">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h5>
                    <small class="text-muted d-block">NIS: {{ $siswa->nis ?? '-' }} | NISN: {{ $siswa->nisn ?? '-' }}</small>
                    <hr>
                    
                    <!-- Tombol Edit Profil -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNamaModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg> Nama
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg> Email
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                            </svg> Foto
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg> Password
                        </button>
                    </div>
                    
                    <p class="mb-1"><strong>Profil lengkap:</strong></p>
                    @if(isset($missing) && count($missing) > 0)
                        <div class="alert alert-warning d-flex align-items-center justify-content-center p-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <span class="small">Masih ada {{ count($missing) }} field kosong</span>
                        </div>
                        <button class="btn btn-sm btn-outline-warning" onclick="location.href='{{ route('siswa.dataDiri.edit') }}'">Lengkapi Sekarang</button>
                    @else
                        <div class="alert alert-success d-flex align-items-center justify-content-center p-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <span class="small">Semua data penting terisi</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Raport</h6>
                            <p class="small text-muted">Ringkasan tahun ajaran yang tersedia</p>
                            @if(!empty($raportYears) && count($raportYears) > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($raportYears as $year)
                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div><strong>{{ $year }}</strong></div>
                                            <div>
                                                <a href="{{ route('siswa.raport.show', ['semester' => 'Ganjil', 'tahun' => str_replace('/','-',$year)]) }}" class="btn btn-sm btn-outline-primary me-1">Ganjil</a>
                                                <a href="{{ route('siswa.raport.show', ['semester' => 'Genap', 'tahun' => str_replace('/','-',$year)]) }}" class="btn btn-sm btn-outline-primary">Genap</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                                    <div class="small">
                                        Belum ada data raport. Silakan hubungi wali kelas.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Kontak Orang Tua</h6>
                            <p class="small text-muted">Informasi kontak dan alamat orang tua/wali</p>
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th width="35%">Nama Ayah</th>
                                        <td>{{ $siswa->ayah->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Ayah</th>
                                        <td>{{ $siswa->ayah->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td>{{ $siswa->ibu->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Ibu</th>
                                        <td>{{ $siswa->ibu->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Orang Tua</th>
                                        <td>{{ $siswa->ayah->alamat ?? ($siswa->ibu->alamat ?? '-') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-sm btn-primary">Edit Kontak</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Informasi Lainnya</h6>
                            <p class="mb-0 small text-muted">Anda dapat mengakses raport, mengunduh PDF data diri, atau menghubungi wali kelas jika ada masalah data.</p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('siswa.raport') }}" class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text me-1" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                    Lihat Semua Raport
                                </a>
                                <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-outline-danger" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf me-1" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                    </svg>
                                    Unduh Data Diri (PDF)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Edit Nama -->
<div class="modal fade" id="editNamaModal" tabindex="-1" aria-labelledby="editNamaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNamaModalLabel">Edit Nama Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $siswa->nama_lengkap ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Email -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailModalLabel">Edit Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateEmail') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="form-text">Masukkan password saat ini untuk mengubah email</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFotoModalLabel">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal: 2MB</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
