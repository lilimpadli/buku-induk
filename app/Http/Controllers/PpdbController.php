<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\Ppdb;
use App\Models\SesiPpdb;
use App\Models\JalurPpdb;
use App\Models\DataSiswa;
use App\Models\Jurusan;

class PpdbController extends Controller
{
    // =========================
    // HALAMAN PILIH SESI & JALUR
    // =========================
    public function index()
    {
        return view('ppdb.index', [
            'sesis'  => SesiPpdb::orderBy('tahun_ajaran', 'desc')->get(),
            'jalurs' => JalurPpdb::orderBy('nama_jalur')->get(),
        ]);
    }

    // =========================
    // FORM INPUT PPDB
    // =========================
    public function create(Request $request)
    {
        return view('ppdb.create', [
            'sesi'        => $request->filled('sesi')  ? SesiPpdb::find($request->sesi)  : null,
            'jalur'       => $request->filled('jalur') ? JalurPpdb::find($request->jalur) : null,
            'datasiswas'  => DataSiswa::orderBy('nama_lengkap')->get(),
            'jurusans'    => Jurusan::orderBy('nama')->get(),
        ]);
    }

    // =========================
    // SIMPAN DATA PPDB
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nisn'           => 'nullable|string|max:30',
            'jenis_kelamin'  => 'required|in:L,P,Laki-laki,Perempuan',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',

            'jalur_ppdb_id'  => 'required|exists:jalur_ppdb,id',
            'sesi_ppdb_id'   => 'required|exists:sesi_ppdb,id',

            'jurusan_id'     => 'nullable|exists:jurusans,id',
            'kelas_id'       => 'nullable|exists:kelas,id',
            'rombel_id'      => 'nullable|exists:rombels,id',

            'tanggal_diterima' => 'nullable|date',

            'nama_ayah'      => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu'       => 'nullable|string|max:255',
            'pekerjaan_ibu'  => 'nullable|string|max:255',
        ]);

        // =========================
        // NORMALISASI ENUM JK
        // =========================
        if ($validated['jenis_kelamin'] === 'L') {
            $validated['jenis_kelamin'] = 'Laki-laki';
        } elseif ($validated['jenis_kelamin'] === 'P') {
            $validated['jenis_kelamin'] = 'Perempuan';
        }

        // =========================
        // SIMPAN DATA (tangkap error agar terlihat di UI)
        // =========================
        try {
            Ppdb::create(array_merge($validated, [
                'status' => 'diterima',
            ]));

            return redirect()
                ->route('ppdb.index')
                ->with('success', 'Data PPDB berhasil disimpan.');

        } catch (Throwable $e) {
            Log::error('PPDB store failed: ' . $e->getMessage(), [
                'input' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // =========================
    // AJAX AUTOFILL DATA ORANG TUA
    // =========================
    public function fetchDataSiswa($id)
    {
        $s = DataSiswa::findOrFail($id);

        return response()->json([
            'nama_ayah'       => $s->nama_ayah,
            'pekerjaan_ayah'  => $s->pekerjaan_ayah,
            'nama_ibu'        => $s->nama_ibu,
            'pekerjaan_ibu'   => $s->pekerjaan_ibu,
            'alamat_orangtua' => $s->alamat_orangtua,
            'no_hp'           => $s->no_hp,
        ]);
    }
}
