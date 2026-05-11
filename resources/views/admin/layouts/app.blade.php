<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel - Balai Bahasa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            color: #111827;
            background: #eef2f7;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #172033 0%, #1f2a44 55%, #26324f 100%);
            color: white;
            position: fixed;
            overflow-y: auto;
            z-index: 1030;
            transition: transform 0.2s ease;
            box-shadow: 12px 0 30px rgba(15, 23, 42, 0.16);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 18px;
            border-bottom: 1px solid rgba(203, 213, 225, 0.14);
        }

        .admin-brand img {
            width: 164px;
            height: auto;
            display: block;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.18));
        }

        .sidebar a, .sidebar button {
            display: block;
            padding: 12px 18px;
            margin: 4px 12px;
            color: #d8e0eb;
            text-decoration: none;
            border: none;
            background: transparent;
            width: calc(100% - 24px);
            text-align: left;
            font-size: 14px;
            border-radius: 8px;
            transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .sidebar a:hover, .sidebar button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(2px);
        }

        .sidebar a.active {
            background: #2563eb;
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.28);
        }

        .main {
            margin-left: 240px;
            padding: 30px;
            background: linear-gradient(180deg, #f7f9fc 0%, #eef2f7 100%);
            min-height: 100vh;
        }

        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 1040;
            border: none;
            border-radius: 8px;
            background: #1e293b;
            color: white;
            width: 42px;
            height: 42px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.2);
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 8px 8px 0 0 !important;
        }

        .table {
            vertical-align: middle;
        }

        .table thead th {
            background: #f8fafc;
            color: #0f172a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody tr {
            transition: background 0.16s ease;
        }

        .table-hover tbody tr:hover {
            background: #f8fbff;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            box-shadow: none;
        }

        .btn-sm {
            min-width: 34px;
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .badge {
            border-radius: 7px;
            padding: 0.44rem 0.62rem;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border-color: #d8dee8;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.16);
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
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

        .admin-page-hero {
            background: linear-gradient(135deg, #003d7a 0%, #1767a8 58%, #0ea5c6 100%);
            border-radius: 8px;
            color: #ffffff;
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 38px rgba(0, 61, 122, 0.16);
        }

        .admin-page-hero::after {
            content: "";
            position: absolute;
            right: -64px;
            bottom: -84px;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
        }

        .admin-page-hero > * {
            position: relative;
            z-index: 1;
        }

        .admin-page-hero h2 {
            margin: 0;
            font-weight: 800;
        }

        .admin-page-hero p {
            color: rgba(255, 255, 255, 0.82);
            margin: 8px 0 0;
        }

        .admin-page-hero .btn {
            border: none;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
        }

        .admin-card-interactive {
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .admin-card-interactive:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.13);
        }

        .admin-toolbar-card .card-body {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .admin-form-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #eef6ff 100%);
            padding: 18px 20px;
        }

        .admin-form-card .card-body {
            padding: 24px;
        }

        .admin-empty-state {
            padding: 42px 16px;
            color: #64748b;
        }

        .admin-empty-state i {
            display: block;
            font-size: 30px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .admin-action-group {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .admin-create-layout {
            align-items: flex-start;
        }

        .admin-create-card {
            position: relative;
        }

        .admin-create-card .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #eef7ff 100%);
        }

        .admin-create-card .form-label {
            font-weight: 700;
            color: #0f172a;
        }

        .admin-create-card .mb-3 {
            padding: 14px;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            background: #ffffff;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .admin-create-card .mb-3:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.12);
            transform: translateY(-2px);
        }

        .admin-create-card .row.mb-3 {
            padding: 0;
            border: none;
            background: transparent;
            box-shadow: none;
        }

        .admin-create-card .row.mb-3 > [class*="col-"] {
            padding-top: 14px;
            padding-bottom: 14px;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            background: #ffffff;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .admin-create-card .row.mb-3 > [class*="col-"]:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.12);
            transform: translateY(-2px);
        }

        .admin-create-side {
            position: sticky;
            top: 24px;
        }

        .admin-create-side .card-body {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .admin-create-icon {
            width: 58px;
            height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 28px;
            margin-bottom: 16px;
        }

        .admin-create-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            font-size: 13px;
            margin-top: 10px;
        }

        .admin-create-pill i {
            color: #0ea5e9;
        }

        .admin-create-actions {
            padding-top: 8px;
            border-top: 1px solid #eef2f7;
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
                width: 240px;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                padding: 72px 15px 15px;
            }

            .mobile-menu-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<button class="mobile-menu-btn" type="button" id="adminSidebarToggle" aria-label="Buka menu admin">
    <i class="bi bi-list fs-4"></i>
</button>

<div class="sidebar" id="adminSidebar">
    <div class="admin-brand">
        <img src="{{ asset('images/logo-bbpr.png') }}" alt="Balai Bahasa Provinsi Riau">
    </div>

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
    <a href="{{ route('admin.peta.index') }}" class="@if(Route::is('admin.peta.*')) active @endif">
        <i class="bi bi-map"></i> Peta
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
<script>
    const adminSidebar = document.getElementById('adminSidebar');
    const adminSidebarToggle = document.getElementById('adminSidebarToggle');

    adminSidebarToggle?.addEventListener('click', () => {
        adminSidebar?.classList.toggle('show');
    });

    adminSidebar?.querySelectorAll('a, button[type="submit"]').forEach((item) => {
        item.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                adminSidebar.classList.remove('show');
            }
        });
    });
</script>
@stack('scripts')

</body>
</html>
