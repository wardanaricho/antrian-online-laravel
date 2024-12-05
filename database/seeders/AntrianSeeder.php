<?php

namespace Database\Seeders;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AntrianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 300; $i++) {
            Antrian::create([
                'tanggal' => Carbon::now()->toDateString(),
                'jam' => Carbon::now()->toTimeString(),
                'no_antrian' => $i,
                'status_antrian' => 1,
                'no_rkm_medis' => '000001',
                'dokter_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
