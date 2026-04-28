@extends('peta.layout')

@section('content')

<div class="row">
    <!-- Map Column -->
    <div class="col-lg-9 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-map"></i> Peta Interaktif Kegiatan</h5>
            </div>
            <div style="height: 600px; position: relative;">
                <div id="map" style="height: 100%; width: 100%; border-radius: 0 0 8px 8px;"></div>
            </div>
        </div>
    </div>

    <!-- Info Column -->
    <div class="col-lg-3">
        <!-- Balai Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Tentang Kami</h5>
            </div>
            <div class="card-body">
                <h6>{{ $infoBalai['nama'] }}</h6>
                <p style="font-size: 13px; color: #666;">{{ $infoBalai['deskripsi'] }}</p>

                <hr style="margin: 15px 0;">

                <p style="font-size: 12px; margin-bottom: 8px;">
                    <strong><i class="bi bi-telephone"></i> Telepon:</strong><br>
                    <a href="tel:{{ $infoBalai['no_telp'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['no_telp'] }}
                    </a>
                </p>

                <p style="font-size: 12px; margin-bottom: 8px;">
                    <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                    <a href="mailto:{{ $infoBalai['email'] }}" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['email'] }}
                    </a>
                </p>

                <p style="font-size: 12px; margin-bottom: 0;">
                    <strong><i class="bi bi-globe"></i> Website:</strong><br>
                    <a href="https://{{ $infoBalai['website'] }}" target="_blank" style="color: #003d7a; text-decoration: none;">
                        {{ $infoBalai['website'] }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-question-circle"></i> Cara Menggunakan</h5>
            </div>
            <div class="card-body" style="font-size: 13px;">
                <ol>
                    <li><strong>Klik marker</strong> untuk melihat kegiatan di lokasi tersebut</li>
                    <li>Pilih <strong>"Lihat Kegiatan"</strong> untuk daftar lengkap</li>
                    <li>Klik <strong>"Detail Lengkap"</strong> untuk informasi detail lokasi, peserta, dan arsip</li>
                    <li>Gunakan <strong>zoom</strong> untuk memperjelas peta</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@push('scripts')
<script>
    // Initialize Map
    const map = L.map('map').setView([0.5431, 101.4477], 8);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    // Custom Icons
    const greenIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Load Map Data from API
    fetch('{{ route("api.map-data") }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.data.forEach(lokasi => {
                    // Create marker
                    const marker = L.marker(
                        [lokasi.latitude, lokasi.longitude],
                        { icon: greenIcon }
                    ).addTo(map);

                    // Create popup content
                    const popupContent = `
                        <div style="min-width: 280px;">
                            <h6 style="margin-bottom: 8px; color: #003d7a;"><strong>${lokasi.nama}</strong></h6>
                            <p style="margin-bottom: 8px; font-size: 13px;">
                                <i class="bi bi-calendar-event"></i> Kegiatan: <strong>${lokasi.kegiatan_count}</strong>
                            </p>
                            <p style="margin-bottom: 8px; font-size: 13px;">
                                <i class="bi bi-people"></i> Peserta: <strong>${lokasi.peserta_count}</strong>
                            </p>
                            <p style="margin-bottom: 12px; font-size: 13px;">
                                <i class="bi bi-file-earmark"></i> Arsip: <strong>${lokasi.arsip_count}</strong>
                            </p>
                            <div style="display: flex; gap: 8px;">
                                <button onclick="showKegiatanModal(${lokasi.id}, '${lokasi.nama}')" 
                                        class="btn btn-sm" style="flex: 1; background: #003d7a; color: white; border: none; border-radius: 4px; padding: 6px; font-size: 12px; cursor: pointer;">
                                    Lihat Kegiatan
                                </button>
                                <a href="${lokasi.detail_url}" 
                                   class="btn btn-sm" style="flex: 1; background: #ffc107; color: #333; border: none; border-radius: 4px; padding: 6px; font-size: 12px; text-decoration: none;">
                                    Detail Lengkap
                                </a>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent, { maxWidth: 320 });
                });
            }
        })
        .catch(error => {
            console.error('Error loading map data:', error);
        });

    // Function to show kegiatan modal
    function showKegiatanModal(lokasiId, lokasiNama) {
        fetch(`{{ route("api.kegiatan-by-lokasi", ":id") }}`.replace(':id', lokasiId))
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let kegiatanHTML = '';

                    if (data.kegiatans.length > 0) {
                        data.kegiatans.forEach(kegiatan => {
                            const badge = kegiatan.jenis === 'penyuluhan' 
                                ? '<span style="background: #0dcaf0; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px;">Penyuluhan</span>' 
                                : '<span style="background: #ffc107; color: #333; padding: 2px 8px; border-radius: 3px; font-size: 11px;">Pembinaan</span>';

                            kegiatanHTML += `
                                <div style="border-bottom: 1px solid #e0e0e0; padding: 12px 0; margin-bottom: 12px;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                        <h6 style="margin: 0; flex: 1; color: #003d7a;">${kegiatan.nama}</h6>
                                        ${badge}
                                    </div>
                                    <p style="margin: 4px 0; font-size: 12px; color: #666;">
                                        <i class="bi bi-calendar"></i> ${kegiatan.tahun} • ${kegiatan.tanggal_mulai} s/d ${kegiatan.tanggal_selesai}
                                    </p>
                                    <p style="margin: 4px 0; font-size: 12px; color: #666;">
                                        <i class="bi bi-people"></i> Peserta: ${kegiatan.peserta_count} • 
                                        <i class="bi bi-file-earmark"></i> Arsip: ${kegiatan.arsip_count}
                                    </p>
                                    <a href="${kegiatan.detail_url}" class="btn btn-sm" style="margin-top: 6px; padding: 4px 8px; font-size: 11px; background: #003d7a; color: white; border: none; border-radius: 3px; text-decoration: none; cursor: pointer;">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            `;
                        });
                    } else {
                        kegiatanHTML = '<p class="text-muted text-center py-3">Belum ada kegiatan di lokasi ini</p>';
                    }

                    // Show modal using Bootstrap
                    const modal = new bootstrap.Modal(document.getElementById('kegiatanModal'));
                    document.getElementById('modalTitle').innerHTML = `<i class="bi bi-calendar-event"></i> Kegiatan di ${lokasiNama}`;
                    document.getElementById('modalContent').innerHTML = kegiatanHTML;
                    modal.show();
                }
            })
            .catch(error => {
                console.error('Error loading kegiatans:', error);
            });
    }
</script>
@endpush

<!-- Modal untuk Kegiatan -->
<div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #003d7a 0%, #1a5c9a 100%); color: white; border: none;">
                <h5 class="modal-title" id="modalTitle">Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent" style="max-height: 500px; overflow-y: auto;">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status" style="color: #003d7a;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection