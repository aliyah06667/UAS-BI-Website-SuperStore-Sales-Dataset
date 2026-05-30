@php
$current_page = request()->segment(1);
@endphp

<style>
/* ===== CORE SIDEBAR STYLE ===== */
.sidebar {
    width: 260px;
    height: 100vh;
    background: #fff;
    display: flex;
    flex-direction: column;
    padding: 2rem 1.4rem;
    border-right: 1px solid rgba(93, 51, 64, 0.06);
    transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    position: fixed; /* Membuat posisi sidebar tetap/mengunci di kiri */
    top: 0;
    left: 0;
    z-index: 100;
}

/* LOGO */
.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 2.4rem;
    white-space: nowrap;
}

.hamburger-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 4px;
    flex-shrink: 0;
}

.hamburger-btn span {
    width: 22px;
    height: 2.5px;
    background: #5D3340;
    border-radius: 3px;
}

/* NAV MENU */
.nav-menu {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.nav-link {
    font-size: 0.875rem;
    font-weight: 500;
    color: #A08090;
    padding: 13px 18px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    transition: all 0.3s;
    white-space: nowrap;
}

.nav-link i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

.nav-link:hover {
    background: #F9DCE7;
    color: #5D3340;
    transform: translateX(6px);
}

.nav-link.active {
    background: linear-gradient(135deg, #5D3340, #8B4060);
    color: #fff;
    box-shadow: 0 8px 24px rgba(93, 51, 64, 0.2);
}

/* USER PROFILE SYSTEM */
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #F9DCE7;
    border-radius: 20px;
    overflow: hidden;
    white-space: nowrap;
    transition: all 0.3s;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5D3340, #FF5CA8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    flex-shrink: 0;
}

/* ===== LOGIKA KETIKA SIDEBAR MENGECIL (COLLAPSED) ===== */
.sidebar.collapsed {
    width: 88px;
    padding: 2rem 1rem;
}

/* Sembunyikan Teks */
.sidebar.collapsed .sidebar-logo strong,
.sidebar.collapsed .nav-link .text,
.sidebar.collapsed .sidebar-user div:not(.user-avatar) {
    display: none;
}

/* Menyesuaikan posisi komponen di tengah saat mengecil */
.sidebar.collapsed .sidebar-logo {
    justify-content: center;
    gap: 0;
}

.sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 13px 0;
}

.sidebar.collapsed .sidebar-user {
    justify-content: center;
    background: transparent; /* Hilangkan background pink saat mengecil agar rapi */
    padding: 0;
}

/* ===== MANIPULASI HALAMAN UTAMA (GLOBAL EFFECT) ===== */
/* CSS ini akan langsung otomatis mendeteksi .main-content di file transaksi Anda */
.main-content {
    margin-left: 260px !important; 
    transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

/* Jika sibebar mengecil, geser margin kiri halaman transaksi secara otomatis */
.sidebar.collapsed ~ .wrapper .main-content,
.sidebar.collapsed ~ .main-content {
    margin-left: 88px !important;
}

/* OVERLAY MOBILE */
.sidebar-overlay {
    position: fixed;
    display: block;
    inset: 0;
    background: rgba(0,0,0,.35);
    opacity: 0;
    visibility: hidden;
    transition: 0.3s;
    z-index: 90;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Responsif Layar Gadget */
@media (max-width: 992px) {
    .sidebar {
        left: -260px;
    }
    .sidebar.active {
        left: 0;
    }
    .main-content,
    .sidebar.collapsed ~ .wrapper .main-content,
    .sidebar.collapsed ~ .main-content {
        margin-left: 0 !important;
    }
}
</style>

<!-- SIDEBAR HTML -->
<div class="sidebar" id="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">
        <button class="hamburger-btn" id="hamburgerBtn">
            <span></span><span></span><span></span>
        </button>
        <strong style="font-family:'EB Garamond', serif; font-size:22px; color: var(--primary-plum, #5D3340);">
            SerbaSerbi.
        </strong>
    </div>

    <!-- MENU NAVIGATION -->
    <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span class="text">Dashboard</span>
        </a>

        <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i>
            <span class="text">Transaksi</span>
        </a>

        <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
            <i class="fa-solid fa-box"></i>
            <span class="text">Produk</span>
        </a>

        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span class="text">Laporan</span>
        </a>

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="text">Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </nav>

    <!-- USER INFO -->
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <div style="font-weight:600; font-size: 0.85rem; color: #5D3340;">
                {{ auth()->user()->name ?? 'Admin' }}
            </div>
            <small style="color:#A08090; font-size: 0.75rem;">System Admin</small>
        </div>
    </div>
</div>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="overlay"></div>

<!-- JAVASCRIPT TOGGLE SYSTEM -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const btn = document.getElementById('hamburgerBtn');
    const overlay = document.getElementById('overlay');

    // Fungsi klik tombol hamburger
    btn.addEventListener('click', () => {
        if (window.innerWidth > 992) {
            sidebar.classList.toggle('collapsed');
        } else {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    });

    // Tutup sidebar di mobile jika klik area luar
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
});
</script>