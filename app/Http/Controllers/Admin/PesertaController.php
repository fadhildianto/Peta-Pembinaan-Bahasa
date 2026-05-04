<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Kegiatan;
use App\Http\Requests\StorePesertaRequest;
use App\Http\Requests\UpdatePesertaRequest;

class PesertaController extends Controller
{
    /**
     * Display a listing of peserta
     */
    public function index()
    {
        $peserta = Peserta::with('kegiatan')->latest()->paginate(15);
        return view('admin.peserta.index', compact('peserta'));
    }

    /**
     * Show the form for creating a new peserta
     */
    public function create()
    {
        $kegiatans = Kegiatan::orderByDesc('tahun')
            ->orderBy('nama_kegiatan')
            ->get();

        return view('admin.peserta.create', compact('kegiatans'));
    }

    /**
     * Get kegiatan details for AJAX
     */
    public function getKegiatanDetails($id)
    {
        $kegiatan = Kegiatan::find($id);
        
        if (!$kegiatan) {
            return response()->json(['error' => 'Kegiatan not found'], 404);
        }

        return response()->json([
            'jenis_kegiatan' => $kegiatan->jenis_kegiatan
        ]);
    }

    /**
     * Store a newly created peserta in storage
     */
    public function store(StorePesertaRequest $request)
    {
        Peserta::create($request->validated());

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan');
    }

    /**
     * Display the specified peserta
     */
    public function show(Peserta $peserta)
    {
        return view('admin.peserta.show', compact('peserta'));
    }

    /**
     * Show the form for editing the specified peserta
     */
    public function edit(Peserta $peserta)
    {
        $kegiatans = Kegiatan::orderByDesc('tahun')
            ->orderBy('nama_kegiatan')
            ->get();

        return view('admin.peserta.edit', compact('peserta', 'kegiatans'));
    }

    /**
     * Update the specified peserta in storage
     */
    public function update(UpdatePesertaRequest $request, Peserta $peserta)
    {
        $peserta->update($request->validated());

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil diperbarui');
    }

    /**
     * Remove the specified peserta from storage
     */
    public function destroy(Peserta $peserta)
    {
        $peserta->delete();

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil dihapus');
    }
}
