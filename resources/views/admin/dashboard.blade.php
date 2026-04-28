@extends('admin.layouts.app')

@section('content')
<h3>Dashboard</h3>

<div class="row mb-4">
    <div class="col">
        <div class="card p-3 text-center">
            <h5>{{ $totalKegiatan }}</h5>
            <p>Kegiatan</p>
        </div>
    </div>

    <div class="col">
        <div class="card p-3 text-center">
            <h5>{{ $totalLokasi }}</h5>
            <p>Lokasi</p>
        </div>
    </div>

    <div class="col">
        <div class="card p-3 text-center">
            <h5>{{ $totalArsip }}</h5>
            <p>Arsip</p>
        </div>
    </div>
</div>

<div class="card p-3">
    <h5>Arsip Terbaru</h5>

    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Lokasi</th>
        </tr>

        @foreach($arsipTerbaru as $k)
        <tr>
            <td>{{ $k->nama_kegiatan }}</td>
            <td>{{ $k->lokasi->nama_kabupaten }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection