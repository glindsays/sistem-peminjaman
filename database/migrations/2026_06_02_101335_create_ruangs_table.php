<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->integer('kapasitas');
            $table->string('lokasi');
            $table->string('status')->default('tersedia');
            $table->string('uppk');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ruang');
    }
};
