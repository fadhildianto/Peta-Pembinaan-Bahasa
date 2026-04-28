@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kegiatan</h3>

    <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control"
                   value="{{ $kegiatan->nama_kegiatan }}">
        </div>

        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control"
                   value="{{ $kegiatan->tahun }}">
        </div>

        <div class="mb-3">
            <label>Jenis Kegiatan</label>
            <select name="jenis_kegiatan" class="form-control">
                <option value="penyuluhan" 
                    {{ $kegiatan->jenis_kegiatan == 'penyuluhan' ? 'selected' : '' }}>
                    Penyuluhan
                </option>
                <option value="pembinaan" 
                    {{ $kegiatan->jenis_kegiatan == 'pembinaan' ? 'selected' : '' }}>
                    Pembinaan
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi (Kabupaten)</label>
            <select name="lokasi_id" class="form-control">
                @foreach($lokasi as $l)
                    <option value="{{ $l->id }}"
                        {{ $kegiatan->lokasi_id == $l->id ? 'selected' : '' }}>
                        {{ $l->nama_kabupaten }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $kegiatan->deskripsi }}</textarea>
        </div>

        <!-- Upload file baru -->
        <div class="mb-3">
            <label>Tambah Dokumen Baru</label>
            <input type="file" name="files[]" multiple class="form-control">
        </div>

        <!-- Tampilkan file lama -->
        <div class="mb-3">
            <label>Dokumen Lama</label>
            <ul>
                @foreach($kegiatan->arsip as $file)
                    <li>{{ $file->nama_file }}</li>
                @endforeach
            </ul>
        </div>

        <!-- PESERTA -->
        <div class="mb-3">
            <label>Peserta</label>
            <div id="peserta-wrapper">

                @foreach($kegiatan->peserta as $p)
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="peserta_nama[]" class="form-control"
                               value="{{ $p->nama }}">
                    </div>
                    <div class="col">
                        <input type="text" name="peserta_instansi[]" class="form-control"
                               value="{{ $p->instansi }}">
                    </div>
                </div>
                @endforeach

            </div>

            <button type="button" onclick="tambahPeserta()" class="btn btn-sm btn-primary">
                + Tambah Peserta
            </button>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>

<script>
function tambahPeserta() {
    let html = `
    <div class="row mb-2">
        <div class="col">
            <input type="text" name="peserta_nama[]" class="form-control" placeholder="Nama">
        </div>
        <div class="col">
            <input type="text" name="peserta_instansi[]" class="form-control" placeholder="Instansi">
        </div>
    </div>`;
    document.getElementById('peserta-wrapper').insertAdjacentHTML('beforeend', html);
}
</script>

@endsection