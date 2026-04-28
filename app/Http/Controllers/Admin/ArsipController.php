<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Models\Kegiatan;
use App\Http\Requests\StoreArsipRequest;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Display a listing of arsip
     */
    public function index()
    {
        $arsip = Arsip::with('kegiatan')->latest()->paginate(15);
        return view('admin.arsip.index', compact('arsip'));
    }

    /**
     * Show the form for creating a new arsip
     */
    public function create()
    {
        $kegiatans = Kegiatan::all();
        return view('admin.arsip.create', compact('kegiatans'));
    }

    /**
     * Store a newly created arsip in storage
     */
    public function store(StoreArsipRequest $request)
    {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('arsip', $filename, 'public');

        // Get file extension
        $extension = $file->getClientOriginalExtension();

        // Create arsip record
        Arsip::create([
            'kegiatan_id' => $request->kegiatan_id,
            'nama_file' => $request->nama_file,
            'path_file' => $path,
            'tipe_file' => $extension,
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('admin.arsip.index')
            ->with('success', 'File berhasil diunggah');
    }

    /**
     * Display the specified arsip (download/preview)
     */
    public function show(Arsip $arsip)
    {
        return response()->download(storage_path('app/public/' . $arsip->path_file));
    }

    /**
     * Remove the specified arsip from storage
     */
    public function destroy(Arsip $arsip)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($arsip->path_file)) {
            Storage::disk('public')->delete($arsip->path_file);
        }

        // Delete database record
        $arsip->delete();

        return redirect()->route('admin.arsip.index')
            ->with('success', 'File berhasil dihapus');
    }
}