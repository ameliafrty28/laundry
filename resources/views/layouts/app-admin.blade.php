<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Laundry BI</title>

  <link rel="shortcut icon" href="{{ asset('assets/admin/imgages/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/styles.min.css') }}">
</head>
<style>
/* =========================================================
   HEADER
========================================================= */

.app-header {

    background: white;

    height: 80px;

    border-bottom: 1px solid #eef2f7;

    box-shadow:
        0 2px 12px rgba(0,0,0,.03);

    position: sticky;

    top: 0;

    z-index: 99;
}



/* =========================================================
   NAVBAR
========================================================= */

.navbar {

    height: 100%;

    padding: 0 30px;

    display: flex;

    align-items: center;

    justify-content: space-between;
}



/* =========================================================
   LEFT
========================================================= */
.left-sidebar {

    background:
        linear-gradient(
            180deg,
            #1e3c72,
            #2a5298
        );

    box-shadow:
        4px 0 20px rgba(0,0,0,.06);

    top: 0 !important;

    height: 100vh !important;

    z-index: 1000;
}
.header-left {

    display: flex;

    align-items: center;

    gap: 18px;
}

.mobile-toggle {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f3f4f6;

    color: #111827;

    font-size: 22px;

    text-decoration: none;
}



/* =========================================================
   PAGE TITLE
========================================================= */

.page-title {

    font-size: 24px;

    font-weight: 700;

    margin-bottom: 2px;

    color: #111827;
}

.page-subtitle {

    margin: 0;

    color: #6b7280;

    font-size: 14px;
}



/* =========================================================
   RIGHT
========================================================= */

.header-right {

    display: flex;

    align-items: center;

    gap: 18px;
}



/* =========================================================
   ICON
========================================================= */

.header-icon {

    width: 46px;

    height: 46px;

    border-radius: 14px;

    background: #f3f4f6;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;

    color: #111827;

    cursor: pointer;

    transition: .3s;
}

.header-icon:hover {

    background: #e5e7eb;
}



/* =========================================================
   PROFILE
========================================================= */

.profile-box {

    display: flex;

    align-items: center;

    gap: 12px;

    background: #f9fafb;

    padding: 8px 14px;

    border-radius: 16px;
}

.profile-box img {

    width: 46px;

    height: 46px;

    border-radius: 50%;

    object-fit: cover;
}

.profile-box h6 {

    margin: 0;

    font-size: 14px;

    font-weight: 700;

    color: #111827;
}

.profile-box small {

    color: #6b7280;

    font-size: 12px;
}



/* =========================================================
   SIDEBAR
========================================================= */

.left-sidebar {

    background:
        linear-gradient(
            180deg,
            #1e3c72,
            #2a5298
        );

    border-right: none;
}



/* =========================================================
   MENU
========================================================= */

.sidebar-link {

    height: 52px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 0 18px;

    color: rgba(255,255,255,.82) !important;

    font-weight: 500;

    transition: .3s;
}

.sidebar-link:hover {

    background: rgba(255,255,255,.10);

    color: white !important;

    transform: translateX(4px);
}

.sidebar-item.selected .sidebar-link {

    background: white;

    color: #1e3c72 !important;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);
}



/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:768px){

    .navbar {

        padding: 0 18px;
    }

    .page-title {

        font-size: 18px;
    }

    .profile-box div {

        display: none;
    }
}
</style>

<body>

<div
    class="page-wrapper"
    id="main-wrapper"
    data-layout="vertical"
    data-navbarbg="skin6"
    data-sidebartype="full"
    data-sidebar-position="fixed"
    data-header-position="fixed">




    {{-- ========================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================= --}}

    <aside class="left-sidebar">

        <div>

            {{-- LOGO --}}
            <div class="brand-logo p-4">

                <h4 class="text-white fw-bold mb-0">

                    Laundry BI

                </h4>

            </div>



           <ul id="sidebarnav">

    {{-- MENU TITLE --}}
    <li class="nav-small-cap">

        MENU UTAMA

    </li>



    {{-- DASHBOARD --}}
    <li class="sidebar-item active">

        <a
            class="sidebar-link"
            href="/admin/dashboard">

            <i class="ti ti-layout-dashboard"></i>

            <span>

                Dashboard

            </span>

        </a>

    </li>



    {{-- PELANGGAN --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/pelanggan">

            <i class="ti ti-users"></i>

            <span>

                Pelanggan

            </span>

        </a>

    </li>



    {{-- LAYANAN --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/layanan">

            <i class="ti ti-wash"></i>

            <span>

                Layanan

            </span>

        </a>

    </li>



    {{-- TRANSAKSI --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/transaksi">

            <i class="ti ti-shopping-cart"></i>

            <span>

                Transaksi

            </span>

        </a>

    </li>



    {{-- BUSINESS INTELLIGENCE --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/laporan">

            <i class="ti ti-chart-bar"></i>

            <span>

                Business Intelligence

            </span>

        </a>

    </li>



    {{-- PREDIKSI --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/prediksi">

            <i class="ti ti-brain"></i>

            <span>

                Prediksi

            </span>

        </a>

    </li>



    {{-- REKAP --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/rekap">

            <i class="ti ti-file-analytics"></i>

            <span>

                Rekap Harian

            </span>

        </a>

    </li>



    {{-- USER --}}
    <li class="sidebar-item">

        <a
            class="sidebar-link"
            href="/admin/user">

            <i class="ti ti-user-circle"></i>

            <span>

                User

            </span>

        </a>

    </li>



    {{-- LOGOUT --}}
    <li class="sidebar-item mt-4">

        <a
            class="sidebar-link"
            href="/logout">

            <i class="ti ti-logout"></i>

            <span>

                Logout

            </span>

        </a>

    </li>

</ul>

    </aside>





    {{-- ========================================= --}}
    {{-- BODY WRAPPER --}}
    {{-- ========================================= --}}

    <div class="body-wrapper">



        {{-- ========================================= --}}
        {{-- HEADER --}}
        {{-- ========================================= --}}

        <header class="app-header">

            <nav class="navbar navbar-expand-lg">

                {{-- LEFT --}}
                <div class="header-left">

                    <a
                        class="mobile-toggle d-xl-none"
                        href="javascript:void(0)">

                        <i class="ti ti-menu-2"></i>

                    </a>

                    <div>

                        <h4 class="page-title">

                            Dashboard Business Intelligence

                        </h4>

                        <p class="page-subtitle">

                            Monitoring dan analytics laundry system

                        </p>

                    </div>

                </div>



                {{-- RIGHT --}}
                <div class="header-right">
                    <div class="profile-box">

                        <img
                            src="{{ asset('assets/admin/images/profile/user-1.jpg') }}"
                            alt="profile">

                        <div>

                            <h6>

                                Administrator

                            </h6>

                            <small>

                                Business Intelligence

                            </small>

                        </div>

                    </div>

                </div>

            </nav>

        </header>





        {{-- ========================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================= --}}

        <div class="container-fluid">

            @yield('content')

        </div>

    </div>

</div>

<!-- JS -->
<script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/simplebar/dist/simplebar.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

@stack('scripts')
@yield('scripts')

</body>
</html>