<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Admin E-Voting Paskibra SMKN 6 Jember">
    <title>Login Admin — E-Voting Paskibra SMKN 6 Jember</title>

    {{-- Offline Local Fonts & Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    <style>
        :root {
            --navy-deep: #0B1120;
            --navy-dark: #0F172A;
            --navy-card: #1E293B;
            --navy-border: #334155;
            --emerald: #10B981;
            --emerald-hover: #059669;
            --text-light: #F8FAFC;
            --text-muted: #94A3B8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--navy-deep);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow */
        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }
        .orb-1 {
            width: 420px;
            height: 420px;
            background: #10B981;
            top: -100px;
            right: -100px;
        }
        .orb-2 {
            width: 480px;
            height: 480px;
            background: #3B82F6;
            bottom: -120px;
            left: -120px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-box {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-box i {
            font-size: 32px;
            color: var(--emerald);
        }

        .badge-secure {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--emerald);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 12px;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .brand-sub {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Alerts */
        .alert-box {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #FCA5A5;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6EE7B7;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #CBD5E1;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #64748B;
            font-size: 16px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1.5px solid var(--navy-border);
            border-radius: 14px;
            padding: 14px 16px 14px 44px;
            font-size: 14px;
            color: #FFFFFF;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--emerald);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .form-control-custom:focus + .input-icon,
        .input-group-custom:focus-within .input-icon {
            color: var(--emerald);
        }

        .toggle-pwd {
            position: absolute;
            right: 14px;
            background: transparent;
            border: none;
            color: #64748B;
            cursor: pointer;
            font-size: 17px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-pwd:hover {
            color: #CBD5E1;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94A3B8;
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--emerald);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: var(--emerald);
            color: #0F172A;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .btn-submit:hover {
            background: var(--emerald-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            color: #FFFFFF;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-links {
            text-align: center;
            margin-top: 28px;
        }

        .back-link {
            color: #64748B;
            text-decoration: none;
            font-size: 12.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--emerald);
        }

        .copyright-text {
            text-align: center;
            font-size: 11.5px;
            color: #475569;
            margin-top: 24px;
            letter-spacing: 0.04em;
        }
    </style>
</head>
<body>

    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>

    <div class="login-wrapper">
        <div class="login-card">

            {{-- Header --}}
            <div class="brand-header">
                <div class="logo-box">
                    @if (file_exists(public_path('images/logo-paskibra.png')))
                        <img src="{{ asset('images/logo-paskibra.png') }}" alt="Logo Paskibra">
                    @else
                        <i class="bi bi-shield-lock-fill"></i>
                    @endif
                </div>
                <div class="badge-secure">
                    <i class="bi bi-shield-fill-check"></i> Panel Terproteksi
                </div>
                <h1 class="brand-title">Admin E-Voting</h1>
                <p class="brand-sub">Paskibra SMK Negeri 6 Jember</p>
            </div>

            {{-- Flash Alert Messages --}}
            @if (session('success'))
                <div class="alert-box alert-success">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-box alert-error">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('admin.login.submit') }}" method="POST" id="loginForm" autocomplete="off">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email Administrator</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control-custom"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            required
                            autocomplete="off"
                            autofocus
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control-custom"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pwd" id="togglePassword" aria-label="Lihat kata sandi">
                            <i class="bi bi-eye-slash" id="pwdEyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" class="remember-checkbox" {{ old('remember') ? 'checked' : '' }}>
                        Ingat sesi saya
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <div class="footer-links">
                <a href="{{ route('voting.index') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali ke Halaman Pemilihan
                </a>
            </div>

        </div>

        <div class="copyright-text">
            &copy; {{ date('Y') }} Rizqi Arif Ardiansyah &bull; SMKN 6 Jember
        </div>
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const pwdInput = document.getElementById('password');
        const eyeIcon = document.getElementById('pwdEyeIcon');

        toggleBtn.addEventListener('click', function () {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                pwdInput.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        });

        // Submit loading indicator
        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Memverifikasi…';
            btn.style.opacity = '0.7';
        });
    </script>

</body>
</html>
