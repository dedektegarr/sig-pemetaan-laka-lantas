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
        Schema::table('lokasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kecamatan')->after('kota_kabupaten');
            $table->unsignedBigInteger('id_kelurahan')->after('id_kecamatan');

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokasi', function (Blueprint $table) {
            //
        });
    }
};
