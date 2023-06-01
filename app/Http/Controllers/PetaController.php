<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Lokasi;

class PetaController extends Controller
{
    public function index()
    {
        // $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Noveber', 'Desember'];
        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];

        $kecelakaan = Kecelakaan::join('lokasi', 'lokasi.id_lokasi', '=', 'kecelakaan.id_lokasi')
            ->join('kecamatan', 'kecamatan.id', '=', 'lokasi.id_kecamatan')
            ->select('kecelakaan.*', 'lokasi.id_kecamatan', 'kecamatan.nama')
            ->get()
            ->groupBy('nama');

        $getTotalKejadian = $kecelakaan->map(function ($data) {
            return $data->count();
        });

        return view('peta.index', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_kecamatan' => Kecamatan::all(),
            'data_bulan' => $data_bulan,
            'total_kejadian' => $getTotalKejadian,
            'data_kecelakaan' => Kecelakaan::latest()->filter()->get()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }
}
