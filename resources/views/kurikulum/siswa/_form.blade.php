@php
    $siswa = $siswa ?? null;
    $selected_kelas = old('kelas_id', optional(optional(optional($siswa)->rombel)->kelas)->id);
    $selected_rombel = old('rombel_id', $siswa->rombel_id ?? null);
    $selected_jurusan = old('jurusan_id', optional(optional(optional(optional($siswa)->rombel)->kelas)->jurusan)->id);
@endphp

<div class="row g-3">
    <div class="col-12">
        <h5 class="border-bottom pb-2 fw-semibold">Data Akun Siswa</h5>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold"><i class="fas fa-user text-primary me-1"></i> Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="nama_lengkap" class="form-control" required value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold"><i class="fas fa-id-card text-primary me-1"></i> NIS <span class="text-danger">*</span></label>
        <input type="text" name="nis" class="form-control" required value="{{ old('nis', $siswa->nis ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold"><i class="fas fa-id-card text-primary me-1"></i> NISN</label>
        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-calendar-alt text-primary me-1"></i> Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-school text-primary me-1"></i> Sekolah Asal</label>
        <input type="text" name="sekolah_asal" class="form-control" value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-layer-group text-primary me-1"></i> Kelas</label>
        <select name="kelas_id" id="kelasSelect" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas ?? [] as $k)
                <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}" {{ (string)$selected_kelas === (string)$k->id ? 'selected' : '' }}>{{ $k->tingkat }} {{ optional($k->jurusan)->nama ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-building text-primary me-1"></i> Jurusan</label>
        <select name="jurusan_id" class="form-select">
            <option value="">-- Pilih Jurusan --</option>
            @foreach($jurusans ?? [] as $jur)
                <option value="{{ $jur->id }}" {{ (string)$selected_jurusan === (string)$jur->id ? 'selected' : '' }}>{{ $jur->nama ?? 'Jurusan ' . $jur->id }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold"><i class="fas fa-users text-primary me-1"></i> Rombel</label>
        <select name="rombel_id" class="form-select" id="rombelSelect">
            <option value="">-- Pilih Rombel --</option>
            @foreach($rombels ?? [] as $r)
                <option value="{{ $r->id }}" data-kelas="{{ $r->kelas_id }}" {{ (string)$selected_rombel === (string)$r->id ? 'selected' : '' }}>{{ $r->nama ?? ('Rombel ' . $r->id) }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold"><i class="fas fa-lock text-primary me-1"></i> Password{{ isset($siswa) ? ' (kosongkan bila tidak diubah)' : '' }} <span class="text-danger">{{ isset($siswa) ? '' : '*' }}</span></label>
        <input type="password" name="password" class="form-control" {{ isset($siswa) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold"><i class="fas fa-check-circle text-primary me-1"></i> Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($siswa) ? '' : 'required' }}>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
        const kelasSelect = document.getElementById('kelasSelect');
        const rombelSelect = document.getElementById('rombelSelect');

        function filterKelas() {
            const jurusanId = jurusanSelect ? jurusanSelect.value : '';
            Array.from(kelasSelect.options).forEach(opt => {
                if (!opt.value) return;
                const match = !jurusanId || opt.dataset.jurusan == jurusanId;
                opt.style.display = match ? '' : 'none';
            });
            if (kelasSelect.selectedOptions.length && kelasSelect.selectedOptions[0].style.display === 'none') {
                kelasSelect.value = '';
            }
            filterRombel();
        }

        function filterRombel() {
            const kelasId = kelasSelect ? kelasSelect.value : '';
            Array.from(rombelSelect.options).forEach(opt => {
                if (!opt.value) return;
                const dataKelas = opt.dataset.kelas || '';
                const match = !kelasId || dataKelas == kelasId;
                opt.style.display = match ? '' : 'none';
            });
            if (rombelSelect.selectedOptions.length && rombelSelect.selectedOptions[0].style.display === 'none') {
                rombelSelect.value = '';
            }
        }

        if (jurusanSelect) jurusanSelect.addEventListener('change', filterKelas);
        if (kelasSelect) kelasSelect.addEventListener('change', filterRombel);
        filterKelas();
    });
</script>