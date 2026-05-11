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
                <i class="bi bi-map"></i> Balai Bahasa Provinsi Riau
            </a>
        </div>
    </nav>

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
                    <p>Lembaga pemerintah yang bertugas melaksanakan pembinaan, pengembangan, dan perlindungan bahasa serta sastra indonesia</p>
                </div>
                <div class="col-md-6 text-start">
                    <h5>Kontak</h5>
                    <p>
                        <i class="bi bi-telephone"></i> (0761) 3223048<br>
                        <i class="bi bi-envelope"></i> <a href="mailto:balaibahasariau@kemendikdasmen.go.id">balaibahasariau@kemendikdasmen.go.id</a><br>
                        <i class="bi bi-globe"></i> <a href="https://balaibahasariau.kemendikdasmen.go.id" target="_blank">balaibahasariau.kemendikdasmen.go.id</a>
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
