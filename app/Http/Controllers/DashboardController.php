<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Noveber', 'Desember'];
        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
        $kecamatan = Kecamatan::all()->map(function ($data) {
            return $data->nama;
        });

        // whereYear('tgl_kejadian', date('Y'))->get();

        $data_kecelakaan = Kecelakaan::join('lokasi', 'lokasi.id_lokasi', '=', 'kecelakaan.id_lokasi')
            ->join('kecamatan', 'kecamatan.id', '=', 'lokasi.id_kecamatan')->whereYear('tgl_kejadian', date('Y'))->get();

        $kejadian_kecamatan = [];
        foreach ($kecamatan as $index => $value) {
            $filtered = $data_kecelakaan->filter(function ($kecelakaan) use ($value) {
                return $kecelakaan->nama == $value;
            });

            $kejadian_kecamatan[] = $filtered->count();
        }

        return view('dashboard.index', [
            'page_title' => 'Dashboard',
            'data_kecelakaan' => $data_kecelakaan,
            'data_bulan' => $data_bulan,
            'data_lokasi' => Lokasi::all()->unique('nama_jalan'),
            'kecamatan' => $kecamatan,
            'kejadian_kecamatan' => $kejadian_kecamatan
        ]);
    }
}