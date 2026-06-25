<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class SiswaController extends Controller
{
    /**
     * Mendapatkan data siswa milik user yang login
     */
    private function getSiswaLogin()
    {
        $user = Auth::user();
        return DataSiswa::where('nis', $user->nomor_induk)->first();
    }

    /**
     * Menampilkan halaman data diri siswa
     */
    public function dataDiri()
    {
       $siswa = $this->getSiswaLogin();

        // Jika tidak ada data siswa, arahkan ke form pembuatan data diri
        if (! $siswa) {
            return redirect()->route('siswa.dataDiri.create')
                ->with('info', 'Silakan lengkapi data diri siswa terlebih dahulu.');
        }

        // Load relasi orang tua
        $siswa->load(['ayah', 'ibu', 'wali']);

        return view('siswa.data-diri', compact('siswa'));
    }

    /**
     * Dashboard siswa — ringkasan data penting agar tidak kosong
     */
    public function dashboard()
    {
        $siswa = $this->getSiswaLogin();

        // Load relasi mutasi untuk checking status alumni
        if ($siswa) {
            $siswa->load(['mutasiTerakhir', 'rombel.kelas.jurusan', 'user']);
            
            // Jika siswa adalah alumni (status = lulus), tampilkan halaman alumni
            if ($siswa->mutasiTerakhir && $siswa->mutasiTerakhir->status === 'lulus') {
                return view('siswa.dashboard-alumni', compact('siswa'));
            }
        }

        // Ambil daftar tahun_ajaran unik untuk raport
        $raportYears = [];
        if ($siswa) {
            $raportYears = NilaiRaport::select('tahun_ajaran')
                ->where('siswa_id', $siswa->id)
                ->groupBy('tahun_ajaran')
                ->orderBy('tahun_ajaran', 'desc')
                ->pluck('tahun_ajaran')
                ->toArray();
        }

        // cek kelengkapan profil (field penting)
        $required = ['nama_lengkap','nisn','tempat_lahir','tanggal_lahir','agama','alamat','no_hp'];
        $missing = [];
        if ($siswa) {
            foreach ($required as $f) {
                if (empty($siswa->{$f})) {
                    $missing[] = $f;
                }
            }
        }

        return view('siswa.dashboard', compact('siswa','raportYears','missing'));
    }

    public function create()
    {
        return view('siswa.data-diri-create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // Data siswa
            'nama_lengkap'     => 'required|string|max:255',
            'nisn'             => 'required|string|max:20|unique:data_siswa',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'kewarganegaraan'  => 'required|string|max:100',
            'dusun'            => 'required|string|max:255',
            'rt'               => 'required|string|max:10',
            'rw'               => 'required|string|max:10',
            'kelurahan'        => 'required|string|max:255',
            'kecamatan'        => 'required|string|max:255',
            'kode_pos'         => 'required|string|max:10',
            'no_hp'            => 'required|string|max:20',

            // Data Ayah
            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',
            'alamat_ayah'      => 'required|string',

            // Data Ibu
            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',
            'alamat_ibu'       => 'required|string',

            // Data Wali (opsional)
            'nama_wali'        => 'nullable|string|max:255',
            'pekerjaan_wali'   => 'nullable|string|max:255',
            'telepon_wali'     => 'nullable|string|max:20',
            'alamat_wali'      => 'nullable|string',
        ]);

        // Simpan data ayah
        $ayah = Ayah::create([
            'nama' => $request->nama_ayah,
            'pekerjaan' => $request->pekerjaan_ayah,
            'telepon' => $request->telepon_ayah,
            'alamat' => $request->alamat_ayah,
        ]);

        // Simpan data ibu
        $ibu = Ibu::create([
            'nama' => $request->nama_ibu,
            'pekerjaan' => $request->pekerjaan_ibu,
            'telepon' => $request->telepon_ibu,
            'alamat' => $request->alamat_ibu,
        ]);

        // Simpan data wali jika ada
        $wali = null;
        if ($request->filled('nama_wali')) {
            $wali = Wali::create([
                'nama' => $request->nama_wali,
                'pekerjaan' => $request->pekerjaan_wali,
                'telepon' => $request->telepon_wali,
                'alamat' => $request->alamat_wali,
            ]);
        }

        // Simpan data siswa
        $siswa = DataSiswa::create([
            'user_id' => $user->id,
            'nis' => $user->nomor_induk,
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'kewarganegaraan' => $request->kewarganegaraan,
            'dusun' => $request->dusun,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kode_pos' => $request->kode_pos,
            'no_hp' => $request->no_hp,
            'ayah_id' => $ayah->id,
            'ibu_id' => $ibu->id,
            'wali_id' => $wali ? $wali->id : null,
        ]);

        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil disimpan.');
    }

    /**
     * TAMPILKAN FORM EDIT (Mendukung Multi-Role Siswa & TU)
     */
    public function edit($id = null)
    {
        // Jika tidak ada ID di URL, berarti ini siswa yang coba-coba masuk ke halaman edit
        if (!$id) {
            return redirect()->route('siswa.dashboard')->with('error', 'Siswa tidak memiliki hak akses untuk mengubah data Buku Induk.');
        }

        // Jika ada ID, berarti Admin/TU yang sedang mengakses data siswa tersebut
        $siswa = DataSiswa::find($id);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Arahkan Admin/TU ke halaman edit khusus admin
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * PROSES SIMPAN EDIT DATA SISWA & ORANG TUA
     */
    public function update(Request $request, $id = null)
    {
        // 1. Tentukan siapa yang sedang di-update (TU atau Siswa sendiri)
        if ($id) {
            // Jika ada ID, berarti yang nge-edit adalah TU
            $siswa = DataSiswa::findOrFail($id);
        } else {
            // Jika tidak ada ID, berarti siswa sedang nge-edit datanya sendiri via dashboard siswa
            $siswa = $this->getSiswaLogin();
        }

        // 2. Jalankan Validasi yang fleksibel (nullable) agar tidak saling mengunci
        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nis'              => 'nullable|string|max:50',
            'nisn'             => 'nullable|string|max:20|unique:data_siswa,nisn,' . $siswa->id,
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|string|max:50',
            'no_hp'            => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'tanggal_diterima' => 'nullable|date',
            'email'            => 'nullable|email',

            // Data orang tua dari form
            'ayah_nama'        => 'nullable|string|max:255',
            'ayah_pekerjaan'   => 'nullable|string|max:255',
            'ayah_telepon'     => 'nullable|string|max:20',

            'ibu_nama'         => 'nullable|string|max:255',
            'ibu_pekerjaan'    => 'nullable|string|max:255',
            'ibu_telepon'      => 'nullable|string|max:20',

            'wali_nama'        => 'nullable|string|max:255',
            'wali_pekerjaan'   => 'nullable|string|max:255',
            'wali_telepon'     => 'nullable|string|max:20',
            'wali_alamat'      => 'nullable|string',
        ]);

        // 3. Eksekusi Update ke satu tabel tunggal (data_siswa)
        $siswa->update([
            'nama_lengkap'     => $request->nama_lengkap,
            'nis'              => $request->nis,
            'nisn'             => $request->nisn,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'agama'            => $request->agama,
            'no_hp'            => $request->no_hp,
            'alamat'           => $request->alamat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'email'            => $request->email,

            // Simpan langsung ke kolom tabel data_siswa kamu yang asli
            'nama_ayah'        => $request->ayah_nama,
            'pekerjaan_ayah'   => $request->ayah_pekerjaan,
            'telepon_ayah'     => $request->ayah_telepon,

            'nama_ibu'         => $request->ibu_nama,
            'pekerjaan_ibu'    => $request->ibu_pekerjaan,
            'telepon_ibu'      => $request->ibu_telepon,

            'nama_wali'        => $request->wali_nama,
            'pekerjaan_wali'   => $request->wali_pekerjaan,
            'telepon_wali'     => $request->wali_telepon,
            'alamat_wali'      => $request->wali_alamat,
        ]);

        // 4. Redirect cerdas berdasarkan siapa yang melakukan update
        if ($id) {
            // Kalau TU yang ubah, balikkan ke detail siswa di menu TU
            return redirect()->to('/tu/siswa/' . $siswa->id)
                ->with('success', 'Data siswa dan orang tua berhasil diperbarui oleh TU.');
        }

        // Kalau siswa yang ubah diri sendiri, balikkan ke halaman data diri siswa
        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil diperbarui.');
    }

   /**
     * Upload / update foto profil siswa
     */
    public function uploadPhoto(Request $request)
    {
        $siswa = $this->getSiswaLogin();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // 1. HAPUS FOTO LAMA TERLEBIH DAHULU (Sebelum ditimpa path baru)
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // 2. BARU SIMPAN FOTO BARU KE STORAGE
            $path = $request->file('foto')->store('siswa_photos', 'public');

            // 3. SIMPAN PATH BARU KE MODEL SISWA
            $siswa->foto = $path;
            $siswa->save();

            // 4. SINKRONKAN KE TABEL USERS (Untuk Sidebar)
            $user = Auth::user();
            if ($user) {
                // Hapus foto lama di user jika ada dan berbeda
                if (!empty($user->photo) && $user->photo !== $path && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $user->photo = $path;
                $user->save();
            }

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memproses file foto.');
    }


    /**
     * Hapus foto profil siswa
     */
    public function deletePhoto(Request $request)
    {
        $siswa = $this->getSiswaLogin();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Hapus file foto siswa jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->foto = null;
        $siswa->save();

        // Sinkronkan juga kolom photo pada users
        $user = Auth::user();
        if ($user) {
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * ============================
     *       RAPORT SISWA
     * ============================
     */

    // 🔹 Halaman list raport: daftar (tahun ajaran)
    public function raport()
    {
        $siswa = $this->getSiswaLogin();

        // Ubah query untuk hanya mengambil tahun ajaran unik
        $raports = NilaiRaport::select('tahun_ajaran')
            ->where('siswa_id', $siswa->id)
            ->groupBy('tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->get();

        return view('siswa.raport.raport', compact('siswa', 'raports'));
    }

    // 🔹 Halaman detail raport lengkap
    public function raportShow($semester, $tahun)
    {
        $siswa = $this->getSiswaLogin();
        // jika $tahun dikirimkan dari URL sebagai '2025-2026', konversi kembali ke '2025/2026'
        $tahun = str_replace('-', '/', $tahun);

        // Validasi semester
        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            return redirect()->route('siswa.raport')
                ->with('error', 'Semester tidak valid');
        }

        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        // Cek apakah ada data raport
        if ($nilaiRaports->isEmpty()) {
            return redirect()->route('siswa.raport')
                ->with('error', 'Data raport untuk semester ' . $semester . ' tahun ajaran ' . $tahun . ' tidak ditemukan');
        }

        // derive historical kelas/rombel from nilaiRaports if available
        $kelasRaport = null;
        $rombelRaport = null;
        $firstRaport = $nilaiRaports->first();
        if ($firstRaport) {
            if (isset($firstRaport->kelas) && $firstRaport->kelas) {
                $kelasRaport = $firstRaport->kelas;
            }
            if (isset($firstRaport->rombel) && $firstRaport->rombel) {
                $rombelRaport = $firstRaport->rombel;
            }
        }

        if (!$kelasRaport && $siswa->rombel && $siswa->rombel->kelas) {
            $kelasRaport = $siswa->rombel->kelas;
        }
        if (!$rombelRaport && $siswa->rombel) {
            $rombelRaport = $siswa->rombel;
        }

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        return view('siswa.raport.show', compact(
            'siswa',
            'semester',
            'tahun',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'info',
            'kenaikan',
            'kelasRaport',
            'rombelRaport'
        ));
    }

    // 🔹 Export raport ke PDF
    public function raportPDF($semester, $tahun)
    {
        $siswa = $this->getSiswaLogin();
        // jika $tahun dikirimkan dari URL sebagai '2025-2026', konversi kembali ke '2025/2026'
        $tahun = str_replace('-', '/', $tahun);

        // Validasi semester
        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            return redirect()->route('siswa.raport')
                ->with('error', 'Semester tidak valid');
        }

        $nilaiRaports = NilaiRaport::with(['mapel', 'rombel'])
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        // Cek apakah ada data raport
        if ($nilaiRaports->isEmpty()) {
            return redirect()->route('siswa.raport')
                ->with('error', 'Data raport untuk semester ' . $semester . ' tahun ajaran ' . $tahun . ' tidak ditemukan');
        }

        // Dapatkan rombel dari data raport (sesuai dengan raport yang sedang dicetak)
        $rombelRaport = $nilaiRaports->first()?->rombel;

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $info = RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $pdf = Pdf::loadView('siswa.raport.pdf', compact(
            'siswa',
            'semester',
            'tahun',
            'nilaiRaports',
            'ekstra',
            'kehadiran',
            'info',
            'kenaikan',
            'rombelRaport'
        ))->setPaper('A4', 'portrait');

        // filename for Content-Disposition must not contain '/' or '\\', sanitize it
        $safeTahun = str_replace(["/", "\\"], '-', $tahun);
        $filename = 'Raport - ' . $siswa->nama_lengkap . ' - ' . $semester . ' - ' . $safeTahun . '.pdf';

        return $pdf->stream($filename);
    }

    public function catatan()
    {
        $siswa = $this->getSiswaLogin();
        return view('siswa.catatan', compact('siswa'));
    }

    /**
     * Menampilkan Buku Induk Siswa (untuk siswa sendiri)
     */
   public function bukuIndukShow()
{
    $siswa = $this->getSiswaLogin();

    $siswa->load([
        'user', 
        'rombel.kelas.jurusan',
        'mutasis',
        'ayah',
        'ibu',
        'wali',
        'nilaiRaports' => function($query) {
            // Kita urutkan tahun DESC agar tahun paling baru (2025) ada di urutan pertama
            $query->with('mapel')->orderBy('tahun_ajaran', 'desc')->orderBy('semester');
        }
    ]);
    
    // Ambil daftar tahun yang unik dari nilai siswa
    $daftarTahun = $siswa->nilaiRaports->pluck('tahun_ajaran')->unique()->values();
    
    $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
    
    return view('siswa.buku-induk-show', compact('siswa', 'nilaiByKelompok', 'daftarTahun'));
}
    /**
     * Helper function untuk group nilai by kelompok
     */
    private function groupNilaiByKelompok($siswa)
{
    $nilaiByKelompok = [];
    $semesterMap = ['Ganjil' => 1, 'Genap' => 2, 1 => 1, 2 => 2];
    
    // PERBAIKAN: Ambil daftar tahun dari database dan urutkan dari tahun masuk (paling lama)
    $tahunAjaranList = $siswa->nilaiRaports
        ->pluck('tahun_ajaran')
        ->unique()
        ->sort() // Mengurutkan dari tahun lama ke baru (2023 -> 2024 -> 2025)
        ->values()
        ->toArray();
    
    $mapelByKelompok = $this->getMataPelajaranByJurusan($siswa);
    
    foreach ($mapelByKelompok as $kelompok => $mapels) {
        if (!isset($nilaiByKelompok[$kelompok])) {
            $nilaiByKelompok[$kelompok] = [];
        }
        
        foreach ($mapels as $mapel) {
            $mapelNama = $mapel['nama'];
            $nilaiByKelompok[$kelompok][$mapelNama] = [
                'nama' => $mapelNama,
                'urutan' => $mapel['urutan'],
                'nilai' => []
            ];
            
            foreach ($tahunAjaranList as $tahunAjaran) {
                $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [1 => null, 2 => null];
            }
        }
    }
    
    foreach ($siswa->nilaiRaports as $nilai) {
        $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
        $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
        $tahunAjaran = $nilai->tahun_ajaran;
        $semester = $semesterMap[$nilai->semester] ?? $nilai->semester;
        
        if (!isset($nilaiByKelompok[$kelompok][$mapelNama])) {
            $nilaiByKelompok[$kelompok][$mapelNama] = [
                'nama' => $mapelNama,
                'urutan' => $nilai->mapel->urutan ?? 999,
                'nilai' => []
            ];
        }
        
        if (!isset($nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran])) {
            $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran] = [1 => null, 2 => null];
        }
        
        $nilaiByKelompok[$kelompok][$mapelNama]['nilai'][$tahunAjaran][$semester] = $nilai->nilai_akhir;
    }
    
    $sortedKelompok = [];
    foreach (['A', 'B'] as $k) {
        if (isset($nilaiByKelompok[$k])) { $sortedKelompok[$k] = $nilaiByKelompok[$k]; }
    }
    foreach ($nilaiByKelompok as $k => $v) {
        if (!isset($sortedKelompok[$k])) { $sortedKelompok[$k] = $v; }
    }
    
    foreach ($sortedKelompok as &$mapelGroup) {
        uasort($mapelGroup, function ($a, $b) {
            if ($a['urutan'] == $b['urutan']) return strcmp($a['nama'], $b['nama']);
            return $a['urutan'] - $b['urutan'];
        });
    }
    
    return [
        'byKelompok' => $sortedKelompok,
        'tahunAjaranList' => $tahunAjaranList
    ];
}

    /**
     * Get tahun ajaran list based on student's class level
     */
  private function getTahunAjaranList($siswa)
{
    // 1. Tentukan tahun ajaran saat ini
    $currentMonth = date('n');
    $currentYear = date('Y');
    $tahunSekarang = $currentMonth < 7 ? $currentYear - 1 : $currentYear;
    
    // 2. Ambil tingkat siswa (10, 11, atau 12)
    $tingkat = $siswa->rombel && $siswa->rombel->kelas ? intval($siswa->rombel->kelas->tingkat) : 10;
    
    // 3. HITUNG TAHUN MASUK SECARA MATEMATIS
    // Jika kelas 10, tahun masuk = tahunSekarang.
    // Jika kelas 11, tahun masuk = tahunSekarang - 1.
    // Jika kelas 12, tahun masuk = tahunSekarang - 2.
    $tahunMasuk = $tahunSekarang - ($tingkat - 10);
    
    // 4. Generate 3 Tahun Ajaran (Mulai dari tahun masuk)
    $tahunAjaranList = [];
    for ($i = 0; $i < 3; $i++) {
        $startYear = $tahunMasuk + $i;
        $endYear = $startYear + 1;
        $tahunAjaranList[] = "{$startYear}/{$endYear}";
    }
    
    return $tahunAjaranList;
}

    /**
     * Get mata pelajaran by jurusan and kelompok
     */
    private function getMataPelajaranByJurusan($siswa)
    {
        $mapelByKelompok = [];
        
        // First priority: Get from jurusan if siswa has one
        if ($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan) {
            $jurusanId = $siswa->rombel->kelas->jurusan->id;
            
            // Get all mata pelajaran for this specific jurusan (via many-to-many relationship)
            $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($jurusanId) {
                                       $q->where('jurusan_id', $jurusanId);
                                   })
                                   ->orderBy('kelompok')
                                   ->orderBy('urutan')
                                   ->get();
            
            if ($mapels->count() > 0) {
                foreach ($mapels as $mapel) {
                    $kelompok = $mapel->kelompok;
                    $mapelNama = trim($mapel->nama);
                    
                    if (!isset($mapelByKelompok[$kelompok])) {
                        $mapelByKelompok[$kelompok] = [];
                    }
                    
                    // Check if this mapel name already exists in this kelompok
                    $exists = false;
                    foreach ($mapelByKelompok[$kelompok] as $existing) {
                        if (trim($existing['nama']) === $mapelNama) {
                            $exists = true;
                            break;
                        }
                    }
                    
                    if (!$exists) {
                        $mapelByKelompok[$kelompok][] = [
                            'nama' => $mapelNama,
                            'urutan' => $mapel->urutan,
                        ];
                    }
                }
            }
        }
        
        // Second priority: If no mapel from jurusan, get from nilai raport
        if (empty($mapelByKelompok) && $siswa->nilaiRaports->count() > 0) {
            foreach ($siswa->nilaiRaports as $nilai) {
                $kelompok = trim($nilai->mapel->kelompok ?? 'Lainnya');
                $mapelNama = trim($nilai->mapel->nama ?? 'Tidak Diketahui');
                $mapelUrutan = $nilai->mapel->urutan ?? 999;
                
                if (!isset($mapelByKelompok[$kelompok])) {
                    $mapelByKelompok[$kelompok] = [];
                }
                
                // Check if already added
                $exists = false;
                foreach ($mapelByKelompok[$kelompok] as $existing) {
                    if (trim($existing['nama']) === $mapelNama) {
                        $exists = true;
                        break;
                    }
                }
                
                if (!$exists) {
                    $mapelByKelompok[$kelompok][] = [
                        'nama' => $mapelNama,
                        'urutan' => $mapelUrutan,
                    ];
                }
            }
        }
        
        // Third priority: If still empty and no jurusan, use first jurusan as fallback placeholder
        if (empty($mapelByKelompok) && !($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan)) {
            $firstJurusan = Jurusan::first();
            if ($firstJurusan) {
                $mapels = MataPelajaran::whereHas('jurusans', function($q) use ($firstJurusan) {
                                           $q->where('jurusan_id', $firstJurusan->id);
                                       })
                                       ->orderBy('kelompok')
                                       ->orderBy('urutan')
                                       ->get();
                
                if ($mapels->count() > 0) {
                    foreach ($mapels as $mapel) {
                        $kelompok = $mapel->kelompok;
                        $mapelNama = trim($mapel->nama);
                        
                        if (!isset($mapelByKelompok[$kelompok])) {
                            $mapelByKelompok[$kelompok] = [];
                        }
                        
                        // Check if this mapel name already exists
                        $exists = false;
                        foreach ($mapelByKelompok[$kelompok] as $existing) {
                            if (trim($existing['nama']) === $mapelNama) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if (!$exists) {
                            $mapelByKelompok[$kelompok][] = [
                                'nama' => $mapelNama,
                                'urutan' => $mapel->urutan,
                            ];
                        }
                    }
                }
            }
        }
        
        // Sort each kelompok by urutan and nama
        foreach ($mapelByKelompok as &$mapels) {
            usort($mapels, function ($a, $b) {
                if ($a['urutan'] == $b['urutan']) {
                    return strcmp($a['nama'], $b['nama']);
                }
                return $a['urutan'] - $b['urutan'];
            });
        }
        
        // Sort kelompok
        $sortedKelompok = [];
        foreach (['A', 'B'] as $k) {
            if (isset($mapelByKelompok[$k])) {
                $sortedKelompok[$k] = $mapelByKelompok[$k];
            }
        }
        foreach ($mapelByKelompok as $k => $v) {
            if (!isset($sortedKelompok[$k])) {
                $sortedKelompok[$k] = $v;
            }
        }
        
        return $sortedKelompok;
    }
