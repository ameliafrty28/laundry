<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }

        .login-card {
            border-radius: 15px;
            overflow: hidden;
        }

        .login-card .card-body {
            padding: 30px;
        }

        .login-title {
            font-weight: 600;
        }

        .btn-primary {
            border-radius: 10px;
            transition: 0.2s;
        }

        .btn-primary:hover {
            transform: scale(1.03);
        }

        .form-control {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container">
<div class="row justify-content-center align-items-center" style="height:100vh">

<div class="col-md-4">

<div class="card shadow-lg login-card">

<div class="card-body">

<h4 class="text-center mb-4 login-title">
    🔐 Login Sistem Laundry
</h4>

@if(session('error'))
<div class="alert alert-danger text-center">
    {{ session('error') }}
</div>
@endif

<form method="POST" action="/login">
@csrf

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" name="user_username" class="form-control" placeholder="Masukkan username" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="user_password" class="form-control" placeholder="Masukkan password" required>
</div>

<button class="btn btn-primary w-100">
    Login
</button>

</form>

</div>
</div>

<p class="text-center text-white mt-3 small">
    © {{ date('Y') }} Laundry System
</p>

</div>

</div>
</div>

</body>
</html>