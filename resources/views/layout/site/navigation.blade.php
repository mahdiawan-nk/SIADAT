@php
    // Get the current route name
    $currentRoute = Route::currentRouteName();

    // Extract the prefix from the route name
    $prefix = explode('.', $currentRoute)[0];
@endphp
<div class="container-fluid sticky-top bg-dark bg-light-radial shadow-sm px-5 pe-lg-0">
    <nav class="navbar navbar-expand-lg bg-dark bg-light-radial navbar-dark py-3 py-lg-0">
        <a href="index.html" class="navbar-brand">
            <h1 class="m-0 display-4 text-uppercase text-white"><img src="{{ asset('static-file/logo-kampar.png') }}"
                    style="width: 3vw" alt="">KAMPAR</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ url('/') }}"
                    class="nav-item nav-link {{ $prefix === 'home' ? 'active' : '' }}">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $prefix === 'profil' ? 'active' : '' }}"
                        data-bs-toggle="dropdown">Profil</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('profil.visi-misi') }}" class="dropdown-item">Visi Misi</a>
                        <a href="{{ route('profil.sejarah') }}" class="dropdown-item">Sejarah</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $prefix === 'informasi' ? 'active' : '' }}"
                        data-bs-toggle="dropdown">Informasi</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('informasi.ninik-mamak') }}" class="dropdown-item">Datuok atau Ninik Mamak</a>
                        <a href="{{ route('informasi.kenegerian') }}" class="dropdown-item">Kenegerian</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $prefix === 'kebudayaan' ? 'active' : '' }}"
                        data-bs-toggle="dropdown">Adat &
                        Kebudayaan</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('kebudayaan.page', ['pages' => 'adat-istiadat']) }}"
                            class="dropdown-item">Adat
                            Istiadat</a>
                        <a href="{{ route('kebudayaan.page', ['pages' => 'seni-tari']) }}" class="dropdown-item">Seni
                            Tari</a>
                        <a href="{{ route('kebudayaan.page', ['pages' => 'seni-musik']) }}" class="dropdown-item">Seni
                            Musik</a>
                        <a href="{{ route('kebudayaan.page', ['pages' => 'kuliner-khas']) }}"
                            class="dropdown-item">Kuliner</a>
                        <a href="{{ route('kebudayaan.page', ['pages' => 'peninggalan']) }}"
                            class="dropdown-item">Peninggalan</a>
                    </div>
                </div>
                <a href="{{ route('berita') }}"
                    class="nav-item nav-link {{ $prefix === 'berita' ? 'active' : '' }}">Berita</a>
                <a href="{{ route('kontak') }}" class="nav-item nav-link {{ $prefix === 'kontak' ? 'active' : '' }}">Kontak</a>
                {{-- <a href="{{ route('register') }}" class="nav-item nav-link bg-primary text-white px-5 ms-3 d-none d-lg-block">Registrasi<i class="bi bi-arrow-right ms-2"></i></a> --}}
            </div>
        </div>
    </nav>
</div>
