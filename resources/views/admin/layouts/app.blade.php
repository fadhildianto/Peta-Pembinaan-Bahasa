<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Balai Bahasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #1e293b;
            color: white;
            position: fixed;
            overflow-y: auto;
        }

        .sidebar h4 {
            padding: 20px;
            border-bottom: 1px solid #334155;
        }

        .sidebar a, .sidebar button {
            display: block;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            font-size: 14px;
        }

        .sidebar a:hover, .sidebar button:hover {
            background: #334155;
            color: white;
        }

        .sidebar a.active {
            background: #3b82f6;
            color: white;
            border-left: 4px solid #60a5fa;
        }

        .main {
            margin-left: 240px;
            padding: 30px;
            background: #f4f6f9;
            min-height: 100vh;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 8px 8px 0 0 !important;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-card h5 {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: none;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>
        <i class="bi bi-speedometer2"></i> Admin
    </h4>

    <a href="{{ route('admin.dashboard') }}" class="@if(Route::is('admin.dashboard')) active @endif">
        <i class="bi bi-graph-up"></i> Dashboard
    </a>
    <a href="{{ route('admin.kegiatan.index') }}" class="@if(Route::is('admin.kegiatan.*')) active @endif">
        <i class="bi bi-calendar-event"></i> Kegiatan
    </a>
    <a href="{{ route('admin.lokasi.index') }}" class="@if(Route::is('admin.lokasi.*')) active @endif">
        <i class="bi bi-geo-alt"></i> Lokasi
    </a>
    <a href="{{ route('admin.peserta.index') }}" class="@if(Route::is('admin.peserta.*')) active @endif">
        <i class="bi bi-people"></i> Peserta
    </a>
    <a href="{{ route('admin.arsip.index') }}" class="@if(Route::is('admin.arsip.*')) active @endif">
        <i class="bi bi-file-earmark"></i> Arsip
    </a>

    <hr style="border-color: #334155; margin: 20px 0;">

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="cursor: pointer; color: #cbd5e1;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<div class="main">
    <!-- Flash Messages -->
    @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>