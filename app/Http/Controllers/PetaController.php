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

        $total_kejadian = Lokasi::all()->groupBy('nama_jalan')->map(function ($data) {
            return $data->count();
        })->sortByDesc(function ($count) {
            return $count;
        })->take(5);

        return view('peta.index', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_lokasi' => Lokasi::all()->unique('nama_jalan'),
            'data_bulan' => $data_bulan,
            'total_kejadian' => $total_kejadian,
            'data_kecelakaan' => Kecelakaan::latest()->filter()->get()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }
}