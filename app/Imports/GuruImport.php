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
        return 2; // Data mulai dari baris 2 (setelah header di baris 1)
    }

    public function headingRow(): int
    {
        return 1; // Header ada di baris 1
    }

    /**
     * Normalize row keys to standard lowercase format
     * Handles various column name formats (camelCase, spaces, etc.)
     */
    protected function normalizeRowKeys(array $row): array
    {
        $normalized = [];
        $keyMap = [
            'nama' => ['nama', 'Nama', 'NAMA', 'name'],
            'nomor_induk' => ['nomor_induk', 'nomor induk', 'nip', 'NIP', 'nip_guru', 'niP', 'Nomor Induk', 'nomor_induk'],
            'jenis_kelamin' => ['jenis_kelamin', 'jenis kelamin', 'jenis_kelamin', 'Jenis Kelamin', 'gender'],
            'email' => ['email', 'Email', 'EMAIL', 'e_mail'],
            'role' => ['role', 'Role', 'ROLE', 'jabatan'],
            'rombel_id' => ['rombel_id', 'rombel_Id', 'rombel', 'rombel id', 'rombelid'],
            'jurusan_id' => ['jurusan_id', 'jurusan_Id', 'jurusan', 'jurusan id', 'jurusanid'],
        ];

        // Map each key to its standard form
        foreach ($row as $key => $value) {
            // Normalize key: lowercase and replace spaces with underscores
            $normalizedKey = strtolower(str_replace(' ', '_', trim($key)));
            
            // Find which standard key this maps to
            $standardKey = $normalizedKey;
            foreach ($keyMap as $standard => $variants) {
                if (in_array($normalizedKey, array_map('strtolower', $variants))) {
                    $standardKey = $standard;
                    break;
                }
            }
            
            $normalized[$standardKey] = $value;
        }

        return $normalized;
    }

    /**
     * Normalize role values to match enum values
     * Handles typos and variations like 'kurrikulum' -> 'kurikulum'
     */
    protected function normalizeRole(string $role): string
    {
        $role = strtolower(trim($role));
        
        // Map common typos and variations
        $roleMap = [
            'guru' => 'guru',
            'walikelas' => 'walikelas',
            'wali_kelas' => 'walikelas',
            'wali kelas' => 'walikelas',
            'kaprog' => 'kaprog',
            'kepala program' => 'kaprog',
            'kaprogdam' => 'kaprog',
            'tu' => 'tu',
            'tatausa' => 'tu',
            'tata_usaha' => 'tu',
            'tata usaha' => 'tu',
            'kurikulum' => 'kurikulum',
            'kurrikulum' => 'kurikulum',  // Common typo
            'kurukulum' => 'kurikulum',   // Another typo
            'calon_siswa' => 'calon_siswa',
            'calon siswa' => 'calon_siswa',
            'kepala_sekolah' => 'guru',  // Map to guru as fallback
            'kepala sekolah' => 'guru',
            'siswa' => 'siswa',
        ];
        
        // Try direct match first
        if (isset($roleMap[$role])) {
            return $roleMap[$role];
        }
        
        // Try fuzzy matching with common patterns
        foreach ($roleMap as $key => $value) {
            if (strpos($role, str_replace('_', '', $key)) !== false || 
                strpos(str_replace(' ', '', $key), str_replace(' ', '', $role)) !== false) {
                return $value;
            }
        }
        
        // Default to guru if no match
        return 'guru';
    }

    public function model(array $row)
    {
        // Debug: log raw row and keys
        Log::info('GuruImport Row Keys', ['keys' => array_keys($row)]);
        Log::info('GuruImport Row Data', ['row' => $row]);

        // Normalize row keys to lowercase and handle various formats
        $normalizedRow = $this->normalizeRowKeys($row);
        
        // Get nama - required field
        $nama = trim($normalizedRow['nama'] ?? '');
        if (empty($nama)) {
            $this->errors[] = "Baris skip: Kolom 'nama' kosong. Kunci tersedia: " . implode(', ', array_keys($normalizedRow));
            return null;
        }

        try {
            // Extract data from normalized row
            $nomor_induk = trim($normalizedRow['nomor_induk'] ?? $normalizedRow['nip'] ?? '');
            $jenis_kelamin = trim($normalizedRow['jenis_kelamin'] ?? 'L');
            $role = trim($normalizedRow['role'] ?? 'guru');
            $rombel_id = !empty($normalizedRow['rombel_id']) ? (int)$normalizedRow['rombel_id'] : null;
            $jurusan_id = !empty($normalizedRow['jurusan_id']) ? (int)$normalizedRow['jurusan_id'] : null;

            // Validate and normalize role - map to valid enum values
            $validRoles = ['siswa', 'guru', 'walikelas', 'kaprog', 'tu', 'kurikulum', 'calon_siswa'];
            $normalizedRole = $this->normalizeRole($role);
            
            if (!in_array($normalizedRole, $validRoles)) {
                // Default to 'guru' if role is invalid
                $this->errors[] = "Warning: Role '$role' tidak valid untuk guru {$nama}, menggunakan default 'guru'";
                $normalizedRole = 'guru';
            }
            
            $role = $normalizedRole;

            // Handle case where nomor_induk is empty - use nama as fallback
            if (empty($nomor_induk)) {
                $nomor_induk = $nama;
            }

            // Generate email dari nama jika tidak ada
            if (!empty($normalizedRow['email'] ?? '')) {
                $email = trim($normalizedRow['email']);
            } else {
                $email = strtolower(str_replace(' ', '', $nama)) . time() . "@smkn1x.sch.id";
            }

            // Handle duplicate email - tambahkan timestamp jika sudah ada
            $emailExists = User::where('email', $email)->first();
            if ($emailExists && (!empty($normalizedRow['email'] ?? '') === false)) {
                // Email sudah digunakan dan bukan dari user input, generate unique email
                $email = strtolower(str_replace(' ', '', $nama)) . "." . time() . "@smkn1x.sch.id";
            }

            // Check if user already exists
            $existingUser = User::where('nomor_induk', $nomor_induk)->first();
            if ($existingUser) {
                // Update existing user
                $user = $existingUser;
                $user->update([
                    'name' => $nama,
                    'email' => $email,
                    'role' => $role,
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $nama,
                    'nomor_induk' => $nomor_induk,
                    'email' => $email,
                    'password' => Hash::make($this->defaultPassword),
                    'role' => $role,
                ]);
            }

            // Check if guru already exists
            $guru = Guru::where('nip', $nomor_induk)->first();
            
            if (!$guru) {
                $guru = new Guru();
                $guru->nip = $nomor_induk;
            }

            $guru->nama = $nama;
            $guru->email = $email;  // HARUS DIISI karena unique dan NOT NULL
            $guru->jenis_kelamin = $jenis_kelamin;
            $guru->user_id = $user->id;

            // Normalize role values for assignment logic
            $roleNorm = strtolower(str_replace([' ', '_'], '', $role));
            
            // Set jurusan_id dan rombel_id berdasarkan role
            if (in_array($roleNorm, ['walikelas', 'wali'])) {
                // Wali kelas: isi rombel_id, kosongkan jurusan_id
                $guru->rombel_id = $rombel_id;
                $guru->jurusan_id = null;
            } elseif (in_array($roleNorm, ['kaprog', 'program'])) {
                // Kaprog: isi jurusan_id, kosongkan rombel_id
                $guru->jurusan_id = $jurusan_id;
                $guru->rombel_id = null;
            } else {
                // Guru biasa: kosongkan keduanya
                $guru->rombel_id = null;
                $guru->jurusan_id = null;
            }
            
            // Save guru first (harus di-save sebelum digunakan untuk foreign key)
            $guru->save();
            
            // Setelah guru di-save, update rombel jika walikelas
            if (in_array($roleNorm, ['walikelas', 'wali'])) {
                if ($rombel_id) {
                    $rombel = Rombel::find($rombel_id);
                    if ($rombel) {
                        // Update rombel dengan guru_id (HARUS guru->id, bukan user->id)
                        $rombel->guru_id = $guru->id;
                        $rombel->save();
                    } else {
                        $this->errors[] = "Warning: Rombel dengan ID {$rombel_id} tidak ditemukan untuk guru {$nama}";
                    }
                } else {
                    $this->errors[] = "Warning: Walikelas {$nama} tidak memiliki rombel_id";
                }
            } elseif (in_array($roleNorm, ['kaprog', 'program'])) {
                if (!$jurusan_id) {
                    $this->errors[] = "Warning: Kaprog {$nama} tidak memiliki jurusan_id";
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