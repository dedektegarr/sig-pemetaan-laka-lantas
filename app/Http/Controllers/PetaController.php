<?php

namespace App\Http\Controllers;

use App\Models\Kecelakaan;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
    {
        return view('peta.index', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_kecelakaan' => Kecelakaan::all()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }
}