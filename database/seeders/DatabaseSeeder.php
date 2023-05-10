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
                "id_kecamatan" => 1771010,
                "nama_kecamatan" => "Selebar"
            ],
            [
                "id_kecamatan" => 1771011,
                "nama_kecamatan" => "Kampung Melayu"
            ],
            [
                "id_kecamatan" => 1771020,
                "nama_kecamatan" => "Gading Cempaka"
            ],
            [
                "id_kecamatan" => 1771021,
                "nama_kecamatan" => "Ratu Agung"
            ],
            [
                "id_kecamatan" => 1771022,
                "nama_kecamatan" => "Ratu Samban"
            ],
            [
                "id_kecamatan" => 1771023,
                "nama_kecamatan" => "Singaran Pati"
            ],
            [
                "id_kecamatan" => 1771030,
                "nama_kecamatan" => "Teluk Segara"
            ],
            [
                "id_kecamatan" => 1771031,
                "nama_kecamatan" => "Sungai Serut"
            ],
            [
                "id_kecamatan" => 1771040,
                "nama_kecamatan" => "Muara Bangka Hulu"
            ]
        ];

        $data_kelurahan = [
            [
                "id_kelurahan" => 1771010003,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Betungan"
            ],
            [
                "id_kelurahan" => 1771010004,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Pekan Sabtu"
            ],
            [
                "id_kelurahan" => 1771010005,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Suka Rami"
            ],
            [
                "id_kelurahan" => 1771010006,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Pagar Dewa"
            ],
            [
                "id_kelurahan" => 1771010007,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Bumiayu"
            ],
            [
                "id_kelurahan" => 1771010008,
                "id_kecamatan" => "1771010",
                "nama_kelurahan" => "Sumur Dewa"
            ],
            [
                "id_kelurahan" => 1771011001,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Teluk Sepang"
            ],
            [
                "id_kelurahan" => 1771011002,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Sumber Jaya"
            ],
            [
                "id_kelurahan" => 1771011003,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Kandang"
            ],
            [
                "id_kelurahan" => 1771011004,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Kandang Mas"
            ],
            [
                "id_kelurahan" => 1771011005,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Padang Serai"
            ],
            [
                "id_kelurahan" => 1771011006,
                "id_kecamatan" => "1771011",
                "nama_kelurahan" => "Muara Dua"
            ],
            [
                "id_kelurahan" => 1771020001,
                "id_kecamatan" => "1771020",
                "nama_kelurahan" => "Sido Mulyo"
            ],
            [
                "id_kelurahan" => 1771020005,
                "id_kecamatan" => "1771020",
                "nama_kelurahan" => "Jalan Gedang"
            ],
            [
                "id_kelurahan" => 1771020006,
                "id_kecamatan" => "1771020",
                "nama_kelurahan" => "Padang Harapan"
            ],
            [
                "id_kelurahan" => 1771020024,
                "id_kecamatan" => "1771020",
                "nama_kelurahan" => "Cempaka Permai"
            ],
            [
                "id_kelurahan" => 1771020027,
                "id_kecamatan" => "1771020",
                "nama_kelurahan" => "Lingkar Barat"
            ],
            [
                "id_kelurahan" => 1771021001,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Tanah Patah"
            ],
            [
                "id_kelurahan" => 1771021002,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Kebun Tebeng"
            ],
            [
                "id_kelurahan" => 1771021003,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Sawah Lebar Baru"
            ],
            [
                "id_kelurahan" => 1771021004,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Sawah Lebar"
            ],
            [
                "id_kelurahan" => 1771021005,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Nusa Indah"
            ],
            [
                "id_kelurahan" => 1771021006,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Kebun Kenanga"
            ],
            [
                "id_kelurahan" => 1771021007,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Kebun Beler"
            ],
            [
                "id_kelurahan" => 1771021008,
                "id_kecamatan" => "1771021",
                "nama_kelurahan" => "Lempuing"
            ],
            [
                "id_kelurahan" => 1771022001,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Anggut Bawah"
            ],
            [
                "id_kelurahan" => 1771022002,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Penurunan"
            ],
            [
                "id_kelurahan" => 1771022003,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Padang Jati"
            ],
            [
                "id_kelurahan" => 1771022004,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Belakang Pondok"
            ],
            [
                "id_kelurahan" => 1771022005,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Pengantungan"
            ],
            [
                "id_kelurahan" => 1771022006,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Kebun Dahri"
            ],
            [
                "id_kelurahan" => 1771022007,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Kebun Gerand"
            ],
            [
                "id_kelurahan" => 1771022008,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Anggut Atas"
            ],
            [
                "id_kelurahan" => 1771022009,
                "id_kecamatan" => "1771022",
                "nama_kelurahan" => "Anggut Dalam"
            ],
            [
                "id_kelurahan" => 1771023001,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Jembatan Kecil"
            ],
            [
                "id_kelurahan" => 1771023002,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Panorama"
            ],
            [
                "id_kelurahan" => 1771023003,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Lingkar Timur"
            ],
            [
                "id_kelurahan" => 1771023004,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Timur Indah"
            ],
            [
                "id_kelurahan" => 1771023005,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Padang Nangka"
            ],
            [
                "id_kelurahan" => 1771023006,
                "id_kecamatan" => "1771023",
                "nama_kelurahan" => "Dusun Besar"
            ],
            [
                "id_kelurahan" => 1771030001,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Kebun Keling"
            ],
            [
                "id_kelurahan" => 1771030004,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Malabero"
            ],
            [
                "id_kelurahan" => 1771030005,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Sumur Melele"
            ],
            [
                "id_kelurahan" => 1771030006,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pasar Berkas"
            ],
            [
                "id_kelurahan" => 1771030007,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pasar Baru"
            ],
            [
                "id_kelurahan" => 1771030008,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pasar Jitra"
            ],
            [
                "id_kelurahan" => 1771030009,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pasar Melintang"
            ],
            [
                "id_kelurahan" => 1771030011,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pondok Besi"
            ],
            [
                "id_kelurahan" => 1771030012,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Kebun Ros"
            ],
            [
                "id_kelurahan" => 1771030013,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Pintu Batu"
            ],
            [
                "id_kelurahan" => 1771030014,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Tengah Padang"
            ],
            [
                "id_kelurahan" => 1771030015,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Bajak"
            ],
            [
                "id_kelurahan" => 1771030016,
                "id_kecamatan" => "1771030",
                "nama_kelurahan" => "Kampung Bali"
            ],
            [
                "id_kelurahan" => 1771031001,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Surabaya"
            ],
            [
                "id_kelurahan" => 1771031002,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Semarang"
            ],
            [
                "id_kelurahan" => 1771031003,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Tanjung Jaya"
            ],
            [
                "id_kelurahan" => 1771031004,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Tanjung Agung"
            ],
            [
                "id_kelurahan" => 1771031005,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Suka Merindu"
            ],
            [
                "id_kelurahan" => 1771031006,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Kampung Kelawi"
            ],
            [
                "id_kelurahan" => 1771031007,
                "id_kecamatan" => "1771031",
                "nama_kelurahan" => "Pasar Bengkulu"
            ]
        ];

        Kecamatan::insert($data_kecamatan);
        Kelurahan::insert($data_kelurahan);
    }
}
