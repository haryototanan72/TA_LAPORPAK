<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - LaporPak</title>

    <!-- ✅ WAJIB PWA -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1c1c1e, #2c3e50);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
        }

        h1 {
            color: white;
            font-size: 26px;
            margin-bottom: 10px;
        }

        p {
            color: #cbd5e1;
            font-size: 14px;
            margin-bottom: 20px;
        }

        a {
            color: #fbbf24;
            text-decoration: none;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            font-size: 13px;
            color: #ddd;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #555;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
        }

        input::placeholder {
            color: #aaa;
        }

        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 32px;
            cursor: pointer;
            color: white;
        }

        .form-group {
            position: relative;
        }

        .error {
            color: #ff4d4d;
            font-size: 12px;
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(to right, #fbbf24, #f59e0b);
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        /* 💻 Desktop Mode */
        @media (min-width: 768px) {
            .container {
                max-width: 900px;
                display: flex;
                padding: 0;
            }

            .form-section {
                flex: 1;
                padding: 40px;
            }

            .image-section {
                flex: 1;
                background: url('{{ asset('assets/img/daftar1.png') }}') center/cover;
                border-radius: 0 16px 16px 0;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="form-section">
        <h1>Daftar</h1>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" id="name">
                <div id="nameError" class="error"></div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email">
                <div id="emailError" class="error"></div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password">
                <span class="eye-toggle" onclick="togglePassword('password')">👁</span>
                <div id="passwordError" class="error"></div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
                <span class="eye-toggle" onclick="togglePassword('password_confirmation')">👁</span>
                <div id="confirmPasswordError" class="error"></div>
            </div>

            <button type="submit">Daftar</button>
        </form>
    </div>

    <div class="image-section"></div>

</div>

<script>
function togglePassword(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}

document.getElementById('registerForm').addEventListener('submit', function(event) {
    let valid = true;

    document.getElementById('nameError').innerText = '';
    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    document.getElementById('confirmPasswordError').innerText = '';

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    if (name === '') {
        document.getElementById('nameError').innerText = 'Nama wajib diisi';
        valid = false;
    }

    if (email === '') {
        document.getElementById('emailError').innerText = 'Email wajib diisi';
        valid = false;
    }

    if (password === '') {
        document.getElementById('passwordError').innerText = 'Password wajib diisi';
        valid = false;
    }

    if (confirmPassword === '') {
        document.getElementById('confirmPasswordError').innerText = 'Konfirmasi password wajib diisi';
        valid = false;
    }

    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').innerText = 'Password tidak sama';
        valid = false;
    }

    if (!valid) event.preventDefault();
});
</script>

</body>
</html>