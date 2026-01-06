<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// AUTH
use App\Http\Controllers\Auth\LoginController;

// SISWA
use App\Http\Controllers\SiswaController;

// WALI KELAS
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\WaliKelas\InputNilaiRaportController;
use App\Http\Controllers\WaliKelas\NilaiRaportController;
use App\Http\Controllers\RaporController;

// tu
use App\Http\Controllers\TU\TambahKelasController;
use App\Http\Controllers\TU\KelastuController;
use App\Http\Controllers\TU\WaliKelasController;

// KURIKULUM
use App\Http\Controllers\Kurikulum\KurikulumDashboardController;
use App\Http\Controllers\Kurikulum\KurikulumSiswaController;
use App\Http\Controllers\Kurikulum\KelasController;
use App\Http\Controllers\Kurikulum\JurusanController;

// KELAS KAPROG
use App\Http\Controllers\KelaskaprogController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\KaprogGuruController;

// PPDB
use App\Http\Controllers\PpdbController;

// TU
use App\Http\Controllers\TUController;
use App\Http\Controllers\TU\KelulusanController;
use App\Http\Controllers\TU\AlumniController;

// KAPROG
use App\Http\Controllers\Kaprog\KaprogDashboardController;
use App\Http\Controllers\Kurikulum\KurikulumSiswaController as KurikulumKurikulumSiswaController;

