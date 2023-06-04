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

        $kecelakaan = Kecelakaan::filter()->get();

        $getTotalKejadian = $kecelakaan->map(function ($data) {
            return $data->count();
        })->sortByDesc(function ($count) {
            return $count;
        })->take(5);

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

    public function userIndex()
    {
        $kecelakaan = Kecelakaan::filter()->get();

        $getTotalKejadian = $kecelakaan->map(function ($data) {
            return $data->count();
        })->sortByDesc(function ($count) {
            return $count;
        })->take(5);

        return view('user.peta', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_kecamatan' => Kecamatan::all(),
            // 'data_bulan' => $data_bulan,
            'total_kejadian' => $getTotalKejadian,
            'data_kecelakaan' => Kecelakaan::latest()->filter()->get()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }

    public function userGrafik()
    {
        $data_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];

        $kecamatan = Kecamatan::all()->map(function ($data) {
            return $data->nama;
        });
        $kejadian_kecamatan = [];
        $data_kecelakaan = Kecelakaan::join('lokasi', 'lokasi.id_lokasi', '=', 'kecelakaan.id_lokasi')
            ->join('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan')->whereYear('tgl_kejadian', request('tahun_kejadian') ?? date('Y'))->get();
        foreach ($kecamatan as $index => $value) {
            $filtered = $data_kecelakaan->filter(function ($kecelakaan) use ($value) {
                return $kecelakaan->nama == $value;
            });

            $kejadian_kecamatan[] = $filtered->count();
        }

        $kecelakaan = Kecelakaan::filter()->get();
        $getTotalKejadian = $kecelakaan->map(function ($data) {
            return $data->count();
        })->sortByDesc(function ($count) {
            return $count;
        })->take(5);

        return view('user.grafik', [
            'page_title' => 'Peta Lokasi Kecelakaan',
            'data_kecamatan' => Kecamatan::all(),
            'data_bulan' => $data_bulan,
            'total_kejadian' => $getTotalKejadian,
            'kecamatan' => $kecamatan,
            'kejadian_kecamatan' => $kejadian_kecamatan,
            'data_kecelakaan' => Kecelakaan::latest()->filter()->get()->map(function ($data) {
                $data->lokasi;
                return $data;
            })
        ]);
    }
}
