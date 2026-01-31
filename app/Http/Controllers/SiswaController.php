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
            'alamat'           => 'required|string',
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
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'ayah_id' => $ayah->id,
            'ibu_id' => $ibu->id,
            'wali_id' => $wali ? $wali->id : null,
        ]);

        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil disimpan.');
    }

    public function edit()
    {
        $siswa = $this->getSiswaLogin();
        // Load relasi orang tua
        $siswa->load(['ayah', 'ibu', 'wali']);

        if (!$siswa) {
            return redirect()->route('siswa.dataDiri.create')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('siswa.data-diri-edit', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = $this->getSiswaLogin();

        $request->validate([
            // Data siswa
            'nama_lengkap'     => 'required|string|max:255',
            'nisn'             => 'required|string|max:20|unique:data_siswa,nisn,' . $siswa->id,
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'status_keluarga'  => 'required|string|max:50',
            'anak_ke'          => 'required|integer|min:1',
            'sekolah_asal'     => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'alamat'           => 'required|string',
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

        // Update data siswa
        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'status_keluarga' => $request->status_keluarga,
            'anak_ke' => $request->anak_ke,
            'sekolah_asal' => $request->sekolah_asal,
            'tanggal_diterima' => $request->tanggal_diterima,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        // Update data ayah
        if ($siswa->ayah_id) {
            $ayah = Ayah::find($siswa->ayah_id);
            $ayah->update([
                'nama' => $request->nama_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'telepon' => $request->telepon_ayah,
                'alamat' => $request->alamat_ayah,
            ]);
        } else {
            $ayah = Ayah::create([
                'nama' => $request->nama_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'telepon' => $request->telepon_ayah,
                'alamat' => $request->alamat_ayah,
            ]);
            $siswa->ayah_id = $ayah->id;
            $siswa->save();
        }

        // Update data ibu
        if ($siswa->ibu_id) {
            $ibu = Ibu::find($siswa->ibu_id);
            $ibu->update([
                'nama' => $request->nama_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'telepon' => $request->telepon_ibu,
                'alamat' => $request->alamat_ibu,
            ]);
        } else {
            $ibu = Ibu::create([
                'nama' => $request->nama_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'telepon' => $request->telepon_ibu,
                'alamat' => $request->alamat_ibu,
            ]);
            $siswa->ibu_id = $ibu->id;
            $siswa->save();
        }

        // Update data wali jika ada
        if ($request->filled('nama_wali')) {
            if ($siswa->wali_id) {
                $wali = Wali::find($siswa->wali_id);
                $wali->update([
                    'nama' => $request->nama_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'telepon' => $request->telepon_wali,
                    'alamat' => $request->alamat_wali,
                ]);
            } else {
                $wali = Wali::create([
                    'nama' => $request->nama_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'telepon' => $request->telepon_wali,
                    'alamat' => $request->alamat_wali,
                ]);
                $siswa->wali_id = $wali->id;
                $siswa->save();
            }
        } elseif ($siswa->wali_id) {
            // Hapus data wali jika ada sebelumnya tapi sekarang dikosongkan
            Wali::destroy($siswa->wali_id);
            $siswa->wali_id = null;
            $siswa->save();
        }

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

        // Simpan pada disk `public` di folder `siswa_photos`

        $path = $request->file('foto')->store('siswa_photos', 'public');

        // Hapus foto lama jika ada (pada table siswa)
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        // Simpan path pada model DataSiswa
        $siswa->foto = $path;
        $siswa->save();

        // Juga sinkronkan ke kolom `photo` pada tabel users agar sidebar menampilkan foto
        $user = Auth::user();
        if ($user) {
            // Hapus foto lama pada users jika berbeda dan ada
            if (!empty($user->photo) && $user->photo !== $path && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
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

    public function exportPDF()
    {
        $siswa = $this->getSiswaLogin();
        // Load relasi orang tua
        $siswa->load(['ayah', 'ibu', 'wali']);

        $pdf = Pdf::loadView('siswa.pdf', compact('siswa'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Data Diri - ' . $siswa->nama_lengkap . '.pdf');
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
}