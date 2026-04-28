@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-geo-alt"></i> Manajemen Lokasi</h2>
            <p class="text-muted">Total: {{ $lokasis->count() }} lokasi</p>
        </div>
        <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Lokasi
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kabupaten</th>
                        <th>Koordinat</th>
                        <th>Kegiatan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lokasis as $l)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $l->nama_kabupaten }}</strong>
                        </td>
                        <td>
                            <small>
                                {{ number_format($l->latitude, 4) }}, 
                                {{ number_format($l->longitude, 4) }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $l->kegiatans()->count() }}</span>
                        </td>
                        <td>
                            <small>{{ Str::limit($l->deskripsi, 40) ?? '-' }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.lokasi.edit', $l->id) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.lokasi.destroy', $l->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada lokasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection