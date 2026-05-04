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
        Schema::table('arsips', function (Blueprint $table) {
            $table->enum('tipe_file', ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'])->default('pdf')->after('nama_file');
            $table->bigInteger('file_size')->nullable()->after('tipe_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsips', function (Blueprint $table) {
            $table->dropColumn(['tipe_file', 'file_size']);
        });
    }
};
