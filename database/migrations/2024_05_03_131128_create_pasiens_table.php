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
        Schema::create('pasien', function (Blueprint $table) {
            $table->string('no_rkm_medis', 8)->primary();
            $table->string('nik', 16)->unique();
            $table->string('nama_pasien', 50);
            $table->string('jenis_kelamin', 1);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->date('tanggal_daftar');
            $table->time('jam_daftar');
            $table->string('agama', 15);
            $table->string('pekerjaan', 50);
            $table->string('nomor_tlp', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('status_pernikahan', 15);
            $table->string('alamat', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