public function exportPDF() // Atau apapun nama fungsinya
{
    // 1. Ambil data siswa yang sedang login
    $siswa = $this->getSiswaLogin();
    if (!$siswa) {
        return "Error: Data siswa tidak ditemukan.";
    }

    // 2. Load relasi yang diperlukan (pastikan nilaiRaports dan mapel di-load)
    $siswa->load(['nilaiRaports.mapel']);

    // 3. PANGGIL FUNGSI DINAMIS (Ini kuncinya!)
    // Fungsi ini sudah otomatis menghitung tahun ajaran berdasarkan data riwayat siswa
    $dataNilai = $this->groupNilaiByKelompok($siswa);

    // 4. Masukkan ke PDF
    // Kita kirim $dataNilai['byKelompok'] dan $dataNilai['tahunAjaranList']
    $pdf = Pdf::loadView('siswa.pdf', [
        'siswa' => $siswa,
        'nilaiByKelompok' => $dataNilai['byKelompok'],
        'tahunAjaranList' => $dataNilai['tahunAjaranList'] // Sekarang tahunnya dinamis!
    ]);

    return $pdf->stream('Buku_Induk_' . $siswa->nis . '.pdf');
}

    /**
 * Update profil siswa (nama)
 */
public function updateProfile(Request $request)
{
    $siswa = $this->getSiswaLogin();
    
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
    ]);
    
    $siswa->update([
        'nama_lengkap' => $request->nama_lengkap,
    ]);
    
    return redirect()->route('siswa.dashboard')->with('success', 'Nama berhasil diperbarui.');
}

