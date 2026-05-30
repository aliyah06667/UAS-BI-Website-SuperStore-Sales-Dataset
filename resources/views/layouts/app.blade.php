<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SerbaSerbi Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=EB+Garamond:wght@700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            background: #fff9fb;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'EB Garamond', serif;
        }

        /* ===== LAYOUT WRAPPER ===== */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ===== SIDEBAR POSITION CONTROL ===== */
        .sidebar {
            flex-shrink: 0;
        }

        /* ===== MAIN CONTENT WRAPPER ===== */
        .main-content-wrapper {
            flex: 1;
            min-width: 0; /* Mencegah konten Chart/Tabel merusak grid layout */
            margin-left: 260px; /* Jarak pas sesuai lebar sidebar */
            padding: 30px;
            transition: 0.35s ease;
            box-sizing: border-box;
        }

        /* SIDEBAR COLLAPSED SUPPORT */
        .sidebar.collapsed ~ .main-content-wrapper {
            margin-left: 90px;
        }

        /* RESPONSIVE LAYOUT (MOBILE) */
        @media (max-width: 992px) {
            .app-wrapper {
                flex-direction: column; /* Mengubah susunan baris pada mobile jika sidebar responsive */
            }
            .main-content-wrapper {
                margin-left: 0 !important;
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="app-wrapper">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN AREA CONTROLLER --}}
    <div class="main-content-wrapper">
        @yield('content')
    </div>

</div>

<!-- Core Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>