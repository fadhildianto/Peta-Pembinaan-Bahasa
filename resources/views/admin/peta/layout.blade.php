<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Interaktif - Balai Bahasa Provinsi Riau</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #003d7a;
            --secondary-color: #ffc107;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a5c9a 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 18px;
        }

        .navbar a {
            color: white !important;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: var(--secondary-color) !important;
        }

        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a5c9a 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .hero h1 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a5c9a 100%);
            color: white;
            border-radius: 8px 8px 0 0 !important;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: #1a5c9a;
        }

        .footer {
            background: var(--primary-color);
            color: white;
            padding: 40px 0 20px 0;
            margin-top: 50px;
        }

        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 20px 0;
            }

            .hero h1 {
                font-size: 24px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('peta.index') }}">
                <i class="bi bi-map"></i> Balai Bahasa Prov. Riau
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peta.index') }}">
                            <i class="bi bi-map"></i> Peta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">
                            <i class="bi bi-info-circle"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="bi bi-speedometer2"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container-fluid">
            <h1><i class="bi bi-map"></i> Peta Interaktif</h1>
            <p>Balai Bahasa Provinsi Riau</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <h5>Balai Bahasa Provinsi Riau</h5>
                    <p>Lembaga pemerintah yang bertugas melaksanakan pembinaan dan pengembangan bahasa, sastra, dan aksara Indonesia.</p>
                </div>
                <div class="col-md-6">
                    <h5>Kontak</h5>
                    <p>
                        <i class="bi bi-telephone"></i> (0761) 123456<br>
                        <i class="bi bi-envelope"></i> <a href="mailto:info@balaibahasariau.go.id">info@balaibahasariau.go.id</a><br>
                        <i class="bi bi-globe"></i> <a href="https://balaibahasariau.go.id" target="_blank">balaibahasariau.go.id</a>
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p style="margin-bottom: 0;">&copy; 2025-2026 Balai Bahasa Provinsi Riau. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>