@extends('peta.layout')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('peta.index') }}" class="btn btn-outline-primary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Peta
        </a>
    </div>
</div>

<!-- Header -->
<div class="card mb-4" style="border: none; background: linear-gradient(135deg, #003d7a 0%, #1a5c9a 100%); color: white;">
    <div class="card-body">
        <h2 class="mb-2"><i class="bi bi-geo-alt"></i> {{ $lokasi->nama_kabupaten }}</h2>
        <p class="mb-0">Informasi detail kegiatan dan peserta di lokasi ini</p>
    </div>
</div>

<!-- Info Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Kegiatan</h6>
                <div class="fs-3 fw-bold" style="color: #003d7a;">{{ $totalKegiatan }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Peserta</h6>
                <div class="fs-3 fw-bold" style="color: #28a745;">{{ $totalPeserta }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Arsip</h6>
                <div class="fs-3 fw-bold" style="color: #ffc107;">{{ $totalArsip }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Koordinat</h6>
                <small>
                    {{ number_format($lokasi->latitude, 4) }}<br>
                    {{ number_format($lokasi->longitude, 4) }}
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Lokasi Info -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Lokasi</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama Kabupaten:</strong> {{ $lokasi->nama_kabupaten }}</p>
                @if($lokasi->deskripsi)
                <p><strong>Deskripsi:</strong></p>
                <p>{{ $lokasi->deskripsi }}</p>
                @endif

                <hr>

                <p><strong>Koordinat:</strong></p>
                <p>
                    <small>
                        Latitude: {{ $lokasi->latitude }}<br>
                        Longitude: {{ $lokasi->longitude }}<br>
                        Zoom Level: {{ $lokasi->zoom_level }}
                    </small>
                </p>
            </div>
        </div>
    </div>

    <!-- Balai Info -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Balai Bahasa Provinsi Riau</h5>
            </div>
            <div class="card-body" style="font-size: 13px;">
                <p>{{ $infoBalai['deskripsi'] }}</p>

                <hr>

                <p class="mb-2">
                    <strong><i class="bi bi-geo-alt"></i> Alamat:</strong><br>
                    {{ $infoBalai['alamat'] }}
                </p>
                <p class="mb-2">
                    <strong><i class="bi bi-telephone"></i> Telepon:</strong><br>
                    <a href="tel:{{ $infoBalai['no_telp'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['no_telp'] }}
                    </a>
                </p>
                <p class="mb-2">
                    <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                    <a href="mailto:{{ $infoBalai['email'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['email'] }}
                    </a>
                </p>
                <p class="mb-0">
                    <strong><i class="bi bi-globe"></i> Website:</strong><br>
                    <a href="https://{{ $infoBalai['website'] }}" target="_blank" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['website'] }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Kegiatan -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Daftar Kegiatan di {{ $lokasi->nama_kabupaten }} ({{ $totalKegiatan }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th>Nama Kegiatan</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Tanggal</th>
                    <th>Peserta</th>
                    <th>Arsip</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatans as $kegiatan)
                <tr>
                    <td><strong>{{ $kegiatan->nama_kegiatan }}</strong></td>
                    <td>
                        @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                            <span class="badge" style="background: #0dcaf0; color: white;">Penyuluhan</span>
                        @else
                            <span class="badge" style="background: #ffc107; color: #333;">Pembinaan</span>
                        @endif
                    </td>
                    <td>{{ $kegiatan->tahun }}</td>
                    <td>
                        <small>
                            {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }} s/d
                            {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                        </small>
                    </td>
                    <td>
                        <span class="badge" style="background: #003d7a; color: white;">
                            {{ $kegiatan->peserta()->count() }}
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background: #6c757d; color: white;">
                            {{ $kegiatan->arsip()->count() }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </td>
                </tr>

                <!-- Detail Kegiatan (Collapsible) -->
                <tr class="table-light">
                    <td colspan="7">
                        <div class="collapse" id="detail{{ $kegiatan->id }}">
                            <div class="row mt-3 mb-3">
                                <!-- Peserta -->
                                <div class="col-md-6">
                                    <h6 style="color: #003d7a;"><i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})</h6>
                                    @if($kegiatan->peserta()->count() > 0)
                                        <div style="max-height: 250px; overflow-y: auto;">
                                            <table class="table table-sm table-borderless">
                                                <tbody>
                                                    @foreach($kegiatan->peserta as $p)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $p->nama }}</strong><br>
                                                            <small style="color: #666;">{{ $p->instansi ?? '-' }}</small><br>
                                                            <small style="color: #666;">{{ $p->email ?? $p->no_telp ?? '-' }}</small>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">Belum ada peserta</p>
                                    @endif
                                </div>

                                <!-- Arsip -->
                                <div class="col-md-6">
                                    <h6 style="color: #003d7a;"><i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip()->count() }})</h6>
                                    @if($kegiatan->arsip()->count() > 0)
                                        <div style="max-height: 250px; overflow-y: auto;">
                                            <div class="list-group list-group-flush">
                                                @foreach($kegiatan->arsip as $a)
                                                <div class="list-group-item">
                                                    <i class="bi bi-file-earmark"></i>
                                                    <strong>{{ $a->nama_file }}</strong><br>
                                                    <small style="color: #666;">
                                                        {{ strtoupper($a->tipe_file) }} • {{ $a->formatted_file_size }}
                                                    </small>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted">Belum ada arsip</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada kegiatan di lokasi ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection