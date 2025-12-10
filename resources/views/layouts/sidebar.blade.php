{{-- MENU WALI KELAS --}}
@if(auth()->user()->role == 'walikelas')

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}"
            href="{{ route('walikelas.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('walikelas.siswa.*') ? 'active' : '' }}"
            href="{{ route('walikelas.siswa.index') }}">
            <i class="fas fa-users"></i> Daftar Siswa
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('walikelas.nilai_raport.*') ? 'active' : '' }}"
            href="{{ route('walikelas.nilai_raport.index') }}">
            <i class="fas fa-chart-line"></i> Nilai Raport
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('walikelas.input_nilai_raport.*') ? 'active' : '' }}"
            href="{{ route('walikelas.input_nilai_raport.index') }}">
            <i class="fas fa-edit"></i> Input Nilai Raport
        </a>
    </li>

@endif
