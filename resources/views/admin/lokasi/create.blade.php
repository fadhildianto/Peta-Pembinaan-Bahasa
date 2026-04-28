@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Lokasi</h3>

    <form action="{{ route('lokasi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Kabupaten</label>
            <input type="text" name="nama_kabupaten" class="form-control">
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control">
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection