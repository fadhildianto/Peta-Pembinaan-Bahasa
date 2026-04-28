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
        Schema::create('kegiatans', function (Blueprint $table) {
           $table->id();
            $table->string('nama_kegiatan');
            $table->enum('jenis_kegiatan', ['penyuluhan', 'pembinaan']);
            $table->year('tahun');
            $table->foreignId('lokasi_id')->constrained()->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
