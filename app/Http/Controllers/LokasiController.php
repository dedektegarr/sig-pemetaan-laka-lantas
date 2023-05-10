<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi.index', [
            'page_title' => 'Data Lokasi'
        ]);
    }

    public function tambah()
    {
        return view('lokasi.tambah', [
            'page_title' => 'Tambah Data Lokasi'
        ]);
    }
}
