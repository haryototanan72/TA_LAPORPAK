<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - LaporPak</title>

    <!-- PWA viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1c1c1e, #2c3e50);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
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

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        label {
            font-size: 13px;
            color: #ddd;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border-radius: 8px;
            border: 1px solid #555;
            background: rgba(255,255,255,0.1);
            color: white;
            outline: none;
        }

        input[readonly] {
            background: rgba(255,255,255,0.05);
            color: #aaa;
            border-color: #444;
            cursor: not-allowed;
        }

        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 35px;
            cursor: pointer;
            color: white;
            user-select: none;
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
        <h1>Reset Password</h1>
        <p>Silakan masukkan password baru Anda untuk mengamankan akun.</p>

        @if ($errors->any())
            <div class="error" style="margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="resetForm" method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" readonly>
                <div id="emailError" class="error"></div>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" placeholder="Min. 8 karakter">
                <span class="eye-toggle" onclick="togglePassword('password')">👁</span>
                <div id="passwordError" class="error"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru">
                <span class="eye-toggle" onclick="togglePassword('password_confirmation')">👁</span>
                <div id="confirmPasswordError" class="error"></div>
            </div>

            <button type="submit">Reset Password</button>
        </form>
    </div>

    <div class="image-section"></div>

</div>

<script>
function togglePassword(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}

document.getElementById('resetForm').addEventListener('submit', function(event) {
    let valid = true;

    document.getElementById('passwordError').innerText = '';
    document.getElementById('confirmPasswordError').innerText = '';

    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    if (password === '') {
        document.getElementById('passwordError').innerText = 'Password baru wajib diisi';
        valid = false;
    } else if (password.length < 8) {
        document.getElementById('passwordError').innerText = 'Password minimal 8 karakter';
        valid = false;
    }

    if (confirmPassword === '') {
        document.getElementById('confirmPasswordError').innerText = 'Konfirmasi password wajib diisi';
        valid = false;
    }

    if (password !== '' && confirmPassword !== '' && password !== confirmPassword) {
        document.getElementById('confirmPasswordError').innerText = 'Password tidak sama';
        valid = false;
    }

    if (!valid) event.preventDefault();
});
</script>

</body>
</html>
