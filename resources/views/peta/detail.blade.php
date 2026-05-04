@extends('peta.layout')

@section('content')

<style>
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-up {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 61, 122, 0.15);
        border-color: #003d7a;
    }

    .kegiatan-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e0e0e0;
    }

    .kegiatan-row:hover {
        background-color: #f8f9fa;
    }

    .collapse-btn {
        transition: all 0.3s ease;
    }

    .collapse-btn:hover {
        background-color: #003d7a !important;
        color: white !important;
        transform: scale(1.05);
    }

    .badge-custom {
        transition: all 0.2s ease;
    }

    .badge-custom:hover {
        transform: scale(1.1);
    }

    .info-card {
        border-left: 4px solid #003d7a;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 15px rgba(0, 61, 122, 0.1);
        transform: translateX(5px);
    }

    .btn-back {
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        transform: translateX(-3px);
    }

    /* Deskripsi Container */
    .deskripsi-container {
        background: white;
        border-left: 5px solid #003d7a;
        padding: 25px;
        margin: 0 0 20px 0;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 61, 122, 0.08);
    }

    .deskripsi-section {
        margin-bottom: 18px;
    }

    .deskripsi-section:last-child {
        margin-bottom: 0;
    }

    .deskripsi-title {
        color: #003d7a;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .deskripsi-content {
        color: #555;
        line-height: 1.7;
        font-size: 14px;
    }

    .deskripsi-content ul {
        margin: 0;
        padding-left: 18px;
    }

    .deskripsi-content li {
        margin-bottom: 8px;
        color: #666;
    }

    .peserta-list, .arsip-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .peserta-item, .arsip-item {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.2s ease;
    }

    .peserta-item:hover, .arsip-item:hover {
        background-color: #f8f9fa;
        padding-left: 16px;
    }

    .peserta-item:last-child, .arsip-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 15px;
        }
    }
</style>

<!-- Breadcrumb & Back Button -->
<div class="mb-4 fade-in">
    <a href="{{ route('peta.index') }}" class="btn btn-sm btn-outline-primary btn-back mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Peta
    </a>
</div>

