<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;

class PetaPublicController extends Controller
{
    /**
     * Display public interactive map
     */
    public function index()
    {
        // Info Balai Bahasa Provinsi Riau
        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'deskripsi' => 'Balai Bahasa Provinsi Riau adalah lembaga pemerintah yang bertugas melaksanakan pembinaan dan pengembangan bahasa, sastra, dan aksara Indonesia, serta melaksanakan pembinaan dan pengembangan bahasa-bahasa daerah.',
            'alamat' => 'Jl. Sudirman No. 123, Pekanbaru, Riau',
            'no_telp' => '(0761) 123456',
            'email' => 'info@balaibahasariau.go.id',
            'website' => 'www.balaibahasariau.go.id',
            'latitude' => 0.5431,
            'longitude' => 101.4477,
        ];

        return view('peta.index', compact('infoBalai'));
    }

    /**
     * Show detail lengkap lokasi (public)
     */
    public function show(Lokasi $lokasi)
    {
        $lokasi->load('kegiatans.peserta', 'kegiatans.arsip');

        // Get statistics
        $totalKegiatan = $lokasi->kegiatans()->count();
        $totalPeserta = $lokasi->kegiatans()
            ->withCount('peserta')
            ->get()
            ->sum('peserta_count');
        $totalArsip = $lokasi->kegiatans()
            ->withCount('arsip')
            ->get()
            ->sum('arsip_count');

        // Get kegiatans with details
        $kegiatans = $lokasi->kegiatans()
            ->with('peserta', 'arsip')
            ->latest()
            ->get();

        // Info Balai Bahasa
        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'deskripsi' => 'Balai Bahasa Provinsi Riau adalah lembaga pemerintah yang bertugas melaksanakan pembinaan dan pengembangan bahasa, sastra, dan aksara Indonesia.',
            'alamat' => 'Jl. Sudirman No. 123, Pekanbaru, Riau',
            'no_telp' => '(0761) 123456',
            'email' => 'info@balaibahasariau.go.id',
            'website' => 'www.balaibahasariau.go.id',
        ];

        return view('peta.show', compact(
            'lokasi',
            'totalKegiatan',
            'totalPeserta',
            'totalArsip',
            'kegiatans',
            'infoBalai'
        ));
    }
}