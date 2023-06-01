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
            $table->unsignedBigInteger('id_kecamatan')->after('polresta')->nullable();
            $table->unsignedBigInteger('id_kelurahan')->after('id_kecamatan')->nullable();

            $table->foreign('id_kecamatan')->references('id')->on('kecamatan');
            $table->foreign('id_kelurahan')->references('id')->on('kelurahan');
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