@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-0">
    <!-- Map Container -->
    <div style="height: 800px; position: relative;">
        <div id="map" style="height: 100%; width: 100%;"></div>
    </div>

    <!-- Info Panel (Bottom) -->
    <div class="mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Tentang Peta</h5>
                    </div>
                    <div class="card-body">
                        <p>Peta interaktif di atas menampilkan semua lokasi kegiatan Balai Bahasa Provinsi Riau.</p>
                        <ul>
                            <li><strong>Klik marker</strong> untuk melihat daftar kegiatan di lokasi tersebut</li>
                            <li><strong>Klik "Detail Lengkap"</strong> untuk melihat informasi detail lengkap lokasi termasuk peserta dan arsip</li>
                            <li>Gunakan zoom untuk memperjelas tampilan peta</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-building"></i> {{ $infoBalai['nama'] }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Alamat:</strong><br>
                            {{ $infoBalai['alamat'] }}
                        </p>
                        <p class="mb-2">
                            <strong>Telepon:</strong><br>
                            <a href="tel:{{ $infoBalai['no_telp'] }}">{{ $infoBalai['no_telp'] }}</a>
                        </p>
                        <p class="mb-2">
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $infoBalai['email'] }}">{{ $infoBalai['email'] }}</a>
                        </p>
                        <p class="mb-0">
                            <strong>Website:</strong><br>
                            <a href="https://{{ $infoBalai['website'] }}" target="_blank">{{ $infoBalai['website'] }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@push('scripts')
<script>
    const kegiatanByLokasiUrl = @json(route('admin.api.kegiatan-by-lokasi', ['lokasiId' => '__ID__']));

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    }

    function routeWithId(template, id) {
        return template.replace('__ID__', encodeURIComponent(id));
    }

    function safeUrl(value) {
        try {
            const url = new URL(value, window.location.origin);
            return url.origin === window.location.origin ? url.href : '#';
        } catch (error) {
            return '#';
        }
    }

    // Initialize Map
    const map = L.map('map').setView([0.5431, 101.4477], 8);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    const greenIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Load Map Data from API
    fetch(@json(route('admin.api.map-data')))
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.data.forEach(lokasi => {
                    const lokasiId = Number(lokasi.id);
                    const lokasiNama = escapeHtml(lokasi.nama);
                    const detailUrl = escapeHtml(safeUrl(lokasi.detail_url));

                    // Create marker
                    const marker = L.marker(
                        [lokasi.latitude, lokasi.longitude],
                        { icon: greenIcon }
                    ).addTo(map);

                    // Create popup content
                    const popupContent = `
                        <div style="min-width: 250px;">
                            <h6 style="margin-bottom: 8px;"><strong>${lokasiNama}</strong></h6>
                            <p style="margin-bottom: 8px; font-size: 13px;">
                                <i class="bi bi-calendar-event"></i> Kegiatan: <strong>${escapeHtml(lokasi.kegiatan_count)}</strong>
                            </p>
                            <p style="margin-bottom: 8px; font-size: 13px;">
                                <i class="bi bi-people"></i> Peserta: <strong>${escapeHtml(lokasi.peserta_count)}</strong>
                            </p>
                            <p style="margin-bottom: 12px; font-size: 13px;">
                                <i class="bi bi-file-earmark"></i> Arsip: <strong>${escapeHtml(lokasi.arsip_count)}</strong>
                            </p>
                            <div style="display: flex; gap: 8px;">
                                <button onclick="showKegiatanModal(${lokasiId})"
                                        class="btn btn-sm btn-primary" style="flex: 1;">
                                    Lihat Kegiatan
                                </button>
                                <a href="${detailUrl}"
                                   class="btn btn-sm btn-info" style="flex: 1; text-decoration: none;">
                                    Detail Lengkap
                                </a>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent, { maxWidth: 300 });
                });
            }
        })
        .catch(error => {
            console.error('Error loading map data:', error);
            alert('Gagal memuat data peta');
        });

    // Function to show kegiatan modal
    function showKegiatanModal(lokasiId) {
        fetch(routeWithId(kegiatanByLokasiUrl, lokasiId))
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let kegiatanHTML = '';

                    if (data.kegiatans.length > 0) {
                        data.kegiatans.forEach(kegiatan => {
                            const badge = kegiatan.jenis === 'penyuluhan'
                                ? '<span class="badge bg-info">Penyuluhan</span>'
                                : '<span class="badge bg-warning">Pembinaan</span>';
                            const detailUrl = escapeHtml(safeUrl(kegiatan.detail_url));

                            kegiatanHTML += `
                                <div style="border-bottom: 1px solid #e0e0e0; padding: 12px 0; margin-bottom: 12px;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                        <h6 style="margin: 0; flex: 1;">${escapeHtml(kegiatan.nama)}</h6>
                                        ${badge}
                                    </div>
                                    <p style="margin: 4px 0; font-size: 12px; color: #666;">
                                        <i class="bi bi-calendar"></i> ${escapeHtml(kegiatan.tahun ?? '-')} &bull; ${escapeHtml(kegiatan.tanggal_mulai ?? '-')} s/d ${escapeHtml(kegiatan.tanggal_selesai ?? '-')}
                                    </p>
                                    <p style="margin: 4px 0; font-size: 12px; color: #666;">
                                        <i class="bi bi-people"></i> Peserta: ${escapeHtml(kegiatan.peserta_count)} &bull; 
                                        <i class="bi bi-file-earmark"></i> Arsip: ${escapeHtml(kegiatan.arsip_count)}
                                    </p>
                                    <a href="${detailUrl}" class="btn btn-xs btn-outline-primary" style="margin-top: 6px; padding: 4px 8px; font-size: 11px;">
                                        Lihat Detail
                                    </a>
                                </div>
                            `;
                        });
                    } else {
                        kegiatanHTML = '<p class="text-muted text-center py-3">Belum ada kegiatan di lokasi ini</p>';
                    }

                    const modal = new bootstrap.Modal(document.getElementById('kegiatanModal'));
                    document.getElementById('modalTitle').textContent = `Kegiatan di ${data.lokasi?.nama ?? 'Lokasi'}`;
                    document.getElementById('modalContent').innerHTML = kegiatanHTML;
                    modal.show();
                }
            })
            .catch(error => {
                console.error('Error loading kegiatans:', error);
                alert('Gagal memuat data kegiatan');
            });
    }
</script>
@endpush

<!-- Modal untuk Kegiatan -->
<div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent" style="max-height: 500px; overflow-y: auto;">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
