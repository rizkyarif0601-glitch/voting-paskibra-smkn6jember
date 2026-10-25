@php
// ── SISTEM SLIDESHOW FOTO LATAR BELAKANG (JPG / PNG) ──
$bgSlides = [];

// 1. Prioritas Utama: Foto per kandidat di public/images/candidates/ (kandidat-1, kandidat-2, dst)
foreach (range(1, 4) as $num) {
$matches = glob(public_path("images/candidates/kandidat-{$num}.*"));
if (!empty($matches)) {
foreach ($matches as $match) {
$ext = strtolower(pathinfo($match, PATHINFO_EXTENSION));
if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
$bgSlides[] = asset('images/candidates/' . basename($match));
break;
}
}
}
}

// Jika ada file kandidat tanpa prefix "kandidat-", ambil seluruh file gambar di folder candidates/
if (empty($bgSlides)) {
$candidateFiles = glob(public_path('images/candidates/*.*'));
if (!empty($candidateFiles)) {
foreach ($candidateFiles as $f) {
$ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
$bgSlides[] = asset('images/candidates/' . basename($f));
}
}
}
}

// 2. Prioritas Kedua: Foto kandidat dari database (diunggah via Admin Panel)
if (empty($bgSlides)) {
try {
$candidatesList = $candidates ?? \App\Models\Candidate::orderBy('paslon_number')->get();
foreach ($candidatesList as $c) {
if (!empty($c->photo_url)) {
$bgSlides[] = $c->photo_url;
}
}
} catch (\Throwable $e) {
// Abaikan jika database belum siap
}
}

// 3. Prioritas Ketiga: File latar belakang khusus voting di public/images/bg-voting* (JPG/PNG)
if (empty($bgSlides)) {
$votingBgs = glob(public_path('images/bg-voting*'));
if (!empty($votingBgs)) {
foreach ($votingBgs as $vb) {
$ext = strtolower(pathinfo($vb, PATHINFO_EXTENSION));
if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
$bgSlides[] = asset('images/' . basename($vb));
}
}
}
}

