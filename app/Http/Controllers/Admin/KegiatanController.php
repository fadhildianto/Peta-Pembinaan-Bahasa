<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Lokasi;
use App\Models\Peserta;
use App\Models\Arsip;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tahun' => $request->tahun,
            'lokasi_id' => $request->lokasi_id,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request->peserta_nama) {
            foreach ($request->peserta_nama as $i => $nama) {
                Peserta::create([
                    'kegiatan_id' => $kegiatan->id,
                    'nama' => $nama,
                    'instansi' => $request->peserta_instansi[$i],
                ]);
            }
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('arsip', 'public');

                Arsip::create([
                    'kegiatan_id' => $kegiatan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                ]);
            }
        }

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::with(['lokasi', 'peserta', 'arsip'])
            ->findOrFail($id);

        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $lokasi = Lokasi::all();

        return view('admin.kegiatan.edit', compact('kegiatan', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tahun' => $request->tahun,
            'lokasi_id' => $request->lokasi_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Data berhasil dihapus');
    }
}



