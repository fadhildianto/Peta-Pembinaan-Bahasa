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
        $kegiatans = Kegiatan::orderByDesc('tahun')
            ->orderBy('nama_kegiatan')
            ->get();

        return view('admin.arsip.create', compact('kegiatans'));
    }

    /**
     * Store a newly created arsip in storage
     */
    public function store(StoreArsipRequest $request)
    {
        $validated = $request->validated();
        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        $extension = strtolower($file->getClientOriginalExtension());
        $extension = $extension === 'jpeg' ? 'jpg' : $extension;

        Arsip::create([
            'kegiatan_id' => $validated['kegiatan_id'],
            'nama_file' => $validated['nama_file'],
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
        if (! Storage::disk('public')->exists($arsip->path_file)) {
            abort(404, 'File arsip tidak ditemukan');
        }

        $downloadName = $arsip->nama_file . '.' . $arsip->tipe_file;

        return response()->download(
            Storage::disk('public')->path($arsip->path_file),
            $downloadName
        );
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
