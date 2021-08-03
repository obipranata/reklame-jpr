@extends('layouts.templates')

@section('sidebar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @if (Auth::user()->level == 1)
                            {{-- <a class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}" href="">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a> --}}
                            <a class="nav-link {{ Request::segment(1) == 'vendor' ? 'active' : '' }}" href="/vendor">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Vendor
                            </a>
                            <a class="nav-link {{ Request::segment(1) == 'jenisreklame' ? 'active' : '' }}" href="/jenisreklame">
                                <div class="sb-nav-link-icon"><i class="fas fa-chalkboard"></i></div>
                                Jenis Reklame
                            </a>
                            <a class="nav-link {{ Request::segment(1) == 'wilayah' ? 'active' : '' }}" href="/wilayah">
                                <div class="sb-nav-link-icon"><i class="fas fa-location-arrow"></i></div>
                                Wilayah
                            </a>
                            <a class="nav-link {{ Request::segment(1) == 'datareklame' ? 'active' : '' }}" href="/datareklame">
                                <div class="sb-nav-link-icon"><i class="fab fa-flipboard"></i></div>
                                Data Reklame
                            </a>
                            <a class="nav-link {{ Request::segment(1) == 'petareklame' ? 'active' : '' }}" href="/petareklame">
                                <div class="sb-nav-link-icon"><i class="fas fa-map"></i></div>
                                Peta Penyebaran
                            </a>
                            <a class="nav-link {{ Request::segment(2) == 'pesanan' ? 'active' : '' }}" href="/admin/pesanan">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pesanan
                            </a>
                            <a class="nav-link {{ Request::segment(2) == 'buktibayar' ? 'active' : '' }}" href="/admin/buktibayar">
                                <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                                Verifikasi Bukti Bayar
                            </a>
                        @elseif(Auth::user()->level == 2)
                            <a class="nav-link {{ Request::segment(2) == 'pesanan' ? 'active' : '' }}" href="/vendor/pesanan">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pesanan
                            </a>
                            <a class="nav-link {{ Request::segment(2) == 'buktibayar' ? 'active' : '' }}" href="/vendor/buktibayar">
                                <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                                Verifikasi Bukti Bayar
                            </a>
                            <a class="nav-link {{ Request::segment(2) == 'pengajuan' ? 'active' : '' }}" href="/vendor/pengajuan">
                                <div class="sb-nav-link-icon"><i class="fas fa-sticky-note"></i></div>
                                Pengajuan
                            </a>
                            <a class="nav-link {{ Request::segment(2) == 'petareklame' ? 'active' : '' }}" href="/vendor/petareklame">
                                <div class="sb-nav-link-icon"><i class="fas fa-sticky-note"></i></div>
                                Data Reklame
                            </a>
                        @elseif(Auth::user()->level == 4)
                            <a class="nav-link {{ Request::segment(2) == 'izinvendor' ? 'active' : '' }}" href="/dinas/izinvendor">
                                <div class="sb-nav-link-icon"><i class="fas fa-sticky-note"></i></div>
                                Izin Vendor
                            </a>
                        @endif
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small text-white">Login in sebagai:</div>
                    <span class="text-success">{{Auth::user()->email}}</span>
                </div>
            </nav>
        </div>

        @if (Auth::user()->level == 1)
            @yield('content_admin')
        @elseif(Auth::user()->level == 2)
            @yield('content_vendor')
        @elseif(Auth::user()->level == 4)
            @yield('content_dinas')
        @endif
    </div>
@endsection