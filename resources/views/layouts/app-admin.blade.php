<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Laundry BI</title>

  <link rel="shortcut icon" href="{{ asset('assets/admin/imgages/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/styles.min.css') }}">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        <a class="d-flex justify-content-center" href="#">
          <img src="assets/admin/images/logos/logo-wrappixel.svg" alt="" width="150">
        </a>

        
      </div>

      <div class="d-lg-flex align-items-center gap-2">
        <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center">Check Flexy Premium Version</h3>
        <div class="d-flex align-items-center justify-content-center gap-2">
          
          <div class="dropdown d-flex">
            <a class="btn btn-primary d-flex align-items-center gap-1 " href="javascript:void(0)" id="drop4"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ti ti-shopping-cart fs-5"></i>
              Buy Now
              <i class="ti ti-chevron-down fs-5"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

  <!-- SIDEBAR -->
  <aside class="left-sidebar">
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="/dashboard" class="text-nowrap logo-img">
          <img src="{{ asset('assets/admin/images/logos/logo.svg') }}" alt="">
        </a>
      </div>

      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">

          <li class="nav-small-cap">
            <span class="hide-menu">Menu Utama</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="/admin/dashboard">
              <i class="ti ti-home"></i>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="/admin/pelanggan">
              <i class="ti ti-users"></i>
              <span class="hide-menu">Pelanggan</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="/admin/layanan">
              <i class="ti ti-list"></i>
              <span class="hide-menu">Layanan</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="/admin/transaksi">
              <i class="ti ti-shopping-cart"></i>
              <span class="hide-menu">Transaksi</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="/admin/laporan">
              <i class="ti ti-chart-bar"></i>
              <span class="hide-menu">Business Intelligence</span>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="body-wrapper">

    <!-- HEADER -->
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">

        <ul class="navbar-nav">
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0">
          <ul class="navbar-nav flex-row ms-auto align-items-center">

            <!-- USER -->
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/admin/images/profile/user-1.jpg') }}" width="35" class="rounded-circle">
              </a>

              <div class="dropdown-menu dropdown-menu-end">
                <div class="p-3">
                  <p class="mb-1">
                    {{ auth()->user()->user_nama ?? 'User' }}
                  </p>
                </div>

                <a href="/logout" class="btn btn-outline-primary mx-3 mb-2 d-block">
                  Logout
                </a>
              </div>
            </li>

          </ul>
        </div>

      </nav>
    </header>

    <!-- CONTENT -->
    <div class="body-wrapper-inner">
      <div class="container-fluid">

        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        {{-- INI YANG AKAN DIISI HALAMAN LAIN --}}
        @yield('content')

      </div>
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