<?php

namespace App\Imports;

use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use App\Models\Kelurahan;
use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\ToModel;

class KecelakaanImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $lokasi = [
            'polresta' => $row[1],
            'latitude' => $row[7],
            'longitude' => $row[8],
            'nama_jalan' => $row[9]
        ];

        $filteredKecamatan = Kecamatan::all()->filter(function ($kec) use ($lokasi) {
            $namaJalan = str_replace(' ', '', strtolower($lokasi['nama_jalan']));
            $namaKecamatan = str_replace(' ', '', strtolower($kec->nama));
            return str_contains(strtolower($namaJalan), strtolower($namaKecamatan));
        })->pluck('id')->first();

        $filteredKelurahan = Kelurahan::where('id_kecamatan', $filteredKecamatan)->get()->filter(function ($kel) use ($lokasi) {
            $namaJalan = str_replace(' ', '', strtolower($lokasi['nama_jalan']));
            $namaKelurahan = str_replace(' ', '', strtolower($kel->nama));
            return str_contains(strtolower($namaJalan), strtolower($namaKelurahan));
        })->pluck('id')->first();

        $lokasi['id_kecamatan'] = $filteredKecamatan;
        $lokasi['id_kelurahan'] = $filteredKelurahan;

        $kecelakaan = [
            'no_laka' => $row[0],
            'tgl_kejadian' => $row[2],
            'tingkat_kecelakaan' => $row[3],
            'meninggal' => $row[4],
            'luka_berat' => $row[5],
            'luka_ringan' => $row[6],
        ];


        $storedLokasi = Lokasi::create($lokasi);
        if ($storedLokasi->exists()) {
            $kecelakaan['id_lokasi'] = $storedLokasi->id_lokasi;

            return new Kecelakaan($kecelakaan);
        }
    }
}
