<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Buku Induk Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #d9e7ff, #6aa8ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.10);
        }

        .login-card img {
            width: 90px;
            display: block;
            margin: 0 auto 15px;
        }
    </style>
</head>
<body>

    <div class="login-card">

        <!-- LOGO -->
        <img src="images/smkn1-kawali-logo.png" alt="Logo">

        <!-- TITLE -->
        <h3 class="text-center fw-bold mb-2">Masuk Ke Akun Anda</h3>
        <p class="text-center mb-3">Gunakan nomor induk dan password untuk mengakses sistem Buku Induk Siswa.</p>

        <!-- ERROR MESSAGE -->
        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <small>{{ $errors->first() }}</small>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <!-- NOMOR INDUK -->
            <label class="fw-semibold mb-1">Nomor Induk</label>
            <input type="text" name="nomor_induk" class="form-control mb-3" placeholder="Masukkan NIS atau NIP" required>

            <!-- PASSWORD -->
            <label class="fw-semibold mb-1">Password</label>
            <div class="input-group mb-2">
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                <span class="input-group-text" onclick="togglePassword()">
                    <i class="bi bi-eye" id="icon-eye"></i>
                </span>
            </div>

            <div class="text-end mb-3">
                <a href="#" class="forgot-link">Lupa Password?</a>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            const icon = document.getElementById("icon-eye");

            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                pass.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>

</body>
</html>
