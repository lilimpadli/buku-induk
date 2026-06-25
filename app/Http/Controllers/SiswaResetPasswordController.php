<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaResetPasswordController extends Controller
{
    public function showResetForm()
    {
        // Untuk sementara, kita buat tampilkan pesan saja agar tidak error
        return "Halaman Reset Password Siswa akan segera hadir.";
    }

    public function reset(Request $request)
    {
        // Logika reset password nanti bisa diisi di sini
        return "Proses reset password sedang diproses.";
    }
}