<!-- Header Section -->
<div class="card mb-4 fade-in" style="border: none; background: linear-gradient(135deg, #003d7a 0%, #1a5c9a 100%); color: white; overflow: hidden;">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2" style="font-weight: 700; font-size: 2.5rem;">
                    <i class="bi bi-geo-alt-fill"></i> {{ $lokasi->nama_kabupaten }}
                </h1>
                <p class="mb-0" style="font-size: 16px; opacity: 0.95;">
                    Informasi lengkap kegiatan dan peserta Balai Bahasa
                </p>
            </div>
            <div class="col-md-4 text-center" style="opacity: 0.9;">
                <i class="bi bi-map" style="font-size: 4rem;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4 slide-up">
    <div class="col-md-3 mb-3">
        <div class="card stat-card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-3" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">
                    <i class="bi bi-calendar-event"></i> Total Kegiatan
                </h6>
                <div style="font-size: 2.5rem; font-weight: 700; color: #003d7a;">
                    {{ $totalKegiatan }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-3" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">
                    <i class="bi bi-people"></i> Total Peserta
                </h6>
                <div style="font-size: 2.5rem; font-weight: 700; color: #28a745;">
                    {{ $totalPeserta }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-3" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">
                    <i class="bi bi-file-earmark"></i> Total Arsip
                </h6>
                <div style="font-size: 2.5rem; font-weight: 700; color: #ffc107;">
                    {{ $totalArsip }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card text-center">
            <div class="card-body">
                <h6 class="text-muted mb-3" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">
                    <i class="bi bi-globe"></i> Koordinat
                </h6>
                <small style="font-size: 12px; line-height: 1.6;">
                    <strong>{{ number_format($lokasi->latitude, 4) }}</strong><br>
                    <strong>{{ number_format($lokasi->longitude, 4) }}</strong>
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Lokasi Info & Balai Info -->
    <div class="col-lg-8 mb-4 slide-up">
        <div class="card info-card">
            <div class="card-header" style="background: #003d7a; color: white; border: none;">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Lokasi</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 8px;">Nama Kabupaten</h6>
                    <p style="font-size: 16px; margin: 0;">{{ $lokasi->nama_kabupaten }}</p>
                </div>

                @if($lokasi->deskripsi)
                <div class="mb-4">
                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 8px;">Deskripsi</h6>
                    <p style="font-size: 14px; color: #555; line-height: 1.6;">{{ $lokasi->deskripsi }}</p>
                </div>
                @endif

                <hr>

                <div>
                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 8px;">Detail Koordinat</h6>
                    <div class="row" style="font-size: 13px;">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Latitude:</strong><br>
                                <code style="background: #f8f9fa; padding: 4px 8px; border-radius: 3px;">{{ $lokasi->latitude }}</code>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong>Longitude:</strong><br>
                                <code style="background: #f8f9fa; padding: 4px 8px; border-radius: 3px;">{{ $lokasi->longitude }}</code>
                            </p>
                        </div>
                    </div>
                    <p style="font-size: 12px; color: #999; margin-top: 8px;">
                        <strong>Zoom Level:</strong> {{ $lokasi->zoom_level }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4 slide-up">
        <div class="card info-card">
            <div class="card-header" style="background: #003d7a; color: white; border: none;">
                <h5 class="mb-0"><i class="bi bi-building"></i> Balai Bahasa Provinsi Riau</h5>
            </div>
            <div class="card-body" style="font-size: 13px;">
                <div class="mb-3">
                    <h6 style="color: #003d7a; font-weight: 700;">Visi</h6>
                    <p style="color: #555; line-height: 1.5; margin: 0;">{{ $infoBalai['visi'] }}</p>
                </div>

                <div class="mb-3">
                    <h6 style="color: #003d7a; font-weight: 700;">Misi</h6>
                    <p style="color: #555; line-height: 1.5; margin: 0;">{{ $infoBalai['misi'] }}</p>
                </div>

                <hr>

                <p class="mb-2">
                    <i class="bi bi-geo-alt" style="color: #003d7a;"></i> <strong>Alamat:</strong><br>
                    <small style="color: #666;">{{ $infoBalai['alamat'] }}</small>
                </p>
                <p class="mb-2">
                    <i class="bi bi-telephone" style="color: #003d7a;"></i> <strong>Telepon:</strong><br>
                    <a href="tel:{{ $infoBalai['no_telp'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['no_telp'] }}
                    </a>
                </p>
                <p class="mb-2">
                    <i class="bi bi-envelope" style="color: #003d7a;"></i> <strong>Email:</strong><br>
                    <a href="mailto:{{ $infoBalai['email'] }}" style="color: #003d7a; text-decoration: none; word-break: break-all;">
                        {{ $infoBalai['email'] }}
                    </a>
                </p>
                <p class="mb-0">
                    <i class="bi bi-globe" style="color: #003d7a;"></i> <strong>Website:</strong><br>
                    <a href="https://{{ $infoBalai['website'] }}" target="_blank" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['website'] }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Kegiatan -->
<div class="card slide-up">
    <div class="card-header" style="background: #003d7a; color: white; border: none;">
        <h5 class="mb-0">
            <i class="bi bi-calendar-event"></i> Daftar Kegiatan di {{ $lokasi->nama_kabupaten }} 
            <span class="badge bg-warning text-dark float-end">{{ $totalKegiatan }}</span>
        </h5>
    </div>

    <!-- Filter Tabs -->
    <div style="background: white; border-bottom: 1px solid #e0e0e0;">
        <ul class="nav nav-tabs" role="tablist" style="padding: 15px 15px 0;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua-pane" type="button" role="tab" style="color: #003d7a; border: none; border-bottom: 3px solid transparent;">
                    <i class="bi bi-list"></i> Semua ({{ $totalKegiatan }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="penyuluhan-tab" data-bs-toggle="tab" data-bs-target="#penyuluhan-pane" type="button" role="tab" style="color: #003d7a; border: none; border-bottom: 3px solid transparent;">
                    <i class="bi bi-book"></i> Penyuluhan Bahasa 
                    <span class="badge bg-info ms-1">{{ $kegiatans->where('jenis_kegiatan', 'penyuluhan')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pembinaan-tab" data-bs-toggle="tab" data-bs-target="#pembinaan-pane" type="button" role="tab" style="color: #003d7a; border: none; border-bottom: 3px solid transparent;">
                    <i class="bi bi-building"></i> Pembinaan Lembaga 
                    <span class="badge bg-warning ms-1">{{ $kegiatans->where('jenis_kegiatan', 'pembinaan')->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Semua Kegiatan Tab -->
        <div class="tab-pane fade show active" id="semua-pane" role="tabpanel">
            @if($kegiatans->count() > 0)
            <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #003d7a;">
                <tr>
                    <th style="color: #003d7a; font-weight: 700;">Nama Kegiatan</th>
                    <th style="color: #003d7a; font-weight: 700;">Jenis</th>
                    <th style="color: #003d7a; font-weight: 700;">Tahun</th>
                    <th style="color: #003d7a; font-weight: 700;">Periode</th>
                    <th style="color: #003d7a; font-weight: 700;">Peserta</th>
                    <th style="color: #003d7a; font-weight: 700;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatans as $kegiatan)
                <tr class="kegiatan-row">
                    <td><strong style="color: #003d7a;">{{ $kegiatan->nama_kegiatan }}</strong></td>
                    <td>
                        @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                            <span class="badge badge-custom" style="background: #0dcaf0; color: white;">Penyuluhan</span>
                        @else
                            <span class="badge badge-custom" style="background: #ffc107; color: #333;">Pembinaan</span>
                        @endif
                    </td>
                    <td><strong>{{ $kegiatan->tahun }}</strong></td>
                    <td>
                        <small style="color: #666;">
                            {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }}<br>
                            s/d<br>
                            {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                        </small>
                    </td>
                    <td>
                        <span class="badge" style="background: #003d7a; color: white;">
                            {{ $kegiatan->peserta_count }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm collapse-btn btn-outline-primary" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                            <i class="bi bi-chevron-down"></i> Buka
                        </button>
                    </td>
                </tr>

                <!-- Detail Kegiatan (Collapsible) -->
                <tr class="table-light">
                    <td colspan="6" style="padding: 0; border: none;">
                        <div class="collapse" id="detail{{ $kegiatan->id }}">
                            <div style="padding: 0;">
                                <!-- Deskripsi Container (sesuai format gambar) -->
                                @if($kegiatan->deskripsi || $kegiatan->tanggal_mulai || $kegiatan->peserta()->count() > 0)
                                <div style="background: linear-gradient(135deg, rgba(0,61,122,0.05) 0%, rgba(255,193,7,0.05) 100%); border-left: 5px solid #003d7a; padding: 30px; margin-bottom: 20px;">
                    
                                    <!-- Tahun Header -->
                                    <div style="margin-bottom: 20px;">
                                        <div style="color: #003d7a; font-weight: 700; font-size: 16px;">Tahun {{ $kegiatan->tahun }}</div>
                                    </div>

                                    <!-- Nama Kegiatan -->
                                    <div style="margin-bottom: 15px;">
                                        <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Nama Kegiatan</div>
                                        <div style="color: #555; font-size: 14px;">{{ $kegiatan->nama_kegiatan }}</div>
                                    </div>

                                    <!-- Waktu Pelaksanaan -->
                                    <div style="margin-bottom: 15px;">
                                        <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Waktu Pelaksanaan</div>
                                        <div style="color: #555; font-size: 14px;">
                                            {{ $kegiatan->tanggal_mulai?->format('d F Y') ?? '-' }} - {{ $kegiatan->tanggal_selesai?->format('d F Y') ?? '-' }}
                                        </div>
                                    </div>

                                    <!-- Tujuan Kegiatan -->
                                    @if($kegiatan->deskripsi)
                                    <div style="margin-bottom: 15px;">
                                        <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Tujuan Kegiatan</div>
                                        <div style="color: #555; font-size: 14px; line-height: 1.7;">
                                            {!! nl2br(e($kegiatan->deskripsi)) !!}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Narasumber (dari peserta) -->
                                    @if($kegiatan->peserta()->count() > 0)
                                    <div style="margin-bottom: 0;">
                                        <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Narasumber</div>
                                        <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                                            @foreach($kegiatan->peserta as $p)
                                            <li style="margin-bottom: 8px;">
                                                <strong>{{ $p->nama }}</strong>
                                                @if($p->instansi)
                                                <small style="color: #666;">
                                                    <i class="bi bi-building"></i> {{ $p->instansi }}
                                                </small><br>
                                                @endif
                                                @if($p->email)
                                                <small style="color: #999;">
                                                    <i class="bi bi-envelope"></i> {{ $p->email }}
                                                </small>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                    
                                </div>
                                @endif

                                <!-- Peserta & Arsip Section -->
                                <div style="padding: 20px; background: #fafafa;">
                                    <div class="row">
                                        <!-- Peserta -->
                                        <div class="col-md-6 mb-3">
                                            <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                            </h6>
                                            @if($kegiatan->peserta()->count() > 0)
                                                <div class="peserta-list">
                                                    @foreach($kegiatan->peserta as $p)
                                                    <div class="peserta-item">
                                                        <strong style="color: #003d7a;">{{ $p->nama }}</strong><br>
                                                        @if($p->instansi)
                                                        <small style="color: #666;">
                                                            <i class="bi bi-building"></i> {{ $p->instansi }}
                                                        </small><br>
                                                        @endif
                                                        @if($p->email)
                                                        <small style="color: #999;">
                                                            <i class="bi bi-envelope"></i> {{ $p->email }}
                                                        </small>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">Belum ada peserta</p>
                                            @endif
                                        </div>

                                        <!-- Arsip -->
                                        <div class="col-md-6 mb-3">
                                            <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                <i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip()->count() }})
                                            </h6>
                                            @if($kegiatan->arsip()->count() > 0)
                                                <div class="arsip-list">
                                                    @foreach($kegiatan->arsip as $a)
                                                    <div class="arsip-item">
                                                        <strong style="color: #003d7a;">{{ $a->nama_file }}</strong><br>
                                                        <small style="color: #666;">
                                                            <i class="bi bi-file-earmark"></i> {{ strtoupper($a->tipe_file) }}<br>
                                                            <i class="bi bi-file-size"></i> {{ $a->formatted_file_size }}
                                                        </small>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">Belum ada arsip</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
            </div>
            @else
            <div class="card-body text-center" style="padding: 40px;">
                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada kegiatan di kategori ini</p>
            </div>
            @endif
        </div>

        <!-- Penyuluhan Tab -->
        <div class="tab-pane fade" id="penyuluhan-pane" role="tabpanel">
            @php $penyuluhans = $kegiatans->where('jenis_kegiatan', 'penyuluhan'); @endphp
            @if($penyuluhans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa; border-bottom: 2px solid #003d7a;">
                        <tr>
                            <th style="color: #003d7a; font-weight: 700;">Nama Kegiatan</th>
                            <th style="color: #003d7a; font-weight: 700;">Jenis</th>
                            <th style="color: #003d7a; font-weight: 700;">Tahun</th>
                            <th style="color: #003d7a; font-weight: 700;">Periode</th>
                            <th style="color: #003d7a; font-weight: 700;">Peserta</th>
                            <th style="color: #003d7a; font-weight: 700;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyuluhans as $kegiatan)
                        <tr class="kegiatan-row">
                            <td><strong style="color: #003d7a;">{{ $kegiatan->nama_kegiatan }}</strong></td>
                            <td>
                                <span class="badge badge-custom" style="background: #0dcaf0; color: white;">Penyuluhan</span>
                            </td>
                            <td><strong>{{ $kegiatan->tahun }}</strong></td>
                            <td>
                                <small style="color: #666;">
                                    {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }}<br>
                                    s/d<br>
                                    {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge" style="background: #003d7a; color: white;">
                                    {{ $kegiatan->peserta()->count() }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm collapse-btn btn-outline-primary" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                                    <i class="bi bi-chevron-down"></i> Buka
                                </button>
                            </td>
                        </tr>

                        <!-- Detail Kegiatan (Collapsible) -->
                        <tr class="table-light">
                            <td colspan="6" style="padding: 0; border: none;">
                                <div class="collapse" id="detail{{ $kegiatan->id }}">
                                    <div style="padding: 0;">
                                        @if($kegiatan->deskripsi || $kegiatan->tanggal_mulai || $kegiatan->peserta()->count() > 0)
                                        <div style="background: linear-gradient(135deg, rgba(0,61,122,0.05) 0%, rgba(255,193,7,0.05) 100%); border-left: 5px solid #003d7a; padding: 30px; margin-bottom: 20px;">
                            
                                            <div style="margin-bottom: 20px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 16px;">Tahun {{ $kegiatan->tahun }}</div>
                                            </div>

                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Nama Kegiatan</div>
                                                <div style="color: #555; font-size: 14px;">{{ $kegiatan->nama_kegiatan }}</div>
                                            </div>

                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Waktu Pelaksanaan</div>
                                                <div style="color: #555; font-size: 14px;">
                                                    {{ $kegiatan->tanggal_mulai?->format('d F Y') ?? '-' }} - {{ $kegiatan->tanggal_selesai?->format('d F Y') ?? '-' }}
                                                </div>
                                            </div>

                                            @if($kegiatan->deskripsi)
                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Tujuan Kegiatan</div>
                                                <div style="color: #555; font-size: 14px; line-height: 1.7;">
                                                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                                                </div>
                                            </div>
                                            @endif

                                            @if($kegiatan->peserta()->count() > 0)
                                            <div style="margin-bottom: 0;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Narasumber</div>
                                                <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                                                    @foreach($kegiatan->peserta as $p)
                                                    <li style="margin-bottom: 8px;">
                                                        <strong>{{ $p->nama }}</strong>
                                                        @if($p->instansi)
                                                        <small style="color: #666;">
                                                            <i class="bi bi-building"></i> {{ $p->instansi }}
                                                        </small><br>
                                                        @endif
                                                        @if($p->email)
                                                        <small style="color: #999;">
                                                            <i class="bi bi-envelope"></i> {{ $p->email }}
                                                        </small>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                        
                                        </div>
                                        @endif

                                        <div style="padding: 20px; background: #fafafa;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                        <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                                    </h6>
                                                    @if($kegiatan->peserta()->count() > 0)
                                                        <div class="peserta-list">
                                                            @foreach($kegiatan->peserta as $p)
                                                            <div class="peserta-item">
                                                                <strong style="color: #003d7a;">{{ $p->nama }}</strong><br>
                                                                @if($p->instansi)
                                                                <small style="color: #666;">
                                                                    <i class="bi bi-building"></i> {{ $p->instansi }}
                                                                </small><br>
                                                                @endif
                                                                @if($p->email)
                                                                <small style="color: #999;">
                                                                    <i class="bi bi-envelope"></i> {{ $p->email }}
                                                                </small>
                                                                @endif
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Belum ada peserta</p>
                                                    @endif
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                        <i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip()->count() }})
                                                    </h6>
                                                    @if($kegiatan->arsip()->count() > 0)
                                                        <div class="arsip-list">
                                                            @foreach($kegiatan->arsip as $a)
                                                            <div class="arsip-item">
                                                                <strong style="color: #003d7a;">{{ $a->nama_file }}</strong><br>
                                                                <small style="color: #666;">
                                                                    <i class="bi bi-file-earmark"></i> {{ strtoupper($a->tipe_file) }}<br>
                                                                    <i class="bi bi-file-size"></i> {{ $a->formatted_file_size }}
                                                                </small>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Belum ada arsip</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body text-center" style="padding: 40px;">
                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada kegiatan di kategori ini</p>
            </div>
            @endif
        </div>

        <!-- Pembinaan Tab -->
        <div class="tab-pane fade" id="pembinaan-pane" role="tabpanel">
            @php $peminaans = $kegiatans->where('jenis_kegiatan', 'pembinaan'); @endphp
            @if($peminaans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa; border-bottom: 2px solid #003d7a;">
                        <tr>
                            <th style="color: #003d7a; font-weight: 700;">Nama Kegiatan</th>
                            <th style="color: #003d7a; font-weight: 700;">Jenis</th>
                            <th style="color: #003d7a; font-weight: 700;">Tahun</th>
                            <th style="color: #003d7a; font-weight: 700;">Periode</th>
                            <th style="color: #003d7a; font-weight: 700;">Peserta</th>
                            <th style="color: #003d7a; font-weight: 700;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminaans as $kegiatan)
                        <tr class="kegiatan-row">
                            <td><strong style="color: #003d7a;">{{ $kegiatan->nama_kegiatan }}</strong></td>
                            <td>
                                <span class="badge badge-custom" style="background: #ffc107; color: #333;">Pembinaan</span>
                            </td>
                            <td><strong>{{ $kegiatan->tahun }}</strong></td>
                            <td>
                                <small style="color: #666;">
                                    {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }}<br>
                                    s/d<br>
                                    {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge" style="background: #003d7a; color: white;">
                                    {{ $kegiatan->peserta()->count() }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm collapse-btn btn-outline-primary" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                                    <i class="bi bi-chevron-down"></i> Buka
                                </button>
                            </td>
                        </tr>

                        <!-- Detail Kegiatan (Collapsible) -->
                        <tr class="table-light">
                            <td colspan="6" style="padding: 0; border: none;">
                                <div class="collapse" id="detail{{ $kegiatan->id }}">
                                    <div style="padding: 0;">
                                        @if($kegiatan->deskripsi || $kegiatan->tanggal_mulai || $kegiatan->peserta()->count() > 0)
                                        <div style="background: linear-gradient(135deg, rgba(0,61,122,0.05) 0%, rgba(255,193,7,0.05) 100%); border-left: 5px solid #003d7a; padding: 30px; margin-bottom: 20px;">
                            
                                            <div style="margin-bottom: 20px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 16px;">Tahun {{ $kegiatan->tahun }}</div>
                                            </div>

                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Nama Kegiatan</div>
                                                <div style="color: #555; font-size: 14px;">{{ $kegiatan->nama_kegiatan }}</div>
                                            </div>

                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Waktu Pelaksanaan</div>
                                                <div style="color: #555; font-size: 14px;">
                                                    {{ $kegiatan->tanggal_mulai?->format('d F Y') ?? '-' }} - {{ $kegiatan->tanggal_selesai?->format('d F Y') ?? '-' }}
                                                </div>
                                            </div>

                                            @if($kegiatan->deskripsi)
                                            <div style="margin-bottom: 15px;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Tujuan Kegiatan</div>
                                                <div style="color: #555; font-size: 14px; line-height: 1.7;">
                                                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                                                </div>
                                            </div>
                                            @endif

                                            @if($kegiatan->peserta()->count() > 0)
                                            <div style="margin-bottom: 0;">
                                                <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Narasumber</div>
                                                <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                                                    @foreach($kegiatan->peserta as $p)
                                                    <li style="margin-bottom: 8px;">
                                                        <strong>{{ $p->nama }}</strong>
                                                        @if($p->instansi)
                                                        <small style="color: #666;">
                                                            <i class="bi bi-building"></i> {{ $p->instansi }}
                                                        </small><br>
                                                        @endif
                                                        @if($p->email)
                                                        <small style="color: #999;">
                                                            <i class="bi bi-envelope"></i> {{ $p->email }}
                                                        </small>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                        
                                        </div>
                                        @endif

                                        <div style="padding: 20px; background: #fafafa;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                        <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                                    </h6>
                                                    @if($kegiatan->peserta()->count() > 0)
                                                        <div class="peserta-list">
                                                            @foreach($kegiatan->peserta as $p)
                                                            <div class="peserta-item">
                                                                <strong style="color: #003d7a;">{{ $p->nama }}</strong><br>
                                                                @if($p->instansi)
                                                                <small style="color: #666;">
                                                                    <i class="bi bi-building"></i> {{ $p->instansi }}
                                                                </small><br>
                                                                @endif
                                                                @if($p->email)
                                                                <small style="color: #999;">
                                                                    <i class="bi bi-envelope"></i> {{ $p->email }}
                                                                </small>
                                                                @endif
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Belum ada peserta</p>
                                                    @endif
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                        <i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip()->count() }})
                                                    </h6>
                                                    @if($kegiatan->arsip()->count() > 0)
                                                        <div class="arsip-list">
                                                            @foreach($kegiatan->arsip as $a)
                                                            <div class="arsip-item">
                                                                <strong style="color: #003d7a;">{{ $a->nama_file }}</strong><br>
                                                                <small style="color: #666;">
                                                                    <i class="bi bi-file-earmark"></i> {{ strtoupper($a->tipe_file) }}<br>
                                                                    <i class="bi bi-file-size"></i> {{ $a->formatted_file_size }}
                                                                </small>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Belum ada arsip</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body text-center" style="padding: 40px;">
                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada kegiatan di kategori ini</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="card mt-4 fade-in" style="border-left: 4px solid #ffc107; background: #fff8f0;">
    <div class="card-body">
        <p class="mb-0">
            <i class="bi bi-info-circle" style="color: #ffc107;"></i>
            <strong>Catatan:</strong> Untuk informasi lebih lanjut tentang kegiatan dan layanan Balai Bahasa Provinsi Riau, silakan kunjungi website resmi atau hubungi langsung melalui kontak yang tersedia di atas.
        </p>
    </div>
</div>

@endsection
