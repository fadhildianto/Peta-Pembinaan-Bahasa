@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Lokasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lokasi.update', $lokasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kabupaten -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kabupaten" 
                                   class="form-control @error('nama_kabupaten') is-invalid @enderror"
                                   value="{{ $lokasi->nama_kabupaten }}">
                            @error('nama_kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Latitude -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                <input type="number" name="latitude" step="0.0000001"
                                       class="form-control @error('latitude') is-invalid @enderror"
                                       value="{{ $lokasi->latitude }}"
                                       min="-90" max="90">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Range: -90 sampai 90</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                <input type="number" name="longitude" step="0.0000001"
                                       class="form-control @error('longitude') is-invalid @enderror"
                                       value="{{ $lokasi->longitude }}"
                                       min="-180" max="180">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Range: -180 sampai 180</small>
                            </div>
                        </div>

                        <!-- Zoom Level -->
                        <div class="mb-3">
                            <label class="form-label">Zoom Level</label>
                            <input type="number" name="zoom_level" 
                                   class="form-control @error('zoom_level') is-invalid @enderror"
                                   value="{{ $lokasi->zoom_level }}" 
                                   min="1" max="20">
                            @error('zoom_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Range: 1 (jauh) sampai 20 (dekat)</small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3">{{ $lokasi->deskripsi }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection