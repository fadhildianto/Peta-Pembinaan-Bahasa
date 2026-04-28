@extends('admin.layouts.app')

@section('content')
<div class="container">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- cards di sini -->
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Kegiatan per Tahun</h5>
                </div>
                <div class="card-body">
                    <canvas id="kegiatanPerTahunChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Kegiatan per Jenis</h5>
                </div>
                <div class="card-body">
                    <canvas id="kegiatanPerJenisChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data dari Controller
    const kegiatanPerTahun = {!! json_encode($kegiatanPerTahun) !!};
    const kegiatanPerJenis = {!! json_encode($kegiatanPerJenis) !!};
    const topLokasi = {!! json_encode($topLokasi) !!};
    const pesertaPerKegiatan = {!! json_encode($pesertaPerKegiatan) !!};

    // Chart 1: Kegiatan per Tahun
    new Chart(document.getElementById('kegiatanPerTahunChart'), {
        type: 'line',
        data: {
            labels: Object.keys(kegiatanPerTahun),
            datasets: [{
                label: 'Kegiatan per Tahun',
                data: Object.values(kegiatanPerTahun),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });

    // Chart 2: Kegiatan per Jenis
    new Chart(document.getElementById('kegiatanPerJenisChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(kegiatanPerJenis),
            datasets: [{
                data: Object.values(kegiatanPerJenis),
                backgroundColor: ['#3b82f6', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // Chart 3: Top Lokasi
    new Chart(document.getElementById('topLokasiChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(topLokasi),
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: Object.values(topLokasi),
                backgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y'
        }
    });

    // Chart 4: Peserta per Kegiatan
    new Chart(document.getElementById('pesertaPerKegiatanChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(pesertaPerKegiatan),
            datasets: [{
                label: 'Jumlah Peserta',
                data: Object.values(pesertaPerKegiatan),
                backgroundColor: '#f59e0b'
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y'
        }
    });
</script>
@endsection