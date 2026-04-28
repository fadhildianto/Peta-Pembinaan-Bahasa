@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Kegiatan</h3>

    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jenis Kegiatan</label>
            <select name="jenis_kegiatan" class="form-control">
                <option value="penyuluhan">Penyuluhan</option>
                <option value="pembinaan">Pembinaan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi (Kabupaten)</label>
            <select name="lokasi_id" class="form-control">
                @foreach($lokasi as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_kabupaten }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <!-- Upload banyak file -->
        <div class="mb-3">
            <label>Dokumen</label>
            <input type="file" name="files[]" multiple class="form-control">
        </div>

        <!-- PESERTA DINAMIS -->
        <div class="mb-3">
            <label>Peserta</label>
            <div id="peserta-wrapper">
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="peserta_nama[]" class="form-control" placeholder="Nama">
                    </div>
                    <div class="col">
                        <input type="text" name="peserta_instansi[]" class="form-control" placeholder="Instansi">
                    </div>
                </div>
            </div>

            <button type="button" onclick="tambahPeserta()" class="btn btn-sm btn-primary">+ Tambah Peserta</button>
        </div>

        <button class="btn btn-success">Simpan</button>
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