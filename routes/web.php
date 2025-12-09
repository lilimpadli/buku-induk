<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\LoginController;

// SISWA
use App\Http\Controllers\SiswaController;

// WALI KELAS
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\WaliKelas\InputNilaiRaportController;
use App\Http\Controllers\WaliKelas\NilaiRaportController;
use App\Http\Controllers\RaporController;

// KURIKULUM
use App\Http\Controllers\Kurikulum\KurikulumDashboardController;
use App\Http\Controllers\Kurikulum\KurikulumSiswaController;
use App\Models\Kelas;

// TU
use App\Http\Controllers\TUController;

/*
|--------------------------------------------------------------------------
| ROUTE RAPOR GLOBAL
|--------------------------------------------------------------------------
*/
Route::prefix('rapor')->group(function () {

    Route::get('/input/{siswa_id}', [RaporController::class, 'formNilai'])
        ->name('rapor.form');

    Route::post('/input/{siswa_id}', [RaporController::class, 'simpanNilai'])
        ->name('rapor.simpan.nilai');

    Route::post('/ekstra/{siswa_id}', [RaporController::class, 'simpanEkstra'])
        ->name('rapor.simpan.ekstra');

    Route::post('/kehadiran/{siswa_id}', [RaporController::class, 'simpanKehadiran'])
        ->name('rapor.simpan.kehadiran');

    Route::post('/info/{siswa_id}', [RaporController::class, 'simpanInfoRapor'])
        ->name('rapor.simpan.info');

    Route::get('/cetak/{siswa_id}/{semester}/{tahun}', [RaporController::class, 'cetakRapor'])
        ->name('rapor.cetak');
});


