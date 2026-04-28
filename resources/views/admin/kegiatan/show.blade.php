@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>Detail Kegiatan</h3>

    <div class="card p-3 mb-3">
        <p><strong>Nama:</strong> {{ $kegiatan->nama_kegiatan }}</p>
        <p><strong>Jenis:</strong> {{ $kegiatan->jenis_kegiatan }}</p>
        <p><strong>Tahun:</strong> {{ $kegiatan->tahun }}</p>
        <p><strong>Lokasi:</strong> {{ $kegiatan->lokasi->nama_kabupaten }}</p>
        <p><strong>Deskripsi:</strong> {{ $kegiatan->deskripsi }}</p>
    </div>

    <!-- PESERTA -->
    <div class="card p-3 mb-3">
        <h5>Peserta</h5>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <th>Instansi</th>
            </tr>
            @foreach($kegiatan->peserta as $p)
            <tr>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->instansi }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- ARSIP -->
    <div class="card p-3">
        <h5>Dokumen</h5>
        <ul>
            @foreach($kegiatan->arsip as $a)
                <li>
                    <a href="{{ asset('storage/'.$a->path_file) }}" target="_blank">
                        {{ $a->nama_file }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection