<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::withCount('kegiatans')
            ->latest()
            ->get();

        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(StoreLokasiRequest $request)
    {
        Lokasi::create($request->validated());

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(UpdateLokasiRequest $request, Lokasi $lokasi)
    {
        $lokasi->update($request->validated());

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil diperbarui');
    }

    public function destroy(Lokasi $lokasi)
    {
        // Check if lokasi has kegiatans
        if ($lokasi->kegiatans()->exists()) {
            return redirect()->route('admin.lokasi.index')
                ->with('error', 'Tidak bisa menghapus lokasi yang masih memiliki kegiatan');
        }

        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}
