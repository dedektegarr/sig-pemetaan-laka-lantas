<?php

namespace App\Http\Controllers;

use App\Models\Kecelakaan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
    {
        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Noveber', 'Desember'];

        return view('peta.index', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_lokasi' => Lokasi::all()->unique('nama_jalan'),
            'data_bulan' => $data_bulan,
            'data_kecelakaan' => Kecelakaan::latest()->filter()->get()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }
}
