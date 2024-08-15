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
        Schema::create('jadwal_tayangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_movie');
            $table->unsignedBigInteger('id_studio');
            $table->date('tanggal_tayang');
            $table->time('jam_tayang');
            $table->string('harga_tiket');
            $table->timestamps();
            $table->foreign('id_movie')->references('id')->on('movies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_studio')->references('id')->on('studios')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_tayangs');
    }
};
