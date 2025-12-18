<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ppdb;
use App\Models\Rombel;
use App\Models\DataSiswa;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use Illuminate\Support\Facades\DB;

class PpdbController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $ppdb = Ppdb::when($q, function($qry) use ($q){
            $qry->where('nama_lengkap', 'like', "%{$q}%")
                ->orWhere('nisn', 'like', "%{$q}%");
        })->whereNull('rombel_id')->latest()->paginate(15)->withQueryString();

        return view('tu.ppdb.index', compact('ppdb', 'q'));
    }

    public function show($id)
    {
        $entry = Ppdb::findOrFail($id);

        // If PPDB provided jurusan_id, prefer rombels in that jurusan
        $rombels = Rombel::when($entry->jurusan_id, function($q) use ($entry){
            $q->whereHas('kelas', function($k) use ($entry){
                $k->where('jurusan_id', $entry->jurusan_id);
            });
        })->get();

        return view('tu.ppdb.show', compact('entry', 'rombels'));
    }

    public function assign(Request $request, $id)
    {
        $entry = Ppdb::findOrFail($id);

        $data = $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
        ]);

        $rombel = Rombel::findOrFail($data['rombel_id']);

        // generate NIS: take max numeric NIS in data_siswa and increment
        $max = DataSiswa::whereNotNull('nis')->max(DB::raw('CAST(nis AS UNSIGNED)'));
        $next = ($max ? intval($max) + 1 : intval(date('Y')) * 1000 + 1);
        $nis = str_pad($next, 6, '0', STR_PAD_LEFT);

        // create parent records (ayah/ibu/wali) if provided in PPDB
        $ayahId = null; $ibuId = null; $waliId = null;

        if (!empty($entry->nama_ayah) || !empty($entry->pekerjaan_ayah) || !empty($entry->telepon_ayah)) {
            $ayah = Ayah::create([
                'nama' => $entry->nama_ayah,
                'pekerjaan' => $entry->pekerjaan_ayah ?? null,
                'telepon' => $entry->telepon_ayah ?? null,
                'alamat' => $entry->alamat_orangtua ?? null,
            ]);
            $ayahId = $ayah->id;
        }

        if (!empty($entry->nama_ibu) || !empty($entry->pekerjaan_ibu) || !empty($entry->telepon_ibu)) {
            $ibu = Ibu::create([
                'nama' => $entry->nama_ibu,
                'pekerjaan' => $entry->pekerjaan_ibu ?? null,
                'telepon' => $entry->telepon_ibu ?? null,
                'alamat' => $entry->alamat_orangtua ?? null,
            ]);
            $ibuId = $ibu->id;
        }

        if (!empty($entry->nama_wali) || !empty($entry->telepon_wali) || !empty($entry->alamat_wali)) {
            $wali = Wali::create([
                'nama' => $entry->nama_wali,
                'pekerjaan' => $entry->pekerjaan_wali ?? null,
                'telepon' => $entry->telepon_wali ?? null,
                'alamat' => $entry->alamat_wali ?? null,
            ]);
            $waliId = $wali->id;
        }

        // create DataSiswa record
        $siswa = DataSiswa::create([
            'nama_lengkap' => $entry->nama_lengkap,
            'nis' => $nis,
            'nisn' => $entry->nisn,
            'tempat_lahir' => $entry->tempat_lahir,
            'tanggal_lahir' => $entry->tanggal_lahir,
            'jenis_kelamin' => $entry->jenis_kelamin,
            'alamat' => $entry->alamat,
            'sekolah_asal' => $entry->sekolah_asal ?? null,
            'tanggal_diterima' => $entry->tanggal_diterima ?? now()->toDateString(),
            'rombel_id' => $rombel->id,
            'kelas' => $rombel->kelas->tingkat ?? null,
            'ayah_id' => $ayahId,
            'ibu_id' => $ibuId,
            'wali_id' => $waliId,
        ]);

        // update PPDB entry to mark assigned
        $entry->update([
            'rombel_id' => $rombel->id,
            'kelas_id' => $rombel->kelas_id,
            'status' => 'aktif'
        ]);

        return redirect()->route('tu.ppdb.index')->with('success', "PPDB terassign ke rombel {$rombel->nama} dan NIS dibuat: {$nis}");
    }
}
