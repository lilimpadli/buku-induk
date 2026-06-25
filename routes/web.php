<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// --- CONTROLLER IMPORTS ---
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RaporController;

// SISWA
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\WaliKelas\InputNilaiRaportController;
use App\Http\Controllers\WaliKelas\NilaiRaportController;

// TU & SUPERADMIN
use App\Http\Controllers\TU\TambahKelasController;
use App\Http\Controllers\TU\KelastuController;
use App\Http\Controllers\TU\WaliKelasController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\ManajemenGuruController;
use App\Http\Controllers\SuperAdmin\ManajemenJurusanController;
use App\Http\Controllers\SuperAdmin\ManajemenKelasController;
use App\Http\Controllers\SuperAdmin\ManajemenKurikulumController;
use App\Http\Controllers\SuperAdmin\ManajemenSiswaController;

// KURIKULUM
use App\Http\Controllers\Kurikulum\KurikulumDashboardController;
use App\Http\Controllers\Kurikulum\KurikulumSiswaController;
use App\Http\Controllers\Kurikulum\KelasController;
use App\Http\Controllers\Kurikulum\JurusanController;
use App\Http\Controllers\Kurikulum\ProgramKeahlianController;
use App\Http\Controllers\Kurikulum\KonsentrasiKeahlianController;
use App\Http\Controllers\Kurikulum\BidangKeahlianController;

// KELAS KAPROG
use App\Http\Controllers\KelaskaprogController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\KaprogGuruController;

// TU
use App\Http\Controllers\TUController;
use App\Http\Controllers\TU\KelulusanController;
use App\Http\Controllers\TU\AlumniController;
use App\Http\Controllers\TU\MutasiController;
use App\Http\Controllers\TU\KenaikanKelasController;
use App\Http\Controllers\TU\DataPribadiController;
use App\Http\Controllers\TU\BukuIndukController;
use App\Http\Controllers\TUKepegawaianController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaResetPasswordController;

// KAPROG
use App\Http\Controllers\Kaprog\KaprogDashboardController;
use App\Http\Controllers\PegawaiController;

use App\Http\Controllers\DokumenController;


