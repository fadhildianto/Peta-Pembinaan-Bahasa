@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Upload Arsip</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.arsip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Kegiatan -->
                        <div class="mb-3">
                            <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                            <select name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}" @if(old('kegiatan_id') == $kegiatan->id) selected @endif>
                                        {{ $kegiatan->nama_kegiatan }} ({{ $kegiatan->tahun }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kegiatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama File -->
                        <div class="mb-3">
                            <label class="form-label">Nama File <span class="text-danger">*</span></label>
                            <input type="text" name="nama_file" class="form-control @error('nama_file') is-invalid @enderror"
                                   value="{{ old('nama_file') }}" placeholder="Berikan nama deskriptif untuk file">
                            @error('nama_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label class="form-label">File <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <small class="form-text text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i>
                                Format: PDF, JPG, JPEG, PNG, DOC, DOCX (Max: 10 MB)
                            </small>
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Progress Bar -->
                        <div id="uploadProgress" class="mb-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     id="progressBar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-cloud-upload"></i> Upload
                            </button>
                            <a href="{{ route('admin.arsip.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightbulb"></i> Tips Upload</h5>
                </div>
                <div class="card-body small">
                    <ul>
                        <li>Gunakan nama file yang deskriptif (misal: "Dokumentasi_Kegiatan_2025")</li>
                        <li>Maksimal ukuran file adalah 10 MB</li>
                        <li>Pastikan file tidak corrupt sebelum upload</li>
                        <li>Untuk gambar, gunakan format PNG atau JPG dengan resolusi optimal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection