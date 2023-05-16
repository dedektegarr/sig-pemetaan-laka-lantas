<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_kecamatan = [
            [
                "id" => 1771010,
                "nama" => "Selebar"
            ],
            [
                "id" => 1771011,
                "nama" => "Kampung Melayu"
            ],
            [
                "id" => 1771020,
                "nama" => "Gading Cempaka"
            ],
            [
                "id" => 1771021,
                "nama" => "Ratu Agung"
            ],
            [
                "id" => 1771022,
                "nama" => "Ratu Samban"
            ],
            [
                "id" => 1771023,
                "nama" => "Singaran Pati"
            ],
            [
                "id" => 1771030,
                "nama" => "Teluk Segara"
            ],
            [
                "id" => 1771031,
                "nama" => "Sungai Serut"
            ],
            [
                "id" => 1771040,
                "nama" => "Muara Bangka Hulu"
            ]
        ];

        Kecamatan::insert($data_kecamatan);
    }
}
