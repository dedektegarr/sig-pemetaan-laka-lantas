<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi.index', [
            'page_title' => 'Data Lokasi',
            'data_lokasi' => Lokasi::orderByDesc('created_at')->get()
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
            'nama_jalan' => 'required|max:255'
        ]);

        Lokasi::create($validated);
        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil ditambahkan');
    }

    public function show(Lokasi $lokasi)
    {
        $data_kecelakaan = [];

        foreach ($lokasi->kecelakaan as $kecelakaan) {
            $kecelakaan['total'] = $kecelakaan->luka_ringan + $kecelakaan->luka_berat + $kecelakaan->meninggal;
            $kecelakaan['tahun'] = Carbon::parse($kecelakaan->tanggal)->format('Y');
            $data_kecelakaan[] = $kecelakaan;
        }

        return view('lokasi.detail', [
            'page_title' => 'Detail Lokasi',
            'lokasi' => $lokasi,
            'data_kecelakaan' => $data_kecelakaan
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
        $validated = $request->validate([
            'kota_kabupaten' => 'required',
            'id_kecamatan' => 'required|numeric|max_digits:11',
            'id_kelurahan' => 'required|numeric|max_digits:11',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'keterangan' => 'nullable|max:255',
            'nama_jalan' => 'required|max:255'
        ]);

        Lokasi::where('id_lokasi', $lokasi->id_lokasi)->update($validated);
        return redirect()->route('lokasi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Lokasi $lokasi)
    {
        Lokasi::where('id_lokasi', $lokasi->id_lokasi)->delete();
        return redirect()->route('lokasi.index')->with('success', 'Data berhasil dihapus');
    }
}
