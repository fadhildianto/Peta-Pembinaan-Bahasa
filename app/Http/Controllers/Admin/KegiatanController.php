<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');
        $tahun = $request->input('tahun');

        $kegiatan = Kegiatan::query()
            ->with('lokasi')
            ->withCount(['peserta', 'arsip'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_kegiatan', 'like', '%' . $request->string('search') . '%');
            })
            ->when(in_array($jenis, ['penyuluhan', 'pembinaan'], true), function ($query) use ($jenis) {
                $query->where('jenis_kegiatan', $jenis);
            })
            ->when(is_numeric($tahun), function ($query) use ($tahun) {
                $query->where('tahun', (int) $tahun);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        $lokasi = Lokasi::orderBy('nama_kabupaten')->get();
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
        $kegiatan->load(['lokasi', 'peserta', 'arsip'])
            ->loadCount(['peserta', 'arsip']);

        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        $lokasi = Lokasi::orderBy('nama_kabupaten')->get();
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

