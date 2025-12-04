<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\LoginController;

// SISWA
use App\Http\Controllers\SiswaController;

// WALI KELAS
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\RaporController;

Route::prefix('rapor')->group(function () {

    // 1. Form input nilai
    Route::get('/input/{siswa_id}', [RaporController::class, 'formNilai'])
        ->name('rapor.form');

    // 1B. Simpan nilai
    Route::post('/input/{siswa_id}', [RaporController::class, 'simpanNilai'])
        ->name('rapor.simpan.nilai');

    // 2. Simpan Ekstrakurikuler
    Route::post('/ekstra/{siswa_id}', [RaporController::class, 'simpanEkstra'])
        ->name('rapor.simpan.ekstra');

    // 3. Simpan Kehadiran
    Route::post('/kehadiran/{siswa_id}', [RaporController::class, 'simpanKehadiran'])
        ->name('rapor.simpan.kehadiran');

    // 4. Simpan Info Rapor
    Route::post('/info/{siswa_id}', [RaporController::class, 'simpanInfoRapor'])
        ->name('rapor.simpan.info');

    // 5. Cetak rapor
    Route::get('/cetak/{siswa_id}/{semester}/{tahun}', [RaporController::class, 'cetakRapor'])
        ->name('rapor.cetak');
});


// TAMBAHAN
use App\Http\Controllers\WaliKelas\InputNilaiRaportController;
use App\Http\Controllers\WaliKelas\NilaiRaportController;


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

        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login.process');
    });

    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | ROUTE UNTUK USER YANG SUDAH LOGIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', function () {

            $role = auth()->user()->role;

            return match ($role) {
                'siswa'       => redirect()->route('siswa.dashboard'),
                'walikelas'   => redirect()->route('walikelas.dashboard'),
                'kaprog'      => redirect()->route('kaprog.dashboard'),
                'tu'          => redirect()->route('tu.dashboard'),
                'kurikulum'   => redirect()->route('kurikulum.dashboard'),
                'calon_siswa' => redirect()->route('calon.dashboard'),

                default => abort(403, 'Role tidak dikenali'),
            };

        })->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | ROUTE SISWA
        |--------------------------------------------------------------------------
        */
        Route::prefix('siswa')->name('siswa.')->group(function () {

            Route::get('/dashboard', fn() => view('siswa.dashboard'))
                ->name('dashboard');

            Route::get('/data-diri', [SiswaController::class, 'dataDiri'])
                ->name('dataDiri');

            Route::get('/data-diri/create', [SiswaController::class, 'create'])
                ->name('dataDiri.create');

            Route::post('/data-diri', [SiswaController::class, 'store'])
                ->name('dataDiri.store');

            Route::get('/data-diri/edit', [SiswaController::class, 'edit'])
                ->name('dataDiri.edit');

            Route::put('/data-diri', [SiswaController::class, 'update'])
                ->name('dataDiri.update');

            Route::get('/raport', [SiswaController::class, 'raport'])
                ->name('raport');

            Route::get('/catatan', [SiswaController::class, 'catatan'])
                ->name('catatan');

            Route::get('/export/pdf', [SiswaController::class, 'exportPDF'])
                ->name('export.pdf');
        });




        /*
        |--------------------------------------------------------------------------
        | ROUTE WALI KELAS (SUDAH DIBERSIHKAN)
        |--------------------------------------------------------------------------
        */
       Route::prefix('walikelas')
    ->name('walikelas.')
    ->middleware('role:walikelas')
    ->group(function () {

        /*
        | Dashboard Wali Kelas
        */
        Route::get('/dashboard', fn() => view('walikelas.dashboard'))
            ->name('dashboard');


        /*
        |----------------------------------------------------------------------
        | DATA SISWA DIPEGANG WALI KELAS
        |----------------------------------------------------------------------
        */
        Route::get('/siswa', [WaliKelasSiswaController::class, 'index'])
            ->name('siswa.index');

        Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
            ->name('siswa.show');


        /*
        |----------------------------------------------------------------------
        | INPUT NILAI RAPOR
        |----------------------------------------------------------------------
        */
        Route::get('/rapor/{siswa_id}/nilai', [RaporController::class, 'formNilai'])
            ->name('rapor.nilai.form');

        Route::post('/rapor/{siswa_id}/nilai', [RaporController::class, 'simpanNilai'])
            ->name('rapor.nilai.simpan');


        /*
        |----------------------------------------------------------------------
        | EKSTRAKURIKULER
        |----------------------------------------------------------------------
        */
        Route::post('/rapor/{siswa_id}/ekstra', [RaporController::class, 'simpanEkstra'])
            ->name('rapor.ekstra.simpan');


        /*
        |----------------------------------------------------------------------
        | KEHADIRAN
        |----------------------------------------------------------------------
        */
        Route::post('/rapor/{siswa_id}/kehadiran', [RaporController::class, 'simpanKehadiran'])
            ->name('rapor.kehadiran.simpan');


        /*
        |----------------------------------------------------------------------
        | INFO RAPOR
        |----------------------------------------------------------------------
        */
        Route::post('/rapor/{siswa_id}/info', [RaporController::class, 'simpanInfoRapor'])
            ->name('rapor.info.simpan');


        /*
        |----------------------------------------------------------------------
        | CETAK RAPOR
        |----------------------------------------------------------------------
        */
        Route::get('/rapor/{siswa_id}/{semester}/{tahun}', [RaporController::class, 'cetakRapor'])
            ->name('rapor.cetak');
    });





        /*
        |--------------------------------------------------------------------------
        | ROUTE KAPROG
        |--------------------------------------------------------------------------
        */
        Route::prefix('kaprog')->name('kaprog.')->group(function () {

            Route::get('/dashboard', fn() => view('kaprog.dashboard'))
                ->name('dashboard');

            Route::get('/raport-siswa', fn() => view('kaprog.raport'))
                ->name('raport.siswa');
        });



        /*
        |--------------------------------------------------------------------------
        | ROUTE TU
        |--------------------------------------------------------------------------
        */
        Route::prefix('tu')->name('tu.')->group(function () {

            Route::get('/dashboard', fn() => view('tu.dashboard'))
                ->name('dashboard');
        });



        /*
        |--------------------------------------------------------------------------
        | ROUTE KURIKULUM
        |--------------------------------------------------------------------------
        */
        Route::prefix('kurikulum')->name('kurikulum.')->group(function () {

            Route::get('/dashboard', fn() => view('kurikulum.dashboard'))
                ->name('dashboard');
        });

    }); // END auth group
});
