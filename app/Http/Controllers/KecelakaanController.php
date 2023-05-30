<?php

namespace App\Http\Controllers;

use App\Exports\KecelakaanExport;
use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function create()
    {
        return view('kecelakaan.tambah', [
            'page_title' => 'Tambah Data Kecelakaan',
            'data_kecamatan' => Kecamatan::all()
        ]);
    }

    public function store(Request $request)
    {
        $data_kecelakaan = [
            // 'id_lokasi' => 'required|numeric',
            'no_laka' => 'required|unique:kecelakaan',
            'tgl_kejadian' => 'required|date',
            'tgl_lp' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric',
            'keterangan' => 'nullable'
        ];

        $data_lokasi = [
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'nama_jalan' => 'required|max:255'
        ];

        $request->validate(array_merge($data_kecelakaan, $data_lokasi));

        $storedLokasi = Lokasi::create($request->except($data_kecelakaan));

        if ($storedLokasi->exists()) {
            $request['id_lokasi'] = $storedLokasi->id_lokasi;
            Kecelakaan::create($request->except($data_lokasi));
        }

        return redirect()->route('kecelakaan.index')->with('success', 'Data berhasil ditambah');
    }

    public function show(Kecelakaan $kecelakaan)
    {
        $kecelakaan['lokasi'] = $kecelakaan->lokasi;

        return view('kecelakaan.detail', [
            'page_title' => 'Detail Kecelakaan',
            'kecelakaan' => $kecelakaan
        ]);
    }

    public function edit(Kecelakaan $kecelakaan)
    {
        return view('kecelakaan.edit', [
            'page_title' => 'Edit Data Kecelakaan',
            'kecelakaan' => $kecelakaan,
            'data_kecamatan' => Kecamatan::all()
        ]);
    }

    public function update(Request $request, Kecelakaan $kecelakaan)
    {
        $rules = [
            // 'no_laka' => 'nullable',
            'tgl_kejadian' => 'required|date',
            'tgl_lp' => 'required|date',
            'luka_ringan' => 'required|numeric',
            'luka_berat' => 'required|numeric',
            'meninggal' => 'required|numeric',
            'keterangan' => 'nullable',
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'nama_jalan' => 'required|max:255'
        ];

        if ($request->no_laka != $kecelakaan->no_laka) {
            $rules['no_laka'] = 'required|unique:kecelakaan';
        }

        $request->validate($rules);

        $data_lokasi = [
            'nama_jalan' => $request->nama_jalan,
            'kota_kabupaten' => $request->kota_kabupaten,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ];

        $data_kecelakaan = [
            'no_laka' => $request->no_laka,
            'tgl_lp' => $request->tgl_lp,
            'luka_ringan' => $request->luka_ringan,
            'luka_berat' => $request->luka_berat,
            'meninggal' => $request->meninggal,
            'keterangan' => $request->keterangan,
            'tgl_kejadian' => $request->tgl_kejadian,
        ];


        Lokasi::where('id_lokasi', $kecelakaan->id_lokasi)->update($data_lokasi);
        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->update($data_kecelakaan);

        return redirect()->route('kecelakaan.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Kecelakaan $kecelakaan)
    {
        Kecelakaan::where('id_kecelakaan', $kecelakaan->id_kecelakaan)->delete();
        Lokasi::where('id_lokasi', $kecelakaan->id_lokasi)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new KecelakaanExport, 'kecelakaan.xlsx');
    }
}
