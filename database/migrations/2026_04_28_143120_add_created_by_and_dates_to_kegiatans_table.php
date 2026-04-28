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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('lokasi_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_mulai')->nullable()->after('deskripsi');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn(['created_by', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};
