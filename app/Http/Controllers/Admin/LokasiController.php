<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::latest()->get();
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Data berhasil dihapus');
    }
}