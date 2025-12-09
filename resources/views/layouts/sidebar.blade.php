<!-- Menu Wali Kelas -->
@if(auth()->user()->hasRole('wali_kelas'))
    <li class="nav-item">
        <a class="nav-link {{ request()->is('walikelas') ? 'active' : '' }}" href="{{ route('walikelas.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('walikelas/siswa*') ? 'active' : '' }}" href="{{ route('walikelas.siswa.index') }}">
            <i class="fas fa-users"></i> Daftar Siswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('walikelas/nilai-raport*') ? 'active' : '' }}" href="{{ route('walikelas.nilai_raport.index') }}">
            <i class="fas fa-chart-line"></i> Nilai Raport
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('walikelas/input-nilai-raport*') ? 'active' : '' }}" href="{{ route('walikelas.input_nilai_raport.index') }}">
            <i class="fas fa-edit"></i> Input Nilai Raport
        </a>
    </li>
@endif

<!-- Menu TU -->
@if(auth()->user()->hasRole('tu'))
    <li class="nav-item">
        <a class="nav-link {{ request()->is('tu') ? 'active' : '' }}" href="{{ route('tu.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('tu/siswa*') ? 'active' : '' }}" href="{{ route('tu.siswa') }}">
            <i class="fas fa-users"></i> Data Siswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('tu/wali-kelas*') ? 'active' : '' }}" href="{{ route('tu.wali-kelas') }}">
            <i class="fas fa-chalkboard-teacher"></i> Wali Kelas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('tu/laporan-nilai*') ? 'active' : '' }}" href="{{ route('tu.laporan.nilai') }}">
            <i class="fas fa-chart-line"></i> Laporan Nilai
        </a>
    </li>
@endif