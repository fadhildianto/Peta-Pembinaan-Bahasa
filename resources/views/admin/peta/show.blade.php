@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-geo-alt"></i> {{ $lokasi->nama_kabupaten }}</h2>
            <p class="text-muted">Detail lengkap lokasi dan kegiatan</p>
        </div>
        <a href="{{ route('admin.peta.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Peta
        </a>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Kegiatan</h6>
                    <div class="fs-3 fw-bold text-primary">{{ $totalKegiatan }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Peserta</h6>
                    <div class="fs-3 fw-bold text-success">{{ $totalPeserta }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Arsip</h6>
                    <div class="fs-3 fw-bold text-warning">{{ $totalArsip }}</div>
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

    <!-- Lokasi Info -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Lokasi</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Kabupaten:</strong> {{ $lokasi->nama_kabupaten }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <p>{{ $lokasi->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    
                    <hr>

                    <p><strong>Koordinat:</strong></p>
                    <p>
                        Latitude: {{ $lokasi->latitude }}<br>
                        Longitude: {{ $lokasi->longitude }}<br>
                        Zoom Level: {{ $lokasi->zoom_level }}
                    </p>

                    <p class="mb-0"><strong>Terdaftar sejak:</strong> {{ $lokasi->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-building"></i> Balai Bahasa Provinsi Riau</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>{{ $infoBalai['nama'] }}</strong>
                    </p>
                    <p class="mb-2" style="font-size: 13px;">
                        <strong>Alamat:</strong><br>
                        {{ $infoBalai['alamat'] }}
                    </p>
                    <p class="mb-2" style="font-size: 13px;">
                        <strong>Telepon:</strong><br>
                        <a href="tel:{{ $infoBalai['no_telp'] }}">{{ $infoBalai['no_telp'] }}</a>
                    </p>
                    <p class="mb-2" style="font-size: 13px;">
                        <strong>Email:</strong><br>
                        <a href="mailto:{{ $infoBalai['email'] }}">{{ $infoBalai['email'] }}</a>
                    </p>
                    <p style="font-size: 13px;">
                        <strong>Website:</strong><br>
                        <a href="https://{{ $infoBalai['website'] }}" target="_blank">{{ $infoBalai['website'] }}</a>
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
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th>Tanggal</th>
                        <th>Peserta</th>
                        <th>Arsip</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $kegiatan)
                    <tr>
                        <td><strong>{{ $kegiatan->nama_kegiatan }}</strong></td>
                        <td>
                            @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                                <span class="badge bg-info">Penyuluhan</span>
                            @else
                                <span class="badge bg-warning">Pembinaan</span>
                            @endif
                        </td>
                        <td>{{ $kegiatan->tahun }}</td>
                        <td>
                            <small>
                                {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }} s/d
                                {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                            </small>
                        </td>
                        <td><span class="badge bg-primary">{{ $kegiatan->peserta_count }}</span></td>
                        <td><span class="badge bg-secondary">{{ $kegiatan->arsip_count }}</span></td>
                        <td>
                            <a href="{{ route('admin.kegiatan.show', $kegiatan->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Detail Kegiatan (Collapsible) -->
                    <tr class="table-light">
                        <td colspan="7">
                            <button class="btn btn-sm btn-outline-secondary" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                                <i class="bi bi-chevron-down"></i> Tampilkan Peserta & Arsip
                            </button>

                            <div class="collapse mt-3" id="detail{{ $kegiatan->id }}">
                                <div class="row">
                                    <!-- Peserta -->
                                    <div class="col-md-6">
                                        <h6>Peserta ({{ $kegiatan->peserta_count }})</h6>
                                        @if($kegiatan->peserta_count > 0)
                                            <div style="max-height: 200px; overflow-y: auto;">
                                                <table class="table table-sm table-borderless">
                                                    <tbody>
                                                        @foreach($kegiatan->peserta as $p)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $p->nama }}</strong><br>
                                                                <small class="text-muted">{{ $p->instansi ?? '-' }}</small><br>
                                                                <small class="text-muted">{{ $p->email ?? $p->no_telp ?? '-' }}</small>
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
                                        <h6>Arsip ({{ $kegiatan->arsip_count }})</h6>
                                        @if($kegiatan->arsip_count > 0)
                                            <div style="max-height: 200px; overflow-y: auto;">
                                                <table class="table table-sm table-borderless">
                                                    <tbody>
                                                        @foreach($kegiatan->arsip as $a)
                                                        <tr>
                                                            <td>
                                                                <i class="bi bi-file-earmark"></i>
                                                                <strong>{{ $a->nama_file }}</strong><br>
                                                                <small class="text-muted">
                                                                    {{ strtoupper($a->tipe_file) }} &bull; {{ $a->formatted_file_size }}
                                                                </small><br>
                                                                <a href="{{ route('admin.arsip.show', $a->id) }}" 
                                                                   class="btn btn-xs btn-outline-primary mt-1"
                                                                   style="padding: 2px 6px; font-size: 11px;"
                                                                   download>
                                                                    <i class="bi bi-download"></i> Download
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
</div>

@endsection
