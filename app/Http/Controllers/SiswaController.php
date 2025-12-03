<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Halaman create data diri
     */
    public function create()
    {
        return view('siswa.data-diri-create');
    }

    /**
     * Store data siswa
     */
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
            'status_keluarga'  => 'nullable|string|max:100',
            'anak_ke'          => 'nullable|integer',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',
            'sekolah_asal'     => 'nullable|string|max:255',
            'kelas'            => 'required|string|max:50',
            'tanggal_diterima' => 'nullable|date',

            // Orang tua
            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',

            // Wali
            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
        ]);

        // Auto set NIS dari user login
        $data = $request->all();
        $data['nis'] = $user->nomor_induk;
        $data['user_id'] = $user->id;

        DataSiswa::create($data);

        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil disimpan.');
    }

    /**
     * Halaman edit data diri
     */
    public function edit()
    {
        $siswa = $this->getSiswaLogin();

        if (!$siswa) {
            return redirect()->route('siswa.dataDiri.create')
                ->with('error', 'Data siswa tidak ditemukan, silakan isi terlebih dahulu.');
        }

        return view('siswa.data-diri-edit', compact('siswa'));
    }

    /**
     * Update data diri siswa
     */
    public function update(Request $request)
    {
        $siswa = $this->getSiswaLogin();

        if (!$siswa) {
            return redirect()->route('siswa.dataDiri.create')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nisn'             => 'required|string|max:20|unique:data_siswa,nisn,' . $siswa->id,
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'status_keluarga'  => 'nullable|string|max:100',
            'anak_ke'          => 'nullable|integer',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',
            'sekolah_asal'     => 'nullable|string|max:255',
            'kelas'            => 'required|string|max:50',
            'tanggal_diterima' => 'nullable|date',

            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',

            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.dataDiri')
            ->with('success', 'Data diri berhasil diperbarui.');
    }

    /**
     * Raport siswa
     */
    public function raport()
    {
        $siswa = $this->getSiswaLogin();
        return view('siswa.raport', compact('siswa'));
    }

    /**
     * Catatan wali kelas
     */
    public function catatan()
    {
        $siswa = $this->getSiswaLogin();
        return view('siswa.catatan', compact('siswa'));
    }
public function exportPDF()
{
    $siswa = $this->getSiswaLogin();

    if (!$siswa) {
        return redirect()->route('siswa.dataDiri')
            ->with('error', 'Data siswa belum diisi.');
    }

    $pdf = Pdf::loadView('siswa.pdf', compact('siswa'))
                ->setPaper('A4', 'portrait');

    return $pdf->stream('Data Diri - '.$siswa->nama_lengkap.'.pdf');
}
    
}

