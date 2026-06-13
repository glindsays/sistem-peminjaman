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
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->id();
            // Kolom tanggal (format: YYYY-MM-DD). 
            $table->date('tanggal')->unique(); 
            // Keterangan libur/blokir, contoh: "Masa KRS Semester Genap" atau "Dies Natalis Kampus"
            $table->string('keterangan'); 
            // Tipe blokir untuk mengelompokkan jenis liburnya, contoh: "libur_nasional", "event_internal", "blokir_akademik"
            $table->string('tipe_blokir'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_libur');
    }
};
