@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Lokasi Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lokasi.store') }}" method="POST">
                        @csrf

                        <!-- Nama Kabupaten -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kabupaten" 
                                   class="form-control @error('nama_kabupaten') is-invalid @enderror"
                                   value="{{ old('nama_kabupaten') }}" 
                                   placeholder="Misal: Jakarta Selatan">
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
                                       value="{{ old('latitude') }}" 
                                       placeholder="-6.2088"
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
                                       value="{{ old('longitude') }}" 
                                       placeholder="106.8456"
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
                                   value="{{ old('zoom_level', 12) }}" 
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
                                      rows="3" placeholder="Deskripsi lokasi...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Card -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Tips:</strong> Anda bisa mendapatkan koordinat dari 
                            <a href="https://maps.google.com" target="_blank" class="alert-link">Google Maps</a>.
                            Klik lokasi lalu lihat latitude & longitude di URL.
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan
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