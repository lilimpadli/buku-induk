<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class GuruImport implements ToCollection
{
    protected $errors = [];
    protected $successCount = 0;
    protected $defaultPassword = 'GuruBiskaone';

    /**
     * DAFTAR ALIAS HEADER
     * Kunci   = judul kolom Excel yang sudah dinormalisasi
     *           (huruf kecil, tanpa spasi/simbol)
     * Nilai   = key internal
     */
    protected $headerAliases = [
        'nama'               => 'nama',
        'nik'                => 'nik',
        'nuptk'              => 'nuptk',
        'nip'                => 'nip',
        'statuskepegawaian'  => 'status_kepegawaian',
        'status'             => 'status_kepegawaian',
        'jenisptk'           => 'status_kepegawaian',
        'jeniskelamin'       => 'jenis_kelamin',
        'jk'                 => 'jenis_kelamin',
        'gender'             => 'jenis_kelamin',
        'pendidikan'         => 'pendidikan',
        'pendidikanterakhir' => 'pendidikan',
        'serdik'             => 'serdik',
        'serdiksertifikasi'  => 'serdik',
        'sertifikasi'        => 'serdik',
        'tugastambahan'      => 'tugas_tambahan',
        'tugas'              => 'tugas_tambahan',
        'jabatan'            => 'tugas_tambahan',
        'tempatlahir'        => 'tempat_lahir',
        'tanggallahir'       => 'tanggal_lahir',
        'emailpribadi'       => 'email_pribadi',
        'emailresmi'         => 'email_resmi',
        'email'              => 'email_pribadi',
        'alamatjalan'        => 'alamat_jalan',
        'alamat'             => 'alamat_jalan',
        'rt'                 => 'rt',
        'rw'                 => 'rw',
        'dusun'              => 'dusun',
        'desakelurahan'      => 'desa',
        'desa'               => 'desa',
        'kelurahan'          => 'desa',
        'kecamatan'          => 'kecamatan',
        'kodepos'            => 'kode_pos',
        'nohp'               => 'telepon',
        'nohpwa'             => 'telepon',
        'nohpwhatsapp'       => 'telepon',
        'notelepon'          => 'telepon',
        'telepon'            => 'telepon',
        'hp'                 => 'telepon',
    ];

    /** Hasil mapping: key internal => index kolom di Excel */
    protected $map = [];

    /**
     * Fallback index — kalau header tidak terdeteksi.
     * Sesuai urutan kolom Excel yang biasa dipakai:
     * 0=Nama, 1=NIK, 2=NUPTK, 3=NIP, 4=Status, 5=JK,
     * 6=Serdik, 7=Tugas Tambahan, 8=Tempat Lahir, 9=Tanggal Lahir,
     * 10=Email Pribadi, 11=Email Resmi, 12=Alamat, 13=RT, 14=RW,
     * 15=Dusun, 16=Kelurahan, 17=Kecamatan, 18=Kode Pos, 19=No HP
     */
    protected $fallbackIndex = [
        'nama'               => 0,
        'nik'                => 1,
        'nuptk'              => 2,
        'nip'                => 3,
        'status_kepegawaian' => 4,
        'jenis_kelamin'      => 5,
        'serdik'             => 6,
        'tugas_tambahan'     => 7,
        'tempat_lahir'       => 8,
        'tanggal_lahir'      => 9,
        'email_pribadi'      => 10,
        'email_resmi'        => 11,
        'alamat_jalan'       => 12,
        'rt'                 => 13,
        'rw'                 => 14,
        'dusun'              => 15,
        'desa'               => 16,
        'kecamatan'          => 17,
        'kode_pos'           => 18,
        'telepon'            => 19,
    ];

    protected function normalizeHeader(?string $header): string
    {
        return preg_replace('/[^a-z0-9]/', '', strtolower(trim((string) $header)));
    }

    protected function buildMap(Collection $headerRow): void
    {
        $this->map = [];

        foreach ($headerRow as $index => $header) {
            $key = $this->normalizeHeader($header);

            if ($key === '' || !isset($this->headerAliases[$key])) {
                continue;
            }

            $field = $this->headerAliases[$key];

            // Ambil kemunculan pertama saja (antisipasi header dobel)
            if (!array_key_exists($field, $this->map)) {
                $this->map[$field] = $index;
            }
        }

        Log::info('GuruImport RAW HEADER: ' . json_encode($headerRow->toArray()));
        Log::info('GuruImport MAP: ' . json_encode($this->map));
    }

    /**
     * Ambil nilai cell berdasarkan NAMA KOLOM (bukan index).
     * Aman: kalau kolom tidak ada di Excel, fallback ke index default.
     */
    protected function cell(Collection $row, string $field): ?string
    {
        $idx = null;

        // 1. Coba ambil dari mapping header
        if (array_key_exists($field, $this->map)) {
            $idx = $this->map[$field];
        }
        // 2. Fallback ke index default
        elseif (array_key_exists($field, $this->fallbackIndex)) {
            $idx = $this->fallbackIndex[$field];
        }

        if ($idx === null) {
            return null;
        }

        $value = trim((string) ($row[$idx] ?? ''));

        return $value !== '' ? $value : null;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            $this->errors[] = 'File Excel kosong / tidak terbaca.';
            return;
        }

        // ── BARIS PERTAMA = HEADER ──
        $this->buildMap($rows->first());

        if (!array_key_exists('nama', $this->map) && !array_key_exists('nama', $this->fallbackIndex)) {
            $this->errors[] = 'Kolom "Nama" tidak ditemukan.';
            return;
        }

        foreach ($rows->skip(1) as $index => $row) {

            $nama = $this->cell($row, 'nama');
            if (empty($nama)) continue;

            $nik                = $this->cell($row, 'nik');
            $nuptk              = $this->cell($row, 'nuptk');
            $nip                = $this->cell($row, 'nip');
            $status_kepegawaian = $this->cell($row, 'status_kepegawaian');
            $pendidikan         = $this->cell($row, 'pendidikan');

            $jk            = strtoupper((string) $this->cell($row, 'jenis_kelamin'));
            $jenis_kelamin = in_array($jk, ['L', 'P']) ? $jk : 'L';

            // ✅ FIX: serdik & tugas_tambahan dibaca berdasarkan HEADER,
            //    kalau header tidak ada → fallback index.
            $serdik         = $this->cell($row, 'serdik');
            $tugas_tambahan = $this->cell($row, 'tugas_tambahan');
            $tempat_lahir   = $this->cell($row, 'tempat_lahir');

            // Debug log per baris
            Log::info("GuruImport ROW {$index}: nama='{$nama}' | serdik='{$serdik}' | tugas_tambahan='{$tugas_tambahan}'");

            // ── Tanggal lahir (dukung tanggal Excel & teks) ──
            $tanggal_lahir = null;
            $raw_tgl = $this->cell($row, 'tanggal_lahir');

            if (!empty($raw_tgl)) {
                try {
                    if (is_numeric($raw_tgl)) {
                        $tanggal_lahir = ExcelDate::excelToDateTimeObject($raw_tgl)->format('Y-m-d');
                    } else {
                        $clean         = trim(str_replace('/', '-', $raw_tgl));
                        $tanggal_lahir = Carbon::parse($clean)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $tanggal_lahir = null;
                }
            }

            $email_pribadi = $this->cell($row, 'email_pribadi');
            $email_resmi   = $this->cell($row, 'email_resmi');
            $alamat_jalan  = $this->cell($row, 'alamat_jalan');
            $rt            = $this->cell($row, 'rt');
            $rw            = $this->cell($row, 'rw');
            $dusun         = $this->cell($row, 'dusun');
            $desa          = $this->cell($row, 'desa');
            $kecamatan     = $this->cell($row, 'kecamatan');
            $kode_pos      = $this->cell($row, 'kode_pos');
            $telepon       = $this->cell($row, 'telepon');

            // ── Gabungkan alamat ──
            $array_alamat = [];
            if ($alamat_jalan) $array_alamat[] = $alamat_jalan;
            if ($rt && $rw)    $array_alamat[] = "RT {$rt}/RW {$rw}";
            if ($dusun)        $array_alamat[] = "Dusun {$dusun}";
            if ($desa)         $array_alamat[] = "Desa/Kel. {$desa}";
            if ($kecamatan)    $array_alamat[] = "Kec. {$kecamatan}";
            if ($kode_pos)     $array_alamat[] = $kode_pos;

            $alamat_gabung = count($array_alamat) > 0 ? implode(', ', $array_alamat) : null;

            try {
                $nomor_induk = $nip ?: ($nik ?: $nama);

                $superAdmin = User::where('nomor_induk', $nomor_induk)
                    ->where('role', 'super_admin')
                    ->first();

                if ($superAdmin) {
                    $this->errors[] = "SKIP: Identitas {$nomor_induk} milik SUPER ADMIN.";
                    continue;
                }

                $email = $email_pribadi
                    ?: (strtolower(str_replace(' ', '', $nama)) . time() . "@smkn1x.sch.id");

                $existingUser = User::where('nomor_induk', $nomor_induk)->first();

                if ($existingUser) {
                    if ($existingUser->role === 'super_admin') {
                        continue;
                    }
                    $user = $existingUser;
                    $user->update(['name' => $nama, 'email' => $email]);
                } else {
                    $user = User::create([
                        'name'        => $nama,
                        'nomor_induk' => $nomor_induk,
                        'email'       => $email,
                        'password'    => Hash::make($this->defaultPassword),
                        'role'        => 'guru',
                    ]);
                }

                Guru::updateOrCreate(
                    ['nip' => $nip ?: $nomor_induk],
                    [
                        'nama'               => $nama,
                        'nik'                => $nik,
                        'nuptk'              => $nuptk,
                        'status_kepegawaian' => $status_kepegawaian,
                        'status_keaktifan'   => 'Aktif',
                        'pendidikan'         => $pendidikan,
                        'jenis_kelamin'      => $jenis_kelamin,
                        'serdik'             => $serdik,
                        'tugas_tambahan'     => $tugas_tambahan,
                        'tempat_lahir'       => $tempat_lahir,
                        'tanggal_lahir'      => $tanggal_lahir,
                        'email'              => $email_pribadi ?: $email,
                        'email_pribadi'      => $email_pribadi ?: $email,
                        'email_resmi'        => $email_resmi,
                        'alamat'             => $alamat_gabung,
                        'alamat_jalan'       => $alamat_jalan,
                        'rt'                 => $rt,
                        'rw'                 => $rw,
                        'dusun'              => $dusun,
                        'desa'               => $desa,
                        'kecamatan'          => $kecamatan,
                        'kode_pos'           => $kode_pos,
                        'telepon'            => $telepon,
                        'user_id'            => $user->id,
                    ]
                );

                $this->successCount++;

            } catch (\Exception $e) {
                $this->errors[] = "Gagal pada guru {$nama}: " . $e->getMessage();
                Log::error('GuruImport Error: ' . $e->getMessage());
            }
        }
    }

    // ==========================================================
    // KOMPATIBILITAS DENGAN CONTROLLER
    // ==========================================================
    public function setSelectedColumns(array $columns)
    {
        // Kolom dideteksi otomatis dari baris header — tidak dipakai.
    }

    public function setColumnMap(array $map)
    {
        // Kolom dideteksi otomatis dari baris header — tidak dipakai.
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}