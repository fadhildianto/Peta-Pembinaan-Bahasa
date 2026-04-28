@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Edit Lokasi</h3>

    <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kabupaten</label>
            <input type="text" name="nama_kabupaten" value="{{ $lokasi->nama_kabupaten }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" value="{{ $lokasi->latitude }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" value="{{ $lokasi->longitude }}" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection