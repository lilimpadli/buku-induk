<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class GuruImport implements ToModel, WithStartRow, SkipsEmptyRows, WithHeadingRow
{
    protected $errors = [];
    protected $successCount = 0;
    protected $defaultPassword = '12345678';

    public function startRow(): int
    {
        return 6; // Data mulai dari baris 6 (setelah header di baris 5)
    }

    public function headingRow(): int
    {
        return 5; // Header ada di baris 5
    }

    public function model(array $row)
    {
        // Debug: log raw row
        Log::info('GuruImport Row', ['row' => $row]);

        // Skip if nama is empty
        if (empty($row['nama'] ?? null)) {
            $this->errors[] = "Baris skip: Kolom 'nama' kosong";
            return null;
        }

        try {
            // Extract data from row with proper key access
            $nama = trim($row['nama'] ?? '');
            $nomor_induk = trim($row['nomor_induk'] ?? '');
            $jenis_kelamin = trim($row['jenis_kelamin'] ?? 'L');
            $role = trim($row['role'] ?? 'walikelas');
            $rombel_id = !empty($row['rombel_id']) ? (int)$row['rombel_id'] : null;
            $jurusan_id = !empty($row['jurusan_id']) ? (int)$row['jurusan_id'] : null;
            
            // Generate email dari nama jika tidak ada
            if (!empty($row['email'])) {
                $email = trim($row['email']);
            } else {
                $email = strtolower(str_replace(' ', '', $nama)) . "@smkn1kawali.sch.id";
            }

            // Validate required fields
            if (empty($nama)) {
                $this->errors[] = "Nama guru tidak boleh kosong";
                return null;
            }

            // Handle case where nomor_induk is same as nama
            if (empty($nomor_induk) || $nomor_induk === $nama) {
                $nomor_induk = $nama; // Use nama as nomor_induk if it's empty or same as nama
            }

            // Check if user already exists
            $existingUser = User::where('nomor_induk', $nomor_induk)->first();
            if ($existingUser) {
                // Update existing user
                $user = $existingUser;
                $user->update([
                    'name' => $nama,
                    'email' => $email ?? $user->email,
                    'role' => $role,  // Update role jika ada
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $nama,
                    'nomor_induk' => $nomor_induk,
                    'email' => $email ?? strtolower(str_replace(' ', '', $nama)) . "@smkn1kawali.sch.id",
                    'password' => Hash::make($this->defaultPassword),
                    'role' => $role,
                ]);
            }

            // Check if guru already exists
            $guru = Guru::where('nip', $nomor_induk)->first();
            
            // Handle duplicate email - tambahkan timestamp jika sudah ada
            $emailExists = Guru::where('email', $email)->first();
            if ($emailExists && (!$guru || $guru->email !== $email)) {
                // Email sudah digunakan, generate unique email
                $email = strtolower(str_replace(' ', '', $nama)) . "." . time() . "@smkn1kawali.sch.id";
            }
            
            if (!$guru) {
                $guru = new Guru();
                $guru->nip = $nomor_induk;
            }

            $guru->nama = $nama;
            $guru->email = $email;  // HARUS DIISI karena unique dan NOT NULL
            $guru->jenis_kelamin = $jenis_kelamin;
            $guru->user_id = $user->id;
            $guru->jurusan_id = $jurusan_id;
            $guru->save();

            // Add to rombel atau jurusan berdasarkan role
            if ($role === 'walikelas' || $role === 'guru') {
                // Wali kelas gunakan rombel_id
                if ($rombel_id) {
                    $rombel = Rombel::find($rombel_id);
                    if ($rombel) {
                        $guru->rombels()->syncWithoutDetaching([$rombel_id]);
                    } else {
                        $this->errors[] = "Warning: Rombel dengan ID {$rombel_id} tidak ditemukan untuk guru {$nama}";
                    }
                }
            } elseif ($role === 'kaprog') {
                // Kaprog gunakan jurusan_id
                if ($jurusan_id) {
                    $guru->jurusan_id = $jurusan_id;
                    $guru->save();
                }
            }

            $this->successCount++;
            Log::info('GuruImport Success', ['guru' => $guru->nama, 'nip' => $guru->nip]);
            return $guru;

        } catch (\Exception $e) {
            $guruName = $row['nama'] ?? 'Unknown';
            Log::error('GuruImport Error', [
                'row' => $row,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errors[] = "Error guru {$guruName}: " . $e->getMessage();
            return null;
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