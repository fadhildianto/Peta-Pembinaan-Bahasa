<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Lokasi;
use App\Models\Peserta;
use App\Models\Arsip;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalKegiatan = Kegiatan::count();
        $totalLokasi = Lokasi::count();
        $totalPeserta = Peserta::count();
        $totalArsip = Arsip::count();

        // Get recent kegiatans
        $kegiatanTerbaru = Kegiatan::with('lokasi', 'createdBy')
            ->withCount(['peserta', 'arsip'])
            ->latest()
            ->take(5)
            ->get();

        // Chart Data: Kegiatan per Tahun
        $kegiatanPerTahun = Kegiatan::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get()
            ->pluck('total', 'tahun');

        // Chart Data: Kegiatan per Jenis
        $kegiatanPerJenis = Kegiatan::select('jenis_kegiatan', DB::raw('count(*) as total'))
            ->groupBy('jenis_kegiatan')
            ->get()
            ->pluck('total', 'jenis_kegiatan');

        // Chart Data: Top 5 Lokasi by Kegiatan Count
        $topLokasi = Lokasi::withCount('kegiatans')
            ->orderByDesc('kegiatans_count')
            ->take(5)
            ->get()
            ->pluck('kegiatans_count', 'nama_kabupaten');

        // Chart Data: Peserta per Kegiatan (Top 5)
        $pesertaPerKegiatan = Kegiatan::select('nama_kegiatan')
            ->withCount('peserta')
            ->orderByDesc('peserta_count')
            ->take(5)
            ->get()
            ->pluck('peserta_count', 'nama_kegiatan');

        // Activity Statistics
        $kegiatanTahunIni = Kegiatan::whereYear('created_at', now()->year)->count();
        $pesertaBulanIni = Peserta::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.dashboard', compact(
            'totalKegiatan',
            'totalLokasi',
            'totalPeserta',
            'totalArsip',
            'kegiatanTerbaru',
            'kegiatanPerTahun',
            'kegiatanPerJenis',
            'topLokasi',
            'pesertaPerKegiatan',
            'kegiatanTahunIni',
            'pesertaBulanIni'
        ));
    }
}
