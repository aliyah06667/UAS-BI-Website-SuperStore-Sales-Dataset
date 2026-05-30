@php
    $current_page     = 'products';
    $totalProducts    = $totalProducts ?? 0;
    $categories       = $categories ?? [];
    $totalSubCategory = $totalSubCategory ?? 0;
    $keyword          = $keyword ?? '';
    $selectedCategory = $selectedCategory ?? '';

    // paginator dari controller
    $productsPaginated = $products ?? null;

    // item collection untuk looping tabel
    $products = $productsPaginated ? $productsPaginated->items() : [];
@endphp

@extends('layouts.app')

@push('styles')
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
            z-index: 1055;
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
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
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
           BACKGROUND BLOBS
        ===================================================== */
        .page-bg { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .blob { position: absolute; border-radius: 50%; filter: blur(100px); will-change: transform; }
        .blob-1 { width: 380px; height: 380px; background: radial-gradient(circle, #FFB3D4 0%, #FF5CA8 70%); top: -160px; right: -60px; opacity: .30; }
        .blob-2 { width: 420px; height: 420px; background: radial-gradient(circle, #E9DFFF 0%, #C5AAFF 70%); bottom: -120px; left: -120px; opacity: .28; }
        .blob-3 { width: 280px; height: 280px; background: radial-gradient(circle, #FFE1D6 0%, #FFB89A 70%); top: 50%; right: -60px; opacity: .22; }

        /* =====================================================
           LAYOUT
        ===================================================== */
        .product-page-content {
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
        .page-header::before {
            content: '';
            position: absolute;
            width: 340px; height: 340px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.05);
            top: -140px; right: 120px;
            pointer-events: none;
        }
        .page-header::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            border: 40px solid rgba(255,255,255,0.05);
            bottom: -90px; right: 30px;
            pointer-events: none;
        }
        .header-content { position: relative; z-index: 2; }
        .header-label {
            font-size: 0.68rem; font-weight: 700;
            color: rgba(255,255,255,0.65);
            text-transform: uppercase; letter-spacing: 2.5px;
            margin-bottom: 6px;
        }
        .header-title {
            font-size: 2.2rem; font-weight: 800;
            color: #fff; line-height: 1.15; margin-bottom: 8px;
        }
        .header-sub {
            font-size: 0.82rem; color: rgba(255,255,255,0.75);
            font-weight: 400; max-width: 420px; margin-bottom: 18px;
        }
        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 14px;
            background: rgba(255,255,255,0.14);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 500;
        }
        .header-illustration {
            position: relative; z-index: 2;
            animation: floatSlow 6s ease-in-out infinite;
            flex-shrink: 0;
        }
        .header-illustration svg {
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.35));
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
            height: 100%;
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
            font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted);
        }
        .stat-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem; flex-shrink: 0;
        }
        .stat-value {
            font-size: 1.55rem; font-weight: 800;
            color: var(--primary-plum); line-height: 1.1;
            margin-bottom: 5px;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .stat-sub { font-size: 0.70rem; color: var(--text-muted); font-weight: 400; }

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
        .search-wrap {
            position: relative;
            flex: 1 1 200px;
            min-width: 0;
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
        .search-input:focus { border-color: var(--accent-pink); }
        .search-input::placeholder { color: var(--text-muted); }
        .search-icon {
            position: absolute;
            left: 13px; top: 50%;
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
            outline: none; cursor: pointer;
            transition: border-color .2s;
            flex-shrink: 0;
        }
        .filter-select:focus { border-color: var(--accent-pink); }
        .btn-search {
            padding: 10px 22px;
            background: var(--primary-plum);
            color: #fff; border: none;
            border-radius: var(--radius-sm);
            font-size: 0.82rem; font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background .2s, transform .2s;
            white-space: nowrap; flex-shrink: 0;
        }
        .btn-search:hover { background: var(--plum-mid); transform: translateY(-1px); }
        .btn-reset {
            font-size: 0.78rem; color: var(--text-muted);
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 5px;
            flex-shrink: 0; transition: color .2s;
        }
        .btn-reset:hover { color: var(--accent-pink); }
        .toolbar-count {
            font-size: 0.76rem; color: var(--text-muted);
            margin-left: auto; white-space: nowrap; flex-shrink: 0;
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
        .table-card-header { margin-bottom: 20px; }
        .table-card-title  { font-size: 1rem; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
        .table-card-sub    { font-size: 0.75rem; color: var(--text-muted); font-weight: 400; }

        /* thead — seamless, uppercase, dark */
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

        /* tbody */
        .table tbody tr { transition: background .15s; }
        .table tbody tr:hover { background: #FFF4F8; }
        .table tbody td {
            padding: 14px 16px;
            border-top: 1px solid var(--border-color);
            border-bottom: none;
            font-size: 0.82rem;
            vertical-align: middle;
            color: var(--text-dark);
        }

        /* Row number */
        .col-no {
            color: var(--text-muted);
            font-size: 0.76rem;
            font-weight: 600;
            width: 48px;
        }

        /* Product ID */
        .col-pid {
            font-weight: 700;
            color: var(--primary-plum);
            font-size: 0.80rem;
            white-space: nowrap;
        }

        /* Product name with icon */
        .prod-thumb {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--soft-pink), var(--soft-lavender));
            border: 1.5px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); font-size: 1rem; flex-shrink: 0;
        }
        .prod-name {
            font-weight: 700; color: var(--text-dark);
            font-size: 0.84rem; line-height: 1.3;
        }

        /* Badges */
        .badge-cat {
            display: inline-block;
            background: var(--soft-lavender);
            color: #7A5CA8;
            font-size: 0.68rem; font-weight: 700;
            padding: 4px 11px; border-radius: 30px;
            border: 1px solid rgba(180,140,255,0.25);
            white-space: nowrap;
        }
        .badge-subcat {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Empty state */
        .empty-state { text-align: center; padding: 52px 24px 48px; }
        .empty-state .empty-icon-wrap {
            font-size: 2.8rem; margin-bottom: 10px; opacity: .50; line-height: 1;
        }
        .empty-state p { font-size: 0.80rem; color: var(--text-muted); margin: 0; }

        /* =====================================================
           PAGINATION FOOTER — identik dengan reports page
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

        /* Sembunyikan nav bawaan Laravel */
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
            font-size: 0.80rem; font-weight: 600;
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
           RESPONSIVE
        ===================================================== */
        @media (max-width: 991.98px) {
            .product-page-content { padding: 1.2rem 1rem 2.5rem; }
            .page-header { padding: 28px 24px; flex-direction: column; align-items: flex-start; gap: 16px; }
            .header-title { font-size: 1.7rem; }
            .header-illustration { display: none; }
        }
        @media (max-width: 575.98px) {
            .stat-value { font-size: 1.25rem; }
            .toolbar-count { display: none; }
        }
    </style>
@endpush

@section('content')

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-box">
        <div class="loading-spinner"></div>
        <span>Memuat data produk...</span>
    </div>
</div>

<!-- Decorative background blobs -->
<div class="page-bg" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<div class="product-page-content">

    <!-- =================== PAGE HEADER =================== -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-label">Manajemen Katalog</div>
            <h1 class="header-title">Daftar Produk</h1>
            <p class="header-sub">Kelola semua produk, stok, dan harga dalam satu tempat.</p>
            <div class="header-badge">
                <i class="fas fa-file-csv"></i>
                Data produk berasal dari upload transaksi CSV
            </div>
        </div>
        <!-- Illustration -->
        <div class="header-illustration d-none d-lg-flex">
            <svg width="200" height="170" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="40" y="60" width="100" height="90" rx="14" fill="url(#boxGrad)" opacity="0.95"/>
                <rect x="40" y="60" width="100" height="90" rx="14" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                <path d="M40 74 Q90 58 140 74" stroke="rgba(255,255,255,0.5)" stroke-width="2" fill="none"/>
                <line x1="90" y1="60" x2="90" y2="40" stroke="rgba(255,255,255,0.6)" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M78 40 Q90 32 102 40" stroke="rgba(255,255,255,0.6)" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                <rect x="58" y="80" width="64" height="5" rx="2.5" fill="rgba(255,255,255,0.3)"/>
                <rect x="65" y="92" width="50" height="4" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="58" y="104" width="64" height="4" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="120" y="90" width="60" height="32" rx="10" fill="rgba(255,255,255,0.18)" stroke="rgba(255,255,255,0.35)" stroke-width="1.2"/>
                <rect x="129" y="100" width="40" height="4" rx="2" fill="rgba(255,255,255,0.5)"/>
                <rect x="135" y="109" width="28" height="5" rx="2.5" fill="rgba(255,255,255,0.7)"/>
                <text x="155" y="55" font-size="20" fill="rgba(255,255,255,0.7)">★</text>
                <text x="35" y="165" font-size="14" fill="rgba(255,255,255,0.45)">✦</text>
                <text x="185" y="130" font-size="10" fill="rgba(255,255,255,0.35)">✦</text>
                <defs>
                    <linearGradient id="boxGrad" x1="40" y1="60" x2="140" y2="150" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#FFFFFF" stop-opacity="0.30"/>
                        <stop offset="100%" stop-color="#FFFFFF" stop-opacity="0.10"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    <!-- =================== STAT CARDS =================== -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.05s">
                <div class="stat-card-top">
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-icon" style="background:rgba(43,73,171,0.10); color:#2b49ab;">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalProducts) }}</div>
                <div class="stat-sub">Produk terdaftar</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.12s">
                <div class="stat-card-top">
                    <div class="stat-label">Kategori</div>
                    <div class="stat-icon" style="background:rgba(255,92,168,0.12); color:#FF5CA8;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
                <div class="stat-value">{{ count($categories) }}</div>
                <div class="stat-sub">Total kategori produk</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="animation-delay:.20s">
                <div class="stat-card-top">
                    <div class="stat-label">Sub Kategori</div>
                    <div class="stat-icon" style="background:rgba(26,170,108,0.12); color:#1aaa6c;">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalSubCategory) }}</div>
                <div class="stat-sub">Sub kategori tersedia</div>
            </div>
        </div>
    </div>

    <!-- =================== TOOLBAR =================== -->
    <div class="toolbar-card">
        <form method="GET" action="{{ url()->current() }}" id="productSearchForm">
            <div class="toolbar-inner">

                <!-- Search -->
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari produk atau kategori…"
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
        value="{{ $cat }}"
        {{ $selectedCategory === $cat ? 'selected' : '' }}
    >
        {{ $cat }}
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

                <!-- Count info -->
                <div class="toolbar-count">
                    <strong>{{ count($products) }}</strong> produk di halaman ini
                </div>

            </div>
        </form>
    </div>

    <!-- =================== TABLE CARD =================== -->
    <div class="table-card">

        <!-- Card header -->
        <div class="table-card-header">
            <div class="table-card-title">Katalog Produk</div>
            <div class="table-card-sub">Daftar seluruh produk yang tersinkron dari data transaksi</div>
        </div>

        @if (count($products) == 0)
            <div class="empty-state">
                <div class="empty-icon-wrap">📦</div>
                <p>
                    @if ($keyword)
                        Produk "{{ $keyword }}" tidak ditemukan. Coba kata kunci lain.
                    @else
                        Belum ada produk yang terdaftar.
                    @endif
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width:48px;">#</th>
                            <th>Product ID</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Sub Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $i => $p)
                            <tr>
                                <td class="col-no">
                                    {{-- Nomor absolut memperhitungkan halaman --}}
                                    {{ isset($productsPaginated) ? ($productsPaginated->firstItem() + $loop->index) : ($loop->index + 1) }}
                                </td>
                                <td class="col-pid">{{ $p->product_id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="prod-thumb">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div class="prod-name">{{ $p->product_name }}</div>
                                    </div>
                                </td>
                                <td><span class="badge-cat">{{ $p->category }}</span></td>
                                <td><span class="badge-subcat">{{ $p->sub_category }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ======= PAGINATION FOOTER (identik reports) ======= -->
            @if(isset($productsPaginated))
            <div class="pagination-footer">

                {{-- Info kiri --}}
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $productsPaginated->firstItem() }}–{{ $productsPaginated->lastItem() }}</strong>
                    dari <strong>{{ number_format($productsPaginated->total()) }}</strong> produk
                </div>

                {{-- Nav Laravel disembunyikan lewat CSS, hanya untuk URL --}}
                <div style="display:none">
                    {{ $productsPaginated->appends(request()->query())->links() }}
                </div>

                {{-- Tombol < cur > --}}
                <div class="pag-wrap">

                    {{-- Prev --}}
                    @if ($productsPaginated->onFirstPage())
                        <span class="pag-btn disabled" aria-label="Previous">
                            <svg viewBox="0 0 20 20">
                                <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $productsPaginated->appends(request()->query())->previousPageUrl() }}"
                           class="pag-btn" aria-label="Previous" onclick="showLoading()">
                            <svg viewBox="0 0 20 20">
                                <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Nomor halaman aktif --}}
                    <span class="pag-btn active">{{ $productsPaginated->currentPage() }}</span>

                    {{-- Next --}}
                    @if ($productsPaginated->hasMorePages())
                        <a href="{{ $productsPaginated->appends(request()->query())->nextPageUrl() }}"
                           class="pag-btn" aria-label="Next" onclick="showLoading()">
                            <svg viewBox="0 0 20 20">
                                <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                        </a>
                    @else
                        <span class="pag-btn disabled" aria-label="Next">
                            <svg viewBox="0 0 20 20">
                                <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                        </span>
                    @endif

                </div>
            </div>
            @endif

        @endif
    </div>

</div> <!-- /.product-page-content -->

@endsection

@push('scripts')
<script>
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.style.display = 'flex';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productSearchForm');
        if (form) {
            form.addEventListener('submit', showLoading);
        }
    });
</script>
@endpush