// 4. Prioritas Keempat: File background umum bg-realtime (JPG/PNG) jika ada
if (empty($bgSlides)) {
$realtimeBgs = glob(public_path('images/bg-realtime*'));
if (!empty($realtimeBgs)) {
foreach ($realtimeBgs as $rb) {
$ext = strtolower(pathinfo($rb, PATHINFO_EXTENSION));
if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
$bgSlides[] = asset('images/' . basename($rb));
break;
}
}
}
}
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem E-Voting Pemilihan Ketua Umum Paskibra SMKN 6 Jember">
    <title>E-Voting Paskibra SMKN 6 Jember — Masukkan Token</title>
    {{-- Offline Local Fonts --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --red: #c0152a;
            --red-glow: #e0243d;
            --red-dk: #7d0d1b;
            --white: #f5f5f7;
            --dark: #080a0f;
            --dark-card: rgba(15, 18, 26, 0.82);
            --card-border: rgba(255, 255, 255, 0.12);
        }

        html,
        body {
            height: 100%;
            background-color: var(--dark);
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            background-image: radial-gradient(circle at 80% 20%, rgba(192, 21, 42, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(125, 13, 27, 0.12) 0%, transparent 60%);
        }

        /* ─── Layout Wrapper (Split Screen 2 Kolom) ─── */
        .layout-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
            position: relative;
        }

        /* ─── Kolom Kiri: Showcase Foto / Slideshow ─── */
        .photo-section {
            position: relative;
            flex: 1 1 56%;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-color: #05070a;
        }

        .photo-slides-wrap {
            position: absolute;
            inset: 0;
            overflow: hidden;
        }

        .photo-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: 0;
            transform: scale(1.02);
            transition: opacity 1.6s cubic-bezier(0.4, 0, 0.2, 1), transform 8s ease-out;
            will-change: opacity, transform;
        }

        .photo-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Fallback bila belum ada foto */
        .photo-fallback {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #161b26 0%, #080a0f 100%);
            padding: 40px;
            text-align: center;
        }

        .photo-fallback-logo {
            width: 120px;
            height: 120px;
            opacity: 0.35;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 30px rgba(192, 21, 42, 0.3));
        }

        /* ─── Efek Pemisah & Transisi Halus (Seamless Fade) ─── */
        /* 1. Fade horizontal ke arah kanan (menghilangkan garis potong / kaku) */
        .photo-fade-edge {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 50%;
            background: linear-gradient(to right,
                    rgba(8, 10, 15, 0) 0%,
                    rgba(8, 10, 15, 0.15) 30%,
                    rgba(8, 10, 15, 0.55) 60%,
                    rgba(8, 10, 15, 0.88) 85%,
                    #080a0f 100%);
            pointer-events: none;
            z-index: 2;
        }

        /* 2. Vignette lembut atas & bawah foto */
        .photo-vignette {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(8, 10, 15, 0.6) 0%,
                    rgba(8, 10, 15, 0.1) 18%,
                    transparent 50%,
                    rgba(8, 10, 15, 0.35) 80%,
                    rgba(8, 10, 15, 0.85) 100%);
            pointer-events: none;
            z-index: 2;
        }

        /* 3. Ambient Glow merah Paskibra di area batas pemisah */
        .ambient-glow-divider {
            position: absolute;
            right: -60px;
            top: 25%;
            height: 50%;
            width: 160px;
            background: radial-gradient(ellipse at center, rgba(192, 21, 42, 0.22) 0%, transparent 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 3;
        }

        /* 4. Garis aksen vertikal berpendar lembut (ultra sleek divider) */
        .glow-divider-line {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(180deg,
                    transparent 0%,
                    rgba(192, 21, 42, 0.12) 15%,
                    rgba(255, 255, 255, 0.22) 45%,
                    rgba(192, 21, 42, 0.4) 65%,
                    rgba(192, 21, 42, 0.1) 88%,
                    transparent 100%);
            box-shadow: 0 0 16px rgba(192, 21, 42, 0.3);
            pointer-events: none;
            z-index: 4;
        }

        /* Keterangan visual di pojok kiri bawah foto */
        .photo-footer-badge {
            position: relative;
            z-index: 5;
            margin: 0 0 36px 40px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(14, 17, 25, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 18px;
            border-radius: 100px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            max-width: fit-content;
        }

        .photo-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--red);
            box-shadow: 0 0 10px var(--red-glow);
            animation: pulse-dot 2s infinite ease-in-out;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 0.6;
                transform: scale(0.9);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        .photo-badge-text {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: rgba(255, 255, 255, 0.88);
        }

        .photo-badge-sub {
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.45);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            padding-left: 10px;
        }

        /* Indikator dots slide foto jika kandidat > 1 */
        .slide-dots {
            position: absolute;
            bottom: 42px;
            right: 48px;
            display: flex;
            gap: 8px;
            z-index: 5;
        }

        .slide-dot-item {
            width: 24px;
            height: 4px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
        }

        .slide-dot-item.active {
            background: var(--red);
            width: 36px;
            box-shadow: 0 0 10px rgba(192, 21, 42, 0.6);
        }

        /* ─── Kolom Kanan: Panel Form Pengisian Token (Full Panel) ─── */
        .form-section {
            flex: 0 0 46%;
            min-width: 440px;
            max-width: 580px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: clamp(24px, 3.5vh, 48px) clamp(24px, 3.5vw, 52px);
            position: relative;
            z-index: 10;
            overflow-y: auto;
            background: linear-gradient(135deg, rgba(12, 15, 22, 0.94) 0%, rgba(8, 10, 15, 0.98) 100%);
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: -20px 0 60px rgba(0, 0, 0, 0.65);
        }

        /* ─── Konten Form Token (Full & Lega Tanpa Border Kotak Kecil) ─── */
        .card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            animation: slide-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
            margin: auto 0;
            background: transparent;
            border: none;
            box-shadow: none;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            padding: 0;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ─── Logo / Header ───────────────────────────────── */
        .logo-ring {
            width: clamp(68px, 8.5vh, 78px);
            height: clamp(68px, 8.5vh, 78px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto clamp(10px, 1.4vh, 16px);
            box-shadow: 0 0 0 7px rgba(192, 21, 42, 0.14),
                0 8px 30px rgba(192, 21, 42, 0.35);
            background: #141722;
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            overflow: hidden;
        }

        .logo-ring img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .logo-ring svg {
            width: 36px;
            height: 36px;
            fill: white;
        }

        .badge {
            display: inline-block;
            background: rgba(192, 21, 42, 0.18);
            border: 1px solid rgba(192, 21, 42, 0.4);
            color: #ff6b7a;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 100px;
            margin-bottom: clamp(6px, 1vh, 10px);
        }

        h1 {
            font-size: clamp(18px, 2.2vh, 21px);
            font-weight: 800;
            line-height: 1.28;
            text-align: center;
            letter-spacing: -0.01em;
        }

        h1 span {
            color: var(--red);
        }

        .subtitle {
            text-align: center;
            font-size: clamp(12px, 1.4vh, 13px);
            color: rgba(255, 255, 255, 0.52);
            margin-top: 5px;
            margin-bottom: clamp(14px, 2vh, 22px);
            line-height: 1.4;
        }

        /* ─── Divider ─────────────────────────────────────── */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.12), transparent);
            margin-bottom: clamp(14px, 2vh, 22px);
        }

        /* ─── Form ────────────────────────────────────────── */
        label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        input[type="text"] {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: clamp(10px, 1.5vh, 14px) 16px;
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            font-size: clamp(22px, 2.8vh, 26px);
            font-weight: 700;
            letter-spacing: 0.35em;
            text-align: center;
            text-transform: uppercase;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 0.2em;
            font-size: 18px;
            font-weight: 400;
        }

        input[type="text"]:focus {
            border-color: var(--red);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(192, 21, 42, 0.22);
        }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(192, 21, 42, 0.12);
            border: 1px solid rgba(192, 21, 42, 0.35);
            border-radius: 10px;
            padding: 8px 12px;
            margin-top: 10px;
            font-size: 12.5px;
            color: #ff8a94;
            animation: shake 0.35s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            75% {
                transform: translateX(6px);
            }
        }

        /* ─── Button ──────────────────────────────────────── */
        .btn-primary {
            width: 100%;
            margin-top: clamp(14px, 2vh, 20px);
            padding: clamp(12px, 1.6vh, 15px);
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dk) 100%);
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: clamp(14px, 1.6vh, 15px);
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(192, 21, 42, 0.42);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, transparent 60%);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(192, 21, 42, 0.55);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 6px 18px rgba(192, 21, 42, 0.4);
        }

        /* ─── Footer Info ─────────────────────────────────── */
        .info-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: clamp(14px, 2vh, 20px);
            padding: clamp(9px, 1.2vh, 12px) 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 12px;
            font-size: clamp(11px, 1.3vh, 12px);
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.35;
        }

        .info-row svg {
            flex-shrink: 0;
            width: 15px;
            height: 15px;
            fill: rgba(255, 255, 255, 0.35);
        }

        .footer-text {
            text-align: center;
            font-size: clamp(10.5px, 1.2vh, 11.5px);
            color: rgba(255, 255, 255, 0.22);
            margin-top: clamp(12px, 1.6vh, 18px);
            letter-spacing: 0.04em;
        }

        /* ─── Responsivitas Layar Kecil / Tablet / Mobile ──── */
        @media (max-width: 960px) {
            .layout-container {
                flex-direction: column;
            }

            .photo-section {
                flex: none;
                height: 38vh;
                min-height: 240px;
            }

            .photo-fade-edge {
                width: 100%;
                top: auto;
                bottom: 0;
                height: 60%;
                background: linear-gradient(to bottom,
                        rgba(8, 10, 15, 0) 0%,
                        rgba(8, 10, 15, 0.45) 40%,
                        rgba(8, 10, 15, 0.85) 75%,
                        #080a0f 100%);
            }

            .glow-divider-line {
                width: 100%;
                height: 1px;
                top: auto;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(90deg,
                        transparent 0%,
                        rgba(192, 21, 42, 0.3) 50%,
                        transparent 100%);
            }

            .form-section {
                flex: 1 1 auto;
                min-width: 100%;
                max-width: 100%;
                min-height: auto;
                padding: 24px 20px 40px;
            }

            .photo-footer-badge {
                margin: 0 0 16px 20px;
                padding: 6px 14px;
            }

            .slide-dots {
                bottom: 20px;
                right: 24px;
            }
        }

        @media (max-width: 480px) {
            .photo-section {
                height: 28vh;
                min-height: 190px;
            }
        }
    </style>
</head>

<body>

    <div class="layout-container">

        {{-- ─── SISI KIRI: Foto / Slideshow Kandidat ─── --}}
        <div class="photo-section">
            @if (!empty($bgSlides))
            <div class="photo-slides-wrap" id="photo-slideshow">
                @foreach ($bgSlides as $index => $slideUrl)
                <div class="photo-slide {{ $index === 0 ? 'active' : '' }}"
                    style="background-image: url('{{ $slideUrl }}')"></div>
                @endforeach
            </div>

            {{-- Indikator Slide jika foto lebih dari 1 --}}
            @if (count($bgSlides) > 1)
            <div class="slide-dots" id="slide-dots">
                @foreach ($bgSlides as $index => $slideUrl)
                <div class="slide-dot-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div>
            @endif
            @else
            {{-- Fallback jika foto belum ada di folder --}}
            <div class="photo-fallback">
                <img src="{{ asset('images/logo-paskibra.png') }}" alt="Paskibra SMKN 6 Jember" class="photo-fallback-logo">
                <h2 style="font-size:22px;font-weight:700;color:rgba(255,255,255,0.7);margin-bottom:8px">Paskibra SMKN 6 Jember</h2>
                <p style="font-size:13px;color:rgba(255,255,255,0.4)">Pemilihan Ketua Umum </p>
            </div>
            @endif

            {{-- Lapisan Efek Fade & Pemisah Anti-Kaku --}}
            <div class="photo-vignette"></div>
            <div class="photo-fade-edge"></div>
            <div class="ambient-glow-divider"></div>
            <div class="glow-divider-line"></div>

            {{-- Badge Identitas Elegan di Atas Foto --}}
            <div class="photo-footer-badge">
                <span class="photo-badge-dot"></span>
                <span class="photo-badge-text">E-Pilketum</span>
                <span class="photo-badge-sub">Kandidat Ketua Umum Periode 2026/2027</span>
            </div>
        </div>

        {{-- ─── SISI KANAN: Border Pengisian Token ─── --}}
        <div class="form-section">
            <div class="card">

                {{-- Logo & Header --}}
                <div style="text-align:center">
                    <div class="logo-ring">
                        @if (file_exists(public_path('images/logo-paskibra.png')))
                        <img src="{{ asset('images/logo-paskibra.png') }}" alt="Logo Paskibra SMKN 6 Jember">
                        @else
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 2h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 10h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zM3 7h1v10H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1zm18 0a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-1V7h1z" />
                        </svg>
                        @endif
                    </div>

                    <div class="badge">Pasknam.Jember</div>

                    <h1><span>Pemilihan Ketua Umum</span><br>Berbasis Voting Digital<br><span>Paskibra SMKN 6 Jember</span></h1>
                    <p class="subtitle">Masukkan token 6 karakter yang Anda terima<br>untuk mengakses bilik suara.</p>
                </div>

                <div class="divider"></div>

                {{-- Form Token --}}
                <form method="POST" action="{{ route('voting.authenticate') }}" id="token-form" autocomplete="off">
                    @csrf

                    <label for="token">Token Pemilih</label>

                    <div class="input-wrap">
                        <input
                            type="text"
                            id="token"
                            name="token"
                            maxlength="6"
                            placeholder="——————"
                            value="{{ old('token') }}"
                            autofocus
                            spellcheck="false">
                    </div>

                    @error('token')
                    <div class="error-msg" role="alert" id="token-error">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;fill:#ff8a94;flex-shrink:0">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror

                    <button type="submit" class="btn-primary" id="submit-btn">
                        Masuk ke Bilik Suara &rarr;
                    </button>
                </form>

                {{-- Info Kerahasiaan --}}
                <div class="info-row">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                    </svg>
                    <strong style="color:rgba(255,255,255,0.7);margin:0 3px">Suara Anda bersifat rahasia & tidak dapat dilacak. LUBER JURDIL.</strong>
                </div>

                <p class="footer-text">&copy; Website Built by Rizqi Arif Ardiansyah &bull; {{ date('Y') }}</p>
            </div>
        </div>

    </div>

    <script>
        // Auto-uppercase input token
        const tokenInput = document.getElementById('token');
        if (tokenInput) {
            tokenInput.addEventListener('input', function() {
                const pos = this.selectionStart;
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                this.setSelectionRange(pos, pos);
            });
        }

        // Cegah klik berulang saat submit
        const tokenForm = document.getElementById('token-form');
        if (tokenForm) {
            tokenForm.addEventListener('submit', function() {
                const btn = document.getElementById('submit-btn');
                if (btn) {
                    btn.disabled = true;
                    btn.textContent = 'Memverifikasi…';
                    btn.style.opacity = '0.75';
                }
            });
        }

        // Slideshow crossfade foto kandidat (berganti otomatis per 6 detik)
        const slides = document.querySelectorAll('.photo-slide');
        const dots = document.querySelectorAll('.slide-dot-item');
        if (slides.length > 1) {
            let current = 0;
            setInterval(() => {
                slides[current].classList.remove('active');
                if (dots[current]) dots[current].classList.remove('active');

                current = (current + 1) % slides.length;

                slides[current].classList.add('active');
                if (dots[current]) dots[current].classList.add('active');
            }, 6000);
        }
    </script>
</body>

</html>