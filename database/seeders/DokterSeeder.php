<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        Dokter::create([
            'nama_dokter' => "dr. Rengga",
            'tempat_lahir' => $faker->city(),
            'tanggal_lahir' => $faker->date(),
            'jenis_kelamin' => "L",
            'alamat' => $faker->address()
        ]);
    }
}