/**
 * Update email user
 */
public function updateEmail(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'current_password' => 'required|string',
    ]);
    
    // Verifikasi password saat ini
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
    }
    
    $user->update([
        'email' => $request->email,
    ]);
    
    return redirect()->route('siswa.dashboard')->with('success', 'Email berhasil diperbarui.');
}

/**
 * Update password user
 */
public function updatePassword(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    // Verifikasi password saat ini
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
    }
    
    $user->update([
        'password' => Hash::make($request->password),
    ]);
    
    return redirect()->route('siswa.dashboard')->with('success', 'Password berhasil diperbarui.');
}

/**
 * Menampilkan versi cetak Buku Induk Siswa
 */
public function bukuIndukCetak()
{
    $siswa = $this->getSiswaLogin();

    // Load relasi yang diperlukan untuk buku induk cetak
    $siswa->load([
        'user', 
        'rombel.kelas.jurusan',
        'ayah',
        'ibu',
        'wali',
        'mutasis', 
        'mutasiTerakhir',
        'nilaiRaports' => function($query) {
            $query->with('mapel')
                  ->orderBy('tahun_ajaran')
                  ->orderBy('semester');
        }
    ]);
    
    // Group nilai by kelompok and nama mata pelajaran
    $nilaiByKelompok = $this->groupNilaiByKelompok($siswa);
    
    return view('siswa.buku-induk-cetak', compact('siswa', 'nilaiByKelompok'));
}

// ... baris-baris kode fungsi kamu yang lama (misal: exportPDF, dll) ...

    // TARUH COPIAN KODE INDEX DI SINI (Sebelum tanda kurung kurawal penutup class)
    public function index()
    {
        // Ambil data siswa yang sedang login beserta seluruh relasi pentingnya
        $siswa = DataSiswa::with(['rombel.guru', 'ayah', 'ibu', 'wali'])
                    ->where('user_id', Auth::id())
                    ->orWhere('nis', Auth::user()->username)
                    ->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data profil siswa tidak ditemukan.');
        }

        return view('siswa.dashboard', compact('siswa'));
    }

} // <--- Ini kurung kurawal penutup akhir file controller, pastikan fungsi index ada di atasnya

