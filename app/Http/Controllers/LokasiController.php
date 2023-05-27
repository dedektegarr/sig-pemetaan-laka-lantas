<?php

namespace App\Http\Controllers;

use App\Exports\KecelakaanExport;
use App\Exports\LokasiExport;
use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Kelurahan;
use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LokasiController extends Controller
{
    public function index()
    {
        $data = Lokasi::all()->unique('nama_jalan');

        return view('lokasi.index', [
            'page_title' => 'Data Lokasi',
            'data_lokasi' => $data,
            'data_kecamatan' => Kecamatan::all(),
            'data_kelurahan' => Kelurahan::all()
        ]);
    }

    public function create()
    {
        return view('lokasi.tambah', [
            'page_title' => 'Tambah Data Lokasi',
            'data_kecamatan' => Kecamatan::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'keterangan' => 'nullable|max:255',
            'nama_jalan' => 'required|max:255|unique:lokasi'
        ]);

        Lokasi::create($validated);
        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil ditambahkan');
    }

    public function show(Lokasi $lokasi)
    {
        $data_kecelakaan = Kecelakaan::filter()->get()->filter(function ($data) use ($lokasi) {
            return $lokasi->nama_jalan == $data->lokasi->nama_jalan;
        });

        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Noveber', 'Desember'];

        return view('lokasi.detail', [
            'page_title' => 'Detail Lokasi',
            'lokasi' => $lokasi,
            'data_kecelakaan' => $data_kecelakaan->values()->all(),
            'data_bulan' => $data_bulan
        ]);
    }

    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', [
            'page_title' => 'Edit Lokasi',
            'lokasi' => $lokasi,
            'data_kecamatan' => Kecamatan::all()
        ]);
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $rules = [
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'keterangan' => 'nullable|max:255'
        ];

        if ($lokasi->nama_jalan != $request->nama_jalan) {
            $rules['nama_jalan'] = 'required|max:255|unique:lokasi';
        }

        $validated = $request->validate($rules);

        Lokasi::where('id_lokasi', $lokasi->id_lokasi)->update($validated);
        return redirect()->route('lokasi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Lokasi $lokasi)
    {
        Lokasi::where('id_lokasi', $lokasi->id_lokasi)->delete();
        return redirect()->route('lokasi.index')->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new LokasiExport, 'lokasi.xlsx');
    }
}
