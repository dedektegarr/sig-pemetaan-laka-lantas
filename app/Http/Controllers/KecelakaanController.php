<?php

namespace App\Http\Controllers;

use App\Models\Kecelakaan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class KecelakaanController extends Controller
{
    public function index()
    {
        $data_kecelakaan = [];

        foreach (Kecelakaan::all() as $kecelakaan) {
            $kecelakaan['total'] = $kecelakaan->luka_ringan + $kecelakaan->luka_berat + $kecelakaan->meninggal;
            $data_kecelakaan[] = $kecelakaan;
        }

        return view('kecelakaan.index', [
            'page_title' => 'Data Kecelakaan',
            'data_lokasi' => Lokasi::orderByDesc('created_at')->pluck('nama_jalan', 'id_lokasi'),
            'data_kecelakaan' => collect($data_kecelakaan)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lokasi' => 'required|numeric',
            'waktu' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric'
        ]);

        Kecelakaan::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambah');
    }

    public function update(Request $request, Kecelakaan $kecelakaan)
    {
        $validated = $request->validate([
            'id_lokasi' => 'required|numeric',
            'waktu' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric'
        ]);

        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Kecelakaan $kecelakaan)
    {
        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
