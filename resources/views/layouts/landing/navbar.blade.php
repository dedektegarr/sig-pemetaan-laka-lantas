<nav class="main-header navbar navbar-expand-md navbar-dark">
    <div class="container">
        <a href="{{ env('APP_URL') }}" class="navbar-brand">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ env('APP_URL') }}" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.peta.index') }}" class="nav-link">Peta Kecelakaan</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.grafik.index') }}" class="nav-link">Grafik</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
