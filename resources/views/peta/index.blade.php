@extends('peta.layout')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .map-shell {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 1.25rem;
        align-items: start;
    }

    .map-card {
        overflow: hidden;
        border: 1px solid rgba(0, 61, 122, .08);
    }

    .map-card .card-header,
    aside .card-header {
        border-bottom: 0;
    }

    .map-title-meta {
        color: rgba(255, 255, 255, .82);
        display: block;
        font-size: 12px;
        font-weight: 500;
        margin-top: .25rem;
    }

    .map-toolbar {
        display: flex;
        gap: .75rem;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 1rem;
        background: #fff;
        border-bottom: 1px solid #e9ecef;
    }

    .map-runway {
        overflow: hidden;
        border-bottom: 1px solid #e9ecef;
        background: #fff8e1;
        color: #003d7a;
        font-weight: 700;
        white-space: nowrap;
    }

    .map-runway span {
        display: inline-block;
        min-width: 100%;
        padding: .7rem 1rem;
        animation: runwayText 18s linear infinite;
    }

    @keyframes runwayText {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(-100%);
        }
    }

    .map-search {
        max-width: 360px;
    }

    .filter-group {
        display: inline-flex;
        gap: .35rem;
        padding: .25rem;
        background: #f1f5f9;
        border-radius: 8px;
    }

    .filter-btn {
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        padding: .5rem .75rem;
    }

    .filter-btn.active {
        background: #003d7a;
        color: #fff;
    }

    .map-wrap {
        position: relative;
        min-height: 640px;
        background: #eef5fb;
    }

    #map {
        width: 100%;
        min-height: 640px;
    }

    .map-overlay {
        position: absolute;
        inset: 1rem;
        z-index: 500;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        pointer-events: none;
    }

    .map-message {
        display: none;
        max-width: 420px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 10px 30px rgba(15, 23, 42, .16);
        padding: .85rem 1rem;
        color: #334155;
        font-size: 14px;
        pointer-events: auto;
    }

    .map-message.show {
        display: block;
    }

    .map-floating-tools {
        position: absolute;
        right: 1rem;
        top: 1rem;
        z-index: 501;
        display: grid;
        gap: .5rem;
    }

    .map-tool-btn {
        width: 42px;
        height: 42px;
        border: 0;
        border-radius: 8px;
        background: rgba(255, 255, 255, .95);
        color: #003d7a;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .16);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform .2s ease, background .2s ease;
    }

    .map-tool-btn:hover {
        background: #ffc107;
        color: #1f2937;
        transform: translateY(-2px);
    }

    .map-tool-btn.active {
        background: #003d7a;
        color: #fff;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .summary-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: .9rem;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .summary-item:hover {
        border-color: rgba(0, 61, 122, .35);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        transform: translateY(-2px);
    }

    .summary-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .summary-value {
        color: #003d7a;
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.1;
        margin-top: .35rem;
    }

    .legend-dot {
        display: inline-block;
        width: .75rem;
        height: .75rem;
        border-radius: 50%;
        margin-right: .45rem;
        vertical-align: middle;
    }

    .popup-title {
        margin: 0 0 .75rem;
        color: #003d7a;
        font-size: 15px;
        font-weight: 800;
    }

    .popup-stats {
        display: grid;
        gap: .45rem;
        margin-bottom: .75rem;
    }

    .popup-stat {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: .45rem .55rem;
        border-radius: 6px;
        background: #f8fafc;
        font-size: 12px;
    }

    .popup-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .5rem;
    }

    .popup-actions .btn {
        font-size: 12px;
        font-weight: 700;
    }

    .kegiatan-card {
        border-bottom: 1px solid #e9ecef;
        padding: .9rem 0;
    }

    .kegiatan-card:first-child {
        padding-top: 0;
    }

    .kegiatan-card:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .location-list {
        display: grid;
        gap: .7rem;
        max-height: 430px;
        overflow-y: auto;
        padding-right: .25rem;
    }

    .location-item {
        width: 100%;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #fff;
        padding: .85rem;
        text-align: left;
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .location-item:hover,
    .location-item.active {
        border-color: #003d7a;
        box-shadow: 0 12px 24px rgba(0, 61, 122, .12);
        transform: translateY(-2px);
    }

    .location-item-title {
        color: #003d7a;
        font-weight: 800;
        margin-bottom: .45rem;
    }

    .location-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        color: #64748b;
        font-size: 12px;
    }

    .mini-badge {
        border-radius: 999px;
        background: #f1f5f9;
        padding: .2rem .5rem;
    }

    @media (max-width: 992px) {
        .map-shell {
            grid-template-columns: 1fr;
        }

        .map-wrap,
        #map {
            min-height: 520px;
        }

        aside {
            order: -1;
        }
    }

    @media (max-width: 576px) {
        .map-toolbar {
            align-items: stretch;
        }

        .map-search,
        .filter-group {
            width: 100%;
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .map-wrap,
        #map {
            min-height: 460px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .map-floating-tools {
            right: .75rem;
            top: .75rem;
        }
    }
    /* Sidebar layout order */
    aside {
        display: flex;
        flex-direction: column;
    }
    
    aside > .card:nth-child(1) {
        order: 2; /* Ringkasan -> posisi ke-2 */
    }
    
    aside > .card:nth-child(2) {
        order: 1; /* Informasi -> posisi ke-1 */
    }
    
    aside > .card:nth-child(3) {
        order: 3; /* Tentang Kami -> posisi ke-3 */
    }
</style>
@endpush

@section('content')
<div class="map-shell">
    <div class="card map-card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h5 class="mb-0"><i class="bi bi-map"></i> Peta Pembinaan Bahasa</h5>
                <span class="map-title-meta">Klik marker atau daftar lokasi untuk membuka ringkasan kegiatan.</span>
            </div>
            <span class="badge bg-warning text-dark" id="visibleLocationCount">0 lokasi</span>
        </div>

        <div class="map-runway">
            <span>Selamat Datang di Peta Pembinaan Bahasa Balai Bahasa Provinsi Riau</span>
        </div>

        <div class="map-toolbar">
            <div class="input-group map-search">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input id="locationSearch" type="search" class="form-control" placeholder="Cari kabupaten/kota">
            </div>

            <div class="filter-group" aria-label="Filter jenis kegiatan">
                <button type="button" class="filter-btn active" data-filter="all">Semua</button>
                <button type="button" class="filter-btn" data-filter="penyuluhan">Penyuluhan</button>
                <button type="button" class="filter-btn" data-filter="pembinaan">Pembinaan</button>
            </div>
        </div>

        <div class="map-wrap">
            <div id="map"></div>
            <div class="map-floating-tools" aria-label="Kontrol peta">
                <button type="button" class="map-tool-btn" id="resetMapButton" title="Reset tampilan peta">
                    <i class="bi bi-house"></i>
                </button>
                <button type="button" class="map-tool-btn" id="toggleScrollButton" title="Aktifkan/nonaktifkan zoom roda mouse">
                    <i class="bi bi-mouse"></i>
                </button>
            </div>
            <div class="map-overlay">
                <div class="map-message show" id="mapMessage">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Memuat data peta...
                </div>
            </div>
        </div>
    </div>

    <aside>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Ringkasan</h5>
            </div>
            <div class="card-body">
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Lokasi</div>
                        <div class="summary-value" id="totalLokasi">0</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Kegiatan</div>
                        <div class="summary-value" id="totalKegiatan">0</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Peserta</div>
                        <div class="summary-value" id="totalPeserta">0</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body" style="font-size: 13px; line-height: 1.7;">
                <p class="mb-0">Peta Pembinaan Bahasa merupakan produk dari Tim Pembinaan dan Bahasa Hukum (Pembahu) Balai Bahasa Provinsi Riau. Peta ini memuat informasi penyuluhan bahasa dan lembaga terbina yang telah dilaksanakan Tim Pembahu Balai Bahasa Provinsi Riau dari tahun 2023.</p>
            </div>
        </div>

        <div class="card" id="tentang">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Tentang Kami</h5>
            </div>
            <div class="card-body">
                <h6>{{ $infoBalai['nama'] }}</h6>
                <p class="text-muted" style="font-size: 13px;">{{ $infoBalai['deskripsi'] }}</p>

                <hr>

                <p class="mb-2" style="font-size: 12px;">
                    <strong><i class="bi bi-telephone"></i> Telepon:</strong><br>
                    <a href="tel:{{ $infoBalai['no_telp'] }}">{{ $infoBalai['no_telp'] }}</a>
                </p>

                <p class="mb-2" style="font-size: 12px;">
                    <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                    <a href="mailto:{{ $infoBalai['email'] }}">{{ $infoBalai['email'] }}</a>
                </p>

                <p class="mb-0" style="font-size: 12px;">
                    <strong><i class="bi bi-globe"></i> Website:</strong><br>
                    <a href="https://{{ $infoBalai['website'] }}" target="_blank">{{ $infoBalai['website'] }}</a>
                </p>
            </div>
        </div>
    </aside>
</div>

<div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #003d7a 0%, #1a5c9a 100%); color: white; border: none;">
                <h5 class="modal-title" id="modalTitle">Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status" style="color: #003d7a;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="modalDetailLink" class="btn btn-primary">
                    <i class="bi bi-eye"></i> Detail Lengkap
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const mapDataUrl = @json(route('api.map-data'));
    const kegiatanByLokasiUrl = @json(route('api.kegiatan-by-lokasi', ['lokasiId' => '__ID__']));
    const mapCenter = [{{ $infoBalai['latitude'] }}, {{ $infoBalai['longitude'] }}];

    const state = {
        locations: [],
        markers: [],
        filter: 'all',
        query: '',
        scrollZoom: false,
    };

    const map = L.map('map', {
        scrollWheelZoom: false,
    }).setView(mapCenter, 8);

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
        shadowSize: [41, 41],
    });

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
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

    function formatNumber(value) {
        return Number(value || 0).toLocaleString('id-ID');
    }

    function setMapMessage(message, options = {}) {
        const element = document.getElementById('mapMessage');
        const spinner = options.loading
            ? '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
            : '';

        element.innerHTML = `${spinner}${escapeHtml(message)}`;
        element.classList.toggle('show', Boolean(message));
    }

    function locationMatchesFilter(location) {
        const matchesQuery = location.nama.toLowerCase().includes(state.query);

        if (!matchesQuery) {
            return false;
        }

        if (state.filter === 'penyuluhan') {
            return Number(location.kegiatan_penyuluhan) > 0;
        }

        if (state.filter === 'pembinaan') {
            return Number(location.kegiatan_pembinaan) > 0;
        }

        return true;
    }

    function buildPopup(location) {
        const detailUrl = escapeHtml(safeUrl(location.detail_url));

        return `
            <div style="min-width: 300px;">
                <h6 class="popup-title">${escapeHtml(location.nama)}</h6>
                <div class="popup-stats">
                    <div class="popup-stat">
                        <span><i class="bi bi-book"></i> Penyuluhan Bahasa</span>
                        <strong>${formatNumber(location.kegiatan_penyuluhan)}</strong>
                    </div>
                    <div class="popup-stat">
                        <span><i class="bi bi-building"></i> Pembinaan Lembaga</span>
                        <strong>${formatNumber(location.kegiatan_pembinaan)}</strong>
                    </div>
                    <div class="popup-stat">
                        <span><i class="bi bi-people"></i> Peserta</span>
                        <strong>${formatNumber(location.peserta_count)}</strong>
                    </div>
                    <div class="popup-stat">
                        <span><i class="bi bi-file-earmark"></i> Arsip</span>
                        <strong>${formatNumber(location.arsip_count)}</strong>
                    </div>
                </div>
                <div class="popup-actions">
                    <button type="button" onclick="showKegiatanModal(${Number(location.id)})" class="btn btn-sm btn-primary">
                        Kegiatan
                    </button>
                    <a href="${detailUrl}" class="btn btn-sm btn-warning">
                        Detail
                    </a>
                </div>
            </div>
        `;
    }

    function updateSummary(locations) {
        const totals = locations.reduce((carry, location) => {
            carry.kegiatan += Number(location.kegiatan_count || 0);
            carry.peserta += Number(location.peserta_count || 0);
            carry.arsip += Number(location.arsip_count || 0);
            return carry;
        }, { kegiatan: 0, peserta: 0, arsip: 0 });

        document.getElementById('totalLokasi').textContent = formatNumber(locations.length);
        document.getElementById('totalKegiatan').textContent = formatNumber(totals.kegiatan);
        document.getElementById('totalPeserta').textContent = formatNumber(totals.peserta);
        document.getElementById('totalArsip').textContent = formatNumber(totals.arsip);
        document.getElementById('visibleLocationCount').textContent = `${formatNumber(locations.length)} lokasi`;
    }

    function setActiveLocation(locationId) {
        document.querySelectorAll('.location-item').forEach(item => {
            item.classList.toggle('active', Number(item.dataset.locationId) === Number(locationId));
        });
    }

    function renderLocationList(locations) {
        const locationList = document.getElementById('locationList');
        
        if (!locationList) {
            return;
        }

        if (!locations.length) {
            locationList.innerHTML = '<p class="text-muted mb-0">Tidak ada lokasi yang cocok.</p>';
            return;
        }

        locationList.innerHTML = locations.map(location => `
            <button type="button" class="location-item" data-location-id="${Number(location.id)}">
                <div class="location-item-title">${escapeHtml(location.nama)}</div>
                <div class="location-item-meta">
                    <span class="mini-badge"><i class="bi bi-calendar-event"></i> ${formatNumber(location.kegiatan_count)} kegiatan</span>
                    <span class="mini-badge"><i class="bi bi-people"></i> ${formatNumber(location.peserta_count)} peserta</span>
                </div>
            </button>
        `).join('');

        locationList.querySelectorAll('.location-item').forEach(item => {
            item.addEventListener('click', () => focusLocation(Number(item.dataset.locationId)));
        });
    }

    function focusLocation(locationId) {
        const markerEntry = state.markers.find(({ location }) => Number(location.id) === Number(locationId));

        if (!markerEntry) {
            return;
        }

        setActiveLocation(locationId);
        map.setView(markerEntry.marker.getLatLng(), Math.max(map.getZoom(), 10), { animate: true });
        markerEntry.marker.openPopup();
    }

    function renderMarkers() {
        state.markers.forEach(({ marker }) => marker.removeFrom(map));

        const visibleLocations = state.locations.filter(locationMatchesFilter);
        state.markers = visibleLocations.map(location => {
            const marker = L.marker([location.latitude, location.longitude], { icon: greenIcon })
                .bindPopup(buildPopup(location), { maxWidth: 360 })
                .addTo(map);

            marker.on('click', () => setActiveLocation(location.id));

            return { location, marker };
        });

        updateSummary(visibleLocations);
        renderLocationList(visibleLocations);

        if (state.markers.length > 0) {
            const group = L.featureGroup(state.markers.map(({ marker }) => marker));
            map.fitBounds(group.getBounds(), { padding: [35, 35], maxZoom: 10 });
            setMapMessage('');
        } else {
            map.setView(mapCenter, 8);
            setMapMessage('Tidak ada lokasi yang cocok dengan filter saat ini.');
        }
    }

    function renderKegiatanList(kegiatans) {
        if (!kegiatans.length) {
            return '<p class="text-muted text-center py-3 mb-0">Belum ada kegiatan di lokasi ini.</p>';
        }

        return kegiatans.map(kegiatan => {
            const isPenyuluhan = kegiatan.jenis === 'penyuluhan';
            const badgeClass = isPenyuluhan ? 'bg-info text-white' : 'bg-warning text-dark';

            return `
                <div class="kegiatan-card">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                        <h6 class="mb-0" style="color:#003d7a;">${escapeHtml(kegiatan.nama)}</h6>
                        <span class="badge ${badgeClass}">${escapeHtml(kegiatan.jenis_label ?? kegiatan.jenis)}</span>
                    </div>
                    <p class="mb-1 text-muted" style="font-size: 12px;">
                        <i class="bi bi-calendar"></i>
                        ${escapeHtml(kegiatan.tahun ?? '-')} &bull;
                        ${escapeHtml(kegiatan.tanggal_mulai ?? '-')} s/d ${escapeHtml(kegiatan.tanggal_selesai ?? '-')}
                    </p>
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        <i class="bi bi-people"></i> Peserta: ${formatNumber(kegiatan.peserta_count)}
                        &bull;
                        <i class="bi bi-file-earmark"></i> Arsip: ${formatNumber(kegiatan.arsip_count)}
                    </p>
                </div>
            `;
        }).join('');
    }

    window.showKegiatanModal = function (lokasiId) {
        const modalElement = document.getElementById('kegiatanModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const modalContent = document.getElementById('modalContent');
        const modalDetailLink = document.getElementById('modalDetailLink');

        document.getElementById('modalTitle').textContent = 'Kegiatan';
        modalContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border" role="status" style="color: #003d7a;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modalDetailLink.href = '#';
        modal.show();

        fetch(routeWithId(kegiatanByLokasiUrl, lokasiId))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal memuat kegiatan.');
                }

                return response.json();
            })
            .then(data => {
                if (data.status !== 'success') {
                    throw new Error('Respons data tidak valid.');
                }

                document.getElementById('modalTitle').textContent = `Kegiatan di ${data.lokasi?.nama ?? 'Lokasi'}`;
                modalContent.innerHTML = renderKegiatanList(data.kegiatans || []);
                modalDetailLink.href = safeUrl(data.lokasi?.detail_url);
            })
            .catch(error => {
                modalContent.innerHTML = `<p class="text-danger mb-0">${escapeHtml(error.message)}</p>`;
            });
    };

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            state.filter = button.dataset.filter;
            renderMarkers();
        });
    });

    document.getElementById('locationSearch').addEventListener('input', event => {
        state.query = event.target.value.trim().toLowerCase();
        renderMarkers();
    });

    document.getElementById('resetMapButton').addEventListener('click', () => {
        state.query = '';
        state.filter = 'all';
        document.getElementById('locationSearch').value = '';
        document.querySelectorAll('.filter-btn').forEach(item => {
            item.classList.toggle('active', item.dataset.filter === 'all');
        });
        renderMarkers();
    });

    document.getElementById('toggleScrollButton').addEventListener('click', event => {
        state.scrollZoom = !state.scrollZoom;

        if (state.scrollZoom) {
            map.scrollWheelZoom.enable();
        } else {
            map.scrollWheelZoom.disable();
        }

        event.currentTarget.classList.toggle('active', state.scrollZoom);
    });

    setMapMessage('Memuat data peta...', { loading: true });

    fetch(mapDataUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal memuat data peta.');
            }

            return response.json();
        })
        .then(data => {
            if (data.status !== 'success') {
                throw new Error('Respons data peta tidak valid.');
            }

            state.locations = (data.data || []).filter(location => {
                return Number.isFinite(Number(location.latitude)) && Number.isFinite(Number(location.longitude));
            }).map(location => ({
                ...location,
                latitude: Number(location.latitude),
                longitude: Number(location.longitude),
            }));

            renderMarkers();
        })
        .catch(error => {
            updateSummary([]);
            setMapMessage(error.message);
        });
</script>
@endpush
