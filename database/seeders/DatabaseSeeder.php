<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();

        \App\Models\Kecamatan::factory()->createMany(
            [
                ['nama_kecamatan' => 'Sungai Serut'],
                ['nama_kecamatan' => 'Gading Cempaka'],
                ['nama_kecamatan' => 'Selebar'],
                ['nama_kecamatan' => 'Kampung Melayu'],
                ['nama_kecamatan' => 'Muara Bangka Hulu'],
                ['nama_kecamatan' => 'Ratu Agung'],
                ['nama_kecamatan' => 'Ratu Samban'],
                ['nama_kecamatan' => 'Singaran Pati'],
                ['nama_kecamatan' => 'Teluk Segara'],
            ]
        );

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}