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

    .detail-header {
        background: linear-gradient(135deg, #003d7a 0%, #1a5c9a 100%);
        color: white;
        padding: 40px 20px;
        margin-bottom: 30px;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50px, -50px);
    }

    .deskripsi-container {
        background: white;
        border-left: 5px solid #003d7a;
        padding: 30px;
        margin-bottom: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 61, 122, 0.1);
    }

    .deskripsi-section {
        margin-bottom: 25px;
    }

    .deskripsi-section:last-child {
        margin-bottom: 0;
    }

    .deskripsi-title {
        color: #003d7a;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .deskripsi-content {
        color: #555;
        line-height: 1.8;
        font-size: 15px;
    }

    .deskripsi-content ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .deskripsi-content li {
        margin-bottom: 10px;
        color: #666;
    }

    .info-card {
        background: white;
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0, 61, 122, 0.15);
        transform: translateY(-2px);
    }

    .info-card .card-header {
        background: #003d7a;
        color: white;
        border: none;
        border-radius: 8px 8px 0 0;
    }

    .stat-badge {
        display: inline-block;
        background: #003d7a;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .peserta-list, .arsip-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .peserta-item, .arsip-item {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.2s ease;
    }

    .peserta-item:hover, .arsip-item:hover {
        background-color: #f8f9fa;
        padding-left: 20px;
    }

    .peserta-item:last-child, .arsip-item:last-child {
        border-bottom: none;
    }

    .btn-back {
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        transform: translateX(-3px);
    }

    @media (max-width: 768px) {
        .detail-header {
            padding: 20px 15px;
        }

        .deskripsi-container {
            padding: 20px;
        }
    }
</style>

<!-- Back Button -->
<div class="mb-4 fade-in">
    <a href="{{ route('peta.detail', $kegiatan->lokasi_id) }}" class="btn btn-sm btn-outline-primary btn-back mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Detail Header -->
<div class="detail-header fade-in">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div style="margin-bottom: 8px;">
                <span class="badge bg-warning text-dark">{{ $kegiatan->tahun }}</span>
                <span class="badge" style="background: rgba(255,255,255,0.3);">{{ $kegiatan->lokasi->nama_kabupaten }}</span>
            </div>
            <h1 class="mb-2" style="font-weight: 700; font-size: 2.2rem;">{{ $kegiatan->nama_kegiatan }}</h1>
            <p class="mb-0" style="font-size: 16px; opacity: 0.95;">
                @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                    <i class="bi bi-megaphone"></i> Kegiatan Penyuluhan
                @else
                    <i class="bi bi-book"></i> Kegiatan Pembinaan
                @endif
            </p>
        </div>
        <div class="col-md-4 text-center" style="opacity: 0.9;">
            <i class="bi bi-calendar-event" style="font-size: 4rem;"></i>
        </div>
    </div>
</div>

<!-- Deskripsi Container -->
<div class="deskripsi-container slide-up">
    <!-- Tahun & Lokasi -->
    <div class="deskripsi-section">
        <div class="deskripsi-title">Tahun & Lokasi</div>
        <div class="deskripsi-content">
            <strong>{{ $kegiatan->tahun }}</strong> - {{ $kegiatan->lokasi->nama_kabupaten }}
        </div>
    </div>

    <!-- Nama Kegiatan -->
    <div class="deskripsi-section">
        <div class="deskripsi-title">Nama Kegiatan</div>
        <div class="deskripsi-content">
            {{ $kegiatan->nama_kegiatan }}
        </div>
    </div>

    <!-- Waktu Pelaksanaan -->
    <div class="deskripsi-section">
        <div class="deskripsi-title">Waktu Pelaksanaan</div>
        <div class="deskripsi-content">
            {{ $kegiatan->tanggal_mulai?->format('d F Y') ?? '-' }} s/d {{ $kegiatan->tanggal_selesai?->format('d F Y') ?? '-' }}
        </div>
    </div>

    <!-- Tujuan Kegiatan -->
    @if($kegiatan->deskripsi)
    <div class="deskripsi-section">
        <div class="deskripsi-title">Tujuan & Deskripsi Kegiatan</div>
        <div class="deskripsi-content">
            {!! nl2br($kegiatan->deskripsi) !!}
        </div>
    </div>
    @endif

    <!-- Jenis Kegiatan -->
    <div class="deskripsi-section">
        <div class="deskripsi-title">Jenis Kegiatan</div>
        <div class="deskripsi-content">
            @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                <span class="badge" style="background: #0dcaf0; color: white; padding: 6px 12px; font-size: 12px;">Penyuluhan</span>
            @else
                <span class="badge" style="background: #ffc107; color: #333; padding: 6px 12px; font-size: 12px;">Pembinaan</span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <!-- Peserta Section -->
    <div class="col-lg-6 mb-4 slide-up">
        <div class="info-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta_count }})
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border mb-0" style="font-size: 13px;">
                    Data identitas peserta hanya tersedia di panel admin. Halaman publik hanya menampilkan jumlah peserta.
                </div>
            </div>
        </div>
    </div>

    <!-- Arsip Section -->
    <div class="col-lg-6 mb-4 slide-up">
        <div class="info-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark"></i> Arsip & Dokumentasi ({{ $kegiatan->arsip_count }})
                </h5>
            </div>
            <div class="card-body">
                @if($kegiatan->arsip_count > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        <ul class="arsip-list">
                            @foreach($kegiatan->arsip as $a)
                            <li class="arsip-item">
                                <div style="display: flex; justify-content: space-between; align-items: start; gap: 10px;">
                                    <div>
                                        <strong style="color: #003d7a;">{{ $a->nama_file }}</strong><br>
                                        <small style="color: #666;">
                                            <i class="bi bi-file-earmark"></i> {{ strtoupper($a->tipe_file) }}<br>
                                            <i class="bi bi-file-size"></i> {{ $a->formatted_file_size }}<br>
                                            <i class="bi bi-calendar"></i> {{ $a->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-muted text-center py-3">Belum ada arsip</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Balai -->
<div class="card info-card slide-up">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-building"></i> {{ $infoBalai['nama'] }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <p class="mb-2">
                    <i class="bi bi-geo-alt" style="color: #003d7a;"></i> <strong>Alamat:</strong><br>
                    <small style="color: #666;">{{ $infoBalai['alamat'] }}</small>
                </p>
                <p class="mb-0">
                    <i class="bi bi-telephone" style="color: #003d7a;"></i> <strong>Telepon:</strong><br>
                    <a href="tel:{{ $infoBalai['no_telp'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['no_telp'] }}
                    </a>
                </p>
            </div>
            <div class="col-md-6">
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

@endsection
