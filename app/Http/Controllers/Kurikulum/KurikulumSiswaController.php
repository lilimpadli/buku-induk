<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;

class KurikulumSiswaController extends Controller
{
    public function index()
    {
        $siswa = DataSiswa::with(['user', 'ayah', 'ibu', 'wali', 'rombel'])
            ->latest()
            ->paginate(15);

        return view('kurikulum.siswa.index', compact('siswa'));
    }
}
