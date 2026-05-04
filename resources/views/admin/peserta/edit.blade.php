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
                            <select id="kegiatan_id" name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}" data-jenis="{{ $kegiatan->jenis_kegiatan }}" @if(old('kegiatan_id', $peserta->kegiatan_id) == $kegiatan->id) selected @endif>
                                        {{ $kegiatan->nama_kegiatan }} ({{ $kegiatan->tahun }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kegiatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama - untuk Penyuluhan Bahasa -->
                        <div class="mb-3" id="nama-field" style="display: none;">
                            <label class="form-label">Nama Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $peserta->nama) }}" placeholder="Masukkan nama peserta">
                            @error('nama')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Instansi/Lembaga -->
                        <div class="mb-3" id="instansi-field" style="display: none;">
                            <label class="form-label" id="instansi-label">Asal Instansi <span class="text-danger" id="instansi-required">*</span></label>
                            <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror"
                                   value="{{ old('instansi', $peserta->instansi) }}" id="instansi-input" placeholder="Nama instansi">
                            @error('instansi')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email - tersembunyi untuk Pembinaan Lembaga -->
                        <div class="mb-3" id="email-field" style="display: none;">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $peserta->email) }}" placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telepon - tersembunyi untuk Pembinaan Lembaga -->
                        <div class="mb-3" id="telp-field" style="display: none;">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                                   value="{{ old('no_telp', $peserta->no_telp) }}" placeholder="08xx-xxxx-xxxx">
                            @error('no_telp')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat - tersembunyi untuk Pembinaan Lembaga -->
                        <div class="mb-3" id="alamat-field" style="display: none;">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                      rows="3" placeholder="Alamat peserta">{{ old('alamat', $peserta->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Jenis Kegiatan -->
                        <div class="alert alert-info d-none" id="jenisInfo" role="alert">
                            <small id="jenisText"></small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kegiatanSelect = document.getElementById('kegiatan_id');
    const namaField = document.getElementById('nama-field');
    const instansiField = document.getElementById('instansi-field');
    const emailField = document.getElementById('email-field');
    const telpField = document.getElementById('telp-field');
    const alamatField = document.getElementById('alamat-field');
    
    const instansiLabel = document.getElementById('instansi-label');
    const instansiRequired = document.getElementById('instansi-required');
    const jenisInfo = document.getElementById('jenisInfo');
    const jenisText = document.getElementById('jenisText');
    
    const namaInput = document.querySelector('input[name="nama"]');
    const instansiInput = document.querySelector('input[name="instansi"]');
    const emailInput = document.querySelector('input[name="email"]');
    const telpInput = document.querySelector('input[name="no_telp"]');
    const alamatInput = document.querySelector('textarea[name="alamat"]');

    function updateFormFields() {
        const selectedOption = kegiatanSelect.options[kegiatanSelect.selectedIndex];
        const jenisKegiatan = selectedOption.getAttribute('data-jenis');

        if (jenisKegiatan === 'Penyuluhan Bahasa') {
            // Penyuluhan Bahasa: Nama & Instansi wajib
            namaField.style.display = 'block';
            instansiField.style.display = 'block';
            emailField.style.display = 'block';
            telpField.style.display = 'block';
            alamatField.style.display = 'block';
            
            instansiLabel.textContent = 'Asal Instansi ';
            instansiRequired.textContent = '*';
            
            // Update required attributes
            namaInput.required = true;
            instansiInput.required = true;
            emailInput.required = false;
            telpInput.required = false;
            alamatInput.required = false;
            
            // Show info
            jenisInfo.classList.remove('d-none');
            jenisText.textContent = '📋 Penyuluhan Bahasa - Isilah Nama Peserta dan Asal Instansi. Email, No Telepon, dan Alamat bersifat opsional.';
        } else if (jenisKegiatan === 'Pembinaan Lembaga') {
            // Pembinaan Lembaga: Hanya Instansi/Lembaga wajib
            namaField.style.display = 'none';
            instansiField.style.display = 'block';
            emailField.style.display = 'none';
            telpField.style.display = 'none';
            alamatField.style.display = 'none';
            
            instansiLabel.textContent = 'Nama Lembaga/Instansi ';
            instansiRequired.textContent = '*';
            
            // Update required attributes
            namaInput.required = false;
            instansiInput.required = true;
            emailInput.required = false;
            telpInput.required = false;
            alamatInput.required = false;
            
            // Show info
            jenisInfo.classList.remove('d-none');
            jenisText.textContent = '🏢 Pembinaan Lembaga - Hanya isilah Nama Lembaga/Instansi saja.';
        }
    }

    kegiatanSelect.addEventListener('change', updateFormFields);
    
    // Trigger on page load jika kegiatan sudah dipilih
    updateFormFields();
});
</script>

@endsection

