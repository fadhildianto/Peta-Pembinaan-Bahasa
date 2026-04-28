@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Kegiatan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kegiatan.store') }}" method="POST">
                        @csrf

                        <!-- Nama Kegiatan -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kegiatan" 
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                   value="{{ old('nama_kegiatan') }}" 
                                   placeholder="Misal: Penyuluhan Bahasa Indonesia">
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Kegiatan -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                                <select name="jenis_kegiatan" 
                                        class="form-select @error('jenis_kegiatan') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="penyuluhan" @if(old('jenis_kegiatan') == 'penyuluhan') selected @endif>Penyuluhan</option>
                                    <option value="pembinaan" @if(old('jenis_kegiatan') == 'pembinaan') selected @endif>Pembinaan</option>
                                </select>
                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" 
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       value="{{ old('tahun', now()->year) }}" 
                                       min="2000" max="2100">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <select name="lokasi_id" 
                                    class="form-select @error('lokasi_id') is-invalid @enderror">
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasi as $lok)
                                    <option value="{{ $lok->id }}" @if(old('lokasi_id') == $lok->id) selected @endif>
                                        {{ $lok->nama_kabupaten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" 
                                       class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                       value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" 
                                       class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                       value="{{ old('tanggal_selesai') }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4" placeholder="Deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">
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