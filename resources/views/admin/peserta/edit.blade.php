@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Peserta</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kegiatan -->
                        <div class="mb-3">
                            <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                            <select name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}" @if($peserta->kegiatan_id == $kegiatan->id) selected @endif>
                                        {{ $kegiatan->nama_kegiatan }} ({{ $kegiatan->tahun }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kegiatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ $peserta->nama }}" placeholder="Masukkan nama peserta">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Instansi -->
                        <div class="mb-3">
                            <label class="form-label">Instansi</label>
                            <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror"
                                   value="{{ $peserta->instansi }}" placeholder="Nama instansi">
                            @error('instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ $peserta->email }}" placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                                   value="{{ $peserta->no_telp }}" placeholder="08xx-xxxx-xxxx">
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                      rows="3" placeholder="Alamat peserta">{{ $peserta->alamat }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">
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