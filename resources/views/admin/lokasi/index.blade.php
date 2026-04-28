@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Data Lokasi</h3>

    <a href="{{ route('lokasi.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kabupaten</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lokasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kabupaten }}</td>
                <td>{{ $item->latitude }}</td>
                <td>{{ $item->longitude }}</td>
                <td>
                    <a href="{{ route('lokasi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('lokasi.destroy', $item->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection