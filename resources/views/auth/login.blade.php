<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Laundry System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        /* =========================================================
           BODY
        ========================================================= */

        body {

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #1e3c72,
                    #2a5298
                );

            overflow: hidden;

            font-family: 'Segoe UI', sans-serif;

            position: relative;
        }



        /* =========================================================
           BACKGROUND CIRCLE
        ========================================================= */

        .bg-circle {

            position: absolute;

            border-radius: 50%;

            background: rgba(255,255,255,.08);

            backdrop-filter: blur(10px);
        }

        .circle-1 {

            width: 300px;

            height: 300px;

            top: -100px;

            left: -80px;
        }

        .circle-2 {

            width: 220px;

            height: 220px;

            bottom: -80px;

            right: -60px;
        }



        /* =========================================================
           LOGIN CONTAINER
        ========================================================= */

        .login-wrapper {

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            position: relative;

            z-index: 10;
        }



        /* =========================================================
           LOGIN CARD
        ========================================================= */

        .login-card {

            width: 100%;

            max-width: 430px;

            border: none;

            border-radius: 30px;

            overflow: hidden;

            background: rgba(255,255,255,.12);

            backdrop-filter: blur(18px);

            box-shadow:
                0 10px 40px rgba(0,0,0,.18);

            padding: 45px 38px;

            color: white;
        }



        /* =========================================================
           LOGO
        ========================================================= */

        .login-logo {

            width: 85px;

            height: 85px;

            border-radius: 24px;

            margin: auto;

            margin-bottom: 25px;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #dbeafe
                );

            color: #1e3c72;

            font-size: 38px;

            box-shadow:
                0 8px 20px rgba(255,255,255,.18);
        }



        /* =========================================================
           TITLE
        ========================================================= */

        .login-title {

            font-size: 32px;

            font-weight: 700;

            margin-bottom: 8px;

            text-align: center;
        }

        .login-subtitle {

            text-align: center;

            color: rgba(255,255,255,.75);

            margin-bottom: 35px;

            font-size: 15px;
        }



        /* =========================================================
           FORM
        ========================================================= */

        .form-label {

            font-weight: 500;

            margin-bottom: 10px;

            color: rgba(255,255,255,.92);
        }

        .input-group {

            margin-bottom: 22px;
        }

        .input-group-text {

            border: none;

            background: rgba(255,255,255,.15);

            color: white;

            border-radius: 16px 0 0 16px;

            padding: 14px 18px;
        }

        .form-control {

            border: none;

            background: rgba(255,255,255,.12);

            color: white;

            height: 55px;

            border-radius: 0 16px 16px 0;

            padding-left: 15px;
        }

        .form-control::placeholder {

            color: rgba(255,255,255,.55);
        }

        .form-control:focus {

            background: rgba(255,255,255,.18);

            color: white;

            box-shadow: none;
        }



        /* =========================================================
           BUTTON
        ========================================================= */

        .btn-login {

            height: 55px;

            border: none;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #dbeafe
                );

            color: #1e3c72;

            font-weight: 700;

            transition: .3s;
        }

        .btn-login:hover {

            transform: translateY(-2px);

            color: #1e3c72;

            box-shadow:
                0 10px 24px rgba(255,255,255,.18);
        }



        /* =========================================================
           ALERT
        ========================================================= */

        .custom-alert {

            background: rgba(255,0,0,.12);

            border: 1px solid rgba(255,255,255,.12);

            color: white;

            border-radius: 16px;

            padding: 14px;

            margin-bottom: 20px;

            text-align: center;
        }



        /* =========================================================
           FOOTER
        ========================================================= */

        .login-footer {

            text-align: center;

            margin-top: 30px;

            color: rgba(255,255,255,.65);

            font-size: 14px;
        }



        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media(max-width:576px){

            .login-card {

                margin: 20px;

                padding: 35px 25px;
            }

            .login-title {

                font-size: 26px;
            }
        }

    </style>

</head>

<body>

    <!-- Background -->
    <div class="bg-circle circle-1"></div>

    <div class="bg-circle circle-2"></div>



    <!-- Login -->
    <div class="login-wrapper">

        <div class="login-card">

            <!-- Logo -->
            <div class="login-logo">

                <i class="bi bi-basket2-fill"></i>

            </div>



            <!-- Title -->
            <h2 class="login-title">

                Laundry System

            </h2>

            <p class="login-subtitle">

                Business Intelligence & Analytics Dashboard

            </p>



            <!-- Alert -->
            @if(session('error'))

                <div class="custom-alert">

                    {{ session('error') }}

                </div>

            @endif



            <!-- Form -->
            <form method="POST" action="/login">

                @csrf

                <!-- Username -->
                <label class="form-label">

                    Username

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-fill"></i>

                    </span>

                    <input
                        type="text"
                        name="user_username"
                        class="form-control"
                        placeholder="Masukkan username"
                        required>

                </div>



                <!-- Password -->
                <label class="form-label">

                    Password

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input
                        type="password"
                        name="user_password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>

                </div>



                <!-- Button -->
                <button class="btn btn-login w-100">

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    Login Dashboard

                </button>

            </form>



            <!-- Footer -->
            <div class="login-footer">

                © {{ date('Y') }} Laundry Business Intelligence System

            </div>

        </div>

    </div>

</body>

</html>