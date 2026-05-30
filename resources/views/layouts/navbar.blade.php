<header class="navbar">

    <div class="logo">
        SerbaSerbi.
    </div>

    <nav aria-label="Main Navigation">

        <a href="#home">Home</a>
        <a href="#contact">Contact</a>

        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('reports.index') }}">Laporan</a>
        @endauth

    </nav>

    <div class="auth-section">

        @auth
            <a href="{{ route('dashboard') }}" class="login-btn">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="login-btn">
                Login
            </a>
        @endauth

    </div>

</header>