<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use App\Models\Lokasi;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::with('lokasi')->latest()->get();
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        $lokasi = Lokasi::all();
        return view('admin.kegiatan.create', compact('lokasi'));
    }

    public function store(StoreKegiatanRequest $request)
    {
        Kegiatan::create(array_merge(
            $request->validated(),
            ['created_by' => auth()->id()]
        ));

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load(['lokasi', 'peserta', 'arsip']);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        $lokasi = Lokasi::all();
        return view('admin.kegiatan.edit', compact('kegiatan', 'lokasi'));
    }

    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan)
    {
        $kegiatan->update($request->validated());

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}



