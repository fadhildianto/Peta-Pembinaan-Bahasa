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
        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'deskripsi' => 'Balai Bahasa Provinsi Riau adalah lembaga pemerintah yang bertugas melaksanakan pembinaan dan pengembangan bahasa, sastra, dan aksara Indonesia, serta melaksanakan pembinaan dan pengembangan bahasa-bahasa daerah.',
            'alamat' => 'Jl. HR. Soebrantas Panam No.Km. 12,5, Simpang Baru, Kec. Tuah Madani, Kota Pekanbaru, Riau 28292',
            'no_telp' => '(0761) 3223048',
            'email' => 'balaibahasariau@kemendikdasmen.go.id',
            'website' => 'balaibahasariau.kemendikdasmen.go.id',
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
        $kegiatans = $lokasi->kegiatans()
            ->with('arsip')
            ->withCount(['peserta', 'arsip'])
            ->latest()
            ->get();

        $totalKegiatan = $kegiatans->count();
        $totalPeserta = $kegiatans->sum('peserta_count');
        $totalArsip = $kegiatans->sum('arsip_count');

        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'misi' => 'Melaksanakan pembinaan dan pengembangan bahasa, sastra, dan aksara Indonesia, serta melaksanakan pembinaan dan pengembangan bahasa-bahasa daerah.',
            'visi' => 'Terwujudnya pelindungan dan pengembangan bahasa serta sastra Indonesia yang kuat dan berkelanjutan.',
            'alamat' => 'Jl. HR. Soebrantas Panam No.Km. 12,5, Simpang Baru, Kec. Tuah Madani, Kota Pekanbaru, Riau 28292',
            'no_telp' => '(0761) 3223048',
            'email' => 'balaibahasariau@kemendikdasmen.go.id',
            'website' => 'balaibahasariau.kemendikdasmen.go.id',
        ];

        return view('peta.detail', compact(
            'lokasi',
            'totalKegiatan',
            'totalPeserta',
            'totalArsip',
            'kegiatans',
            'infoBalai'
        ));
    }
}
