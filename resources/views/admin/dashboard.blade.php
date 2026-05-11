@extends('admin.layouts.app')

@section('content')

<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #003d7a 0%, #1d6fb8 58%, #12a7d9 100%);
        border-radius: 8px;
        color: #ffffff;
        padding: 26px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 38px rgba(0, 61, 122, 0.18);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        inset: auto -80px -120px auto;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.16);
    }

    .dashboard-hero h2,
    .dashboard-hero p {
        position: relative;
        z-index: 1;
    }

    .dashboard-hero p {
        color: rgba(255, 255, 255, 0.82);
    }

    .dashboard-stat {
        position: relative;
        min-height: 154px;
        text-align: left;
        overflow: hidden;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .dashboard-stat:hover,
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.13);
    }

    .dashboard-stat .stat-icon {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #ffffff;
        font-size: 22px;
        margin-bottom: 18px;
    }

    .dashboard-stat .number {
        font-size: 34px;
        line-height: 1;
    }

    .dashboard-stat::after {
        content: "";
        position: absolute;
        right: -42px;
        top: -42px;
        width: 116px;
        height: 116px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.08);
    }

    .stat-blue .stat-icon { background: #2563eb; }
    .stat-green .stat-icon { background: #059669; }
    .stat-cyan .stat-icon { background: #0891b2; }
    .stat-amber .stat-icon { background: #d97706; }
    .stat-red .stat-icon { background: #dc2626; }
    .stat-violet .stat-icon { background: #7c3aed; }

    .dashboard-card {
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .dashboard-card .card-header {
        padding: 16px 18px;
    }

    .dashboard-card .card-body {
        min-height: 340px;
    }

    .dashboard-table tbody tr {
        transition: transform 0.16s ease, background 0.16s ease;
    }

    .dashboard-table tbody tr:hover {
        transform: scale(1.005);
    }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="dashboard-hero mb-4">
        <h2 class="mb-2"><i class="bi bi-graph-up-arrow"></i> Dashboard Admin</h2>
        <p class="mb-0">Selamat datang, {{ Auth::user()->name }}! Pantau ringkasan kegiatan, lokasi, peserta, dan arsip Balai Bahasa Provinsi Riau.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card dashboard-stat stat-blue">
                <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                <h5>Total Kegiatan</h5>
                <div class="number">{{ $totalKegiatan }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card dashboard-stat stat-green">
                <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
                <h5>Total Lokasi</h5>
                <div class="number">{{ $totalLokasi }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card dashboard-stat stat-cyan">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <h5>Total Peserta</h5>
                <div class="number">{{ $totalPeserta }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card dashboard-stat stat-amber">
                <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
                <h5>Total Arsip</h5>
                <div class="number">{{ $totalArsip }}</div>
            </div>
        </div>
    </div>

    <!-- Activity Stats -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stat-card dashboard-stat stat-red">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <h5>Kegiatan Tahun Ini</h5>
                <div class="number text-primary">{{ $kegiatanTahunIni }}</div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stat-card dashboard-stat stat-violet">
                <div class="stat-icon"><i class="bi bi-person-plus"></i></div>
                <h5>Peserta Bulan Ini</h5>
                <div class="number text-success">{{ $pesertaBulanIni }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Kegiatan per Tahun</h5>
                </div>
                <div class="card-body">
                    <canvas id="kegiatanPerTahunChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Kegiatan per Jenis</h5>
                </div>
                <div class="card-body">
                    <canvas id="kegiatanPerJenisChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Top 5 Lokasi by Kegiatan</h5>
                </div>
                <div class="card-body">
                    <canvas id="topLokasiChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-people"></i> Peserta per Kegiatan (Top 5)</h5>
                </div>
                <div class="card-body">
                    <canvas id="pesertaPerKegiatanChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Kegiatans -->
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Kegiatan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-table">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Tahun</th>
                                    <th>Peserta</th>
                                    <th>Arsip</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatanTerbaru as $kegiatan)
                                <tr>
                                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                                    <td>
                                        @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                                            <span class="badge bg-info">Penyuluhan</span>
                                        @else
                                            <span class="badge bg-warning">Pembinaan</span>
                                        @endif
                                    </td>
                                    <td>{{ $kegiatan->lokasi->nama_kabupaten }}</td>
                                    <td>{{ $kegiatan->tahun }}</td>
                                    <td><span class="badge bg-primary">{{ $kegiatan->peserta_count }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $kegiatan->arsip_count }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.kegiatan.show', $kegiatan->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada kegiatan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')
<script>
    // Data dari Controller
    const kegiatanPerTahun = {!! json_encode($kegiatanPerTahun) !!};
    const kegiatanPerJenis = {!! json_encode($kegiatanPerJenis) !!};
    const topLokasi = {!! json_encode($topLokasi) !!};
    const pesertaPerKegiatan = {!! json_encode($pesertaPerKegiatan) !!};

    // Chart 1: Kegiatan per Tahun (Line Chart)
    new Chart(document.getElementById('kegiatanPerTahunChart'), {
        type: 'line',
        data: {
            labels: Object.keys(kegiatanPerTahun),
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: Object.values(kegiatanPerTahun),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Chart 2: Kegiatan per Jenis (Doughnut Chart)
    new Chart(document.getElementById('kegiatanPerJenisChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(kegiatanPerJenis),
            datasets: [{
                data: Object.values(kegiatanPerJenis),
                backgroundColor: ['#3b82f6', '#ef4444'],
                borderColor: ['#ffffff', '#ffffff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // Chart 3: Top Lokasi (Bar Chart - Horizontal)
    new Chart(document.getElementById('topLokasiChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(topLokasi),
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: Object.values(topLokasi),
                backgroundColor: '#10b981',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Chart 4: Peserta per Kegiatan (Bar Chart)
    new Chart(document.getElementById('pesertaPerKegiatanChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(pesertaPerKegiatan),
            datasets: [{
                label: 'Jumlah Peserta',
                data: Object.values(pesertaPerKegiatan),
                backgroundColor: '#f59e0b',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush

@endsection
