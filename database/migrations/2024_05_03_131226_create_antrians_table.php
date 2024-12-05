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
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('no_antrian', 4);
            $table->enum('status_antrian', ['1', '2', '3']);
            $table->string('no_rkm_medis');
            $table->dateTime('estimasi');
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
        Schema::dropIfExists('antrian');
    }
};
