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
    'jenis_kelamin_id',
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
    'kurikulum_id',
];
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

    public function scopeFilterByJenisKelamin($query, $value)
    {
        if (is_null($value) || $value === '') return $query;
        $map = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
        $nama = $map[$value] ?? $value;
        return $query->whereHas('jenisKelamin', function($qq) use ($nama) {
            $qq->where('nama', $nama);
        });
    }
}