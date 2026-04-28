<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
        }

        .sidebar h4 {
            padding: 20px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .main {
            margin-left: 240px;
            padding: 20px;
            background: #f4f6f9;
            min-height: 100vh;
        }

        .card {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>Admin Panel</h4>

    <a href="/admin/dashboard">📊 Dashboard</a>
    <a href="/admin/kegiatan">📁 Kegiatan</a>
    <a href="/admin/lokasi">📍 Lokasi</a>
    <a href="#">📁 Arsip</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="
            all: unset;
            cursor: pointer;
            display: block;
            padding: 10px;
            color: #fff;">📦 Logout
        </button>
    </form>
</div>

<div class="main">
    @yield('content')
</div>

</body>
</html>