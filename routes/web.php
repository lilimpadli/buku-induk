<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\WaliKelas\InputNilaiRaportController;
use App\Http\Controllers\WaliKelas\NilaiRaportController; // Tambahkan ini

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::middleware('web')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    /*
    |--------------------------------------------------------------------------
    | AUTENTIKASI
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.process');
    });

    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ROUTE UNTUK PENGGUNA LOGIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            $role = auth()->user()->role;

            return match ($role) {
                'siswa'       => redirect()->route('siswa.dashboard'),
                'walikelas'   => redirect()->route('walikelas.dashboard'),
                'kaprog'      => redirect()->route('kaprog.dashboard'),
                'tu'          => redirect()->route('tu.dashboard'),
                'kurikulum'   => redirect()->route('kurikulum.dashboard'),
                'calon_siswa' => redirect()->route('calon.dashboard'),
                default       => abort(403, 'Role tidak dikenali'),
            };
        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | ROUTE SISWA
        |--------------------------------------------------------------------------
        */
        Route::prefix('siswa')->name('siswa.')->group(function () {

            Route::get('/dashboard', fn() => view('siswa.dashboard'))->name('dashboard');

            Route::get('/data-diri', [SiswaController::class, 'dataDiri'])->name('dataDiri');
            Route::get('/data-diri/create', [SiswaController::class, 'create'])->name('dataDiri.create');
            Route::post('/data-diri', [SiswaController::class, 'store'])->name('dataDiri.store');
            Route::get('/data-diri/edit', [SiswaController::class, 'edit'])->name('dataDiri.edit');
            Route::put('/data-diri', [SiswaController::class, 'update'])->name('dataDiri.update');

            Route::get('/raport', [SiswaController::class, 'raport'])->name('raport');
            Route::get('/catatan', [SiswaController::class, 'catatan'])->name('catatan');

            Route::get('/export/pdf', [SiswaController::class, 'exportPDF'])->name('export.pdf');
        });


        /*
        |--------------------------------------------------------------------------
        | ROUTE WALI KELAS
        |--------------------------------------------------------------------------
        */
        Route::prefix('walikelas')->name('walikelas.')->group(function () {
            Route::get('/dashboard', fn() => view('walikelas.dashboard'))->name('dashboard');

            Route::get('/siswa', [WaliKelasSiswaController::class, 'index'])
                ->name('siswa.index');

            Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
                ->name('siswa.show');
                
            // Route untuk Input Nilai Raport
            Route::get('/input-nilai-raport', [InputNilaiRaportController::class, 'index'])->name('input_nilai_raport.index');
            Route::get('/input-nilai-raport/create/{siswa_id}', [InputNilaiRaportController::class, 'create'])->name('input_nilai_raport.create');
            Route::post('/input-nilai-raport/store/{siswa_id}', [InputNilaiRaportController::class, 'store'])->name('input_nilai_raport.store');
            
            // Route untuk melihat Nilai Raport
            Route::get('/nilai-raport', [NilaiRaportController::class, 'index'])->name('nilai_raport.index');
            Route::get('/nilai-raport/{siswa_id}', [NilaiRaportController::class, 'show'])->name('nilai_raport.show');
        });

        /*
        |--------------------------------------------------------------------------
        | ROUTE KAPROG
        |--------------------------------------------------------------------------
        */
       Route::prefix('kaprog')->name('kaprog.')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('kaprog.dashboard'))->name('dashboard');

    // Raport siswa
    Route::get('/raport-siswa', fn() => view('kaprog.raport'))->name('raport.siswa');

});


        /*
        |--------------------------------------------------------------------------
        | ROUTE TU
        |--------------------------------------------------------------------------
        */
        Route::prefix('tu')->name('tu.')->group(function () {
            Route::get('/dashboard', fn() => view('tu.dashboard'))->name('dashboard');
        });

        /*
        |--------------------------------------------------------------------------
        | ROUTE KURIKULUM
        |--------------------------------------------------------------------------
        */
        Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
            Route::get('/dashboard', fn() => view('kurikulum.dashboard'))->name('dashboard');
        });
    });
});