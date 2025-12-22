<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalonSiswaController extends Controller
{
    public function dashboard()
    {
        return view('calonSiswa.dashboard');
    }
}