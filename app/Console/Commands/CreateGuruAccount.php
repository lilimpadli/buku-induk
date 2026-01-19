<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateGuruAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guru:create {--name=Siti Nurhaliza} {--nomor-induk=GU001} {--email=siti@school.com} {--password=password123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new guru (teacher) account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->option('name');
        $nomor_induk = $this->option('nomor-induk');
        $email = $this->option('email');
        $password = $this->option('password');

        // Check if user already exists
        if (User::where('nomor_induk', $nomor_induk)->exists()) {
            $this->error('❌ Nomor Induk sudah ada!');
            return 1;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('❌ Email sudah ada!');
            return 1;
        }

        try {
            // Create user
            $user = User::create([
                'name' => $name,
                'nomor_induk' => $nomor_induk,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'guru',
            ]);

            // Create guru profile dengan data yang valid
            Guru::create([
                'user_id' => $user->id,
                'nama' => $name,
                'nip' => $nomor_induk,
                'email' => $email,
                'telepon' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => null,
                'jenis_kelamin' => 'L', // Default: Laki-laki
                'alamat' => '',
            ]);

            $this->info('✓ Akun Guru Berhasil Dibuat!');
            $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("Nama Guru        : <fg=green>$name</>");
            $this->line("Nomor Induk      : <fg=green>$nomor_induk</>");
            $this->line("Email            : <fg=green>$email</>");
            $this->line("Password         : <fg=green>$password</>");
            $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info('✓ Silahkan login dengan Nomor Induk dan Password di atas.');

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
