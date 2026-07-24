<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        return view('kenaikan-kelas.index');
    }

    public function proses(Request $request)
    {
        // Logika proses kenaikan kelas
        return redirect()->back()->with('success', 'Proses kenaikan kelas berhasil!');
    }

    public function preview(Request $request)
    {
        // Logika preview kenaikan kelas
        return response()->json(['message' => 'Preview kenaikan kelas']);
    }

    public function upAll(Request $request)
    {
        // Logika naikkan semua
        return redirect()->back()->with('success', 'Semua siswa naik kelas!');
    }

    public function exportPdf()
    {
        // Export PDF
        return view('kenaikan-kelas.export-pdf');
    }

    public function exportExcel()
    {
        // Export Excel
        return redirect()->back()->with('success', 'Export Excel berhasil!');
    }
}