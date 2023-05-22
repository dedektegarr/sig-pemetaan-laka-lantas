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
        Schema::create('kecelakaan', function (Blueprint $table) {
            $table->id('id_kecelakaan');
            $table->unsignedBigInteger('id_lokasi');
            $table->string('no_laka')->unique();
            $table->integer('luka_ringan');
            $table->integer('luka_berat');
            $table->integer('meninggal');
            $table->datetime('tanggal');
            $table->timestamps();

            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecelakaan');
    }
};
