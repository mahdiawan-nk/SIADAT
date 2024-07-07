@php
    $routeName = Route::currentRouteName();
    $urlParts = explode('.', $routeName);
    // Mengakses elemen kedua (indeks 1)
    $urlSite = isset($urlParts[1]) ? $urlParts[1] : null;
    // Mengakses elemen ketiga (indeks 2)
    $urlSiteNext = isset($urlParts[2]) ? $urlParts[2] : null;
    $menuAdatKebudayaan = [
        'Adat Istiadat' => route('panel-admin.adat-kebudayaan.adat-istiadat'),
        'Seni Tari' => route('panel-admin.adat-kebudayaan.seni-tari'),
        'Seni Musik' => route('panel-admin.adat-kebudayaan.seni-musik'),
        'Kuliner Khas' => route('panel-admin.adat-kebudayaan.kuliner-khas'),
        'Peninggalan' => route('panel-admin.adat-kebudayaan.peninggalan'),
    ];
@endphp
<div id="sidebar">
    <div class="sidebar-wrapper ">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('panel-admin.home') }}">SIADAT</a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ $urlSite == 'home' ? 'active' : '' }}">
                    <a href="{{ route('panel-admin.home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard </span>
                    </a>
                </li>
                <li class="sidebar-item {{ $urlSite == 'berita' ? 'active' : '' }}">
                    <a href="{{ route('panel-admin.berita') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Berita</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub {{ $urlSite == 'profil' ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Profil</span>
                    </a>
                    <ul class="submenu {{ $urlSite == 'profil' ? 'active submenu-open' : '' }}">
                        <li class="submenu-item {{ $urlSiteNext == 'visi-misi' ? 'active' : '' }}">
                            <a href="{{ route('panel-admin.profil.visi-misi') }}" class="submenu-link">Visi Misi </a>
                        </li>
                        <li class="submenu-item  {{ $urlSiteNext == 'sejarah' ? 'active' : '' }}">
                            <a href="{{ route('panel-admin.profil.sejarah') }}" class="submenu-link">Sejarah</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $urlSite == 'informasi' ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Informasi</span>
                    </a>
                    <ul class="submenu {{ $urlSite == 'informasi' ? 'active submenu-open' : '' }}">
                        <li class="submenu-item  {{ $urlSiteNext == 'ninik-mamak' ? 'active' : '' }}">
                            <a href="{{ route('panel-admin.informasi.ninik-mamak') }}" class="submenu-link">Datouk
                                ninik Mamak</a>
                        </li>
                        @if (in_array(auth()->user()->role, [1]))
                            <li class="submenu-item  {{ $urlSiteNext == 'kenegerian' ? 'active' : '' }}">
                                <a href="{{ route('panel-admin.informasi.kenegerian') }}"
                                    class="submenu-link">Kenegerian</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $urlSite == 'adat-kebudayaan' ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Adat & Kebudayaan</span>
                    </a>
                    <ul class="submenu {{ $urlSite == 'adat-kebudayaan' ? 'active submenu-open' : '' }}">
                        @foreach ($menuAdatKebudayaan as $menuTitle => $menuRoute)
                            @php
                                $slug = strtolower(str_replace(' ', '-', $menuTitle));
                                $allowedAccess = true; // Default: semua role diizinkan
                                if ($menuTitle !== 'Adat Istiadat' && auth()->user()->role == 2) {
                                    $allowedAccess = false; // Role 2 hanya boleh mengakses Adat Istiadat
                                }
                            @endphp

                            @if ($allowedAccess)
                                <li class="submenu-item {{ $urlSiteNext == $slug ? 'active' : '' }}">
                                    <a href="{{ $menuRoute }}" class="submenu-link">{{ $menuTitle }} </a>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </li>
                @if (in_array(auth()->user()->role, [1]))
                    <li class="sidebar-item {{ $urlSite == 'kontak' ? 'active' : '' }}">
                        <a href="{{ route('panel-admin.kontak') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Kontak</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a href="{{ route('panel-admin.pesan') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Pesan</span>
                    </a>
                </li>
                @if (in_array(auth()->user()->role, [1]))
                    <li class="sidebar-item {{ $urlSite == 'akun' ? 'active' : '' }}">
                        <a href="{{ route('panel-admin.akun') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Manajemen Akun</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
