<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Lokasi;
use App\Models\Arsip;
class DashboardController extends Controller
{
    public function index()
    {
        $totalKegiatan = Kegiatan::count();
        $totalLokasi = Lokasi::count();
        $totalArsip = Arsip::count();

        $arsipTerbaru = Kegiatan::with('lokasi')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalKegiatan',
            'totalLokasi',
            'totalArsip',
            'arsipTerbaru'
        ));
    }
}
