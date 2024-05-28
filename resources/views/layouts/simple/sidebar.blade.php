<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="">
                KOPIKU
            </a>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="#">
                KOPIKU
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    @if (auth()->user()->role->name == "admin")
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('index') }}">
                                <svg class="stroke-icon">
                                    <use href="/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="/assets/svg/icon-sprite.svg#fill-home"></use>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">MANAJEMEN RESELLER</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('daftar-reseller') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <span>Daftar Reseller</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('pengajuan-reseller') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                                </svg>
                                <span>Pengajuan Reseller</span>
                            </a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">MANAJEMEN PRODUK</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('daftar-produk') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <span>Daftar Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('tambah-produk') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                                </svg>
                                <span>Tambah Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('daftar-order') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                                </svg>
                                <span>Daftar Pesanan</span>
                            </a>
                        </li>
                    @else
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('index-reseller') }}">
                                <svg class="stroke-icon">
                                    <use href="/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="/assets/svg/icon-sprite.svg#fill-home"></use>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('daftar-order-reseller') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <span>Produk Dipesan</span>
                            </a>
                        </li>
                        @if (auth()->user()->reseller->status == false)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('produk') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                    </svg>
                                    <span>Pendaftaran Reseller</span>
                                </a>
                            </li>
                        @else
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('produk') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                    </svg>
                                    <span>Pendaftaran Pembelian Produk</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