// --- TU Kepegawaian ---
Route::prefix('tu_kepegawaian')->name('tu_kepegawaian.')->middleware(['auth'])->group(function () {
    
    // Dashboard & Umum
    Route::get('/dashboard', [App\Http\Controllers\TUKepegawaianController::class, 'dashboard'])->name('dashboard');
    Route::get('/guru', [App\Http\Controllers\TUKepegawaianController::class, 'guruIndex'])->name('guru.index');
    Route::get('/tu', [App\Http\Controllers\TUKepegawaianController::class, 'tuIndex'])->name('tu.index');
    Route::resource('data-guru', App\Http\Controllers\GuruController::class);
    Route::delete('/tu/{id}', [App\Http\Controllers\TUKepegawaianController::class, 'tuDestroy'])->name('tu.destroy');

    // Dokumen
    Route::get('/dokumen', [App\Http\Controllers\TUKepegawaianController::class, 'dokumen'])->name('dokumen.index');
    Route::post('/dokumen/store', [App\Http\Controllers\TUKepegawaianController::class, 'dokumenStore'])->name('dokumen.store');
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('tu_kepegawaian.dokumen.create');
    Route::post('/dokumen/store', [DokumenController::class, 'store'])->name('tu_kepegawaian.dokumen.store');
    Route::post('/dokumen/store', [DokumenController::class, 'store'])->name('dokumen.store');

    // Riwayat Kerja
    Route::get('/riwayat', [App\Http\Controllers\TUKepegawaianController::class, 'riwayatIndex'])->name('riwayat.index');
    Route::post('/riwayat', [App\Http\Controllers\TUKepegawaianController::class, 'riwayatStore'])->name('riwayat.store');
    Route::put('/riwayat/{id}', [App\Http\Controllers\TUKepegawaianController::class, 'riwayatUpdate'])->name('riwayat.update');
    Route::delete('/riwayat/{id}', [App\Http\Controllers\TUKepegawaianController::class, 'riwayatDestroy'])->name('riwayat.destroy');

    // Mutasi
    Route::get('/mutasi', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiIndex'])->name('mutasi.index');
    Route::get('/mutasi/create', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiCreate'])->name('mutasi.create');
    Route::post('/mutasi', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiStore'])->name('mutasi.store');
    Route::get('/mutasi/laporan', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiLaporan'])->name('mutasi.laporan');
    Route::get('/mutasi/{id}/edit', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiEdit'])->name('mutasi.edit');
    Route::put('/mutasi/{id}', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiUpdate'])->name('mutasi.update');
    Route::delete('/mutasi/{id}', [App\Http\Controllers\TUKepegawaianController::class, 'mutasiDestroy'])->name('mutasi.destroy');

    Route::resource('penugasan', App\Http\Controllers\PenugasanController::class);
});
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

    Route::get('/buku-induk/{siswa_id}', [RaporController::class, 'showBukuInduk'])
        ->name('rapor.buku-induk');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Reset password siswa
Route::get('/siswa/reset-password', [SiswaResetPasswordController::class, 'showResetForm'])->name('siswa.password.reset.form');
Route::post('/siswa/reset-password', [SiswaResetPasswordController::class, 'reset'])->name('siswa.password.reset');

// Login
Route::middleware('guest')->group(function () {
     Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
     Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    // Redirect dashboard sesuai role
    Route::get('/dashboard', function () {
        return match (Auth::user()->role) {
            'siswa'         => redirect()->route('siswa.dashboard'),
            'guru'          => redirect()->route('guru.dashboard'),
            'walikelas'     => redirect()->route('walikelas.dashboard'),
            'kaprog'        => redirect()->route('kaprog.dashboard'),
            'tu'            => redirect()->route('tu.dashboard'),
            'tu_kepegawaian' => redirect()->route('tu_kepegawaian.dashboard'),
            'super_admin'   => redirect()->route('super_admin.dashboard'),
            'kurikulum'     => redirect()->route('kurikulum.dashboard'),
            'calon_siswa'   => redirect()->route('calon.dashboard'),
            default         => abort(403, 'Role tidak dikenali'),
        };
    })->name('dashboard');

    // API Routes
    Route::post('/api/check-email', function (Request $request) {
        $email = $request->input('email');
        $userId = $request->input('userId', null);
        
        $query = \App\Models\User::where('email', $email);
        
        if ($userId) {
            $query->where('id', '!=', $userId);
        }
        
        $exists = $query->exists();
        
        return response()->json(['exists' => $exists]);
    })->name('api.check-email');

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */
    Route::prefix('siswa')
        ->name('siswa.')
        ->middleware('role:siswa')
        ->group(function () {

            Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
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

            // Buku Induk
            Route::get('/buku-induk', [SiswaController::class, 'bukuIndukShow'])->name('bukuInduk.show');
            Route::get('/buku-induk/cetak', [SiswaController::class, 'bukuIndukCetak'])->name('bukuInduk.cetak');

            // Catatan
            Route::get('/catatan', [SiswaController::class, 'catatan'])->name('catatan');

            // Upload foto profil siswa
            Route::post('/profile/photo', [SiswaController::class, 'uploadPhoto'])->name('profile.photo');
            // Hapus foto profil
            Route::delete('/profile/photo', [SiswaController::class, 'deletePhoto'])->name('profile.photo.delete');

            // Cetak raport siswa sendiri
            Route::get('/nilai_raport/{siswa_id}/{semester}/{tahun}/cetak', [NilaiRaportController::class, 'exportPdf'])->name('raport.cetak_pdf');
        });

    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */
    Route::prefix('guru')
        ->name('guru.')
        ->middleware('role:guru')
        ->group(function () {

            Route::get('/dashboard', [\App\Http\Controllers\Guru\GuruDashboardController::class, 'index'])
                ->name('dashboard');

            // Profile Management - Use GuruProfileController
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Guru\GuruProfileController::class, 'show'])->name('index');
                Route::get('/edit', [\App\Http\Controllers\Guru\GuruProfileController::class, 'edit'])->name('edit');
                Route::put('/', [\App\Http\Controllers\Guru\GuruProfileController::class, 'update'])->name('update');
            });

            // Kelas Management
            Route::prefix('kelas')->name('kelas.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Guru\GuruKelasController::class, 'index'])->name('index');
                Route::get('/{rombelId}', [\App\Http\Controllers\Guru\GuruKelasController::class, 'show'])->name('show');
                Route::get('/{rombelId}/mata-pelajaran', [\App\Http\Controllers\Guru\GuruKelasController::class, 'mataPelajaran'])->name('mata-pelajaran');
            });

            // Siswa Management
            Route::prefix('siswa')->name('siswa.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Guru\GuruSiswaController::class, 'index'])->name('index');
                Route::get('/{siswaId}', [\App\Http\Controllers\Guru\GuruSiswaController::class, 'show'])->name('show');
            });
        });

    /*
    |--------------------------------------------------------------------------
    | WALI KELAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('walikelas')
        ->name('walikelas.')
        ->middleware('role:walikelas')
        ->group(function () {

            // Dashboard Wali Kelas
            Route::get('/dashboard', [WaliKelasSiswaController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/profile', [App\Http\Controllers\GuruController::class, 'show'])
                ->name('data_diri.profile');

            Route::get('/profile/edit', [App\Http\Controllers\GuruController::class, 'edit'])
                ->name('data_diri.edit');

            Route::put('/profile', [App\Http\Controllers\GuruController::class, 'update'])
                ->name('data_diri.update');

            Route::get('/siswa', [WaliKelasSiswaController::class, 'index'])
                ->name('siswa.index');

            // Export data siswa (Excel)
            Route::get('/siswa/export-excel', [WaliKelasSiswaController::class, 'exportExcel'])
                ->name('siswa.exportExcel');

            Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
                ->name('siswa.show');

            // Export data siswa (PDF)
            Route::get('/siswa/{id}/export-pdf', [WaliKelasSiswaController::class, 'exportPdf'])
                ->name('siswa.exportPDF');

            // Nilai Raport
            Route::get('/nilai-raport', [NilaiRaportController::class, 'index'])
                ->name('nilai_raport.index');
            Route::get('/nilai-raport/export-excel', [NilaiRaportController::class, 'exportExcel'])
                ->name('nilai_raport.export_excel');
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

            // Download template and import leger
            Route::post('/input-nilai-raport/download-template', [InputNilaiRaportController::class, 'downloadTemplate'])
                ->name('input_nilai_raport.download_template');
            Route::post('/input-nilai-raport/import', [InputNilaiRaportController::class, 'import'])
                ->name('input_nilai_raport.import');

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
    | KAPROG
    |--------------------------------------------------------------------------
    */
    Route::prefix('kaprog')
        ->name('kaprog.')
        ->middleware('role:kaprog')
        ->group(function () {

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
            Route::get('/data-diri/edit', [KaprogController::class, 'editDataDiri'])->name('datapribadi.edit');
            Route::put('/data-diri', [KaprogController::class, 'updateDataDiri'])->name('datapribadi.update');
            // Daftar siswa (kaprog)
            Route::get('/siswa', [KaprogController::class, 'siswaIndex'])->name('siswa.index');
            Route::get('/siswa/{id}', [KaprogController::class, 'show'])->name('siswa.show');
            Route::get('/siswa/{id}/export-data-diri', [KaprogController::class, 'exportDataDiri'])->name('siswa.export-data-diri');
            // Raport siswa untuk kaprog
            Route::get('/raport/siswa', [KaprogController::class, 'raportSiswa'])->name('raport.siswa');
            Route::get('/raport/siswa/{siswaId}/{semester}/{tahun}', [KaprogController::class, 'raportShow'])->name('raport.show');
            Route::get('/raport/siswa/{siswaId}/{semester}/{tahun}/cetak', [KaprogController::class, 'cetakRaport'])->name('raport.cetak');
            // Export siswa per rombel dan jurusan
            Route::get('/export/rombel/{rombelId}', [KaprogController::class, 'exportSiswaByRombel'])->name('export.rombel');
            Route::get('/export/jurusan/{jurusanId}', [KaprogController::class, 'exportSiswaByJurusan'])->name('export.jurusan');
            Route::get('/export/angkatan/{jurusanId}', [KaprogController::class, 'exportSiswaByAngkatan'])->name('export.angkatan');
        });

    // Raport list for kaprog (simple view)
    // Removed duplicate

    // Alternate index route (some views reference kaprog.raport.index)
    Route::get('/raport', [KaprogController::class, 'raportSiswa'])->name('raport.index');

    Route::get('/siswa/{id}/detail', [KaprogDashboardController::class, 'detail'])
        ->name('siswa.detail');

    /*
    |--------------------------------------------------------------------------
    | TU
    |--------------------------------------------------------------------------
    */
    Route::prefix('tu')
        ->name('tu.')
        ->middleware('role:tu')
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [TUController::class, 'dashboard'])->name('dashboard');

            // Data Pribadi Guru/TU
            Route::get('/data-pribadi', [DataPribadiController::class, 'index'])->name('data-pribadi.index');
            Route::get('/data-pribadi/edit', [DataPribadiController::class, 'edit'])->name('data-pribadi.edit');
            Route::put('/data-pribadi', [DataPribadiController::class, 'update'])->name('data-pribadi.update');

            // Route untuk guru (TU management)
            Route::get('/guru', [TUController::class, 'guruIndex'])->name('guru.index');
            Route::get('/guru/export', [TUController::class, 'exportGuru'])->name('guru.export');
            Route::get('/guru/create', [TUController::class, 'guruCreate'])->name('guru.create');
            Route::post('/guru', [TUController::class, 'guruStore'])->name('guru.store');
            Route::get('/guru/{id}', [TUController::class, 'guruShow'])->name('guru.show');
            Route::get('/guru/{id}/edit', [TUController::class, 'guruEdit'])->name('guru.edit');
            Route::put('/guru/{id}', [TUController::class, 'guruUpdate'])->name('guru.update');
            Route::delete('/guru/{id}', [TUController::class, 'guruDestroy'])->name('guru.destroy');

            // Route untuk siswa
            Route::get('/siswa', [TUController::class, 'siswa'])->name('siswa.index');
            Route::get('/siswa/export/jurusan/{jurusanId}', [TUController::class, 'exportSiswaByJurusan'])->name('siswa.export.jurusan');
            Route::get('/siswa/export/angkatan/{jurusanId}', [TUController::class, 'exportSiswaByAngkatan'])->name('siswa.export.angkatan');
            Route::get('/siswa/{id}/export-pdf', [TUController::class, 'siswaExportPdf'])->name('siswa.exportPDF');
            Route::get('/siswa/template/download', [TUController::class, 'downloadSiswaTemplate'])->name('siswa.template.download');
            Route::post('/siswa/import', [TUController::class, 'importSiswa'])->name('siswa.import');
            Route::get('/siswa/create', [TUController::class, 'siswaCreate'])->name('siswa.create');
            Route::post('/siswa', [TUController::class, 'siswaStore'])->name('siswa.store');
            Route::get('/siswa/{id}', [TUController::class, 'siswaDetail'])->name('siswa.detail');
            Route::get('/siswa/{id}/raport', [TUController::class, 'siswaRaport'])->name('siswa.raport');
            Route::get('/siswa/{id}/edit', [TUController::class, 'siswaEdit'])->name('siswa.edit');
            Route::put('/siswa/{id}', [TUController::class, 'siswaUpdate'])->name('siswa.update');
            Route::delete('/siswa/{id}', [TUController::class, 'siswaDestroy'])->name('siswa.destroy');

            // Route untuk kelas
            Route::get('/kelas', [TUController::class, 'kelas'])->name('kelas.index');
            Route::get('/kelas/create', [TUController::class, 'kelasCreate'])->name('kelas.create');
            Route::post('/kelas', [TUController::class, 'kelasStore'])->name('kelas.store');
            // Export siswa per rombel (TU) - mirror Kaprog export
            Route::get('/kelas/{id}/export', [TUController::class, 'exportSiswaByRombel'])->name('kelas.export');
            Route::post('/kelas/download-template', [TUController::class, 'downloadTemplate'])->name('kelas.download_template');
            Route::post('/kelas/import', [TUController::class, 'importLedger'])->name('kelas.import');
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

            // Nilai Raport (TU) - mimic walikelas routes for TU role
            Route::get('/nilai-raport', [TUController::class, 'nilaiRaportIndex'])->name('nilai_raport.index');            Route::get('/nilai-raport/list/{id}', [TUController::class, 'siswaRaport'])->name('nilai_raport.list');
            Route::get('/nilai-raport/show', [TUController::class, 'nilaiRaportShow'])->name('nilai_raport.show');
            Route::get('/nilai-raport/edit', [TUController::class, 'nilaiRaportEdit'])->name('nilai_raport.edit');
            Route::put('/nilai-raport/update', [TUController::class, 'nilaiRaportUpdate'])->name('nilai_raport.update');
            Route::delete('/nilai-raport/delete', [TUController::class, 'nilaiRaportDestroy'])->name('nilai_raport.destroy');

            // Cetak rapor (TU) — use TU controller so it renders TU-specific PDF
            Route::get('/rapor/{siswa_id}/{semester}/{tahun}/cetak', [TUController::class, 'cetakRaport'])->name('rapor.cetak');

            // Mutasi Siswa (TU)
            Route::get('/mutasi/laporan', [MutasiController::class, 'laporan'])->name('mutasi.laporan');
            Route::post('/mutasi/bulk', [MutasiController::class, 'bulk'])->name('mutasi.bulk');
            Route::post('/mutasi/up-all', [MutasiController::class, 'upAll'])->name('mutasi.up-all');
            Route::resource('/mutasi', MutasiController::class)->names('mutasi');

            // Buku Induk (TU)
            Route::get('/buku-induk', [BukuIndukController::class, 'index'])->name('buku-induk.index');
            Route::get('/buku-induk/{siswa}', [BukuIndukController::class, 'show'])->name('buku-induk.show');
            Route::get('/buku-induk/{siswa}/cetak', [BukuIndukController::class, 'cetak'])->name('buku-induk.cetak');
            Route::get('/buku-induk/{siswa}/export', [BukuIndukController::class, 'export'])->name('buku-induk.export');

            // Kelulusan & Alumni (TU)
            Route::get('/kelulusan', [KelulusanController::class, 'index'])->name('kelulusan.index');
            Route::get('/kelulusan/rombel/{rombelId}/{tahun}', [KelulusanController::class, 'showRombel'])->name('kelulusan.rombel.show');

            Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
            Route::get('/alumni/{siswa_id}/buku-induk/cetak', [AlumniController::class, 'bukuIndukCetak'])->name('alumni.buku-induk.cetak');
            Route::get('/alumni/{siswa_id}/buku-induk', [AlumniController::class, 'bukuInduk'])->name('alumni.buku-induk.show');
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}/cetak', [AlumniController::class, 'raporCetak'])->name('alumni.raport.cetak');
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}', [AlumniController::class, 'raporShow'])->name('alumni.raport.show');
            Route::get('/alumni/{siswa_id}/raport', [AlumniController::class, 'raporList'])->name('alumni.raport.list');
            Route::get('/alumni/jurusan/{jurusanId}', [AlumniController::class, 'byJurusan'])->name('alumni.by-jurusan');
            Route::get('/alumni/{id}', [AlumniController::class, 'show'])->where('id', '[0-9]+')->name('alumni.show');
        });

    /*
    |--------------------------------------------------------------------------
    | TU KEPEGAWAIAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('tu_kepegawaian')
        ->name('tu_kepegawaian.')
        ->group(function () {
            
            // Dashboard
            Route::get('/dashboard', [TUKepegawaianController::class, 'dashboard'])->name('dashboard');

            // Administrasi (Ditambahkan agar tidak 404)
            Route::get('/administrasi', function () {
                return view('tu_kepegawaian.administrasi.index');
            })->name('administrasi.index');

            // Data Guru
            Route::get('/guru', [TUKepegawaianController::class, 'guruIndex'])->name('guru.index');
            Route::get('/guru/create', [TUKepegawaianController::class, 'guruCreate'])->name('guru.create');
            Route::post('/guru', [TUKepegawaianController::class, 'guruStore'])->name('guru.store');
            Route::get('/guru/template', [TUKepegawaianController::class, 'guruTemplate'])->name('guru.template');
            Route::post('/guru/import', [TUKepegawaianController::class, 'guruImport'])->name('guru.import');
            Route::get('/guru/{id}', [TUKepegawaianController::class, 'guruShow'])->name('guru.show');
            Route::get('/guru/{id}/edit', [TUKepegawaianController::class, 'guruEdit'])->name('guru.edit');
            Route::put('/guru/{id}', [TUKepegawaianController::class, 'guruUpdate'])->name('guru.update');
            Route::delete('/guru/{id}', [TUKepegawaianController::class, 'guruDestroy'])->name('guru.destroy');

            // Data TU/Pegawai
            Route::get('/tu', [TUKepegawaianController::class, 'tuIndex'])->name('tu.index');
            Route::get('/tu/create', [TUKepegawaianController::class, 'tuCreate'])->name('tu.create');
            Route::post('/tu', [TUKepegawaianController::class, 'tuStore'])->name('tu.store');
            Route::get('/tu/{id}', [TUKepegawaianController::class, 'tuShow'])->name('tu.show');
            Route::get('/tu/{id}/edit', [TUKepegawaianController::class, 'tuEdit'])->name('tu.edit');
            Route::put('/tu/{id}', [TUKepegawaianController::class, 'tuUpdate'])->name('tu.update');
            Route::delete('/tu/{id}', [TUKepegawaianController::class, 'tuDestroy'])->name('tu.destroy');

            // Kurikulum
            Route::get('/kurikulum', [TUKepegawaianController::class, 'kurikulumIndex'])->name('kurikulum.index');
            Route::get('/kurikulum/create', [TUKepegawaianController::class, 'kurikulumCreate'])->name('kurikulum.create');
            Route::post('/kurikulum', [TUKepegawaianController::class, 'kurikulumStore'])->name('kurikulum.store');
            Route::get('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumShow'])->name('kurikulum.show');
            Route::get('/kurikulum/{id}/edit', [TUKepegawaianController::class, 'kurikulumEdit'])->name('kurikulum.edit');
            Route::put('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumUpdate'])->name('kurikulum.update');
            Route::delete('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumDestroy'])->name('kurikulum.destroy');

            // Mata Pelajaran
            Route::get('/mata-pelajaran', [TUKepegawaianController::class, 'mataPelajaranIndex'])->name('mata-pelajaran.index');
            Route::get('/mata-pelajaran/create', [TUKepegawaianController::class, 'mataPelajaranCreate'])->name('mata-pelajaran.create');
            Route::post('/mata-pelajaran', [TUKepegawaianController::class, 'mataPelajaranStore'])->name('mata-pelajaran.store');
            Route::get('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranShow'])->name('mata-pelajaran.show');
            Route::get('/mata-pelajaran/{id}/edit', [TUKepegawaianController::class, 'mataPelajaranEdit'])->name('mata-pelajaran.edit');
            Route::put('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranUpdate'])->name('mata-pelajaran.update');
            Route::delete('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranDestroy'])->name('mata-pelajaran.destroy');

            // Tugas Tambahan
            Route::resource('tugas_tambahan', \App\Http\Controllers\TugaTambahanController::class, ['names' => 'tugas_tambahan']);
        });

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('super_admin')
        ->name('super_admin.')
        ->middleware('role:super_admin')
        ->group(function () {
            Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/users', [SuperAdminController::class, 'usersIndex'])->name('users.index');
            Route::get('/system', [SuperAdminController::class, 'systemIndex'])->name('system.index');

            Route::prefix('manajemen-guru')->name('manajemen-guru.')->group(function () {
                Route::get('/', [ManajemenGuruController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenGuruController::class, 'create'])->name('create');
                Route::post('/', [ManajemenGuruController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenGuruController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenGuruController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenGuruController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenGuruController::class, 'destroy'])->name('destroy');

                // Import/Export routes
                Route::get('/import', [ManajemenGuruController::class, 'importForm'])->name('importForm');
                Route::get('/import/template', [ManajemenGuruController::class, 'downloadTemplate'])->name('import.template');
                Route::post('/import', [ManajemenGuruController::class, 'import'])->name('import');
                Route::get('/export', [ManajemenGuruController::class, 'exportExcel'])->name('export');
            });

            Route::prefix('manajemen-jurusan')->name('manajemen-jurusan.')->group(function () {
                Route::get('/', [ManajemenJurusanController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenJurusanController::class, 'create'])->name('create');
                Route::post('/', [ManajemenJurusanController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenJurusanController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenJurusanController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenJurusanController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenJurusanController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('manajemen-kelas')->name('manajemen-kelas.')->group(function () {
                Route::get('/', [ManajemenKelasController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenKelasController::class, 'create'])->name('create');
                Route::post('/', [ManajemenKelasController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenKelasController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenKelasController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenKelasController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenKelasController::class, 'destroy'])->name('destroy');
                Route::get('/{id}/export', [ManajemenKelasController::class, 'export'])->name('export');
            });

            Route::prefix('manajemen-kurikulum')->name('manajemen-kurikulum.')->group(function () {
                Route::get('/', [ManajemenKurikulumController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenKurikulumController::class, 'create'])->name('create');
                Route::post('/', [ManajemenKurikulumController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenKurikulumController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenKurikulumController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenKurikulumController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenKurikulumController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('manajemen-siswa')->name('manajemen-siswa.')->group(function () {
                Route::get('/', [ManajemenSiswaController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenSiswaController::class, 'create'])->name('create');
                Route::post('/', [ManajemenSiswaController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenSiswaController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenSiswaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenSiswaController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenSiswaController::class, 'destroy'])->name('destroy');
                Route::get('/export/jurusan', [ManajemenSiswaController::class, 'exportByJurusan'])->name('export.jurusan');
                Route::get('/export/angkatan', [ManajemenSiswaController::class, 'exportByAngkatan'])->name('export.angkatan');
                Route::post('/import', [ManajemenSiswaController::class, 'import'])->name('import');
            });
        });

    /*
    |--------------------------------------------------------------------------
    | KURIKULUM
    |--------------------------------------------------------------------------
    */
    Route::prefix('kurikulum')
        ->name('kurikulum.')
        ->middleware('role:kurikulum')
        ->group(function () {

           

            Route::get('/dashboard', [KurikulumDashboardController::class, 'index'])
                ->name('dashboard');

            // Data Pribadi (Kurikulum)
            Route::get('/data-pribadi', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'index'])
                ->name('data-pribadi.index');
            Route::get('/data-pribadi/edit', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'edit'])
                ->name('data-pribadi.edit');
            Route::put('/data-pribadi', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'update'])
                ->name('data-pribadi.update');


            // Guru management (Kurikulum)
            Route::get('/guru', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])
                ->name('guru.index');

            // Bidang Keahlian (Kurikulum)
            Route::prefix('bidang-keahlian')->name('bidang-keahlian.')->group(function () {
                Route::get('/', [BidangKeahlianController::class, 'index'])->name('index');
                Route::get('/create', [BidangKeahlianController::class, 'create'])->name('create');
                Route::post('/', [BidangKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [BidangKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [BidangKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [BidangKeahlianController::class, 'update'])->name('update');
                Route::delete('/{id}', [BidangKeahlianController::class, 'destroy'])->name('destroy');
            });

             // Konsentrasi Keahlian (Kurikulum)
            Route::prefix('konsentrasi-keahlian')->name('konsentrasi-keahlian.')->group(function () {
                Route::get('/', [KonsentrasiKeahlianController::class, 'index'])->name('index');
                Route::get('/create', [KonsentrasiKeahlianController::class, 'create'])->name('create');
                Route::post('/', [KonsentrasiKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [KonsentrasiKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [KonsentrasiKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [KonsentrasiKeahlianController::class, 'update'])->name('update');
                Route::delete('/{id}', [KonsentrasiKeahlianController::class, 'destroy'])->name('destroy');
            });

             // Program Keahlian (Kurikulum)
                    Route::prefix('program-keahlian')->name('program-keahlian.')->group(function () {
                        Route::get('/', [ProgramKeahlianController::class, 'index'])->name('index');
                        Route::get('/create', [ProgramKeahlianController::class, 'create'])->name('create');
                        Route::post('/', [ProgramKeahlianController::class, 'store'])->name('store');
                        Route::get('/{id}', [ProgramKeahlianController::class, 'show'])->name('show');
                        Route::get('/{id}/edit', [ProgramKeahlianController::class, 'edit'])->name('edit');
                        Route::put('/{id}', [ProgramKeahlianController::class, 'update'])->name('update');
                        Route::delete('/{id}', [ProgramKeahlianController::class, 'destroy'])->name('destroy');
                    });

            // Guru import
            Route::get('/guru/import', [App\Http\Controllers\Kurikulum\GuruController::class, 'importForm'])
                ->name('guru.importForm');
            Route::get('/guru/import/template', [App\Http\Controllers\Kurikulum\GuruController::class, 'downloadTemplate'])
                ->name('guru.import.template');
            Route::post('/guru/import', [App\Http\Controllers\Kurikulum\GuruController::class, 'import'])
                ->name('guru.import');
            // Guru export (Excel)
            Route::get('/guru/export', [App\Http\Controllers\Kurikulum\GuruController::class, 'exportExcel'])
                ->name('guru.export');

            // Backwards-compatible "manage" routes used by views/controllers
            Route::prefix('guru/manage')->name('guru.manage.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\GuruController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'store'])->name('store');
                Route::get('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\GuruController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'destroy'])->name('destroy');
            });

            // Kurikulum Management (Kurikulum)
            Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'store'])->name('store');
                Route::get('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'destroy'])->name('destroy');
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

            Route::get('/buku-induk', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'index'])->name('buku-induk.index');
            Route::get('/buku-induk/{siswa}', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'show'])->name('buku-induk.show');
            Route::get('/buku-induk/{siswa}/cetak', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'cetak'])->name('buku-induk.cetak');

            // Mutasi Siswa (Kurikulum)
            Route::get('/mutasi/laporan', [App\Http\Controllers\Kurikulum\MutasiController::class, 'laporan'])->name('mutasi.laporan');
            Route::resource('/mutasi', App\Http\Controllers\Kurikulum\MutasiController::class)->names('mutasi');

            // Kenaikan Kelas (TU)
            Route::get('/kenaikan-kelas', [App\Http\Controllers\KenaikanKelasController::class, 'index'])->name('kenaikan-kelas.index');
            Route::post('/kenaikan-kelas/proses', [App\Http\Controllers\KenaikanKelasController::class, 'proses'])->name('kenaikan-kelas.proses');
            Route::post('/kenaikan-kelas/preview', [App\Http\Controllers\KenaikanKelasController::class, 'preview'])->name('kenaikan-kelas.preview');
            Route::post('/kenaikan-kelas/up-all', [App\Http\Controllers\KenaikanKelasController::class, 'upAll'])->name('kenaikan-kelas.upAll');
            Route::get('/kenaikan-kelas/export-pdf', [App\Http\Controllers\KenaikanKelasController::class, 'exportPdf'])->name('kenaikan-kelas.exportPdf');
            Route::get('/kenaikan-kelas/export-excel', [App\Http\Controllers\KenaikanKelasController::class, 'exportExcel'])->name('kenaikan-kelas.exportExcel');

            // Alumni (Kurikulum)
            Route::get('/alumni', [App\Http\Controllers\Kurikulum\AlumniController::class, 'index'])->name('alumni.index');
            
            // Buku Induk Alumni (lebih spesifik, harus di atas)
            Route::get('/alumni/{siswa_id}/buku-induk/cetak', [App\Http\Controllers\Kurikulum\AlumniController::class, 'bukuIndukCetak'])->name('alumni.buku-induk.cetak');
            Route::get('/alumni/{siswa_id}/buku-induk', [App\Http\Controllers\Kurikulum\AlumniController::class, 'bukuInduk'])->name('alumni.buku-induk.show');
            
            // Raport Alumni (lebih spesifik, harus di atas)
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}/cetak', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporCetak'])->name('alumni.raport.cetak');
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporShow'])->name('alumni.raport.show');
            Route::get('/alumni/{siswa_id}/raport', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporList'])->name('alumni.raport.list');
            
            // Alumni by Jurusan
            Route::get('/alumni/jurusan/{jurusanId}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'byJurusan'])->name('alumni.by-jurusan');
            
            // Alumni Show (paling umum, harus di bawah)
            Route::get('/alumni/{id}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'show'])->where('id', '[0-9]+')->name('alumni.show');

            Route::get('/siswa', [KurikulumSiswaController::class, 'index'])
                ->name('siswa.index');

            // Import siswa (Excel) - show form and process
            Route::get('/siswa/import', [KurikulumSiswaController::class, 'importForm'])
                ->name('siswa.import.form');
            Route::post('/siswa/import', [KurikulumSiswaController::class, 'import'])
                ->name('siswa.import');

            // Data Siswa
            Route::get('/siswa/create', [KurikulumSiswaController::class, 'create'])
                ->name('data-siswa.create');

            Route::post('/siswa', [KurikulumSiswaController::class, 'store'])
                ->name('data-siswa.store');

            Route::get('/siswa/{id}', [KurikulumSiswaController::class, 'show'])
                ->name('data-siswa.show');

            Route::get('/siswa/{id}/edit', [KurikulumSiswaController::class, 'editDataDiri'])
                ->name('data-siswa.edit');

            Route::put('/siswa/{id}', [KurikulumSiswaController::class, 'update'])
                ->name('data-siswa.update');

            Route::delete('/siswa/{id}', [KurikulumSiswaController::class, 'destroy'])
                ->name('data-siswa.destroy');

            Route::get('/siswa/{id}/edit-password', [KurikulumSiswaController::class, 'edit'])
                ->name('siswa.edit');

            Route::get('/siswa/{id}/cetak', [KurikulumSiswaController::class, 'cetak'])
                ->name('siswa.cetak');

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

            Route::get('/rapor/{id}/{semester}/{tahun}/cetak', [App\Http\Controllers\Kurikulum\KurikulumRaportController::class, 'exportPdf'])
                ->name('rapor.cetak');

            Route::get('/rapor/{id}/{semester}/{tahun}/show', [App\Http\Controllers\Kurikulum\KurikulumRaportController::class, 'show_html'])
                ->name('rapor.show_html');

            // manajemen kelas
            Route::prefix('manajemen-kelas')->name('kelas.')->group(function () {
                Route::get('/', [KelasController::class, 'index'])->name('index'); // URL: /kurikulum/manajemen-kelas
                Route::get('/{id}/edit', [KelasController::class, 'edit'])->name('edit');
                Route::put('/{id}', [KelasController::class, 'update'])->name('update');
                Route::get('/{id}/export', [KelasController::class, 'export'])->name('export');
            });

            // ============================
            //  MANAGEMEN KELAS — EDIT
            // ============================

            Route::get('/manajemen-kelas/{id}/edit', [KelasController::class, 'edit'])
                ->name('kelas.edit');

            Route::put('/manajemen-kelas/{id}', [KelasController::class, 'update'])
                ->name('kelas.update');

            Route::get('/manajemen-kelas/{id}/export', [KelasController::class, 'export'])
                ->name('kelas.export');

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
            Route::get('/kelulusan', [KelulusanController::class, 'index'])
                ->name('kelulusan.index');
            Route::get('/kelulusan/rombel/{rombelId}/{tahun}', [KelulusanController::class, 'showRombel'])
                ->name('kelulusan.rombel.show');
        });

   // Debug route untuk cek nilai dan mata pelajaran
        if (config('app.debug')) {
    Route::get('/debug/nilai-raport', function () {
        // Cek dulu apakah class model ada agar tidak error fatal
        if (!class_exists('\App\Models\NilaiRaport')) {
            return "Model NilaiRaport tidak ditemukan.";
        }

        $nilaiCount = \App\Models\NilaiRaport::count();
        $siswaCount = \App\Models\DataSiswa::count();
        $mapelCount = \App\Models\MataPelajaran::count();
        
        // Gunakan try-catch agar jika relasi salah tidak langsung crash
        try {
            $nilaiSample = \App\Models\NilaiRaport::with('mapel')->limit(5)->get();
        } catch (\Exception $e) {
            $nilaiSample = "Error memuat relasi mapel: " . $e->getMessage();
        }

        $mapelWithoutKelompok = \App\Models\MataPelajaran::whereNull('kelompok')->orWhere('kelompok', '')->get();

        return view('debug.nilai-raport', compact('nilaiCount', 'siswaCount', 'mapelCount', 'nilaiSample', 'mapelWithoutKelompok'));
    });
}
});