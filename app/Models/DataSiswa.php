<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $table = 'data_siswa';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'jenis_kelamin_id',
        'agama',
        'agama_id',
        'agama_lainnya',
        'kewarganegaraan',
        'status_keluarga',
        'anak_ke',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'no_hp',
        'sekolah_asal',
        'tanggal_diterima',
        'nama_ayah',
        'pekerjaan_ayah',
        'telepon_ayah',
        'alamat_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'telepon_ibu',
        'alamat_ibu',
        'nama_wali',
        'pekerjaan_wali',
        'telepon_wali',
        'alamat_wali',
        'foto',
        'catatan_wali_kelas',
        'rombel_id',
        'kelas_id',
        'kurikulum_id',
        'ayah_id',
        'ibu_id',
        'wali_id',
        'pkl_nilai',
        'pkl_sertifikat',
        'pkl_nama_industri',
        'pkl_alamat',
        'ijazah_nomor',
        'ijazah_tanggal',
        'transkip_nomor',
        'transkip_tanggal',
        'tanggal_lulus',
        'status_kelulusan',

        // ==========================================
        // DAPODIK — IDENTITAS (7)
        // ==========================================
        'nik',
        'no_kk',
        'no_registrasi_akta',
        'kebutuhan_khusus',
        'alat_transportasi',
        'jenis_tinggal',
        'email',

        // ==========================================
        // DAPODIK — AYAH (4)
        // ==========================================
        'tahun_lahir_ayah',
        'jenjang_pendidikan_ayah',
        'penghasilan_ayah',
        'nik_ayah',

        // ==========================================
        // DAPODIK — IBU (4)
        // ==========================================
        'tahun_lahir_ibu',
        'jenjang_pendidikan_ibu',
        'penghasilan_ibu',
        'nik_ibu',

        // ==========================================
        // DAPODIK — WALI (4)
        // ==========================================
        'tahun_lahir_wali',
        'jenjang_pendidikan_wali',
        'penghasilan_wali',
        'nik_wali',

        // ==========================================
        // DAPODIK — KIP / KPS / PIP (6)
        // ==========================================
        'penerima_kps',
        'no_kps',
        'penerima_kip',
        'nomor_kip',
        'nama_kip',
        'nomor_kks',

        // ==========================================
        // DAPODIK — BANK & PIP (5)
        // ==========================================
        'bank',
        'nomor_rekening',
        'rekening_atas_nama',
        'layak_pip',
        'alasan_layak_pip',

        // ==========================================
        // DAPODIK — UJIAN (3)
        // ==========================================
        'skhun',
        'no_peserta_un',
        'no_seri_ijazah',

        // ==========================================
        // DAPODIK — FISIK & LOKASI (7)
        // ==========================================
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'jumlah_saudara',
        'jarak_rumah_sekolah',
        'lintang',
        'bujur',
    ];

    // ============================================
    // CASTS
    // ============================================
    protected $casts = [
        // Existing
        'tanggal_diterima' => 'date',
        'tanggal_lahir' => 'date',
        'tanggal_lulus' => 'date',
        'ijazah_tanggal' => 'date',
        'transkip_tanggal' => 'date',

        // Dapodik — tahun & integer
        'tahun_lahir_ayah' => 'integer',
        'tahun_lahir_ibu' => 'integer',
        'tahun_lahir_wali' => 'integer',
        'jumlah_saudara' => 'integer',

        // Dapodik — decimal
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'jarak_rumah_sekolah' => 'decimal:3',
        'lintang' => 'decimal:7',
        'bujur' => 'decimal:7',
    ];

    // ============================================
    // RELASI
    // ============================================

    public function nilai()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }

    public function nilaiRaports()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }

    public function ekstra()
    {
        return $this->hasMany(EkstrakurikulerSiswa::class, 'siswa_id');
    }

    public function kehadiran()
    {
        return $this->hasOne(Kehadiran::class, 'siswa_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function raporInfo()
    {
        return $this->hasOne(RaporInfo::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_id');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'siswa_id');
    }

    public function mutasis()
    {
        return $this->hasMany(MutasiSiswa::class, 'siswa_id');
    }

    public function mutasiTerakhir()
    {
        return $this->hasOne(MutasiSiswa::class, 'siswa_id')->latestOfMany();
    }

    /**
     * Relasi ke Ayah (legacy — tidak dipakai karena ayah_id tidak ada di DB)
     */
    public function ayah()
    {
        return $this->belongsTo(\App\Models\Ayah::class, 'ayah_id');
    }

    /**
     * Relasi ke Ibu (legacy — tidak dipakai karena ibu_id tidak ada di DB)
     */
    public function ibu()
    {
        return $this->belongsTo(\App\Models\Ibu::class, 'ibu_id');
    }

    /**
     * Relasi ke Wali (legacy — tidak dipakai karena wali_id tidak ada di DB)
     */
    public function wali()
    {
        return $this->belongsTo(\App\Models\Wali::class, 'wali_id');
    }

    // ============================================
    // ACCESSOR
    // ============================================

    public function getJenisKelaminAttribute()
    {
        if (!empty($this->jenis_kelamin_id)) {
            return optional($this->jenisKelamin()->first())->nama;
        }
        return $this->attributes['jenis_kelamin'] ?? null;
    }

    public function getNamaAgamaAttribute()
    {
        if (!empty($this->agama_id)) {
            return optional($this->agama()->first())->nama ?? '-';
        }
        if (!empty($this->agama_lainnya)) {
            return $this->agama_lainnya;
        }
        if (!empty($this->attributes['agama'])) {
            $value = $this->attributes['agama'];
            if (is_string($value) && strpos($value, '{') === 0) {
                $data = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    return $data['nama'] ?? $value;
                }
            }
            return $value;
        }
        return '-';
    }

    public function getNamaAyahAttribute()
    {
        return $this->attributes['nama_ayah'] ?? '-';
    }

    public function getNamaIbuAttribute()
    {
        return $this->attributes['nama_ibu'] ?? '-';
    }

    public function getNamaWaliAttribute()
    {
        return $this->attributes['nama_wali'] ?? '-';
    }

    public function getAlamatLengkapAttribute()
    {
        $parts = [];
        if (!empty($this->dusun)) $parts[] = "Dusun {$this->dusun}";
        if (!empty($this->rt) || !empty($this->rw)) $parts[] = "RT/RW {$this->rt}/{$this->rw}";
        if (!empty($this->kelurahan)) $parts[] = $this->kelurahan;
        if (!empty($this->kecamatan)) $parts[] = $this->kecamatan;
        if (!empty($this->kode_pos)) $parts[] = $this->kode_pos;

        return implode(', ', $parts) ?: '-';
    }

    // ============================================
    // SCOPE
    // ============================================

    public function scopeFilterByJenisKelamin($query, $value)
    {
        if (is_null($value) || $value === '') return $query;
        $map = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
        $nama = $map[$value] ?? $value;
        return $query->whereHas('jenisKelamin', function ($qq) use ($nama) {
            $qq->where('nama', $nama);
        });
    }
}