// Reset Password Siswa
use App\Http\Controllers\Auth\SiswaResetPasswordController;

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

    Route::get('/', fn() => view('welcome'))->name('home');

    // PPDB public routes (sesi -> jalur -> form)
    Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
    Route::get('/ppdb/create', [PpdbController::class, 'create'])->name('ppdb.create');
    Route::post('/ppdb', [PpdbController::class, 'store'])->name('ppdb.store');
    Route::get('/ppdb/datasiswa/{id}', [PpdbController::class, 'fetchDataSiswa'])->name('ppdb.datasiswa');

    // Reset password siswa (public)
    Route::get('/siswa/reset-password', [SiswaResetPasswordController::class, 'showResetForm'])
        ->name('siswa.password.reset.form');
    Route::post('/siswa/reset-password', [SiswaResetPasswordController::class, 'reset'])
        ->name('siswa.password.reset');

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
    | ROUTE SETELAH LOGIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        // Redirect dashboard berdasarkan role
        Route::get('/dashboard', function () {

            return match (Auth::user()->role) {
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
            // Dashboard
            Route::get('/dashboard', [App\Http\Controllers\SiswaController::class, 'dashboard'])->name('dashboard');

                // Route untuk update profil (names are relative to the 'siswa.' group)
                Route::put('/profile', [SiswaController::class, 'updateProfile'])->name('updateProfile');
                Route::put('/email', [SiswaController::class, 'updateEmail'])->name('updateEmail');
                Route::put('/password', [SiswaController::class, 'updatePassword'])->name('updatePassword');
                Route::post('/photo', [SiswaController::class, 'uploadPhoto'])->name('uploadPhoto');

            // Data Diri
            Route::get('/data-diri', [SiswaController::class, 'dataDiri'])->name('dataDiri');
            Route::get('/data-diri/create', [SiswaController::class, 'create'])->name('dataDiri.create');
            Route::post('/data-diri', [SiswaController::class, 'store'])->name('dataDiri.store');
            Route::get('/data-diri/edit', [SiswaController::class, 'edit'])->name('dataDiri.edit');
            Route::put('/data-diri', [SiswaController::class, 'update'])->name('dataDiri.update');
            Route::get('/data-diri/export-pdf', [SiswaController::class, 'exportPDF'])->name('dataDiri.exportPDF');

            // Raport
            Route::get('/raport', [SiswaController::class, 'raport'])->name('raport');
            Route::get('/raport/{semester}/{tahun}', [SiswaController::class, 'raportShow'])->name('raport.show');
            Route::get('/raport/{semester}/{tahun}/pdf', [SiswaController::class, 'raportPDF'])->name('raport.pdf');

            // Catatan
            Route::get('/catatan', [SiswaController::class, 'catatan'])->name('catatan');

            // Upload foto profil siswa
            Route::post('/profile/photo', [SiswaController::class, 'uploadPhoto'])->name('profile.photo');
                // Hapus foto profil
                Route::delete('/profile/photo', [SiswaController::class, 'deletePhoto'])->name('profile.photo.delete');

            // Cetak raport siswa sendiri
            Route::get('/nilai_raport/{siswa_id}/{semester}/{tahun}/cetak', [NilaiRaportController::class, 'exportPdf'])->name('raport.cetak_pdf');
        });

        // ROUTE GURU
        Route::prefix('guru')->name('guru.')->middleware('auth')->group(function () {
            Route::get('/profile', [App\Http\Controllers\GuruController::class, 'show'])->name('profile');
            Route::get('/profile/edit', [App\Http\Controllers\GuruController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [App\Http\Controllers\GuruController::class, 'update'])->name('profile.update');
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

                // Dashboard Wali Kelas
                Route::get('/dashboard', [App\Http\Controllers\WaliKelasSiswaController::class, 'dashboard'])
                    ->name('dashboard');

                Route::get('/profile', [App\Http\Controllers\GuruController::class, 'show'])
                    ->name('data_diri.profile');

                Route::get('/siswa', [WaliKelasSiswaController::class, 'index'])
                    ->name('siswa.index');

                Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
                    ->name('siswa.show');

                // Export data siswa (PDF)
                Route::get('/siswa/{id}/export-pdf', [WaliKelasSiswaController::class, 'exportPdf'])
                    ->name('siswa.exportPDF');

                // Nilai Raport
                Route::get('/nilai-raport', [NilaiRaportController::class, 'index'])
                    ->name('nilai_raport.index');
                Route::get('/nilai-raport/list/{id}', [NilaiRaportController::class, 'list'])
                    ->name('nilai_raport.list');
                Route::get('/nilai-raport/{siswa_id}/{semester}/{tahun}/pdf', [NilaiRaportController::class, 'exportPdf'])
                    ->name('nilai_raport.pdf');
                Route::get('/nilai-raport/show', [NilaiRaportController::class, 'show'])
                    ->name('nilai_raport.show');

                // Edit dan Update Rapor
                Route::get('/nilai-raport/edit', [NilaiRaportController::class, 'edit'])
                    ->name('nilai_raport.edit');

                Route::put('/nilai-raport/update', [NilaiRaportController::class, 'update'])
                    ->name('nilai_raport.update');

                // Cetak rapor final
                Route::get('/rapor/{siswa_id}/{semester}/{tahun}/cetak', [RaporController::class, 'cetakRapor'])
                    ->name('rapor.cetak');

                // Input Nilai Raport
                Route::get('/input-nilai-raport', [InputNilaiRaportController::class, 'index'])
                    ->name('input_nilai_raport.index');
                Route::get('/input-nilai-raport/create/{siswa_id}', [InputNilaiRaportController::class, 'create'])
                    ->name('input_nilai_raport.create');
                Route::post('/input-nilai-raport/store/{siswa_id}', [InputNilaiRaportController::class, 'store'])
                    ->name('input_nilai_raport.store');
                Route::get('input-nilai-raport/{siswa_id}/edit', [InputNilaiRaportController::class, 'edit'])
                    ->name('input_nilai_raport.edit');
                Route::post('input-nilai-raport/{siswa_id}/update', [InputNilaiRaportController::class, 'update'])
                    ->name('input_nilai_raport.update');

                // delete raport for a siswa/semester/tahun
                Route::post('input-nilai-raport/{siswa_id}/delete', [InputNilaiRaportController::class, 'destroy'])
                    ->name('input_nilai_raport.delete');

                // Form Ekstra / Kehadiran / Info
                Route::get('/rapor/ekstra/{siswa_id}', [RaporController::class, 'formEkstra'])
                    ->name('rapor.ekstra.form');
                Route::post('/rapor/ekstra/{siswa_id}', [RaporController::class, 'simpanEkstra'])
                    ->name('rapor.ekstra.simpan');
                Route::get('/rapor/kehadiran/{siswa_id}', [RaporController::class, 'formKehadiran'])
                    ->name('rapor.kehadiran.form');
                Route::post('/rapor/kehadiran/{siswa_id}', [RaporController::class, 'simpanKehadiran'])
                    ->name('rapor.kehadiran.simpan');
                Route::get('/rapor/info/{siswa_id}', [RaporController::class, 'formInfo'])
                    ->name('rapor.info.form');
                Route::post('/rapor/info/{siswa_id}', [RaporController::class, 'simpanInfo'])
                    ->name('rapor.info.simpan');
            });

        /*
        |--------------------------------------------------------------------------
        | ROUTE KAPROG
        |--------------------------------------------------------------------------
        */
        Route::prefix('kaprog')->name('kaprog.')->group(function () {

            // Dashboard (Kaprog)
            Route::get('/dashboard', [KaprogController::class, 'dashboard'])
                ->name('dashboard');

            // View Raport
            Route::get('/raport-siswa', [KaprogController::class, 'raportSiswa'])
                ->name('raport.siswa.old');

            // Detail siswa (AJAX)
            Route::get('/siswa/{id}/detail', [KurikulumDashboardController::class, 'detail'])
                ->name('siswa.detail');

            // Daftar kelas / rombel untuk kaprog
            Route::get('/kelas', [KelaskaprogController::class, 'index'])->name('kelas.index');
            Route::get('/kelas/{id}', [KelaskaprogController::class, 'show'])->name('kelas.show');
            // Daftar siswa per angkatan (X/XI/XII)
            Route::get('/kelas/angkatan/{tingkat}', [KelaskaprogController::class, 'angkatan'])->name('kelas.angkatan');
            // Kirim laporan tentang siswa (kaprog)
            Route::post('/kelas/siswa/{id}/lapor', [KelaskaprogController::class, 'lapor'])->name('kelas.siswa.lapor');

            // Daftar guru untuk kaprog (hanya jurusan kaprog)
            Route::get('/guru', [KaprogGuruController::class, 'index'])->name('guru.index');
            Route::get('/guru/{id}', [KaprogGuruController::class, 'show'])->name('guru.show');

            // Data diri kaprog
            Route::get('/data-diri', [KaprogController::class, 'dataDiri'])->name('datapribadi.index');
            Route::put('/data-diri', [KaprogController::class, 'updateDataDiri'])->name('datapribadi.update');
            // Daftar siswa (kaprog)
            Route::get('/siswa', [KaprogController::class, 'siswaIndex'])->name('siswa.index');
            Route::get('/siswa/{id}', [KaprogController::class, 'show'])->name('siswa.show');
            // Raport siswa untuk kaprog
            Route::get('/raport/siswa', [KaprogController::class, 'raportSiswa'])->name('raport.siswa');
            Route::get('/raport/siswa/{siswaId}/{semester}/{tahun}', [KaprogController::class, 'raportShow'])->name('raport.show');
        });

        // Raport list for kaprog (simple view)
        // Removed duplicate

        // Alternate index route (some views reference kaprog.raport.index)
        Route::get('/raport', [KaprogController::class, 'raportSiswa'])->name('raport.index');

        Route::get('/siswa/{id}/detail', [KaprogDashboardController::class, 'detail'])
            ->name('siswa.detail');

        /*
        |--------------------------------------------------------------------------
        | ROUTE TU
        |--------------------------------------------------------------------------
        */
        Route::prefix('tu')->name('tu.')->group(function () {
            // Dashboard
            Route::get('/dashboard', [TUController::class, 'dashboard'])->name('dashboard');

            // Route untuk guru (TU management)
            Route::get('/guru', [TUController::class, 'guruIndex'])->name('guru.index');
            Route::get('/guru/create', [TUController::class, 'guruCreate'])->name('guru.create');
            Route::post('/guru', [TUController::class, 'guruStore'])->name('guru.store');
            Route::get('/guru/{id}/edit', [TUController::class, 'guruEdit'])->name('guru.edit');
            Route::put('/guru/{id}', [TUController::class, 'guruUpdate'])->name('guru.update');
            Route::delete('/guru/{id}', [TUController::class, 'guruDestroy'])->name('guru.destroy');

            // Route untuk siswa
            Route::get('/siswa', [TUController::class, 'siswa'])->name('siswa.index');
            Route::get('/siswa/create', [TUController::class, 'siswaCreate'])->name('siswa.create');
            Route::post('/siswa', [TUController::class, 'siswaStore'])->name('siswa.store');
            Route::get('/siswa/{id}', [TUController::class, 'siswaDetail'])->name('siswa.detail');
            Route::get('/siswa/{id}/raport', [TUController::class, 'siswaRaport'])->name('siswa.raport');
            Route::get('/siswa/{id}/edit', [TUController::class, 'siswaEdit'])->name('siswa.edit');
            Route::put('/siswa/{id}', [TUController::class, 'siswaUpdate'])->name('siswa.update');
            Route::delete('/siswa/{id}', [TUController::class, 'siswaDestroy'])->name('siswa.destroy');

            // Route untuk guru (TU management)
            Route::get('/guru', [TUController::class, 'guruIndex'])->name('guru.index');
            Route::get('/guru/create', [TUController::class, 'guruCreate'])->name('guru.create');
            Route::post('/guru', [TUController::class, 'guruStore'])->name('guru.store');

            // Route untuk kelas
            Route::get('/kelas', [TUController::class, 'kelas'])->name('kelas.index');
            Route::get('/kelas/create', [TUController::class, 'kelasCreate'])->name('kelas.create');
            Route::post('/kelas', [TUController::class, 'kelasStore'])->name('kelas.store');
            Route::get('/kelas/{id}', [TUController::class, 'kelasDetail'])->name('kelas.show');
            Route::get('/kelas/{id}/edit', [TUController::class, 'kelasEdit'])->name('kelas.edit');
            Route::put('/kelas/{id}', [TUController::class, 'kelasUpdate'])->name('kelas.update');
            Route::delete('/kelas/{id}', [TUController::class, 'kelasDestroy'])->name('kelas.destroy');

            Route::get('/wali-kelas', [TUController::class, 'waliKelas'])->name('wali-kelas');
            Route::get('/wali-kelas/create', [TUController::class, 'waliKelasCreate'])->name('wali-kelas.create');
            Route::post('/wali-kelas', [TUController::class, 'waliKelasStore'])->name('wali-kelas.store');
            Route::get('/wali-kelas/{id}', [TUController::class, 'waliKelasDetail'])->name('wali-kelas.detail');
            Route::get('/wali-kelas/{id}/edit', [TUController::class, 'waliKelasEdit'])->name('wali-kelas.edit');
            Route::put('/wali-kelas/{id}', [TUController::class, 'waliKelasUpdate'])->name('wali-kelas.update');
            Route::delete('/wali-kelas/{id}', [TUController::class, 'waliKelasDestroy'])->name('wali-kelas.destroy');

            // Route untuk laporan
            Route::get('/laporan-nilai', [TUController::class, 'laporanNilai'])->name('laporan.nilai');

            // PPDB (TU) - tampilkan pendaftar dan assign ke rombel
            Route::get('/ppdb', [PpdbController::class, 'tuIndex'])->name('ppdb.index');
            Route::get('/ppdb/jurusan/{id}', [PpdbController::class, 'showJurusan'])->name('ppdb.jurusan.show');
            Route::get('/ppdb/jurusan/{id}/pendaftar', [PpdbController::class, 'showPendaftarJurusan'])->name('ppdb.jurusan.pendaftar');
            Route::get('/ppdb/jurusan/{jurusanId}/sesi/{sesiId}', [PpdbController::class, 'showPendaftarSesi'])->name('ppdb.jurusan.sesi.pendaftar');
            Route::get('/ppdb/jurusan/{jurusanId}/jalur/{jalurId}', [PpdbController::class, 'showPendaftarJalur'])->name('ppdb.jurusan.jalur.pendaftar');
            Route::get('/ppdb/{id}/assign', [PpdbController::class, 'showAssignForm'])->name('ppdb.assign.form');
            Route::post('/ppdb/{id}/assign', [PpdbController::class, 'assign'])->name('ppdb.assign');

            // Nilai Raport (TU) - mimic walikelas routes for TU role
            Route::get('/nilai-raport', [TUController::class, 'nilaiRaportIndex'] ?? [TUController::class, 'nilaiRaportIndex'])->name('nilai_raport.index');
            Route::get('/nilai-raport/list/{id}', [TUController::class, 'siswaRaport'])->name('nilai_raport.list');
            Route::get('/nilai-raport/show', [TUController::class, 'nilaiRaportShow'])->name('nilai_raport.show');
            Route::get('/nilai-raport/edit', [TUController::class, 'nilaiRaportEdit'])->name('nilai_raport.edit');
            Route::put('/nilai-raport/update', [TUController::class, 'nilaiRaportUpdate'])->name('nilai_raport.update');
            Route::delete('/nilai-raport/delete', [TUController::class, 'nilaiRaportDestroy'])->name('nilai_raport.destroy');

            // Cetak rapor (TU)
            Route::get('/rapor/{siswa_id}/{semester}/{tahun}/cetak', [\App\Http\Controllers\RaporController::class, 'cetakRapor'])->name('rapor.cetak');

            // Kelulusan & Alumni (TU)
            Route::get('/kelulusan', [KelulusanController::class, 'index'])->name('kelulusan.index');
            Route::get('/kelulusan/rombel/{rombelId}/{tahun}', [KelulusanController::class, 'showRombel'])->name('kelulusan.rombel.show');

            Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
            Route::get('/alumni/{id}', [AlumniController::class, 'show'])->name('alumni.show');
            
            // (cleaned duplicate kelulusan routes)
        });

        /*
        |--------------------------------------------------------------------------
        | ROUTE KURIKULUM
        |--------------------------------------------------------------------------
        */
        Route::prefix('kurikulum')->name('kurikulum.')->group(function () {

            // PPDB (Kurikulum) - allow Kurikulum users to manage PPDB
            Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');

            Route::get('/dashboard', [KurikulumDashboardController::class, 'index'])
                ->name('dashboard');

            // Guru management (Kurikulum)
            Route::get('/guru', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])
                ->name('guru.index');

            // Backwards-compatible "manage" routes used by views/controllers
            Route::prefix('guru/manage')->name('guru.manage.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\GuruController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\GuruController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'destroy'])->name('destroy');
            });

            // Mata Pelajaran (Kurikulum)
            Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'destroy'])->name('destroy');
            });

            // PPDB (Kurikulum) - jurusan and assign routes
            Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
            Route::get('/ppdb/jurusan/{id}', [PpdbController::class, 'showJurusan'])->name('ppdb.jurusan.show');
            Route::get('/ppdb/jurusan/{id}/pendaftar', [PpdbController::class, 'showPendaftarJurusan'])->name('ppdb.jurusan.pendaftar');
            Route::get('/ppdb/jurusan/{jurusanId}/sesi/{sesiId}', [PpdbController::class, 'showPendaftarSesi'])->name('ppdb.jurusan.sesi.pendaftar');
            Route::get('/ppdb/jurusan/{jurusanId}/jalur/{jalurId}', [PpdbController::class, 'showPendaftarJalur'])->name('ppdb.jurusan.jalur.pendaftar');
            Route::get('/ppdb/{id}/assign', [PpdbController::class, 'showAssignForm'])->name('ppdb.assign.form');
            Route::post('/ppdb/{id}/assign', [PpdbController::class, 'assign'])->name('ppdb.assign');

            Route::get('/siswa', [KurikulumSiswaController::class, 'index'])
                ->name('siswa.index');

            // Data Siswa
            Route::get('/siswa/create', [KurikulumSiswaController::class, 'create'])
                ->name('data-siswa.create');

            Route::post('/siswa', [KurikulumSiswaController::class, 'store'])
                ->name('data-siswa.store');

            Route::get('/siswa/{id}', [KurikulumSiswaController::class, 'show'])
                ->name('data-siswa.show');

            Route::get('/siswa/{id}/edit', [KurikulumSiswaController::class, 'edit'])
                ->name('data-siswa.edit');

            Route::put('/siswa/{id}', [KurikulumSiswaController::class, 'update'])
                ->name('data-siswa.update');

            Route::delete('/siswa/{id}', [KurikulumSiswaController::class, 'destroy'])
                ->name('data-siswa.destroy');

            // KELAS
            Route::get('/kelas/create', [KelasController::class, 'create'])
                ->name('kelas.create');

            Route::post('/kelas', [KelasController::class, 'store'])
                ->name('kelas.store');

            Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])
                ->name('kelas.destroy');

            Route::get('/kelas/{rombel}', [KelasController::class, 'show'])->name('kelas.show');

            // RAPOR SISWA
            Route::get('/rapor', [App\Http\Controllers\Kurikulum\KurikulumRaportController::class, 'index'])
                ->name('rapor.index');

            Route::get('/rapor/{id}', [App\Http\Controllers\Kurikulum\KurikulumRaportController::class, 'show'])
                ->name('rapor.show');

            Route::get('/rapor/{id}/{semester}/{tahun}', [App\Http\Controllers\Kurikulum\KurikulumRaportController::class, 'detail'])
                ->name('rapor.detail');

            Route::get('/kurikulum/manajemen-kelas', [KelasController::class, 'index'])
                ->name('kurikulum.kelas.index');

            // Halaman utama manajemen kelas
            Route::get('/manajemen-kelas', [KelasController::class, 'index'])
                ->name('kelas.index');

            // ============================
            //  MANAGEMEN KELAS — EDIT
            // ============================

            Route::get('/manajemen-kelas/{id}/edit', [KelasController::class, 'edit'])
                ->name('kelas.edit');

            Route::put('/manajemen-kelas/{id}', [KelasController::class, 'update'])
                ->name('kelas.update');

            // JURUSAN
            Route::get('/jurusan', [JurusanController::class, 'index'])
                ->name('jurusan.index');

            Route::get('/jurusan/create', [JurusanController::class, 'create'])
                ->name('jurusan.create');

            Route::post('/jurusan', [JurusanController::class, 'store'])
                ->name('jurusan.store');

            Route::get('/jurusan/{id}', [JurusanController::class, 'show'])
                ->name('jurusan.show');

            Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])
                ->name('jurusan.edit');

            Route::put('/jurusan/{id}', [JurusanController::class, 'update'])
                ->name('jurusan.update');

            Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])
                ->name('jurusan.destroy');

            // Kelulusan & Alumni (reuse TU controllers for data views)
            Route::get('/kelulusan', [\App\Http\Controllers\TU\KelulusanController::class, 'index'])
                ->name('kelulusan.index');
            Route::get('/kelulusan/rombel/{rombelId}/{tahun}', [\App\Http\Controllers\TU\KelulusanController::class, 'showRombel'])
                ->name('kelulusan.rombel.show');

            Route::get('/alumni', [\App\Http\Controllers\TU\AlumniController::class, 'index'])
                ->name('alumni.index');
            Route::get('/alumni/{id}', [\App\Http\Controllers\TU\AlumniController::class, 'show'])
                ->name('alumni.show');
        });
    });
});
