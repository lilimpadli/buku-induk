@php
$siswa = $siswa ?? null;
$selected_kelas = old('kelas_id', $siswa?->rombel?->kelas?->id);
$selected_rombel = old('rombel_id', $siswa?->rombel_id);
$selected_jurusan = old('jurusan_id', $siswa?->rombel?->kelas?->jurusan?->id);
@endphp

<style>
    .form-section{
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,.05);
        border: 1px solid #eef2ff;
    }

    .section-title{
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
    }

    .section-title i{
        color: #4f46e5;
    }

    .form-label{
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select{
        border-radius: 14px;
        padding: 12px 14px;
        border: 1.5px solid #dbe3f0;
        transition: all .25s ease;
        background: #fff;
    }

    .form-control:focus,
    .form-select:focus{
        border-color: #4f46e5;
        box-shadow: 0 0 0 .2rem rgba(79,70,229,.15);
    }

    .form-control::placeholder{
        color: #9ca3af;
    }

    .input-group-text{
        border-radius: 14px 0 0 14px;
        border: 1.5px solid #dbe3f0;
        background: #f9fafb;
    }

    .form-control.with-icon{
        border-left: 0;
        border-radius: 0 14px 14px 0;
    }

    .badge-required{
        background: #fee2e2;
        color: #dc2626;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 999px;
        margin-left: 6px;
    }

    @media(max-width:768px){
        .form-section{
            padding: 18px;
        }
    }
</style>

<div class="row">


<!-- DATA AKUN -->
<div class="col-12">
    <div class="form-section">
        <h5 class="section-title">
            <i class="fas fa-user-circle"></i>
            Data Akun Siswa
        </h5>

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">
                    Nama Lengkap
                    <span class="badge-required">WAJIB</span>
                </label>

                <input type="text"
                       name="nama_lengkap"
                       class="form-control"
                       required
                       placeholder="Masukkan nama lengkap siswa"
                       value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">NIS</label>

                <input type="text"
                       name="nis"
                       class="form-control"
                       required
                       placeholder="Contoh: 2324001"
                       value="{{ old('nis', $siswa->nis ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">NISN</label>

                <input type="text"
                       name="nisn"
                       class="form-control"
                       placeholder="Masukkan NISN"
                       value="{{ old('nisn', $siswa->nisn ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Jenis Kelamin</label>

                <select name="jenis_kelamin_id" class="form-select" required>
                    <option value="">-- Pilih --</option>

                    @foreach($jenisKelamins as $item)
                        <option value="{{ $item->id }}"
                            {{ (string) old('jenis_kelamin_id', $siswa->jenis_kelamin_id ?? '') === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Sekolah Asal</label>

                <input type="text"
                       name="sekolah_asal"
                       class="form-control"
                       placeholder="Contoh: SMP Negeri 1"
                       value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kelas</label>

                <select name="kelas_id" id="kelasSelect" class="form-select">
                    <option value="">-- Pilih Kelas --</option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}"
                            data-jurusan="{{ $k->jurusan_id }}"
                            {{ (string)$selected_kelas === (string)$k->id ? 'selected' : '' }}>
                            {{ $k->tingkat }} {{ $k->jurusan->nama ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Jurusan</label>

                <select name="jurusan_id" class="form-select">
                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusans as $jur)
                        <option value="{{ $jur->id }}"
                            {{ (string)$selected_jurusan === (string)$jur->id ? 'selected' : '' }}>
                            {{ $jur->nama ?? $jur->name ?? 'Jurusan '.$jur->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Rombel</label>

                <select name="rombel_id" class="form-select" id="rombelSelect">
                    <option value="">-- Pilih Rombel --</option>

                    @foreach($rombels as $r)
                        <option value="{{ $r->id }}"
                            data-kelas="{{ $r->kelas_id }}"
                            {{ (string)$selected_rombel === (string)$r->id ? 'selected' : '' }}>
                            {{ $r->nama ?? ('Rombel '.$r->id) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Password
                    {{ isset($siswa) ? '(Kosongkan jika tidak diubah)' : '' }}
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       {{ isset($siswa) ? '' : 'required' }}>
            </div>

            <div class="col-md-6">
                <label class="form-label">Konfirmasi Password</label>

                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       {{ isset($siswa) ? '' : 'required' }}>
            </div>

        </div>
    </div>
</div>

<!-- DATA PRIBADI -->
<div class="col-12">
    <div class="form-section">
        <h5 class="section-title">
            <i class="fas fa-id-card"></i>
            Data Pribadi Siswa
        </h5>

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>

                <input type="text"
                       name="tempat_lahir"
                       class="form-control"
                       value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>

                <input type="date"
                       name="tanggal_lahir"
                       class="form-control"
                       value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
            </div>

            @php
                $currentAgamaId = old('agama_id', $siswa->agama_id ?? '');
                $currentAgamaLainnya = old('agama_lainnya', $siswa->agama_lainnya ?? '');
                $selectedAgamaId = $currentAgamaLainnya !== '' && $currentAgamaId === '' ? 'other' : $currentAgamaId;
                $showAgamaLainnya = $selectedAgamaId === 'other';
            @endphp

            <div class="col-md-4">
                <label class="form-label">Agama</label>

                <select name="agama_id" id="agamaSelect" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach($agamas as $item)
                        <option value="{{ $item->id }}"
                            {{ (string) $selectedAgamaId === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                    <option value="other" {{ $selectedAgamaId === 'other' ? 'selected' : '' }}>
                        Lainnya
                    </option>
                </select>
            </div>

            <div class="col-md-4 {{ $showAgamaLainnya ? '' : 'd-none' }}" id="agama_lainnya_group">
                <label class="form-label">Agama Lainnya</label>

                <input type="text"
                       name="agama_lainnya"
                       id="agama_lainnya"
                       class="form-control"
                       placeholder="Tuliskan agama lain jika dipilih"
                       value="{{ $currentAgamaLainnya }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kewarganegaraan</label>

                <input type="text"
                       name="kewarganegaraan"
                       class="form-control"
                       value="{{ old('kewarganegaraan', $siswa->kewarganegaraan ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">No HP</label>

                <input type="text"
                       name="no_hp"
                       class="form-control"
                       placeholder="08xxxxxxxxxx"
                       value="{{ old('no_hp', $siswa->no_hp ?? '') }}">
            </div>

        </div>
    </div>
</div>

<!-- ALAMAT -->
<div class="col-12">
    <div class="form-section">
        <h5 class="section-title">
            <i class="fas fa-map-marker-alt"></i>
            Alamat Siswa
        </h5>

        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Dusun</label>

                <input type="text"
                       name="dusun"
                       class="form-control"
                       value="{{ old('dusun', $siswa->dusun ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">RT</label>

                <input type="text"
                       name="rt"
                       class="form-control"
                       placeholder="001"
                       value="{{ old('rt', $siswa->rt ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">RW</label>

                <input type="text"
                       name="rw"
                       class="form-control"
                       placeholder="001"
                       value="{{ old('rw', $siswa->rw ?? '') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Kode Pos</label>

                <input type="text"
                       name="kode_pos"
                       class="form-control"
                       value="{{ old('kode_pos', $siswa->kode_pos ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Kelurahan / Desa</label>

                <input type="text"
                       name="kelurahan"
                       class="form-control"
                       value="{{ old('kelurahan', $siswa->kelurahan ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Kecamatan</label>

                <input type="text"
                       name="kecamatan"
                       class="form-control"
                       value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Tanggal Diterima</label>

                <input type="date"
                       name="tanggal_diterima"
                       class="form-control"
                       value="{{ old('tanggal_diterima', $siswa->tanggal_diterima ?? '') }}">
            </div>

        </div>
    </div>
</div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const agamaSelect = document.getElementById('agamaSelect');
        const agamaLainnyaGroup = document.getElementById('agama_lainnya_group');

        function toggleAgamaLainnya() {
            if (!agamaSelect || !agamaLainnyaGroup) {
                return;
            }

            if (agamaSelect.value === 'other') {
                agamaLainnyaGroup.classList.remove('d-none');
            } else {
                agamaLainnyaGroup.classList.add('d-none');
            }
        }

        if (agamaSelect) {
            agamaSelect.addEventListener('change', toggleAgamaLainnya);
            toggleAgamaLainnya();
        }
    });
</script>
