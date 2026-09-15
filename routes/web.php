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

// WALI KELAS ABSENSI
use App\Http\Controllers\WaliKelasAbsensiController;

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
use App\Http\Controllers\Kurikulum\TahunAjaranController;
use App\Http\Controllers\Kurikulum\SemesterController;

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
use App\Http\Controllers\CetakAbsensiController;
use App\Http\Controllers\TU\ClaverController;

// KAPROG
use App\Http\Controllers\Kaprog\KaprogDashboardController;
use App\Http\Controllers\PegawaiController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Route::get('/ppdb', [App\Http\Controllers\TU\PpdbController::class, 'index'])->name('ppdb.index');

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
            Route::put('/profile', [SiswaController::class, 'updateProfile'])->name('updateProfile');
            Route::put('/email', [SiswaController::class, 'updateEmail'])->name('updateEmail');
            Route::put('/password', [SiswaController::class, 'updatePassword'])->name('updatePassword');
            Route::post('/photo', [SiswaController::class, 'uploadPhoto'])->name('uploadPhoto');

            Route::get('/data-diri', [SiswaController::class, 'dataDiri'])->name('dataDiri');
            Route::get('/data-diri/create', [SiswaController::class, 'create'])->name('dataDiri.create');
            Route::post('/data-diri', [SiswaController::class, 'store'])->name('dataDiri.store');
            Route::get('/data-diri/edit', [SiswaController::class, 'edit'])->name('dataDiri.edit');
            Route::put('/data-diri', [SiswaController::class, 'update'])->name('dataDiri.update');
            Route::get('/data-diri/export-pdf', [SiswaController::class, 'exportPDF'])->name('dataDiri.exportPDF');

            Route::get('/raport', [SiswaController::class, 'raport'])->name('raport');
            Route::get('/raport/{semester}/{tahun}', [SiswaController::class, 'raportShow'])->name('raport.show');
            Route::get('/raport/{semester}/{tahun}/pdf', [SiswaController::class, 'raportPDF'])->name('raport.pdf');

            Route::get('/buku-induk', [SiswaController::class, 'bukuIndukShow'])->name('bukuInduk.show');
            Route::get('/buku-induk/cetak', [SiswaController::class, 'bukuIndukCetak'])->name('bukuInduk.cetak');

            Route::get('/catatan', [SiswaController::class, 'catatan'])->name('catatan');

            Route::post('/profile/photo', [SiswaController::class, 'uploadPhoto'])->name('profile.photo');
            Route::delete('/profile/photo', [SiswaController::class, 'deletePhoto'])->name('profile.photo.delete');

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

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Guru\GuruProfileController::class, 'show'])->name('index');
                Route::get('/edit', [\App\Http\Controllers\Guru\GuruProfileController::class, 'edit'])->name('edit');
                Route::put('/', [\App\Http\Controllers\Guru\GuruProfileController::class, 'update'])->name('update');
            });

            Route::prefix('kelas')->name('kelas.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Guru\GuruKelasController::class, 'index'])->name('index');
                Route::get('/{rombelId}', [\App\Http\Controllers\Guru\GuruKelasController::class, 'show'])->name('show');
                Route::get('/{rombelId}/mata-pelajaran', [\App\Http\Controllers\Guru\GuruKelasController::class, 'mataPelajaran'])->name('mata-pelajaran');
            });

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

            Route::get('/siswa/export-excel', [WaliKelasSiswaController::class, 'exportExcel'])
                ->name('siswa.exportExcel');

            Route::get('/siswa/{id}', [WaliKelasSiswaController::class, 'show'])
                ->name('siswa.show');

            Route::get('/siswa/{id}/export-pdf', [WaliKelasSiswaController::class, 'exportPdf'])
                ->name('siswa.exportPDF');

            // ============================================================
            // ABSENSI WALI KELAS
            // ============================================================
            Route::get('/absensi', [WaliKelasAbsensiController::class, 'index'])
                ->name('absensi.index');
            Route::post('/absensi/store', [WaliKelasAbsensiController::class, 'store'])
                ->name('absensi.store');
            Route::get('/absensi/rekap', [WaliKelasAbsensiController::class, 'rekap'])
                ->name('absensi.rekap');
            Route::get('/absensi/export-excel', [WaliKelasAbsensiController::class, 'exportExcel'])
                ->name('absensi.export-excel');
            Route::get('/absensi/{siswa_id}', [WaliKelasAbsensiController::class, 'show'])
                ->name('absensi.show');

            // ============================================================
            // WALI KELAS MANAGEMENT (via TU)
            // ============================================================
            Route::prefix('wali-kelas')->name('wali-kelas.')->group(function () {
                Route::get('/', [TUController::class, 'waliKelas'])->name('index');
                Route::get('/create', [TUController::class, 'waliKelasCreate'])->name('create');
                Route::post('/', [TUController::class, 'waliKelasStore'])->name('store');
                Route::get('/{id}', [TUController::class, 'waliKelasDetail'])->name('detail');
                Route::get('/{id}/edit', [TUController::class, 'waliKelasEdit'])->name('edit');
                Route::put('/{id}', [TUController::class, 'waliKelasUpdate'])->name('update');
                Route::delete('/{id}', [TUController::class, 'waliKelasDestroy'])->name('destroy');
            });

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

            Route::get('/nilai-raport/edit', [NilaiRaportController::class, 'edit'])
                ->name('nilai_raport.edit');

            Route::put('/nilai-raport/update', [NilaiRaportController::class, 'update'])
                ->name('nilai_raport.update');

            Route::get('/rapor/{siswa_id}/{semester}/{tahun}/cetak', [RaporController::class, 'cetakRapor'])
                ->name('rapor.cetak');

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

            Route::post('input-nilai-raport/{siswa_id}/delete', [InputNilaiRaportController::class, 'destroy'])
                ->name('input_nilai_raport.delete');

            Route::post('/input-nilai-raport/download-template', [InputNilaiRaportController::class, 'downloadTemplate'])
                ->name('input_nilai_raport.download_template');
            Route::post('/input-nilai-raport/import', [InputNilaiRaportController::class, 'import'])
                ->name('input_nilai_raport.import');

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

            Route::get('/dashboard', [KaprogController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/raport-siswa', [KaprogController::class, 'raportSiswa'])
                ->name('raport.siswa.old');

            Route::get('/siswa/{id}/detail', [KurikulumDashboardController::class, 'detail'])
                ->name('siswa.detail');

            Route::get('/kelas', [KelaskaprogController::class, 'index'])->name('kelas.index');
            Route::get('/kelas/{id}', [KelaskaprogController::class, 'show'])->name('kelas.show');
            Route::get('/kelas/angkatan/{tingkat}', [KelaskaprogController::class, 'angkatan'])->name('kelas.angkatan');
            Route::post('/kelas/siswa/{id}/lapor', [KelaskaprogController::class, 'lapor'])->name('kelas.siswa.lapor');

            Route::get('/guru', [KaprogGuruController::class, 'index'])->name('guru.index');
            Route::get('/guru/{id}', [KaprogGuruController::class, 'show'])->name('guru.show');

            Route::get('/data-diri', [KaprogController::class, 'dataDiri'])->name('datapribadi.index');
            Route::get('/data-diri/edit', [KaprogController::class, 'editDataDiri'])->name('datapribadi.edit');
            Route::put('/data-diri', [KaprogController::class, 'updateDataDiri'])->name('datapribadi.update');
            Route::get('/siswa', [KaprogController::class, 'siswaIndex'])->name('siswa.index');
            Route::get('/siswa/{id}', [KaprogController::class, 'show'])->name('siswa.show');
            Route::get('/siswa/{id}/export-data-diri', [KaprogController::class, 'exportDataDiri'])->name('siswa.export-data-diri');
            Route::get('/raport/siswa', [KaprogController::class, 'raportSiswa'])->name('raport.siswa');
            Route::get('/raport/siswa/{siswaId}/{semester}/{tahun}', [KaprogController::class, 'raportShow'])->name('raport.show');
            Route::get('/raport/siswa/{siswaId}/{semester}/{tahun}/cetak', [KaprogController::class, 'cetakRaport'])->name('raport.cetak');
            Route::get('/export/rombel/{rombelId}', [KaprogController::class, 'exportSiswaByRombel'])->name('export.rombel');
            Route::get('/export/jurusan/{jurusanId}', [KaprogController::class, 'exportSiswaByJurusan'])->name('export.jurusan');
            Route::get('/export/angkatan/{jurusanId}', [KaprogController::class, 'exportSiswaByAngkatan'])->name('export.angkatan');
        });

    Route::get('/raport', [KaprogController::class, 'raportSiswa'])->name('raport.index');

    Route::get('/siswa/{id}/detail', [KaprogDashboardController::class, 'detail'])
        ->name('siswa.detail');

    /*
    |--------------------------------------------------------------------------
    | TU (Tata Usaha)
    |--------------------------------------------------------------------------
    */
    Route::prefix('tu')
        ->name('tu.')
        ->middleware('role:tu')
        ->group(function () {

            // ============================================================
            // DASHBOARD & DATA PRIBADI
            // ============================================================
            Route::get('/dashboard', [TUController::class, 'dashboard'])->name('dashboard');

            Route::get('/data-pribadi', [DataPribadiController::class, 'index'])->name('data-pribadi.index');
            Route::get('/data-pribadi/edit', [DataPribadiController::class, 'edit'])->name('data-pribadi.edit');
            Route::put('/data-pribadi', [DataPribadiController::class, 'update'])->name('data-pribadi.update');

            // ============================================================
            // MANAJEMEN GURU
            // ============================================================
            Route::prefix('guru')->name('guru.')->group(function () {
                Route::get('/', [TUController::class, 'guruIndex'])->name('index');
                Route::get('/export', [TUController::class, 'exportGuru'])->name('export');
                Route::get('/create', [TUController::class, 'guruCreate'])->name('create');
                Route::post('/', [TUController::class, 'guruStore'])->name('store');
                Route::get('/{id}', [TUController::class, 'guruShow'])->name('show');
                Route::get('/{id}/edit', [TUController::class, 'guruEdit'])->name('edit');
                Route::put('/{id}', [TUController::class, 'guruUpdate'])->name('update');
                Route::delete('/{id}', [TUController::class, 'guruDestroy'])->name('destroy');
            });

            // ============================================================
            // MANAJEMEN SISWA
            // ============================================================
            Route::prefix('siswa')->name('siswa.')->group(function () {
                
                // 1. RUTE STATIS & CETAK CLAVER
                Route::prefix('claver')->name('cetak-claver.')->group(function () {
                    Route::get('/', [ClaverController::class, 'index'])->name('index');
                    Route::get('/preview', [ClaverController::class, 'preview'])->name('preview');
                    Route::get('/pdf', [ClaverController::class, 'cetakPdf'])->name('pdf');
                    Route::get('/excel', [ClaverController::class, 'exportExcel'])->name('excel');
                });

                // Export & Template Statis
                Route::get('/export', [TUController::class, 'exportSiswa'])->name('export');
                Route::get('/export/kelas', [TUController::class, 'exportByKelas'])->name('exportByKelas');
                Route::get('/export/jurusan', [TUController::class, 'exportByJurusan'])->name('exportByJurusan');
                Route::get('/export/aktif', [TUController::class, 'exportAktif'])->name('exportAktif');
                Route::get('/export/jurusan/{jurusanId}', [TUController::class, 'exportSiswaByJurusan'])->name('export.jurusan');
                Route::get('/export/angkatan/{jurusanId}', [TUController::class, 'exportSiswaByAngkatan'])->name('export.angkatan');

                // Import & Template
                Route::get('/template/download', [TUController::class, 'downloadSiswaTemplate'])->name('template.download');
                Route::post('/import', [TUController::class, 'importSiswa'])->name('import');

                // 2. INDEX & CREATE
                Route::get('/', [TUController::class, 'siswa'])->name('index');
                Route::get('/create', [TUController::class, 'siswaCreate'])->name('create');
                Route::post('/', [TUController::class, 'siswaStore'])->name('store');

                // 3. RUTE DINAMIS DENGAN PARAMETER {id}
                Route::get('/{id}', [TUController::class, 'siswaDetail'])->name('detail');
                Route::get('/{id}/edit', [TUController::class, 'siswaEdit'])->name('edit');
                Route::put('/{id}', [TUController::class, 'siswaUpdate'])->name('update');
                Route::delete('/{id}', [TUController::class, 'siswaDestroy'])->name('destroy');
                Route::get('/{id}/raport', [TUController::class, 'siswaRaport'])->name('raport');
                Route::get('/{id}/export-pdf', [TUController::class, 'siswaExportPdf'])->name('exportPDF');
            });

            // ============================================================
            // MANAJEMEN KELAS
            // ============================================================
            Route::prefix('kelas')->name('kelas.')->group(function () {
                Route::get('/', [TUController::class, 'kelas'])->name('index');
                Route::get('/create', [TUController::class, 'kelasCreate'])->name('create');
                Route::post('/', [TUController::class, 'kelasStore'])->name('store');
                
                Route::get('/export-all', [TUController::class, 'exportKelasAll'])->name('exportAll');
                Route::get('/template', [TUController::class, 'downloadKelasTemplate'])->name('template');
                Route::post('/import', [TUController::class, 'importKelas'])->name('import');

                Route::get('/{id}', [TUController::class, 'kelasShow'])->name('show');
                Route::get('/{id}/edit', [TUController::class, 'kelasEdit'])->name('edit');
                Route::put('/{id}', [TUController::class, 'kelasUpdate'])->name('update');
                Route::delete('/{id}', [TUController::class, 'kelasDestroy'])->name('destroy');
                Route::get('/{id}/export', [TUController::class, 'kelasExport'])->name('export');
                Route::get('/{id}/cetak-absensi', [TUController::class, 'printAbsensi'])->name('print-absensi');
            });

            // ============================================================
            // LAPORAN
            // ============================================================
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/nilai', [TUController::class, 'laporanNilai'])->name('nilai');
                Route::get('/biodata-all', [TUController::class, 'cetakBiodataAll'])->name('biodata-all');
                Route::get('/daftar-hadir-rapot', [TUController::class, 'cetakDaftarHadirRapot'])->name('daftar-hadir-rapot');
                Route::get('/surat-aktif/{siswa_id}', [TUController::class, 'cetakSuratAktif'])->name('surat-aktif');
            });

            // ============================================================
            // BUKU INDUK
            // ============================================================
            Route::prefix('buku-induk')->name('buku-induk.')->group(function () {
                Route::get('/', [BukuIndukController::class, 'index'])->name('index');
                Route::get('/{siswa}', [BukuIndukController::class, 'show'])->name('show');
                Route::get('/{siswa}/edit', [BukuIndukController::class, 'edit'])->name('edit');
                Route::put('/{siswa}', [BukuIndukController::class, 'update'])->name('update');
                Route::get('/{siswa}/cetak', [BukuIndukController::class, 'cetak'])->name('cetak');
                Route::get('/{siswa}/export', [BukuIndukController::class, 'export'])->name('export');

                Route::get('/export/siswa', [BukuIndukController::class, 'exportSiswa'])->name('export.siswa');
                Route::get('/export/nilai', [BukuIndukController::class, 'exportNilai'])->name('export.nilai');
                Route::get('/export/pkl', [BukuIndukController::class, 'exportPkl'])->name('export.pkl');

                Route::post('/import/siswa', [BukuIndukController::class, 'importSiswa'])->name('import.siswa');
                Route::post('/import/nilai', [BukuIndukController::class, 'importNilai'])->name('import.nilai');
                Route::post('/import/pkl', [BukuIndukController::class, 'importPkl'])->name('import.pkl');

                Route::get('/template/siswa', [BukuIndukController::class, 'downloadTemplateSiswa'])->name('template.siswa');
                Route::get('/template/nilai', [BukuIndukController::class, 'downloadTemplateNilai'])->name('template.nilai');
                Route::get('/template/pkl', [BukuIndukController::class, 'downloadTemplatePkl'])->name('template.pkl');
                Route::get('/template/pkl-ijazah', [BukuIndukController::class, 'downloadTemplatePklIjazah'])->name('template.pkl-ijazah');

                Route::post('/template/nilai-filtered', [BukuIndukController::class, 'downloadTemplateNilaiFiltered'])->name('template.nilai.filtered');
            });

            // ============================================================
            // CLAVER - BUKU INDUK SISWA (TU)
            // ============================================================
            Route::prefix('siswa/claver')->name('siswa.cetak-claver.')->group(function () {
                Route::get('/', [ClaverController::class, 'index'])->name('index');
                Route::get('/preview', [ClaverController::class, 'preview'])->name('preview');
                Route::get('/pdf', [ClaverController::class, 'cetakPdf'])->name('pdf');
                Route::get('/excel', [ClaverController::class, 'exportExcel'])->name('excel');
            });

            // ============================================================
            // MUTASI SISWA
            // ============================================================
            Route::prefix('mutasi')->name('mutasi.')->group(function () {
                Route::get('/', [MutasiController::class, 'index'])->name('index');
                Route::get('/create', [MutasiController::class, 'create'])->name('create');
                Route::post('/', [MutasiController::class, 'store'])->name('store');
                Route::get('/search', [MutasiController::class, 'searchStudents'])->name('search');
                Route::post('/siswa/update', [MutasiController::class, 'updateSiswa'])->name('siswa.update');
                Route::post('/bulk', [MutasiController::class, 'bulk'])->name('bulk');
                Route::post('/up-all', [MutasiController::class, 'upAll'])->name('up-all');
                Route::get('/laporan', [MutasiController::class, 'laporan'])->name('laporan');
                Route::get('/kelas/{id}', [MutasiController::class, 'kelasByJurusan'])->name('kelas');
                Route::get('/kelas/show/{rombel}', [MutasiController::class, 'showRombel'])->name('kelas.show');
                Route::get('/{mutasi}', [MutasiController::class, 'show'])->name('show');
                Route::get('/{mutasi}/edit', [MutasiController::class, 'edit'])->name('edit');
                Route::put('/{mutasi}', [MutasiController::class, 'update'])->name('update');
                Route::delete('/{mutasi}', [MutasiController::class, 'destroy'])->name('destroy');
            });

            // ============================================================
            // NILAI RAPORT
            // ============================================================
            Route::prefix('nilai-raport')->name('nilai_raport.')->group(function () {
                Route::get('/', [TUController::class, 'nilaiRaportIndex'])->name('index');
                Route::get('/list/{id}', [TUController::class, 'siswaRaport'])->name('list');
                Route::get('/show', [TUController::class, 'nilaiRaportShow'])->name('show');
                Route::get('/edit', [TUController::class, 'nilaiRaportEdit'])->name('edit');
                Route::put('/update', [TUController::class, 'nilaiRaportUpdate'])->name('update');
                Route::delete('/delete', [TUController::class, 'nilaiRaportDestroy'])->name('destroy');
            });

            // ============================================================
            // ALUMNI
            // ============================================================
            Route::prefix('alumni')->name('alumni.')->group(function () {
                Route::get('/', [AlumniController::class, 'index'])->name('index');
                Route::get('/jurusan/{jurusanId?}', [AlumniController::class, 'byJurusan'])->name('by-jurusan');
                Route::get('/{siswa_id}/buku-induk', [AlumniController::class, 'bukuInduk'])->name('buku-induk.show');
                Route::get('/{siswa_id}/buku-induk/cetak', [AlumniController::class, 'bukuIndukCetak'])->name('buku-induk.cetak');
                Route::get('/{siswa_id}/raport', [AlumniController::class, 'raporList'])->name('raport.list');
                Route::get('/{siswa_id}/raport/{semester}/{tahun}', [AlumniController::class, 'raporShow'])->name('raport.show');
                Route::get('/{siswa_id}/raport/{semester}/{tahun}/cetak', [AlumniController::class, 'raporCetak'])->name('raport.cetak');
                Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
            });

            // ============================================================
            // KELULUSAN
            // ============================================================
            Route::prefix('kelulusan')->name('kelulusan.')->group(function () {
                Route::get('/', [KelulusanController::class, 'index'])->name('index');
                Route::get('/rombel/{rombelId}/{tahun}', [KelulusanController::class, 'showRombel'])->name('rombel.show');
            });

        });

    /*
    |--------------------------------------------------------------------------
    | TU KEPEGAWAIAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('tu_kepegawaian')
        ->name('tu_kepegawaian.')
        ->middleware(['auth'])
        ->group(function () {
            
            // Dashboard
            Route::get('/dashboard', [TUKepegawaianController::class, 'dashboard'])->name('dashboard');

            // Administrasi
            Route::get('/administrasi', function () {
                return view('tu_kepegawaian.administrasi.index');
            })->name('administrasi.index');

            // ===== DATA GURU - PAKAI GURU CONTROLLER =====
            Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
            Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
            Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
            Route::get('/guru/template', [GuruController::class, 'template'])->name('guru.template');
            Route::post('/guru/import', [GuruController::class, 'import'])->name('guru.import');

            // ===== CETAK & EXPORT ABSENSI GURU =====
            Route::get('/test-cetak-absensi', [CetakAbsensiController::class, 'index'])
                ->name('guru.index_absensi');

            Route::post('/guru/cetak-absensi', [CetakAbsensiController::class, 'cetak'])
                ->name('guru.cetak_absensi');

            Route::get('/guru/absensi-harian', [CetakAbsensiController::class, 'absensiHarian'])
                ->name('guru.absensi_harian');

            Route::get('/guru/absensi-kegiatan', [CetakAbsensiController::class, 'absensiKegiatan'])
                ->name('guru.absensi_kegiatan');

            Route::get('/guru/excel-absensi/preview', [CetakAbsensiController::class, 'previewExcel'])
                ->name('guru.excel_absensi.preview');

            Route::get('/guru/excel-absensi', [CetakAbsensiController::class, 'exportExcel'])
                ->name('guru.excel_absensi');

            // ===== CETAK & EXPORT ABSENSI PEGAWAI (TU) =====
            Route::get('/tu/absensi-harian-pegawai', [CetakAbsensiController::class, 'absensiHarianPegawai'])
                ->name('tu.absensi_harian_pegawai');

            Route::get('/tu/absensi-kegiatan-pegawai', [CetakAbsensiController::class, 'absensiKegiatanPegawai'])
                ->name('tu.absensi_kegiatan_pegawai');

            // ===== CETAK ABSENSI KEGIATAN GABUNGAN (GURU + PEGAWAI) =====
            Route::get('/absensi-kegiatan-semua', [CetakAbsensiController::class, 'absensiKegiatanSemua'])
                ->name('absensi_kegiatan_semua');

            Route::get('/guru/{id}', [GuruController::class, 'show'])->name('guru.show');
            Route::get('/guru/{id}/edit', [GuruController::class, 'edit'])->name('guru.edit');
            Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
            Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

            // ===== DATA TU/PEGAWAI - PAKAI TU KEPEGAWAIAN CONTROLLER =====
            Route::get('/tu', [TUKepegawaianController::class, 'tuIndex'])->name('tu.index');
            Route::get('/tu/create', [TUKepegawaianController::class, 'tuCreate'])->name('tu.create');
            Route::post('/tu', [TUKepegawaianController::class, 'tuStore'])->name('tu.store');
            Route::get('/tu/template', [TUKepegawaianController::class, 'tuTemplate'])->name('tu.template');
            Route::post('/tu/import', [TUKepegawaianController::class, 'tuImport'])->name('tu.import');
            Route::get('/tu/{id}', [TUKepegawaianController::class, 'tuShow'])->name('tu.show');
            Route::get('/tu/{id}/edit', [TUKepegawaianController::class, 'tuEdit'])->name('tu.edit');
            Route::put('/tu/{id}', [TUKepegawaianController::class, 'tuUpdate'])->name('tu.update');
            Route::delete('/tu/{id}', [TUKepegawaianController::class, 'tuDestroy'])->name('tu.destroy');

            // ===== KURIKULUM =====
            Route::get('/kurikulum', [TUKepegawaianController::class, 'kurikulumIndex'])->name('kurikulum.index');
            Route::get('/kurikulum/create', [TUKepegawaianController::class, 'kurikulumCreate'])->name('kurikulum.create');
            Route::post('/kurikulum', [TUKepegawaianController::class, 'kurikulumStore'])->name('kurikulum.store');
            Route::get('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumShow'])->name('kurikulum.show');
            Route::get('/kurikulum/{id}/edit', [TUKepegawaianController::class, 'kurikulumEdit'])->name('kurikulum.edit');
            Route::put('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumUpdate'])->name('kurikulum.update');
            Route::delete('/kurikulum/{id}', [TUKepegawaianController::class, 'kurikulumDestroy'])->name('kurikulum.destroy');

            // ===== MATA PELAJARAN =====
            Route::get('/mata-pelajaran', [TUKepegawaianController::class, 'mataPelajaranIndex'])->name('mata-pelajaran.index');
            Route::get('/mata-pelajaran/create', [TUKepegawaianController::class, 'mataPelajaranCreate'])->name('mata-pelajaran.create');
            Route::post('/mata-pelajaran', [TUKepegawaianController::class, 'mataPelajaranStore'])->name('mata-pelajaran.store');
            Route::get('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranShow'])->name('mata-pelajaran.show');
            Route::get('/mata-pelajaran/{id}/edit', [TUKepegawaianController::class, 'mataPelajaranEdit'])->name('mata-pelajaran.edit');
            Route::put('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranUpdate'])->name('mata-pelajaran.update');
            Route::delete('/mata-pelajaran/{id}', [TUKepegawaianController::class, 'mataPelajaranDestroy'])->name('mata-pelajaran.destroy');

            // ===== DOKUMEN =====
            Route::get('/dokumen', [TUKepegawaianController::class, 'dokumen'])->name('dokumen.index');
            Route::get('/dokumen/create', [TUKepegawaianController::class, 'dokumenCreate'])->name('dokumen.create');
            Route::post('/dokumen/store', [TUKepegawaianController::class, 'dokumenStore'])->name('dokumen.store');

            // ===== RIWAYAT KERJA =====
            Route::get('/riwayat', [TUKepegawaianController::class, 'riwayatIndex'])->name('riwayat.index');
            Route::post('/riwayat', [TUKepegawaianController::class, 'riwayatStore'])->name('riwayat.store');
            Route::put('/riwayat/{id}', [TUKepegawaianController::class, 'riwayatUpdate'])->name('riwayat.update');
            Route::delete('/riwayat/{id}', [TUKepegawaianController::class, 'riwayatDestroy'])->name('riwayat.destroy');

            // ===== MUTASI =====
            Route::get('/mutasi', [TUKepegawaianController::class, 'mutasiIndex'])->name('mutasi.index');
            Route::get('/mutasi/create', [TUKepegawaianController::class, 'mutasiCreate'])->name('mutasi.create');
            Route::post('/mutasi', [TUKepegawaianController::class, 'mutasiStore'])->name('mutasi.store');
            Route::get('/mutasi/laporan', [TUKepegawaianController::class, 'mutasiLaporan'])->name('mutasi.laporan');
            Route::get('/mutasi/{id}/edit', [TUKepegawaianController::class, 'mutasiEdit'])->name('mutasi.edit');
            Route::put('/mutasi/{id}', [TUKepegawaianController::class, 'mutasiUpdate'])->name('mutasi.update');
            Route::delete('/mutasi/{id}', [TUKepegawaianController::class, 'mutasiDestroy'])->name('mutasi.destroy');
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

            Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])
                ->name('dashboard');

            // USER MANAGEMENT
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'usersIndex'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'create'])->name('create');
                Route::post('/', [SuperAdminController::class, 'store'])->name('store');
                Route::get('/{id}', [SuperAdminController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [SuperAdminController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SuperAdminController::class, 'update'])->name('update');
                Route::delete('/{id}', [SuperAdminController::class, 'destroy'])->name('destroy');
            });

            // SYSTEM
            Route::get('/system', [SuperAdminController::class, 'systemIndex'])->name('system.index');
            Route::post('/system/clear-cache', [SuperAdminController::class, 'clearCache'])->name('system.clear_cache');
            Route::post('/system/optimize', [SuperAdminController::class, 'optimizeSystem'])->name('system.optimize');
            Route::post('/system/backup', [SuperAdminController::class, 'backupDatabase'])->name('system.backup_database');
            Route::post('/system/toggle-maintenance', [SuperAdminController::class, 'toggleMaintenance'])->name('system.toggle_maintenance');

            // MANAJEMEN GURU
            Route::prefix('manajemen-guru')->name('manajemen-guru.')->group(function () {
                Route::get('/', [ManajemenGuruController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenGuruController::class, 'create'])->name('create');
                Route::post('/', [ManajemenGuruController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenGuruController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenGuruController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenGuruController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenGuruController::class, 'destroy'])->name('destroy');

                Route::get('/import', [ManajemenGuruController::class, 'importForm'])->name('importForm');
                Route::get('/import/template', [ManajemenGuruController::class, 'downloadTemplate'])->name('import.template');
                Route::post('/import', [ManajemenGuruController::class, 'import'])->name('import');
                Route::get('/export', [ManajemenGuruController::class, 'exportExcel'])->name('export');
            });

            // MANAJEMEN JURUSAN
            Route::prefix('manajemen-jurusan')->name('manajemen-jurusan.')->group(function () {
                Route::get('/', [ManajemenJurusanController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenJurusanController::class, 'create'])->name('create');
                Route::post('/', [ManajemenJurusanController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenJurusanController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenJurusanController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenJurusanController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenJurusanController::class, 'destroy'])->name('destroy');
            });

            // MANAJEMEN KELAS
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

            // MANAJEMEN KURIKULUM
            Route::prefix('manajemen-kurikulum')->name('manajemen-kurikulum.')->group(function () {
                Route::get('/', [ManajemenKurikulumController::class, 'index'])->name('index');
                Route::get('/create', [ManajemenKurikulumController::class, 'create'])->name('create');
                Route::post('/', [ManajemenKurikulumController::class, 'store'])->name('store');
                Route::get('/{id}', [ManajemenKurikulumController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ManajemenKurikulumController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ManajemenKurikulumController::class, 'update'])->name('update');
                Route::delete('/{id}', [ManajemenKurikulumController::class, 'destroy'])->name('destroy');
            });

            // MANAJEMEN SISWA
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

            // Data Pribadi
            Route::get('/data-pribadi', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'index'])
                ->name('data-pribadi.index');
            Route::get('/data-pribadi/edit', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'edit'])
                ->name('data-pribadi.edit');
            Route::put('/data-pribadi', [App\Http\Controllers\Kurikulum\DataPribadiController::class, 'update'])
                ->name('data-pribadi.update');

            // Guru management
            Route::get('/guru', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])
                ->name('guru.index');

            // Wali Kelas Mapping
            Route::prefix('wali-kelas-mapping')
                ->name('wali-kelas-mapping.')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\Kurikulum\WaliKelasMappingController::class, 'index'])
                        ->name('index');
                    Route::post('/update', [\App\Http\Controllers\Kurikulum\WaliKelasMappingController::class, 'update'])
                        ->name('update');
                    Route::post('/update-massal', [\App\Http\Controllers\Kurikulum\WaliKelasMappingController::class, 'updateMassal'])
                        ->name('update-massal');
                });

            // Bidang Keahlian
            Route::prefix('bidang-keahlian')->name('bidang-keahlian.')->group(function () {
                Route::get('/', [BidangKeahlianController::class, 'index'])->name('index');
                Route::get('/create', [BidangKeahlianController::class, 'create'])->name('create');
                Route::post('/', [BidangKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [BidangKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [BidangKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [BidangKeahlianController::class, 'update'])->name('update');
                Route::delete('/{id}', [BidangKeahlianController::class, 'destroy'])->name('destroy');
            });

            // Konsentrasi Keahlian
            Route::prefix('konsentrasi-keahlian')->name('konsentrasi-keahlian.')->group(function () {
                Route::get('/', [KonsentrasiKeahlianController::class, 'index'])->name('index');
                Route::get('/create', [KonsentrasiKeahlianController::class, 'create'])->name('create');
                Route::post('/', [KonsentrasiKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [KonsentrasiKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [KonsentrasiKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [KonsentrasiKeahlianController::class, 'update'])->name('update');
                Route::delete('/{id}', [KonsentrasiKeahlianController::class, 'destroy'])->name('destroy');
            });

            // Program Keahlian
            Route::prefix('program-keahlian')->name('program-keahlian.')->group(function () {
                Route::get('/', [ProgramKeahlianController::class, 'index'])->name('index');
                Route::get('/create', [ProgramKeahlianController::class, 'create'])->name('create');
                Route::post('/', [ProgramKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [ProgramKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ProgramKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ProgramKeahlianController::class, 'update'])->name('update');
                Route::delete('/{id}', [ProgramKeahlianController::class, 'destroy'])->name('destroy');
            });

            // ============================================================
            // MASTER DATA: TAHUN AJARAN  ← DIPINDAH KE DALAM GRUP KURIKULUM
            // ============================================================
            Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
                Route::get('/', [TahunAjaranController::class, 'index'])->name('index');
                Route::get('/create', [TahunAjaranController::class, 'create'])->name('create');
                Route::post('/', [TahunAjaranController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [TahunAjaranController::class, 'edit'])->name('edit');
                Route::put('/{id}', [TahunAjaranController::class, 'update'])->name('update');
                Route::delete('/{id}', [TahunAjaranController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/set-current', [TahunAjaranController::class, 'setCurrent'])->name('set-current');
                Route::post('/{id}/toggle-active', [TahunAjaranController::class, 'toggleActive'])->name('toggle-active');
            });

            // ============================================================
            // MASTER DATA: SEMESTER  ← DIPINDAH KE DALAM GRUP KURIKULUM
            // ============================================================
            Route::prefix('semester')->name('semester.')->group(function () {
                Route::get('/', [SemesterController::class, 'index'])->name('index');
                Route::get('/create', [SemesterController::class, 'create'])->name('create');
                Route::post('/', [SemesterController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SemesterController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SemesterController::class, 'update'])->name('update');
                Route::delete('/{id}', [SemesterController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/set-active', [SemesterController::class, 'setActive'])->name('set-active');
                Route::post('/{id}/toggle-active', [SemesterController::class, 'toggleActive'])->name('toggle-active');
            });

            // Guru import
            Route::get('/guru/import', [App\Http\Controllers\Kurikulum\GuruController::class, 'importForm'])
                ->name('guru.importForm');
            Route::get('/guru/import/template', [App\Http\Controllers\Kurikulum\GuruController::class, 'downloadTemplate'])
                ->name('guru.import.template');
            Route::post('/guru/import', [App\Http\Controllers\Kurikulum\GuruController::class, 'import'])
                ->name('guru.import');
            Route::get('/guru/export', [App\Http\Controllers\Kurikulum\GuruController::class, 'exportExcel'])
                ->name('guru.export');

            Route::prefix('guru/manage')->name('guru.manage.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\GuruController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\GuruController::class, 'store'])->name('store');
                Route::get('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\GuruController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\GuruController::class, 'destroy'])->name('destroy');
            });

            // Kurikulum Management
            Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'store'])->name('store');
                Route::get('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\KurikulumController::class, 'destroy'])->name('destroy');
            });

            // Mata Pelajaran
            Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
                Route::get('/', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'edit'])->name('edit');
                Route::put('/{id}', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Kurikulum\MataPelajaranController::class, 'destroy'])->name('destroy');
            });

            // Buku Induk
            Route::get('/buku-induk', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'index'])->name('buku-induk.index');
            Route::get('/buku-induk/{siswa}', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'show'])->name('buku-induk.show');
            Route::get('/buku-induk/{siswa}/cetak', [App\Http\Controllers\Kurikulum\BukuIndukController::class, 'cetak'])->name('buku-induk.cetak');

            // Mutasi
            Route::get('/mutasi/laporan', [App\Http\Controllers\Kurikulum\MutasiController::class, 'laporan'])->name('mutasi.laporan');
            Route::resource('/mutasi', App\Http\Controllers\Kurikulum\MutasiController::class)->names('mutasi');

            // Kenaikan Kelas
            Route::get('/kenaikan-kelas', [App\Http\Controllers\KenaikanKelasController::class, 'index'])->name('kenaikan-kelas.index');
            Route::post('/kenaikan-kelas/proses', [App\Http\Controllers\KenaikanKelasController::class, 'proses'])->name('kenaikan-kelas.proses');
            Route::post('/kenaikan-kelas/preview', [App\Http\Controllers\KenaikanKelasController::class, 'preview'])->name('kenaikan-kelas.preview');
            Route::post('/kenaikan-kelas/up-all', [App\Http\Controllers\KenaikanKelasController::class, 'upAll'])->name('kenaikan-kelas.upAll');
            Route::get('/kenaikan-kelas/export-pdf', [App\Http\Controllers\KenaikanKelasController::class, 'exportPdf'])->name('kenaikan-kelas.exportPdf');
            Route::get('/kenaikan-kelas/export-excel', [App\Http\Controllers\KenaikanKelasController::class, 'exportExcel'])->name('kenaikan-kelas.exportExcel');

            // Alumni
            Route::get('/alumni', [App\Http\Controllers\Kurikulum\AlumniController::class, 'index'])->name('alumni.index');
            Route::get('/alumni/{siswa_id}/buku-induk/cetak', [App\Http\Controllers\Kurikulum\AlumniController::class, 'bukuIndukCetak'])->name('alumni.buku-induk.cetak');
            Route::get('/alumni/{siswa_id}/buku-induk', [App\Http\Controllers\Kurikulum\AlumniController::class, 'bukuInduk'])->name('alumni.buku-induk.show');
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}/cetak', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporCetak'])->name('alumni.raport.cetak');
            Route::get('/alumni/{siswa_id}/raport/{semester}/{tahun}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporShow'])->name('alumni.raport.show');
            Route::get('/alumni/{siswa_id}/raport', [App\Http\Controllers\Kurikulum\AlumniController::class, 'raporList'])->name('alumni.raport.list');
            Route::get('/alumni/jurusan/{jurusanId}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'byJurusan'])->name('alumni.by-jurusan');
            Route::get('/alumni/{id}', [App\Http\Controllers\Kurikulum\AlumniController::class, 'show'])->where('id', '[0-9]+')->name('alumni.show');

            // Data Siswa
            Route::get('/siswa', [KurikulumSiswaController::class, 'index'])
                ->name('siswa.index');

            Route::get('/siswa/import', [KurikulumSiswaController::class, 'importForm'])
                ->name('siswa.import.form');
            Route::post('/siswa/import', [KurikulumSiswaController::class, 'import'])
                ->name('siswa.import');

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

            // Kelas
            Route::get('/kelas/create', [KelasController::class, 'create'])
                ->name('kelas.create');

            Route::post('/kelas', [KelasController::class, 'store'])
                ->name('kelas.store');

            Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])
                ->name('kelas.destroy');

            Route::get('/kelas/{rombel}', [KelasController::class, 'show'])->name('kelas.show');

            // Rapor Siswa
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

            // Manajemen Kelas
            Route::prefix('manajemen-kelas')->name('kelas.')->group(function () {
                Route::get('/', [KelasController::class, 'index'])->name('index');
                Route::get('/{id}/edit', [KelasController::class, 'edit'])->name('edit');
                Route::put('/{id}', [KelasController::class, 'update'])->name('update');
                Route::get('/{id}/export', [KelasController::class, 'export'])->name('export');
            });

            Route::get('/manajemen-kelas/{id}/edit', [KelasController::class, 'edit'])
                ->name('kelas.edit');

            Route::put('/manajemen-kelas/{id}', [KelasController::class, 'update'])
                ->name('kelas.update');

            Route::get('/manajemen-kelas/{id}/export', [KelasController::class, 'export'])
                ->name('kelas.export');

            // Jurusan
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

            // Kelulusan & Alumni
            Route::get('/kelulusan', [KelulusanController::class, 'index'])
                ->name('kelulusan.index');
            Route::get('/kelulusan/rombel/{rombelId}/{tahun}', [KelulusanController::class, 'showRombel'])
                ->name('kelulusan.rombel.show');
        });

    // Debug route untuk cek nilai dan mata pelajaran
    if (config('app.debug')) {
        Route::get('/debug/nilai-raport', function () {
            if (!class_exists('\App\Models\NilaiRaport')) {
                return "Model NilaiRaport tidak ditemukan.";
            }

            $nilaiCount = \App\Models\NilaiRaport::count();
            $siswaCount = \App\Models\DataSiswa::count();
            $mapelCount = \App\Models\MataPelajaran::count();
            
            try {
                $nilaiSample = \App\Models\NilaiRaport::with('mapel')->limit(5)->get();
            } catch (\Exception $e) {
                $nilaiSample = "Error memuat relasi mapel: " . $e->getMessage();
            }

            $mapelWithoutKelompok = \App\Models\MataPelajaran::whereNull('kelompok')->orWhere('kelompok', '')->get();

            return view('debug.nilai-raport', compact('nilaiCount', 'siswaCount', 'mapelCount', 'nilaiSample', 'mapelWithoutKelompok'));
        });
    }

    // Test Cetak Absensi
    Route::get('/test-cetak-absensi', [App\Http\Controllers\CetakAbsensiController::class, 'index'])
        ->name('test.cetak.absensi');

    Route::get('/test-cetak-absensi/proses', [App\Http\Controllers\CetakAbsensiController::class, 'cetak'])
        ->name('test.cetak.absensi.proses');
});