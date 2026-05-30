@include('layouts.header')
@include('layouts.navbar')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- HERO -->
<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-content fade-up">

        <span class="hero-label">
            SMART SALES ANALYTICS PLATFORM
        </span>

        <h1>
            Smart Sales Analytics for Modern Superstores
        </h1>

        <p>
            SerbaSerbi membantu memonitor transaksi,
            performa penjualan, stok produk,
            dan laporan bisnis secara real-time
            dalam satu dashboard modern dan interaktif.
        </p>

        <!-- BUTTON KE LOGIN -->
        <a href="{{ route('login') }}" class="primary-btn">
    Go to Dashboard
</a>

    </div>

</section>

<!-- FEATURES -->
<section class="categories">

    <div class="category">
        <i class="fa-solid fa-chart-line"></i>
        <span>Sales Analytics</span>
    </div>

    <div class="category">
        <i class="fa-solid fa-boxes-stacked"></i>
        <span>Inventory Tracking</span>
    </div>

    <div class="category">
        <i class="fa-solid fa-wallet"></i>
        <span>Revenue Reports</span>
    </div>

    <div class="category">
        <i class="fa-solid fa-chart-column"></i>
        <span>Real-Time Monitoring</span>
    </div>

    <div class="category">
        <i class="fa-solid fa-users"></i>
        <span>Customer Insights</span>
    </div>

    <div class="category">
        <i class="fa-solid fa-receipt"></i>
        <span>Transaction Reports</span>
    </div>

</section>

<!-- DASHBOARD PREVIEW -->
<section class="products">

    <div class="title">
        <h2>Dashboard Preview</h2>
        <a href="{{ route('login') }}">Open Dashboard</a>
    </div>

    <div class="product-grid">

        <div class="card product-card">
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=900&auto=format&fit=crop">

            <div class="card-content">
                <h3>Sales Analytics</h3>
                <p>Visualisasi penjualan real-time</p>
            </div>
        </div>

        <div class="card product-card">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=900&auto=format&fit=crop">

            <div class="card-content">
                <h3>Performance Reports</h3>
                <p>Laporan performa bisnis modern</p>
            </div>
        </div>

        <div class="card product-card">
            <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?q=80&w=900&auto=format&fit=crop">

            <div class="card-content">
                <h3>Transaction Monitoring</h3>
                <p>Pantau seluruh transaksi toko</p>
            </div>
        </div>

        <div class="card product-card">
            <img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop">

            <div class="card-content">
                <h3>Inventory Management</h3>
                <p>Kelola stok produk lebih efisien</p>
            </div>
        </div>

    </div>

</section>

<!-- BANNER -->
<section class="banner">

    <div>

        <h2>
            Modern Dashboard Experience
        </h2>

        <p>
            Analisis penjualan, laporan transaksi,
            dan monitoring inventory kini lebih cepat,
            efisien, dan responsif dalam satu platform.
        </p>

    </div>

    <a href="{{ route('login') }}" class="primary-btn light-btn">
        Access Dashboard
    </a>

</section>

<!-- WHY SERBASERBI -->
<section class="products">

    <div class="title">
        <h2>Why SerbaSerbi?</h2>
    </div>

    <div class="product-grid">

        <div class="card product-card">
            <div class="card-content">
                <h3>Interactive Charts</h3>
                <p>
                    Visualisasi data modern menggunakan grafik interaktif.
                </p>
            </div>
        </div>

        <div class="card product-card">
            <div class="card-content">
                <h3>Real-Time Reports</h3>
                <p>
                    Data penjualan diperbarui secara langsung dan akurat.
                </p>
            </div>
        </div>

        <div class="card product-card">
            <div class="card-content">
                <h3>Responsive Dashboard</h3>
                <p>
                    Tampilan optimal di desktop maupun mobile device.
                </p>
            </div>
        </div>

        <div class="card product-card">
            <div class="card-content">
                <h3>Inventory Insights</h3>
                <p>
                    Monitoring stok dan produk terlaris lebih mudah.
                </p>
            </div>
        </div>

    </div>

</section>

<!-- TESTIMONI -->
<section class="testimoni">

    <h2>
        Trusted by Our Team
    </h2>

    <div class="testimoni-grid">

        <div class="testi-card glass-card">
            <p>
                “Monitoring penjualan jadi jauh lebih cepat dan efisien.”
            </p>

            <h4>
                — Nabila Imtiyaz
            </h4>
        </div>

        <div class="testi-card">
            <p>
                “Visualisasi data dashboard sangat membantu pengambilan keputusan.”
            </p>

            <h4>
                — Zahra Aulia
            </h4>
        </div>

        <div class="testi-card">
            <p>
                “Manajemen stok dan laporan penjualan terasa lebih profesional.”
            </p>

            <h4>
                — Aliyah Azzah
            </h4>
        </div>

    </div>

</section>

@include('layouts.footer')
@include('layouts.scripts')