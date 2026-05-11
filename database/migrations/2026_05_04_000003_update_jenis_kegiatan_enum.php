<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            // Change from ENUM to VARCHAR to support longer values
            DB::statement("ALTER TABLE kegiatans MODIFY COLUMN jenis_kegiatan VARCHAR(50) NOT NULL DEFAULT 'Penyuluhan Bahasa'");
            
            // Update existing data
            DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'Penyuluhan Bahasa' WHERE jenis_kegiatan = 'penyuluhan'");
            DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'Pembinaan Lembaga' WHERE jenis_kegiatan = 'pembinaan'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            // Revert to original enum values
            DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'penyuluhan' WHERE jenis_kegiatan = 'Penyuluhan Bahasa'");
            DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'pembinaan' WHERE jenis_kegiatan = 'Pembinaan Lembaga'");
            DB::statement("ALTER TABLE kegiatans MODIFY COLUMN jenis_kegiatan ENUM('penyuluhan', 'pembinaan') NOT NULL");
        }
    }
};


