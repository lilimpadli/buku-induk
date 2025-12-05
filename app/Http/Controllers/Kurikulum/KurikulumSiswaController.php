<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;

class KurikulumSiswaController extends Controller
{
    public function index()
    {
        return view('kurikulum.siswa.index');
    }
}
