@php
    $current_page     = 'reports';
    $reports          = $reports ?? [];
    $categories       = $categories ?? [];
    $totalRevenue     = $totalRevenue ?? 0;
    $totalOrders      = $totalOrders ?? 0;
    $totalQuantity    = $totalQuantity ?? 0;
    $keyword          = $keyword ?? '';
    $selectedCategory = $selectedCategory ?? '';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan — SerbaSerbi.</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* =====================================================
           ROOT VARIABLES
        ===================================================== */
        :root {
            --primary-plum:  #5D3340;
            --plum-mid:      #7A4055;
            --accent-pink:   #FF5CA8;
            --glow-pink:     rgba(255, 92, 168, 0.35);
            --soft-pink:     #F9DCE7;
            --soft-lavender: #EADFFF;
            --soft-mint:     #DFF7EA;
            --soft-peach:    #FFE1D6;
            --bg-base:       #FFF9FB;
            --text-dark:     #3A2030;
            --text-muted:    #A08090;
            --border-color:  rgba(93, 51, 64, 0.10);
            --shadow-sm:     0 4px 20px rgba(93,51,64,0.06);
            --shadow-card:   0 8px 32px rgba(93,51,64,0.09);
            --radius-sm:     14px;
            --radius-md:     20px;
            --radius-lg:     28px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* =====================================================
           LOADING OVERLAY
        ===================================================== */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.80);
            backdrop-filter: blur(6px);
            z-index: 1055; /* di atas modal bootstrap tapi tidak bentrok sidebar */
            display: none;
            align-items: center;
            justify-content: center;
        }
        .loading-box {
            background: #fff;
            padding: 18px 26px;
            border-radius: var(--radius-md);
            box-shadow: 0 12px 48px rgba(93,51,64,0.14);
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--primary-plum);
        }
        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 3px solid #f3d9e5;
            border-top-color: var(--accent-pink);
            border-radius: 50%;
            animation: spin .75s linear infinite;
            flex-shrink: 0;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =====================================================
           BASE
        ===================================================== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* =====================================================
           DECORATIVE BACKGROUND
        ===================================================== */
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            will-change: transform; /* GPU layer, tidak lag */
        }
        .blob-1 {
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, #FFB3D4 0%, #FF5CA8 70%);
            top: -160px;
            right: -60px;
            opacity: .30;
        }
        .blob-2 {
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, #E9DFFF 0%, #C5AAFF 70%);
            bottom: -120px;
            left: -120px;
            opacity: .28;
        }

        /* =====================================================
           LAYOUT
        ===================================================== */
        .main-content {
            margin-left: 260px;
            padding: 2rem 2.4rem 3rem;
            position: relative;
            z-index: 1;
        }

        /* =====================================================
           PAGE HEADER
        ===================================================== */
        .page-header {
            background: linear-gradient(135deg, #3D1A28 0%, #5D3340 35%, #8B3A65 68%, #FF5CA8 100%);
            border-radius: var(--radius-lg);
            padding: 40px 44px;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.8rem;
            box-shadow: 0 16px 56px rgba(93,51,64,0.28);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            animation: fadeInUp 0.45s ease both;
        }
        /* Dekorasi lingkaran halus di dalam header */
        .page-header::before {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.05);
            top: -140px;
            right: 120px;
            pointer-events: none;
        }
        .page-header::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 40px solid rgba(255,255,255,0.05);
            bottom: -90px;
            right: 30px;
            pointer-events: none;
        }
        .header-content { position: relative; z-index: 2; }
        .header-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(255,255,255,0.65);
            text-transform: uppercase;
            letter-spacing: 2.5px;
            margin-bottom: 6px;
        }
        .header-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 8px;
        }
        .header-sub {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.75);
            font-weight: 400;
            max-width: 420px;
        }

        .btn-export {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.96);
            color: var(--primary-plum);
            border: none;
            border-radius: 50px;
            padding: 12px 26px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            transition: all .25s;
            box-shadow: 0 6px 22px rgba(0,0,0,0.16);
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-export:hover {
            background: var(--soft-pink);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(93,51,64,0.20);
            color: var(--primary-plum);
        }

        /* =====================================================
           STAT CARDS
        ===================================================== */
        .stat-card {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 24px 22px;
            border: 1.5px solid var(--border-color);
            box-shadow: var(--shadow-card);
            transition: transform 0.28s ease, box-shadow 0.28s ease;
            animation: fadeInUp 0.55s ease both;
            height: 100%; /* agar semua card sama tinggi dalam satu row */
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(93,51,64,0.13);
        }
        .stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }
        .stat-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }
        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
        .stat-value {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--primary-plum);
            line-height: 1.1;
            margin-bottom: 5px;
            /* Agar angka tidak meluap ke luar card */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .stat-sub {
            font-size: 0.70rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* =====================================================
           TOOLBAR / FILTER CARD
        ===================================================== */
        .toolbar-card {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 18px 22px;
            border: 1.5px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.4rem;
            animation: fadeInUp 0.60s ease both;
        }
        .toolbar-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Bungkus search agar fleksibel */
        .search-wrap {
            position: relative;
            flex: 1 1 200px;
            min-width: 0; /* penting agar tidak overflow */
        }
        .search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-base);
            color: var(--text-dark);
            outline: none;
            transition: border-color .2s;
        }
        .search-input:focus {
            border-color: var(--accent-pink);
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.80rem;
            pointer-events: none;
        }

        .filter-select {
            padding: 10px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-base);
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            transition: border-color .2s;
            flex-shrink: 0;
        }
        .filter-select:focus { border-color: var(--accent-pink); }

        .btn-search {
            padding: 10px 22px;
            background: var(--primary-plum);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background .2s, transform .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-search:hover {
            background: var(--plum-mid);
            transform: translateY(-1px);
        }

        .btn-reset {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
            transition: color .2s;
        }
        .btn-reset:hover { color: var(--accent-pink); }

        .toolbar-count {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-left: auto;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .toolbar-count strong { color: var(--primary-plum); }

        /* =====================================================
           TABLE CARD
        ===================================================== */
        .table-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 28px 28px 20px;
            border: 1.5px solid var(--border-color);
            box-shadow: var(--shadow-card);
            animation: fadeInUp 0.65s ease both;
            overflow: hidden;
        }

        /* Card title area */
        .table-card-header { margin-bottom: 20px; }
        .table-card-title  { font-size: 1rem; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
        .table-card-sub    { font-size: 0.75rem; color: var(--text-muted); font-weight: 400; }

        /* thead — seamless, no background, uppercase bold dark */
        .table { border-collapse: separate; border-spacing: 0; }
        .table thead tr th {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-dark);
            padding: 0 16px 14px;
            border-bottom: 1.5px solid var(--border-color);
            border-top: none;
            background: transparent;
            white-space: nowrap;
            text-align: left;
        }
        .table thead tr th.text-center { text-align: center; }

        /* tbody */
        .table tbody tr { transition: background .15s; }
        .table tbody tr:hover { background: #FFF4F8; }
        .table tbody td {
            padding: 15px 16px;
            border-top: 1px solid var(--border-color);
            border-bottom: none;
            font-size: 0.81rem;
            vertical-align: middle;
            color: var(--text-dark);
        }

        /* Kolom khusus */
        .col-date    { white-space: nowrap; color: var(--text-muted); font-size: 0.76rem; }
        .col-id      { font-weight: 700; color: var(--primary-plum); white-space: nowrap; font-size: 0.80rem; }
        .col-sales   { white-space: nowrap; font-weight: 600; }
        .col-profit  { white-space: nowrap; color: #1aaa6c; font-weight: 700; }
        .col-qty     { text-align: center; font-weight: 700; }
        .col-product { max-width: 170px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* Badges */
        .badge-city {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--soft-lavender); color: #6C5CE7;
            padding: 4px 10px; border-radius: 10px;
            font-size: 0.72rem; font-weight: 600; white-space: nowrap;
        }
        .badge-cat {
            display: inline-block;
            background: var(--soft-pink); color: var(--primary-plum);
            font-size: 0.68rem; font-weight: 600;
            padding: 4px 9px; border-radius: 8px; white-space: nowrap;
        }

        /* Empty state — ikon folder + teks kecil, persis referensi */
        .empty-state { text-align: center; padding: 52px 24px 48px; }
        .empty-state .empty-icon-wrap {
            font-size: 2.8rem; margin-bottom: 10px; opacity: .50; line-height: 1;
        }
        .empty-state p { font-size: 0.80rem; color: var(--text-muted); margin: 0; }

        /* =====================================================
           PAGINATION FOOTER — persis referensi
           info kiri  |  < cur > kanan
        ===================================================== */
        .pagination-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }
        .pagination-info { font-size: 0.75rem; color: var(--text-muted); }
        .pagination-info strong { color: var(--text-dark); font-weight: 600; }

        /* Sembunyikan nav bawaan Laravel, pakai custom pag-wrap */
        .pagination-footer nav,
        .pagination-footer .pagination { display: none !important; }

        /* Tombol custom pagination */
        .pag-wrap { display: flex; align-items: center; gap: 4px; }
        .pag-btn {
            width: 34px; height: 34px;
            border-radius: 8px;
            border: 1.5px solid var(--border-color);
            background: #fff;
            color: var(--text-dark);
            font-size: 0.80rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all .18s;
            line-height: 1;
        }
        .pag-btn:hover:not(.active):not(.disabled) {
            background: var(--soft-pink);
            border-color: var(--soft-pink);
            color: var(--primary-plum);
        }
        .pag-btn.active {
            background: var(--primary-plum);
            border-color: var(--primary-plum);
            color: #fff;
        }
        .pag-btn.disabled { opacity: .35; cursor: default; pointer-events: none; }
        .pag-btn svg { width: 12px; height: 12px; fill: currentColor; display: block; }

        /* =====================================================
           RESPONSIVE — tablet / mobile
        ===================================================== */
        @media (max-width: 991.98px) {
            .main-content { margin-left: 0; padding: 1.2rem 1rem 2.5rem; }
            .page-header { padding: 28px 24px; flex-direction: column; align-items: flex-start; gap: 16px; }
            .header-title { font-size: 1.7rem; }
        }
        @media (max-width: 575.98px) {
            .stat-value { font-size: 1.25rem; }
            .toolbar-count { display: none; } /* hemat ruang di hp kecil */
        }
    </style>
</head>

<body>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-box">
        <div class="loading-spinner"></div>
        <span>Memuat laporan penjualan...</span>
    </div>
</div>

<!-- Decorative background blobs -->
<div class="page-bg" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
</div>

<!-- SIDEBAR -->
@include('layouts.sidebar')

<div class="main-content">

    <!-- =================== PAGE HEADER =================== -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-label">Analisis Data</div>
            <h1 class="header-title">Laporan Penjualan</h1>
            <p class="header-sub">Rekapitulasi performa transaksi, laba rugi, dan persebaran wilayah.</p>
        </div>
        <a href="{{ route('reports.preview', ['search' => $keyword, 'category' => $selectedCategory]) }}"
           class="btn-export"
           onclick="document.getElementById('loadingOverlay').style.display='flex'">
            <i class="fas fa-file-pdf text-danger"></i>
            Export PDF
        </a>
    </div>

    <!-- =================== STAT CARDS =================== -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.05s">
                <div class="stat-card-top">
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-icon" style="background:rgba(26,170,108,0.12); color:#1aaa6c;">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="stat-value">$&nbsp;{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-sub">Akumulasi Penjualan</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.12s">
                <div class="stat-card-top">
                    <div class="stat-label">Jumlah Transaksi</div>
                    <div class="stat-icon" style="background:rgba(43,73,171,0.10); color:#2b49ab;">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
                <div class="stat-sub">Invoice Terbit</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.20s">
                <div class="stat-card-top">
                    <div class="stat-label">Produk Terjual</div>
                    <div class="stat-icon" style="background:rgba(255,92,168,0.12); color:#FF5CA8;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalQuantity) }}&nbsp;Pcs</div>
                <div class="stat-sub">Item Terjual</div>
            </div>
        </div>
    </div>

    <!-- =================== TOOLBAR =================== -->
    <div class="toolbar-card">
        <form method="GET" action="{{ url()->current() }}" id="reportFilterForm">
            <div class="toolbar-inner">

                <!-- Search input -->
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari Order ID, customer, kota…"
                        value="{{ $keyword }}"
                        autocomplete="off"
                    >
                </div>

                <!-- Category filter -->
                <select
                    class="filter-select"
                    name="category"
                    onchange="showLoading(); this.form.submit();"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option
                            value="{{ $cat['category'] }}"
                            {{ $selectedCategory === $cat['category'] ? 'selected' : '' }}
                        >
                            {{ $cat['category'] }}
                        </option>
                    @endforeach
                </select>

                <!-- Submit -->
                <button type="submit" class="btn-search" onclick="showLoading()">
                    <i class="fas fa-search me-1"></i> Cari
                </button>

                <!-- Reset -->
                @if ($keyword || $selectedCategory)
                    <a href="{{ url()->current() }}" class="btn-reset">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif

                <!-- Row count info -->
                <div class="toolbar-count">
                    <strong>{{ count($reports) }}</strong> baris di halaman ini
                </div>

            </div>
        </form>
    </div>

    <!-- =================== DATA TABLE =================== -->
    <div class="table-card">

        <!-- Card header title -->
        <div class="table-card-header">
            <div class="table-card-title">Riwayat Transaksi Penjualan</div>
            <div class="table-card-sub">Daftar data penjualan yang telah masuk ke basis data</div>
        </div>

        @if (empty($reports))
            <div class="empty-state">
                <div class="empty-icon-wrap">🗂️</div>
                <p>Belum ada data transaksi yang cocok.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Kota</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th class="text-center">Qty</th>
                            <th>Sales</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $r)
                            <tr>
                                <td class="col-date">{{ date('d/m/Y', strtotime($r['order_date'])) }}</td>
                                <td class="col-id">{{ $r['order_id'] }}</td>
                                <td>{{ $r['customer_name'] }}</td>
                                <td>
                                    <span class="badge-city">
                                        <i class="fas fa-map-marker-alt" style="font-size:.65rem"></i>
                                        {{ $r['city'] }}
                                    </span>
                                </td>
                                <td class="col-product" title="{{ $r['product_name'] }}">{{ $r['product_name'] }}</td>
                                <td><span class="badge-cat">{{ $r['category'] }}</span></td>
                                <td class="col-qty">{{ $r['quantity'] }}</td>
                                <td class="col-sales">$&nbsp;{{ number_format($r['sales_amount'], 0, ',', '.') }}</td>
                                <td class="col-profit">$&nbsp;{{ number_format($r['profit'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination footer — info kiri, tombol < cur > kanan -->
            @if(isset($salesPaginated))
            <div class="pagination-footer">

                {{-- Info kiri --}}
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $salesPaginated->firstItem() }}–{{ $salesPaginated->lastItem() }}</strong>
                    dari <strong>{{ number_format($salesPaginated->total()) }}</strong> berkas
                </div>

                {{-- Render nav bawaan Laravel (disembunyikan lewat CSS), dipakai untuk ambil URL --}}
                <div style="display:none">
                    {{ $salesPaginated->appends(request()->query())->links() }}
                </div>

                {{-- Custom tombol pagination kompak --}}
                <div class="pag-wrap">
                    {{-- Prev --}}
                    @if ($salesPaginated->onFirstPage())
                        <span class="pag-btn disabled" aria-label="Previous">
                            <svg viewBox="0 0 20 20"><path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/></svg>
                        </span>
                    @else
                        <a href="{{ $salesPaginated->appends(request()->query())->previousPageUrl() }}"
                           class="pag-btn" aria-label="Previous" onclick="showLoading()">
                            <svg viewBox="0 0 20 20"><path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/></svg>
                        </a>
                    @endif

                    {{-- Nomor halaman saat ini --}}
                    <span class="pag-btn active">{{ $salesPaginated->currentPage() }}</span>

                    {{-- Next --}}
                    @if ($salesPaginated->hasMorePages())
                        <a href="{{ $salesPaginated->appends(request()->query())->nextPageUrl() }}"
                           class="pag-btn" aria-label="Next" onclick="showLoading()">
                            <svg viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                        </a>
                    @else
                        <span class="pag-btn disabled" aria-label="Next">
                            <svg viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                        </span>
                    @endif
                </div>

            </div>
            @endif

        @endif
    </div>

</div><!-- /.main-content -->

<script>
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('reportFilterForm');
        if (form) {
            form.addEventListener('submit', showLoading);
        }
    });
</script>

</body>
</html>