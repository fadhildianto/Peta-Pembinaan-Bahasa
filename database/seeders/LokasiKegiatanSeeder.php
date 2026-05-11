<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Kegiatan;
use Illuminate\Database\Seeder;

class LokasiKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Create lokasi
        $lokasi = Lokasi::create([
            'nama_kabupaten' => 'Indragiri Hulu',
            'latitude' => 0.511197,
            'longitude' => 101.429987,
        ]);

        // Create kegiatan
        Kegiatan::create([
            'nama_kegiatan' => 'Penyuluhan Bahasa Kabupaten Indragiri Hulu',
            'jenis_kegiatan' => 'Penyuluhan Bahasa',
            'lokasi_id' => $lokasi->id,
            'tahun' => 2026,
            'created_by' => 1,
        ]);

        Kegiatan::create([
            'nama_kegiatan' => 'Pembinaan Lembaga Pendidikan Indragiri Hulu',
            'jenis_kegiatan' => 'Pembinaan Lembaga',
            'lokasi_id' => $lokasi->id,
            'tahun' => 2026,
            'created_by' => 1,
        ]);
    }
}
