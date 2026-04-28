@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Data Kegiatan</h3>

    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Tahun</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kegiatan }}</td>
                <td>{{ $item->jenis_kegiatan }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->lokasi->nama_kabupaten ?? '-' }}</td>>
                <td>
                <a href="{{ route('kegiatan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>

                <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection