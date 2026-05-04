<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('kegiatans', 'created_by')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            });
        }

        if (Schema::getConnection()->getDriverName() === 'mysql' && Schema::hasColumn('arsips', 'tipe_file')) {
            DB::statement("ALTER TABLE arsips MODIFY tipe_file ENUM('pdf','jpg','jpeg','png','doc','docx') NOT NULL DEFAULT 'pdf'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kegiatans', 'created_by')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        if (Schema::getConnection()->getDriverName() === 'mysql' && Schema::hasColumn('arsips', 'tipe_file')) {
            DB::table('arsips')->where('tipe_file', 'jpeg')->update(['tipe_file' => 'jpg']);
            DB::statement("ALTER TABLE arsips MODIFY tipe_file ENUM('pdf','jpg','png','doc','docx') NOT NULL DEFAULT 'pdf'");
        }
    }
};
