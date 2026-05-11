<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure all kegiatan use proper case enum values
        DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'Penyuluhan Bahasa' WHERE jenis_kegiatan = 'penyuluhan' OR jenis_kegiatan = 'Penyuluhan'");
        DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'Pembinaan Lembaga' WHERE jenis_kegiatan = 'pembinaan' OR jenis_kegiatan = 'Pembinaan'");
    }

    public function down(): void
    {
        // Revert to lowercase
        DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'penyuluhan' WHERE jenis_kegiatan = 'Penyuluhan Bahasa'");
        DB::statement("UPDATE kegiatans SET jenis_kegiatan = 'pembinaan' WHERE jenis_kegiatan = 'Pembinaan Lembaga'");
    }
};
