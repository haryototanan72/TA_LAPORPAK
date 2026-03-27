<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom right, #1c1c1e, #2c3e50);
        }
        .container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            display: flex;
            width: 900px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
        }
        .form-section {
            flex: 1;
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-section h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .form-section p {
            margin-bottom: 30px;
            font-size: 14px;
            color: #cbd5e1;
        }
        .form-section a {
            color: #fbbf24;
            text-decoration: none;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #555;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            color: white;
            font-size: 14px;
            outline: none;
        }
        .form-group input::placeholder {
            color: #aaa;
        }
        .error {
            color: #ff4d4d;
            font-size: 12px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(to right, #fbbf24, #f59e0b);
            color: black;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            opacity: 0.9;
        }
        .image-section {
            flex: 1;
            background: url('{{ asset('assets/img/daftar1.png') }}') no-repeat center center/cover;
            position: relative;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }
            .image-section {
                height: 200px;
            }
        }
    </style>
</head>
<body style="background: url('{{ asset('assets/img/bgl.png') }}') no-repeat center center/cover; background-size: cover;">


<div class="container">
    <div class="form-section">
        <h1>Masuk</h1>
        <p>Tidak punya akun<a href="{{ route('register') }}"> Daftar</a></p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Masukan email Anda" value="{{ old('email') }}">
                <div id="emailError" class="error"></div>
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Masukan password Anda">
                <div id="passwordError" class="error"></div>
            </div>

            <button type="submit">Masuk</button>
        </form>
    </div>

    <div class="image-section">
        <!-- Background gambar daftar1.png -->
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        let valid = true;

        document.getElementById('emailError').innerText = '';
        document.getElementById('passwordError').innerText = '';

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        if (email === '') {
            document.getElementById('emailError').innerText = 'Email is required.';
            valid = false;
        }
        if (password === '') {
            document.getElementById('passwordError').innerText = 'Password is required.';
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
