<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Laundry</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-5.0.0-beta2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.2.0.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <!-- Custom CSS -->
    <style>
        .hero-section {
            padding-top: 120px;
            padding-bottom: 80px;
            overflow: hidden;
        }

        .hero-content {
            padding: 20px;
        }

        .hero-img {
            text-align: center;
        }

        .hero-img img {
            max-width: 100%;
            height: auto;
        }

        @media (min-width: 992px) {
            .hero-img img {
                max-width: 80%;
            }
        }
    </style>
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand text-black" href="#">
                            Dews's Laundry System
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- HERO -->
<section id="home" class="hero-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <div class="hero-content">
                    <span class="wow fadeInLeft" data-wow-delay=".2s">
                        Welcome To Dew's Laundry
                    </span>

                    <h1 class="wow fadeInUp" data-wow-delay=".4s">
                        Rapi, Bersih, dan Wangi
                    </h1>

                    <p class="wow fadeInUp" data-wow-delay=".6s">
                        Siap membersihkan noda-noda kecuali noda masalalumu.
                    </p>

                    <a href="/login" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">
                        Mulai Transaksi
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-img wow fadeInUp" data-wow-delay=".5s">
                    <img src="{{ asset('assets/img/hero/hero.png') }}" alt="Hero Image">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="copy-right">
            <p>
                Design and Developed by 
                <a href="https://uideck.com" target="_blank">UIdeck</a>. 
                Distributed by 
                <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
    </div>
</footer>

<!-- JS -->
<script src="{{ asset('assets/js/bootstrap-5.0.0-beta2.min.js') }}"></script>

</body>
</html>