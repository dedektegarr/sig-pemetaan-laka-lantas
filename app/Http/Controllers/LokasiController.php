<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi.index', [
            'page_title' => 'Data Lokasi',
            'data_lokasi' => Lokasi::all()
        ]);
    }

    public function tambah()
    {
        return view('lokasi.tambah', [
            'page_title' => 'Tambah Data Lokasi'
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'keterangan' => 'nullable|max:255',
            'nama_jalan' => 'required|max:255'
        ]);

        Lokasi::create($validated);
        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil ditambahkan');
    }

    public function show(Lokasi $lokasi)
    {
        return view('lokasi.detail', [
            'page_title' => 'Detail Lokasi',
            'lokasi' => $lokasi
        ]);
    }
}
