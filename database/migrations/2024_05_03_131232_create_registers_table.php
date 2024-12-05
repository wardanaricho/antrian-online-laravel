<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('register_pasien', function (Blueprint $table) {
            $table->string('no_antrian', 4);
            $table->id();
            $table->string('no_rkm_medis');
            $table->date('tanggal_regis');
            $table->time('jam_regis');
            $table->string('keluhan_awal');
            $table->unsignedBigInteger('dokter_id');
            $table->timestamps();

            $table->foreign('no_rkm_medis')->references('no_rkm_medis')->on('pasien');
            $table->foreign('dokter_id')->references('id')->on('dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_pasien');
    }
};
