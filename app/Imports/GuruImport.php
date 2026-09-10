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
    protected $defaultPassword = '12345678';
    
    protected $selectedColumns = [];
    protected $columnMap = [];
    protected $headerRow = [];

    public function setSelectedColumns(array $columns)
    {
        $this->selectedColumns = $columns;
    }

    public function setColumnMap(array $map)
    {
        $this->columnMap = $map;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Ambil baris pertama sebagai header nama kolom
            if ($index === 0) {
                foreach ($row as $colIdx => $colVal) {
                    if (!empty($colVal)) {
                        $cleanHeader = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $colVal)));
                        $this->headerRow[$cleanHeader] = $colIdx;
                    }
                }
                continue;
            }

            // Fungsi helper untuk mengambil data berdasarkan nama kolom di header secara fleksibel
            $getValue = function($possibleKeys, $fallbackIndex) use ($row) {
                foreach ((array)$possibleKeys as $key) {
                    $cleanKey = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $key)));
                    if (isset($this->headerRow[$cleanKey])) {
                        $idx = $this->headerRow[$cleanKey];
                        if (isset($row[$idx]) && trim($row[$idx]) !== '') {
                            return trim($row[$idx]);
                        }
                    }
                }
                // Fallback ke urutan angka jika header tidak ketemu
                return isset($row[$fallbackIndex]) ? trim($row[$fallbackIndex]) : null;
            };

            $nama = $getValue(['nama', 'namalengkap'], 0);
            if (empty($nama)) {
                continue;
            }

            $nik               = $getValue(['nik'], 1);
            $nuptk              = $getValue(['nuptk'], 2);
            $nip                = $getValue(['nip', 'nomorindukpegawai'], 3);
            $status_kepegawaian = $getValue(['statuskepegawaian', 'statuspegawai'], 4);
            $jenis_kelamin      = $getValue(['jeniskelamin', 'jk'], 5) ?: 'L';
            $pendidikan         = $getValue(['pendidikan'], 6);
            $serdik             = $getValue(['serdik'], 7);
            $tempat_lahir       = $getValue(['tempatlahir'], 8);
            
            // Tanggal Lahir
            $raw_tgl_lahir      = $getValue(['tanggallahir', 'tgllahir'], 9);
            $tanggal_lahir      = null;
            if (!empty($raw_tgl_lahir)) {
                try {
                    if (is_numeric($raw_tgl_lahir)) {
                        $tanggal_lahir = ExcelDate::excelToDateTimeObject($raw_tgl_lahir)->format('Y-m-d');
                    } else {
                        $clean_date = trim(str_replace('/', '-', $raw_tgl_lahir));
                        $tanggal_lahir = Carbon::parse($clean_date)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $tanggal_lahir = null;
                }
            }

            $email_pribadi      = $getValue(['emailpribadi', 'email'], 10);
            $email_resmi        = $getValue(['emailresmi'], 11);
            
            $alamat_jalan       = $getValue(['alamat', 'alamatjalan'], 12);
            $rt                 = $getValue(['rt'], 13);
            $rw                 = $getValue(['rw'], 14);
            $dusun              = $getValue(['dusun'], 15);
            $kelurahan          = $getValue(['kelurahan', 'desa', 'desakel'], 16);
            $kecamatan          = $getValue(['kecamatan', 'kec'], 17);
            $kode_pos           = $getValue(['kodepos', 'pos'], 18);
            $telepon            = $getValue(['nohp', 'telepon', 'hp'], 19);

            // Gabungkan alamat lengkap
            $array_alamat = [];
            if ($alamat_jalan) $array_alamat[] = $alamat_jalan;
            if ($rt && $rw) $array_alamat[] = "RT {$rt}/RW {$rw}";
            if ($dusun) $array_alamat[] = "Dusun {$dusun}";
            if ($kelurahan) $array_alamat[] = "Desa/Kel. {$kelurahan}";
            if ($kecamatan) $array_alamat[] = "Kec. {$kecamatan}";
            if ($kode_pos) $array_alamat[] = $kode_pos;
            
            $alamat_gabung = count($array_alamat) > 0 ? implode(', ', $array_alamat) : null;

            try {
                $nomor_induk = $nip ?: ($nik ?: $nama);

                $superAdmin = User::where('nomor_induk', $nomor_induk)->where('role', 'super_admin')->first();
                if ($superAdmin) {
                    $this->errors[] = "SKIP: Identitas {$nomor_induk} milik SUPER ADMIN.";
                    continue;
                }

                $email = $email_pribadi ?: (strtolower(str_replace(' ', '', $nama)) . time() . "@smkn1x.sch.id");

                $existingUser = User::where('nomor_induk', $nomor_induk)->first();
                if ($existingUser) {
                    if ($existingUser->role === 'super_admin') {
                        continue;
                    }
                    $user = $existingUser;
                    $user->update(['name' => $nama, 'email' => $email]);
                } else {
                    $user = User::create([
                        'name' => $nama,
                        'nomor_induk' => $nomor_induk,
                        'email' => $email,
                        'password' => Hash::make($this->defaultPassword),
                        'role' => 'guru',
                    ]);
                }

                Guru::updateOrCreate(
                    [
                        'nip' => $nip ?: $nomor_induk
                    ],
                    [
                        'nama'               => $nama,
                        'nik'                => $nik,
                        'nuptk'              => $nuptk,
                        'status_kepegawaian' => $status_kepegawaian,
                        'status_keaktifan'   => 'Aktif',
                        'jenis_kelamin'      => $jenis_kelamin,
                        'pendidikan'         => $pendidikan,
                        'serdik'             => $serdik,
                        'tempat_lahir'       => $tempat_lahir,
                        'tanggal_lahir'      => $tanggal_lahir,
                        'email'              => $email_pribadi ?: $email, // <-- INI YANG DITAMBAHKAN
                        'email_pribadi'      => $email_pribadi ?: $email,
                        'email_resmi'        => $email_resmi,
                        'alamat_jalan'       => $alamat_gabung,
                        'rt'                 => $rt,
                        'rw'                 => $rw,
                        'dusun'              => $dusun,
                        'desa'               => $kelurahan,
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

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}