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
            'lokasi' => Lokasi::all()
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
        Lokasi::create($request->all());
        return redirect()->route('lokasi.index');
    }
}
