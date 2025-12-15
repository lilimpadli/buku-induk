<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'nama_lengkap'     => 'required|string|max:255',
            'nisn'             => 'required|string|max:20|unique:data_siswa',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',

            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['nis'] = $user->nomor_induk;
        $data['user_id'] = $user->id;

        DataSiswa::create($data);

        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil disimpan.');
    }

    public function edit()
    {
        $siswa = $this->getSiswaLogin();

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
            'nama_lengkap'     => 'required|string|max:255',
            'nisn'             => 'required|string|max:20|unique:data_siswa,nisn,' . $siswa->id,
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',

            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
        ]);

        $siswa->update($request->all());

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

        // Hapus foto lama jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->foto = $path;
        $siswa->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * ============================
     *       RAPORT SISWA
     * ============================
     */

    // 🔹 Halaman list raport: daftar (semester & tahun)
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
        'kenaikan'
    ));
}

    // 🔹 Export raport ke PDF
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
        'kenaikan'
    ))->setPaper('A4', 'portrait');

    return $pdf->stream('Raport - ' . $siswa->nama_lengkap . ' - ' . $semester . ' - ' . $tahun . '.pdf');
}
    public function catatan()
    {
        $siswa = $this->getSiswaLogin();
        return view('siswa.catatan', compact('siswa'));
    }

    public function exportPDF()
    {
        $siswa = $this->getSiswaLogin();

        $pdf = Pdf::loadView('siswa.pdf', compact('siswa'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Data Diri - ' . $siswa->nama_lengkap . '.pdf');
    }
}