<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class KecelakaanController extends Controller
{
    public function index()
    {
        $data_kecelakaan = [];
        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Noveber', 'Desember'];

        foreach (Kecelakaan::latest()->filter()->get() as $kecelakaan) {
            $kecelakaan['total'] = $kecelakaan->luka_ringan + $kecelakaan->luka_berat + $kecelakaan->meninggal;
            $data_kecelakaan[] = $kecelakaan;
        }

        return view('kecelakaan.index', [
            'page_title' => 'Data Kecelakaan',
            'data_lokasi' => Lokasi::orderBy('nama_jalan', 'asc')->get(),
            'data_kecamatan' => Kecamatan::all(),
            'data_kecelakaan' => collect($data_kecelakaan),
            'data_bulan' => $data_bulan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lokasi' => 'required|numeric',
            'no_laka' => 'required|unique:kecelakaan',
            'tanggal' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric'
        ]);

        Kecelakaan::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambah');
    }

    public function update(Request $request, Kecelakaan $kecelakaan)
    {
        $rules = [
            'id_lokasi' => 'required|numeric',
            'tanggal' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric'
        ];

        if ($request->no_laka != $kecelakaan->no_laka) {
            $rules['no_laka'] = 'required|unique:kecelakaan';
        }

        $validated = $request->validate($rules);

        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Kecelakaan $kecelakaan)
    {
        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
