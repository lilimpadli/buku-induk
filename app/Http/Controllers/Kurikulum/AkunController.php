<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class AkunController extends Controller
{
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('kurikulum.akun.show', compact('siswa'));
    }
}
