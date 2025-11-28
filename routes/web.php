<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Form Login
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

// Proses Login
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login.process');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD UTAMA (AUTO REDIRECT BERDASARKAN ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'siswa'      => redirect()->route('dashboard.siswa'),
            'walikelas'  => redirect()->route('dashboard.walikelas'),
            'kaprog'     => redirect()->route('dashboard.kaprog'),
            'tu'         => redirect()->route('dashboard.tu'),
            'kurikulum'  => redirect()->route('dashboard.kurikulum'),
            'calon'      => redirect()->route('dashboard.calon'),
            default      => abort(403, 'Role tidak dikenali'),
        };
    })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD PER ROLE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard/siswa', function () {
        return view('siswa.dashboard');
    })->name('dashboard.siswa');

    Route::get('/dashboard/walikelas', function () {
        return view('walikelas.dashboard');
    })->name('dashboard.walikelas');

    Route::get('/dashboard/kaprog', function () {
        return view('kaprog.dashboard');
    })->name('dashboard.kaprog');

    Route::get('/dashboard/tu', function () {
        return view('tu.dashboard');
    })->name('dashboard.tu');

    Route::get('/dashboard/kurikulum', function () {
        return view('kurikulum.dashboard');
    })->name('dashboard.kurikulum');

    Route::get('/dashboard/calon-siswa', function () {
        return view('calonSiswa.dashboard'); // diperbaiki dari yang sebelumnya salah
    })->name('dashboard.calon');

});