/*
|--------------------------------------------------------------------------
| WEB MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::middleware('web')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');


    /*
    |--------------------------------------------------------------------------
    | AUTH (LOGIN)
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
    | ROUTE UNTUK USER LOGIN (AUTH)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | REDIRECT DASHBOARD BERDASARKAN ROLE
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
        | ROUTE WALIKELAS
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
        | DATA SISWA DIPEGANG WALI KELAS
        */
                Route::get('/siswa', [WaliKelasSiswaController::class, 'index'])
                    ->name('siswa.index');

                Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
                    ->name('siswa.show');


                /*
        | CETAK RAPOR
        */
                Route::get(
                    '/rapor/{siswa_id}/{semester}/{tahun}',
                    [RaporController::class, 'cetakRapor']
                )->name('rapor.cetak');


                /*
        | INPUT NILAI RAPORT
        */
                Route::get(
                    '/input-nilai-raport',
                    [InputNilaiRaportController::class, 'index']
                )->name('input_nilai_raport.index');

                Route::get(
                    '/input-nilai-raport/create/{siswa_id}',
                    [InputNilaiRaportController::class, 'create']
                )->name('input_nilai_raport.create');

                Route::post(
                    '/input-nilai-raport/store/{siswa_id}',
                    [InputNilaiRaportController::class, 'store']
                )->name('input_nilai_raport.store');


                /*
        | NILAI RAPORT
        */
                Route::get(
                    '/nilai-raport',
                    [NilaiRaportController::class, 'index']
                )->name('nilai_raport.index');

                Route::get(
                    '/nilai-raport/{siswa_id}',
                    [NilaiRaportController::class, 'show']
                )->name('nilai_raport.show');

                Route::get(
                    '/nilai-raport/list/{id}',
                    [NilaiRaportController::class, 'list']
                )->name('nilai_raport.list');

                Route::get(
                    '/nilai-raport/{id}/review',
                    [NilaiRaportController::class, 'review']
                )->name('nilai_raport.review');


                /*
        | FORM EKSTRA / KEHADIRAN / INFO
        */
                Route::get(
                    '/rapor/ekstra/{siswa_id}',
                    [RaporController::class, 'formEkstra']
                )->name('rapor.ekstra.form');

                Route::post(
                    '/rapor/ekstra/{siswa_id}',
                    [RaporController::class, 'simpanEkstra']
                )->name('rapor.ekstra.simpan');

                Route::get(
                    '/rapor/kehadiran/{siswa_id}',
                    [RaporController::class, 'formKehadiran']
                )->name('rapor.kehadiran.form');

                Route::post(
                    '/rapor/kehadiran/{siswa_id}',
                    [RaporController::class, 'simpanKehadiran']
                )->name('rapor.kehadiran.simpan');

                Route::get(
                    '/rapor/info/{siswa_id}',
                    [RaporController::class, 'formInfo']
                )->name('rapor.info.form');

                Route::post(
                    '/rapor/info/{siswa_id}',
                    [RaporController::class, 'simpanInfo']
                )->name('rapor.info.simpan');

                // =============================
                // EDIT RAPOR PER SISWA
                // =============================
                Route::get(
                    'input-nilai-raport/{siswa_id}/edit',
                    [InputNilaiRaportController::class, 'edit']
                )->name('input_nilai_raport.edit');

                Route::post(
                    'input-nilai-raport/{siswa_id}/update',
                    [InputNilaiRaportController::class, 'update']
                )->name('input_nilai_raport.update');
            });



        /*
        |--------------------------------------------------------------------------
        | ROUTE KAPROG
        |--------------------------------------------------------------------------
        */
        Route::prefix('kaprog')->name('kaprog.')->group(function () {
            Route::get('/dashboard', fn() => view('kaprog.dashboard'))->name('dashboard');
            Route::get('/raport-siswa', fn() => view('kaprog.raport'))->name('raport.siswa');
        });



        /*
        |--------------------------------------------------------------------------
        | ROUTE TU
        |--------------------------------------------------------------------------
        */
        Route::prefix('tu')->name('tu.')->group(function () {

            Route::get('/dashboard', [TUController::class, 'dashboard'])->name('dashboard');

            Route::get('/siswa', [TUController::class, 'siswa'])->name('siswa');
            Route::get('/siswa/create', [TUController::class, 'siswaCreate'])->name('siswa.create');
            Route::post('/siswa', [TUController::class, 'siswaStore'])->name('siswa.store');
            Route::get('/siswa/{id}', [TUController::class, 'siswaDetail'])->name('siswa.detail');
            Route::get('/siswa/{id}/edit', [TUController::class, 'siswaEdit'])->name('siswa.edit');
            Route::put('/siswa/{id}', [TUController::class, 'siswaUpdate'])->name('siswa.update');
            Route::delete('/siswa/{id}', [TUController::class, 'siswaDestroy'])->name('siswa.destroy');

            Route::get('/wali-kelas', [TUController::class, 'waliKelas'])->name('wali-kelas');
            Route::get('/wali-kelas/{id}', [TUController::class, 'waliKelasDetail'])->name('wali-kelas.detail');

            Route::get('/laporan-nilai', [TUController::class, 'laporanNilai'])->name('laporan.nilai');
        });



        /*
        |--------------------------------------------------------------------------
        | ROUTE KURIKULUM
        |--------------------------------------------------------------------------
        */
       Route::prefix('kurikulum')->name('kurikulum.')->group(function () {

    Route::get('/dashboard', [KurikulumDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/siswa', [KurikulumSiswaController::class, 'index'])
        ->name('siswa.index');
        
        Route::get('/kurikulum/manajemen-kelas', [KelasController::class, 'index'])
    ->name('kurikulum.kelas.index');

    Route::view('/kurikulum/siswa/show', 'kurikulum.show')->name('kurikulum.siswa.show');



        
    // Halaman utama manajemen kelas
    Route::get('/manajemen-kelas', function () {
        return view('kurikulum.manajemen-kelas.index');
    })->name('kelas.index');

    // ============================
    //  MANAGEMEN KELAS — EDIT
    // ============================

    Route::get('/manajemen-kelas/{id}/edit', function ($id) {
        return view('kurikulum.manajemen-kelas.edit', [
            'kelas' => (object)[
                'id' => $id,
                'kelas' => '',
                'jurusan' => '',
                'rombel' => '',
                'wali_kelas' => ''
            ]
        ]);
    })->name('kelas.edit');

    Route::put('/manajemen-kelas/{id}', function ($id) {
        // sementara dummy (belum ada database)
        return redirect()->route('kurikulum.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    })->name('kelas.update');

});

    }); // END AUTH
});
