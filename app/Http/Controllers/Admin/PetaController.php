<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;

class PetaController extends Controller
{
    /**
     * Display the map view
     */
    public function index()
    {
        // Info Balai Bahasa Provinsi Riau
        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'alamat' => 'Jl. HR. Soebrantas Panam No.Km. 12,5, Simpang Baru, Kec. Tuah Madani, Kota Pekanbaru, Riau 28292',
            'no_telp' => '(0761) 3223048',
            'email' => 'balaibahasariau@kemendikdasmen.go.id',
            'website' => 'balaibahasariau.kemendikdasmen.go.id',
            'latitude' => 0.5431,
            'longitude' => 101.4477,
        ];

        return view('admin.peta.index', compact('infoBalai'));
    }

    /**
     * Get all locations with kegiatan count (API)
     */
    public function getMapData()
    {
        $isAdminRoute = request()->routeIs('admin.*');
        $detailRoute = $isAdminRoute ? 'admin.peta.show' : 'peta.detail';

        $lokasis = Lokasi::with([
                'kegiatans' => fn ($query) => $query->withCount(['peserta', 'arsip']),
            ])
            ->withCount('kegiatans')
            ->get()
            ->map(function ($lokasi) use ($detailRoute) {
                // Hitung breakdown per jenis kegiatan
                $penyuluhanCount = $lokasi->kegiatans->where('jenis_kegiatan', 'penyuluhan')->count();
                $peminaanCount = $lokasi->kegiatans->where('jenis_kegiatan', 'pembinaan')->count();
                
                return [
                    'id' => $lokasi->id,
                    'nama' => $lokasi->nama_kabupaten,
                    'latitude' => (float) $lokasi->latitude,
                    'longitude' => (float) $lokasi->longitude,
                    'deskripsi' => $lokasi->deskripsi ?? 'Lokasi di ' . $lokasi->nama_kabupaten,
                    'zoom_level' => $lokasi->zoom_level,
                    'kegiatan_count' => $lokasi->kegiatans_count,
                    'kegiatan_penyuluhan' => $penyuluhanCount,
                    'kegiatan_pembinaan' => $peminaanCount,
                    'peserta_count' => $lokasi->kegiatans->sum('peserta_count'),
                    'arsip_count' => $lokasi->kegiatans->sum('arsip_count'),
                    'detail_url' => route($detailRoute, $lokasi),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $lokasis,
        ]);
    }

    /**
     * Get all locations with kegiatan count per type (API)
     */
    public function getMapDataPerType()
    {
        $lokasis = Lokasi::with('kegiatans')
            ->get()
            ->map(function ($lokasi) {
                $kegiatans = $lokasi->kegiatans();
                
                return [
                    'id' => $lokasi->id,
                    'nama' => $lokasi->nama_kabupaten,
                    'latitude' => (float) $lokasi->latitude,
                    'longitude' => (float) $lokasi->longitude,
                    'deskripsi' => $lokasi->deskripsi ?? 'Lokasi di ' . $lokasi->nama_kabupaten,
                    'zoom_level' => $lokasi->zoom_level,
                    
                    // Breakdown per jenis kegiatan
                    'kegiatan_penyuluhan' => $kegiatans->where('jenis_kegiatan', 'penyuluhan')->count(),
                    'kegiatan_pembinaan' => $kegiatans->where('jenis_kegiatan', 'pembinaan')->count(),
                    'total_kegiatan' => $kegiatans->count(),
                    
                    // Total peserta dan arsip
                    'peserta_count' => $kegiatans
                        ->withCount('peserta')
                        ->get()
                        ->sum('peserta_count'),
                    'arsip_count' => $kegiatans
                        ->withCount('arsip')
                        ->get()
                        ->sum('arsip_count'),
                        
                    'detail_url' => route('peta.detail', $lokasi->id),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $lokasis,
        ]);
    }

    /**
     * Get kegiatans by lokasi (API)
     */
    public function getKegiatanByLokasi($lokasiId)
    {
        $lokasi = Lokasi::findOrFail($lokasiId);
        $kegiatans = $lokasi->kegiatans()
            ->withCount(['peserta', 'arsip'])
            ->get()
            ->map(function ($kegiatan) {
                return [
                    'id' => $kegiatan->id,
                    'nama' => $kegiatan->nama_kegiatan,
                    'jenis' => $kegiatan->jenis_kegiatan,
                    'tahun' => $kegiatan->tahun,
                    'tanggal_mulai' => $kegiatan->tanggal_mulai?->format('d M Y'),
                    'tanggal_selesai' => $kegiatan->tanggal_selesai?->format('d M Y'),
                    'deskripsi' => $kegiatan->deskripsi,
                    'peserta_count' => $kegiatan->peserta_count,
                    'arsip_count' => $kegiatan->arsip_count,
                ];
            });

        return response()->json([
            'status' => 'success',
            'lokasi' => [
                'id' => $lokasi->id,
                'nama' => $lokasi->nama_kabupaten,
                'latitude' => (float) $lokasi->latitude,
                'longitude' => (float) $lokasi->longitude,
                'detail_url' => route('peta.detail', $lokasi),
            ],
            'kegiatans' => $kegiatans,
        ]);
    }

    /**
     * Show detail lengkap lokasi
     */
    public function show(Lokasi $lokasi)
    {
        $kegiatans = $lokasi->kegiatans()
            ->with('peserta', 'arsip')
            ->withCount(['peserta', 'arsip'])
            ->latest()
            ->get();

        $totalKegiatan = $kegiatans->count();
        $totalPeserta = $kegiatans->sum('peserta_count');
        $totalArsip = $kegiatans->sum('arsip_count');

        $infoBalai = [
            'nama' => 'Balai Bahasa Provinsi Riau',
            'alamat' => 'Jl. HR. Soebrantas Panam No.Km. 12,5, Simpang Baru, Kec. Tuah Madani, Kota Pekanbaru, Riau 28292',
            'no_telp' => '(0761) 3223048',
            'email' => 'balaibahasariau@kemendikdasmen.go.id',
            'website' => 'balaibahasariau.kemendikdasmen.go.id',
        ];

        return view('admin.peta.show', compact(
            'lokasi',
            'totalKegiatan',
            'totalPeserta',
            'totalArsip',
            'kegiatans',
            'infoBalai'
        ));
    }
}
