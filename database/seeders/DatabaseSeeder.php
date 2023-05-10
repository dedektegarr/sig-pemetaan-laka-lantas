<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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

        $data_kelurahan = [
            [
                "id" => 1771010003,
                "id_kecamatan" => "1771010",
                "nama" => "Betungan"
            ],
            [
                "id" => 1771010004,
                "id_kecamatan" => "1771010",
                "nama" => "Pekan Sabtu"
            ],
            [
                "id" => 1771010005,
                "id_kecamatan" => "1771010",
                "nama" => "Suka Rami"
            ],
            [
                "id" => 1771010006,
                "id_kecamatan" => "1771010",
                "nama" => "Pagar Dewa"
            ],
            [
                "id" => 1771010007,
                "id_kecamatan" => "1771010",
                "nama" => "Bumiayu"
            ],
            [
                "id" => 1771010008,
                "id_kecamatan" => "1771010",
                "nama" => "Sumur Dewa"
            ],
            [
                "id" => 1771011001,
                "id_kecamatan" => "1771011",
                "nama" => "Teluk Sepang"
            ],
            [
                "id" => 1771011002,
                "id_kecamatan" => "1771011",
                "nama" => "Sumber Jaya"
            ],
            [
                "id" => 1771011003,
                "id_kecamatan" => "1771011",
                "nama" => "Kandang"
            ],
            [
                "id" => 1771011004,
                "id_kecamatan" => "1771011",
                "nama" => "Kandang Mas"
            ],
            [
                "id" => 1771011005,
                "id_kecamatan" => "1771011",
                "nama" => "Padang Serai"
            ],
            [
                "id" => 1771011006,
                "id_kecamatan" => "1771011",
                "nama" => "Muara Dua"
            ],
            [
                "id" => 1771020001,
                "id_kecamatan" => "1771020",
                "nama" => "Sido Mulyo"
            ],
            [
                "id" => 1771020005,
                "id_kecamatan" => "1771020",
                "nama" => "Jalan Gedang"
            ],
            [
                "id" => 1771020006,
                "id_kecamatan" => "1771020",
                "nama" => "Padang Harapan"
            ],
            [
                "id" => 1771020024,
                "id_kecamatan" => "1771020",
                "nama" => "Cempaka Permai"
            ],
            [
                "id" => 1771020027,
                "id_kecamatan" => "1771020",
                "nama" => "Lingkar Barat"
            ],
            [
                "id" => 1771021001,
                "id_kecamatan" => "1771021",
                "nama" => "Tanah Patah"
            ],
            [
                "id" => 1771021002,
                "id_kecamatan" => "1771021",
                "nama" => "Kebun Tebeng"
            ],
            [
                "id" => 1771021003,
                "id_kecamatan" => "1771021",
                "nama" => "Sawah Lebar Baru"
            ],
            [
                "id" => 1771021004,
                "id_kecamatan" => "1771021",
                "nama" => "Sawah Lebar"
            ],
            [
                "id" => 1771021005,
                "id_kecamatan" => "1771021",
                "nama" => "Nusa Indah"
            ],
            [
                "id" => 1771021006,
                "id_kecamatan" => "1771021",
                "nama" => "Kebun Kenanga"
            ],
            [
                "id" => 1771021007,
                "id_kecamatan" => "1771021",
                "nama" => "Kebun Beler"
            ],
            [
                "id" => 1771021008,
                "id_kecamatan" => "1771021",
                "nama" => "Lempuing"
            ],
            [
                "id" => 1771022001,
                "id_kecamatan" => "1771022",
                "nama" => "Anggut Bawah"
            ],
            [
                "id" => 1771022002,
                "id_kecamatan" => "1771022",
                "nama" => "Penurunan"
            ],
            [
                "id" => 1771022003,
                "id_kecamatan" => "1771022",
                "nama" => "Padang Jati"
            ],
            [
                "id" => 1771022004,
                "id_kecamatan" => "1771022",
                "nama" => "Belakang Pondok"
            ],
            [
                "id" => 1771022005,
                "id_kecamatan" => "1771022",
                "nama" => "Pengantungan"
            ],
            [
                "id" => 1771022006,
                "id_kecamatan" => "1771022",
                "nama" => "Kebun Dahri"
            ],
            [
                "id" => 1771022007,
                "id_kecamatan" => "1771022",
                "nama" => "Kebun Gerand"
            ],
            [
                "id" => 1771022008,
                "id_kecamatan" => "1771022",
                "nama" => "Anggut Atas"
            ],
            [
                "id" => 1771022009,
                "id_kecamatan" => "1771022",
                "nama" => "Anggut Dalam"
            ],
            [
                "id" => 1771023001,
                "id_kecamatan" => "1771023",
                "nama" => "Jembatan Kecil"
            ],
            [
                "id" => 1771023002,
                "id_kecamatan" => "1771023",
                "nama" => "Panorama"
            ],
            [
                "id" => 1771023003,
                "id_kecamatan" => "1771023",
                "nama" => "Lingkar Timur"
            ],
            [
                "id" => 1771023004,
                "id_kecamatan" => "1771023",
                "nama" => "Timur Indah"
            ],
            [
                "id" => 1771023005,
                "id_kecamatan" => "1771023",
                "nama" => "Padang Nangka"
            ],
            [
                "id" => 1771023006,
                "id_kecamatan" => "1771023",
                "nama" => "Dusun Besar"
            ],
            [
                "id" => 1771030001,
                "id_kecamatan" => "1771030",
                "nama" => "Kebun Keling"
            ],
            [
                "id" => 1771030004,
                "id_kecamatan" => "1771030",
                "nama" => "Malabero"
            ],
            [
                "id" => 1771030005,
                "id_kecamatan" => "1771030",
                "nama" => "Sumur Melele"
            ],
            [
                "id" => 1771030006,
                "id_kecamatan" => "1771030",
                "nama" => "Pasar Berkas"
            ],
            [
                "id" => 1771030007,
                "id_kecamatan" => "1771030",
                "nama" => "Pasar Baru"
            ],
            [
                "id" => 1771030008,
                "id_kecamatan" => "1771030",
                "nama" => "Pasar Jitra"
            ],
            [
                "id" => 1771030009,
                "id_kecamatan" => "1771030",
                "nama" => "Pasar Melintang"
            ],
            [
                "id" => 1771030011,
                "id_kecamatan" => "1771030",
                "nama" => "Pondok Besi"
            ],
            [
                "id" => 1771030012,
                "id_kecamatan" => "1771030",
                "nama" => "Kebun Ros"
            ],
            [
                "id" => 1771030013,
                "id_kecamatan" => "1771030",
                "nama" => "Pintu Batu"
            ],
            [
                "id" => 1771030014,
                "id_kecamatan" => "1771030",
                "nama" => "Tengah Padang"
            ],
            [
                "id" => 1771030015,
                "id_kecamatan" => "1771030",
                "nama" => "Bajak"
            ],
            [
                "id" => 1771030016,
                "id_kecamatan" => "1771030",
                "nama" => "Kampung Bali"
            ],
            [
                "id" => 1771031001,
                "id_kecamatan" => "1771031",
                "nama" => "Surabaya"
            ],
            [
                "id" => 1771031002,
                "id_kecamatan" => "1771031",
                "nama" => "Semarang"
            ],
            [
                "id" => 1771031003,
                "id_kecamatan" => "1771031",
                "nama" => "Tanjung Jaya"
            ],
            [
                "id" => 1771031004,
                "id_kecamatan" => "1771031",
                "nama" => "Tanjung Agung"
            ],
            [
                "id" => 1771031005,
                "id_kecamatan" => "1771031",
                "nama" => "Suka Merindu"
            ],
            [
                "id" => 1771031006,
                "id_kecamatan" => "1771031",
                "nama" => "Kampung Kelawi"
            ],
            [
                "id" => 1771031007,
                "id_kecamatan" => "1771031",
                "nama" => "Pasar Bengkulu"
            ]
        ];

        Kecamatan::insert($data_kecamatan);
        Kelurahan::insert($data_kelurahan);
    }
}