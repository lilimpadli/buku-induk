<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\RuangKelas;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['rombel', 'mataPelajaran', 'guru', 'ruangKelas', 'jamPelajaran', 'tahunAjaran', 'semester']);

        // Filter berdasarkan rombel
        if ($request->filled('rombel_id')) {
            $query->where('rombel_id', $request->rombel_id);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_ke')->get();

        // Data untuk filter - HAPUS 'jurusan' KARENA TIDAK ADA
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        $semesters = Semester::with('tahunAjaran')->orderBy('tahun_ajaran_id', 'desc')->get();
        $rombels = Rombel::with('kelas')->orderBy('nama')->get(); // HANYA 'kelas'

        // Group jadwal berdasarkan hari untuk tampilan
        $jadwalGrouped = $jadwals->groupBy('hari');

        return view('kurikulum.jadwal_pelajaran.index', compact('jadwals', 'jadwalGrouped', 'tahunAjarans', 'semesters', 'rombels'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        $semesters = Semester::with('tahunAjaran')->orderBy('tahun_ajaran_id', 'desc')->get();
        $rombels = Rombel::with('kelas')->orderBy('nama')->get(); // HANYA 'kelas'
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        $ruangKelas = RuangKelas::active()->orderBy('kode_ruang')->get();
        $jamPelajarans = JamPelajaran::active()->ordered()->get();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('kurikulum.jadwal_pelajaran.create', compact(
            'tahunAjarans',
            'semesters',
            'rombels',
            'mataPelajarans',
            'gurus',
            'ruangKelas',
            'jamPelajarans',
            'hariList'
        ));
    }

    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);

        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        $semesters = Semester::with('tahunAjaran')->orderBy('tahun_ajaran_id', 'desc')->get();
        $rombels = Rombel::with('kelas')->orderBy('nama')->get(); // HANYA 'kelas'
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        $ruangKelas = RuangKelas::active()->orderBy('kode_ruang')->get();
        $jamPelajarans = JamPelajaran::active()->ordered()->get();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('kurikulum.jadwal_pelajaran.edit', compact(
            'jadwal',
            'tahunAjarans',
            'semesters',
            'rombels',
            'mataPelajarans',
            'gurus',
            'ruangKelas',
            'jamPelajarans',
            'hariList'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'rombel_id' => 'required|exists:rombels,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'required|exists:gurus,id',
            'ruang_kelas_id' => 'nullable|exists:ruang_kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_pelajaran_id' => 'required|exists:jam_pelajarans,id',
            'jam_ke' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek duplikasi jadwal di rombel yang sama, hari yang sama, jam yang sama
        $exists = JadwalPelajaran::where('rombel_id', $request->rombel_id)
            ->where('hari', $request->hari)
            ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Jadwal sudah ada untuk kelas ini di hari dan jam yang sama.')
                ->withInput();
        }

        // Cek guru mengajar di waktu yang sama
        $guruExists = JadwalPelajaran::where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
            ->exists();

        if ($guruExists) {
            return redirect()->back()
                ->with('error', 'Guru sudah memiliki jadwal di hari dan jam yang sama.')
                ->withInput();
        }

        // Cek ruang kelas dipakai di waktu yang sama (jika ada)
        if ($request->filled('ruang_kelas_id')) {
            $ruangExists = JadwalPelajaran::where('ruang_kelas_id', $request->ruang_kelas_id)
                ->where('hari', $request->hari)
                ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
                ->exists();

            if ($ruangExists) {
                return redirect()->back()
                    ->with('error', 'Ruang kelas sudah digunakan di hari dan jam yang sama.')
                    ->withInput();
            }
        }

        JadwalPelajaran::create($request->all());

        return redirect()->route('kurikulum.jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'rombel_id' => 'required|exists:rombels,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'required|exists:gurus,id',
            'ruang_kelas_id' => 'nullable|exists:ruang_kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_pelajaran_id' => 'required|exists:jam_pelajarans,id',
            'jam_ke' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek duplikasi (kecuali dirinya sendiri)
        $exists = JadwalPelajaran::where('rombel_id', $request->rombel_id)
            ->where('hari', $request->hari)
            ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Jadwal sudah ada untuk kelas ini di hari dan jam yang sama.')
                ->withInput();
        }

        // Cek guru mengajar di waktu yang sama
        $guruExists = JadwalPelajaran::where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($guruExists) {
            return redirect()->back()
                ->with('error', 'Guru sudah memiliki jadwal di hari dan jam yang sama.')
                ->withInput();
        }

        // Cek ruang kelas dipakai di waktu yang sama
        if ($request->filled('ruang_kelas_id')) {
            $ruangExists = JadwalPelajaran::where('ruang_kelas_id', $request->ruang_kelas_id)
                ->where('hari', $request->hari)
                ->where('jam_pelajaran_id', $request->jam_pelajaran_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($ruangExists) {
                return redirect()->back()
                    ->with('error', 'Ruang kelas sudah digunakan di hari dan jam yang sama.')
                    ->withInput();
            }
        }

        $jadwal->update($request->all());

        return redirect()->route('kurikulum.jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('kurikulum.jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->update(['is_active' => !$jadwal->is_active]);

        $status = $jadwal->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Jadwal Pelajaran berhasil ' . $status . '.');
    }

    // API untuk get jadwal by rombel (untuk AJAX)
    public function getByRombel($rombelId)
    {
        $jadwals = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruangKelas', 'jamPelajaran'])
            ->where('rombel_id', $rombelId)
            ->where('is_active', true)
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get();

        return response()->json($jadwals);
    }
}