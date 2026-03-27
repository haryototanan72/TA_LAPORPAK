<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - LaporPak</title>

    <!-- PWA viewport -->
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
            padding: 30px 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
        }

        h1 {
            color: white;
            margin-bottom: 10px;
            font-size: 26px;
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
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #555;
            background: rgba(255,255,255,0.1);
            color: white;
            outline: none;
        }

        input::placeholder {
            color: #aaa;
        }

        .error {
            color: #ff4d4d;
            font-size: 12px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(to right, #fbbf24, #f59e0b);
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        /* 🔥 Desktop enhancement */
        @media (min-width: 768px) {
            .container {
                max-width: 900px;
                display: flex;
                padding: 0;
            }

            .form-section {
                flex: 1;
                padding: 50px;
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
        <h1>Masuk</h1>
        <p>Tidak punya akun? <a href="{{ route('register') }}">Daftar</a></p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Masukan email Anda">
                <div id="emailError" class="error"></div>
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Masukan password Anda">
                <div id="passwordError" class="error"></div>
            </div>

            <button type="submit">Masuk</button>
        </form>
    </div>

    <div class="image-section"></div>

</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    let valid = true;

    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (email === '') {
        document.getElementById('emailError').innerText = 'Email wajib diisi';
        valid = false;
    }

    if (password === '') {
        document.getElementById('passwordError').innerText = 'Password wajib diisi';
        valid = false;
    }

    if (!valid) event.preventDefault();
});
</script>

</body>
</html>