<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{

    private function get_no_rkm_medis()
    {
        // Ambil nomor terakhir
        $last_no_rm = Pasien::orderByDesc('no_rkm_medis')->pluck('no_rkm_medis')->first();

        if ($last_no_rm === null) {
            $no_rkm_medis = '000001';
        } else {
            $no_rkm_medis = sprintf('%06s', intval($last_no_rm) + 1);
        }

        return $no_rkm_medis;
    }
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        DB::beginTransaction();
        try {
            for ($i = 0; $i < 50; $i++) {
                DB::table('pasien')->insert([
                    'no_rkm_medis'      => $this->get_no_rkm_medis(),
                    'nik'               => $faker->nik(),
                    'nama_pasien'       => $faker->name,
                    'jenis_kelamin'     => $faker->randomElement(['L', 'P']),
                    'tempat_lahir'      => $faker->city,
                    'tanggal_lahir'     => $faker->date('Y-m-d', '-18 years'),
                    'tanggal_daftar'    => $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d'),
                    'jam_daftar'        => $faker->time('H:i:s'),
                    'agama'             => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'pekerjaan'         => $faker->jobTitle,
                    'nomor_tlp'         => $faker->unique()->phoneNumber,
                    'email'             => $faker->unique()->safeEmail,
                    'status_pernikahan' => $faker->randomElement(['Belum Menikah', 'Menikah', 'Duda', 'Janda']),
                    'alamat'            => $faker->address,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            // Commit transaksi jika semua berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            throw $e;
        }
    }
}
