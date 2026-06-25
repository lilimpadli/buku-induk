<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiSiswa extends Model
{
    protected $table = 'mutasi_siswas';

    protected $fillable = [
        'siswa_id',
        'status',
        'tanggal_mutasi',
        'tahun_ajaran',
        'keterangan',
        'alasan_pindah',
        'no_sk_keluar',
        'tanggal_sk_keluar',
        'tujuan_pindah',
    ];

    protected $dates = [
        'tanggal_mutasi',
        'tanggal_sk_keluar',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
        'tanggal_sk_keluar' => 'date',
    ];

    /**
     * Boot method untuk event listeners
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($mutasi) {
            $mutasi->handleMutasi();
        });

        static::updated(function ($mutasi) {
            if ($mutasi->isDirty('status')) {
                $mutasi->handleMutasi();
            }
        });
    }

    /**
     * Relationship dengan Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    /**
     * Scopes untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePindah($query)
    {
        return $query->where('status', 'pindah');
    }

    public function scopeDo($query)
    {
        return $query->where('status', 'do');
    }

    public function scopeMeninggal($query)
    {
        return $query->where('status', 'meninggal');
    }

    public function scopeNaikKelas($query)
    {
        return $query->where('status', 'naik_kelas');
    }

    public function scopeLulus($query)
    {
        return $query->where('status', 'lulus');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Keluar Sekolah',
            'meninggal' => 'Meninggal',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pindah' => 'info',
            'do' => 'warning',
            'meninggal' => 'danger',
            'naik_kelas' => 'success',
            'lulus' => 'primary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Handle mutasi logic berdasarkan status
     */
    private function handleMutasi()
    {
        try {
            match ($this->status) {
                'naik_kelas' => $this->handleNaikKelas(),
                'lulus' => $this->handleLulus(),
                'pindah', 'do', 'meninggal' => $this->handleTerminalStatus(),
                default => null,
            };
        } catch (\Exception $e) {
            // Log error tapi jangan block proses penyimpanan
            \Illuminate\Support\Facades\Log::error('Error handling mutasi siswa: ' . $e->getMessage());
        }
    }

    /**
     * Handle naik kelas - update rombel dan kelas ke tingkat berikutnya
     */
    private function handleNaikKelas()
    {
        $siswa = $this->siswa;
        if (!$siswa || !$siswa->rombel) {
            return;
        }

        $currentRombel = $siswa->rombel;
        $currentKelas = $currentRombel->kelas;
        if (!$currentKelas) {
            return;
        }

        // Tentukan tingkat berikutnya dalam format yang sama seperti data kelas
        $nextTingkat = $this->getNextTingkat($currentKelas->tingkat);
        if (!$nextTingkat) {
            return;
        }

        // Cari kelas tujuan dengan jurusan yang sama
        $nextKelas = Kelas::where('jurusan_id', $currentKelas->jurusan_id)
            ->where('tingkat', $nextTingkat)
            ->first();

        if (!$nextKelas) {
            return;
        }

        // Ambil nama rombel yang sama di kelas tujuan
        $baseName = preg_replace('/^\s*(X|XI|XII|10|11|12)\s+/i', '', $currentRombel->nama);

        $nextRombel = Rombel::where('kelas_id', $nextKelas->id)
            ->where(function ($query) use ($currentRombel, $baseName) {
                $query->where('nama', $currentRombel->nama)
                    ->orWhere('nama', 'like', "%{$baseName}%");
            })
            ->first();

        if (!$nextRombel) {
            $nextRombel = Rombel::where('kelas_id', $nextKelas->id)->first();
        }

        if (!$nextRombel) {
            return;
        }

        $siswa->rombel_id = $nextRombel->id;
        if (array_key_exists('kelas_id', $siswa->getAttributes())) {
            $siswa->kelas_id = $nextKelas->id;
        }
        $siswa->save();
    }

    /**
     * Handle siswa terminal status (pindah/do/meninggal)
     * Tidak mengeluarkan siswa dari rombel agar tetap terlihat di tampilan.
     */
    private function handleTerminalStatus()
    {
        // Untuk status selain lulus, biarkan siswa tetap ada dalam rombel.
        return;
    }

    /**
     * Handle lulus - create alumni record di kenaikan_kelas dan kosongkan rombel/kelas
     */
    private function handleLulus()
    {
        $siswa = $this->siswa;
        if (!$siswa) {
            return;
        }

        // Simpan rombel saat ini sebelum dikosongkan, untuk histori alumni
        $previousRombelId = $siswa->rombel_id;

        // Kosongkan relasi rombel/kelas agar siswa tidak lagi tampil di rombel
        $siswa->rombel_id = null;
        if (array_key_exists('kelas_id', $siswa->getAttributes())) {
            $siswa->kelas_id = null;
        }
        $siswa->save();

        // Gunakan tahun_ajaran dari field jika ada, jika tidak hitung dari tanggal mutasi
        $tahunAjaran = $this->tahun_ajaran ?? $this->getTahunAjaran();
        $semester = $this->getSemester();

        // Buat record di kenaikan_kelas untuk alumni
        KenaikanKelas::create([
            'siswa_id' => $siswa->id,
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran,
            'status' => 'Lulus',
            'catatan' => 'Lulus pada ' . \Carbon\Carbon::parse($this->tanggal_mutasi)->format('d-m-Y'),
            'rombel_tujuan_id' => $previousRombelId,
        ]);
    }

    /**
     * Ambil tingkat berikutnya dari nilai string tingkatan
     */
    private function getNextTingkat($tingkat)
    {
        $map = [
            'X' => 'XI',
            'XI' => 'XII',
            'XII' => null,
            '10' => '11',
            '11' => '12',
            '12' => null,
        ];

        $clean = strtoupper(trim($tingkat));
        return $map[$clean] ?? null;
    }

    /**
     * Helper: Dapatkan tahun ajaran dari tanggal mutasi
     */
    private function getTahunAjaran()
    {
        $bulan = $this->tanggal_mutasi->month;
        $tahun = $this->tanggal_mutasi->year;

        // Tahun ajaran Juli-Juni
        if ($bulan >= 7) {
            return "{$tahun}/" . ($tahun + 1);
        } else {
            return ($tahun - 1) . "/{$tahun}";
        }
    }

    /**
     * Helper: Dapatkan semester dari bulan
     */
    private function getSemester()
    {
        $bulan = $this->tanggal_mutasi->month;
        // Semester 1: Juli-Desember
        // Semester 2: Januari-Juni
        return ($bulan >= 7) ? 'Ganjil' : 'Genap';
    }
}
