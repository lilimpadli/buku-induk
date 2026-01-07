<?php
namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpdbTimeline;

class PpdbTimelineController extends Controller
{
    public function edit()
    {
        // load from DB if exists
        $rows = PpdbTimeline::whereIn('stage', ['tahap1', 'tahap2'])->get()->keyBy('stage');

        $data = [
            'tahap1' => [
                'title' => 'Pendaftaran Tahap 1',
                'pendaftaran' => '',
                'sanggah' => '',
                'rapat' => '',
                'pengumuman' => '',
                'daftar_ulang' => '',
                'open' => true,
            ],
            'tahap2' => [
                'title' => 'Pendaftaran Tahap 2',
                'pendaftaran' => '',
                'sanggah' => '',
                'tes' => '',
                'rapat' => '',
                'pengumuman' => '',
                'daftar_ulang' => '',
                'open' => false,
            ],
        ];

        if ($rows->has('tahap1')) {
            $t1 = $rows->get('tahap1')->toArray();
            foreach (['title','pendaftaran','sanggah','rapat','pengumuman','daftar_ulang','open'] as $k) {
                if (array_key_exists($k, $t1)) $data['tahap1'][$k] = $t1[$k];
            }
        }

        if ($rows->has('tahap2')) {
            $t2 = $rows->get('tahap2')->toArray();
            foreach (['title','pendaftaran','sanggah','tes','rapat','pengumuman','daftar_ulang','open'] as $k) {
                if (array_key_exists($k, $t2)) $data['tahap2'][$k] = $t2[$k];
            }
        }

        return view('kurikulum.ppdb.timeline', compact('data'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tahap1.title' => 'nullable|string|max:255',
            'tahap1.pendaftaran' => 'nullable|string|max:255',
            'tahap1.sanggah' => 'nullable|string|max:255',
            'tahap1.rapat' => 'nullable|string|max:255',
            'tahap1.pengumuman' => 'nullable|string|max:255',
            'tahap1.daftar_ulang' => 'nullable|string|max:255',

            'tahap2.title' => 'nullable|string|max:255',
            'tahap2.pendaftaran' => 'nullable|string|max:255',
            'tahap2.sanggah' => 'nullable|string|max:255',
            'tahap2.tes' => 'nullable|string|max:255',
            'tahap2.rapat' => 'nullable|string|max:255',
            'tahap2.pengumuman' => 'nullable|string|max:255',
            'tahap2.daftar_ulang' => 'nullable|string|max:255',
            'tahap1.open' => 'nullable|in:0,1',
            'tahap2.open' => 'nullable|in:0,1',
        ]);

        // Build data structure preserving nested keys
        $t1 = $validated['tahap1'] ?? [];
        $t2 = $validated['tahap2'] ?? [];

        // normalize open flags
        $t1['open'] = isset($t1['open']) ? ((int)$t1['open'] === 1) : true;
        $t2['open'] = isset($t2['open']) ? ((int)$t2['open'] === 1) : false;

        // upsert to DB
        PpdbTimeline::updateOrCreate(
            ['stage' => 'tahap1'],
            [
                'title' => $t1['title'] ?? null,
                'pendaftaran' => $t1['pendaftaran'] ?? null,
                'sanggah' => $t1['sanggah'] ?? null,
                'rapat' => $t1['rapat'] ?? null,
                'pengumuman' => $t1['pengumuman'] ?? null,
                'daftar_ulang' => $t1['daftar_ulang'] ?? null,
                'open' => $t1['open'],
            ]
        );

        PpdbTimeline::updateOrCreate(
            ['stage' => 'tahap2'],
            [
                'title' => $t2['title'] ?? null,
                'pendaftaran' => $t2['pendaftaran'] ?? null,
                'sanggah' => $t2['sanggah'] ?? null,
                'tes' => $t2['tes'] ?? null,
                'rapat' => $t2['rapat'] ?? null,
                'pengumuman' => $t2['pengumuman'] ?? null,
                'daftar_ulang' => $t2['daftar_ulang'] ?? null,
                'open' => $t2['open'],
            ]
        );

        return redirect()->back()->with('success', 'Timeline PPDB berhasil diperbarui.');
    }
}
