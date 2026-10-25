<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terima kasih telah berpartisipasi dalam E-Voting Paskibra SMKN 6 Jember">
    {{-- Auto-redirect ke halaman token setelah 5 detik --}}
    <meta http-equiv="refresh" content="5;url={{ route('voting.index') }}">
    <title>Terima Kasih — E-Voting Paskibra SMKN 6 Jember</title>
    {{-- Offline Local Fonts --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --red:    #c0152a;
            --red-dk: #8b0e1e;
            --green:  #22c55e;
            --dark:   #0d0d11;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--dark);
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ─── Background Particles ────────────────────────── */
        .confetti-container {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .confetti-dot {
            position: absolute;
            border-radius: 50%;
            animation: confetti-fall linear infinite;
        }

        @keyframes confetti-fall {
            0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        .bg-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
        }
        .bg-glow-1 { width: 600px; height: 600px; background: rgba(34,197,94,0.07); top: -150px; right: -150px; }
        .bg-glow-2 { width: 400px; height: 400px; background: rgba(192,21,42,0.08); bottom: -100px; left: -100px; }

        /* ─── Card ────────────────────────────────────────── */
        .card {
            position: relative;
            z-index: 10;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 28px;
            padding: 56px 48px 48px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 40px 100px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.07);
            animation: zoom-in 0.7s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes zoom-in {
            from { opacity: 0; transform: scale(0.8) translateY(30px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ─── Success Icon ────────────────────────────────── */
        .success-ring {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 28px;
        }

        .success-ring svg.ring-svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            animation: spin-in 1s ease-out both;
        }
        @keyframes spin-in {
            from { transform: rotate(-90deg); opacity: 0; }
            to   { transform: rotate(0deg);   opacity: 1; }
        }

        .success-inner {
            position: absolute;
            inset: 10px;
            background: linear-gradient(135deg, var(--green) 0%, #16a34a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 8px rgba(34,197,94,0.15), 0 8px 32px rgba(34,197,94,0.4);
            animation: pop-icon 0.5s 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
        }
        @keyframes pop-icon {
            from { transform: scale(0); }
            to   { transform: scale(1); }
        }
        .success-inner svg { width: 42px; height: 42px; fill: white; }

        /* ─── Text ────────────────────────────────────────── */
        .badge {
            display: inline-block;
            background: rgba(34,197,94,0.12);
            border: 1px solid rgba(34,197,94,0.3);
            color: #86efac;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 100px;
            margin-bottom: 14px;
            animation: fade-up 0.5s 0.5s ease both;
        }

        h1 {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.3;
            animation: fade-up 0.5s 0.6s ease both;
        }
        h1 span { color: var(--green); }

        .subtitle {
            font-size: 14.5px;
            color: rgba(255,255,255,0.5);
            margin-top: 10px;
            line-height: 1.7;
            animation: fade-up 0.5s 0.7s ease both;
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── Divider ─────────────────────────────────────── */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
            margin: 32px 0;
            animation: fade-up 0.5s 0.8s ease both;
        }

        /* ─── Timer Bar ───────────────────────────────────── */
        .timer-section { animation: fade-up 0.5s 0.9s ease both; }

        .timer-label {
            font-size: 12.5px;
            color: rgba(255,255,255,0.35);
            margin-bottom: 10px;
        }
        .timer-label strong { color: rgba(255,255,255,0.7); }

        .progress-track {
            height: 6px;
            background: rgba(255,255,255,0.08);
            border-radius: 100px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .progress-fill {
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, var(--green), #86efac);
            border-radius: 100px;
            animation: drain 5s linear forwards;
        }
        @keyframes drain {
            from { width: 100%; }
            to   { width: 0%; }
        }

        .countdown-text {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }
        .countdown-text span { color: rgba(255,255,255,0.7); font-weight: 700; }

        /* ─── Manual Link ─────────────────────────────────── */
        .manual-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 24px;
            padding: 11px 24px;
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
            animation: fade-up 0.5s 1s ease both;
        }
        .manual-link:hover {
            background: rgba(255,255,255,0.06);
            color: white;
            border-color: rgba(255,255,255,0.22);
        }

        /* ─── Footer ──────────────────────────────────────── */
        .footer-text {
            margin-top: 32px;
            font-size: 11px;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.05em;
            animation: fade-up 0.5s 1.1s ease both;
        }

        .luber-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            margin-top: 20px;
            animation: fade-up 0.5s 1.05s ease both;
        }
        .luber-badge svg { width: 15px; height: 15px; fill: rgba(255,255,255,0.25); }
    </style>
</head>
<body>

    {{-- Background glows --}}
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    {{-- Confetti --}}
    <div class="confetti-container" id="confetti"></div>

    <div class="card">

        {{-- Success Icon --}}
        <div class="success-ring">
            <svg class="ring-svg" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="46" fill="none" stroke="rgba(34,197,94,0.2)" stroke-width="4"/>
                <circle cx="50" cy="50" r="46" fill="none" stroke="#22c55e" stroke-width="4"
                    stroke-dasharray="289" stroke-dashoffset="289"
                    style="transform-origin:center;animation:draw-circle 1s ease-out forwards">
                </circle>
            </svg>
            <div class="success-inner">
                <svg viewBox="0 0 24 24"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
            </div>
        </div>

        <style>
            @keyframes draw-circle {
                to { stroke-dashoffset: 0; }
            }
        </style>

        <div class="badge">&#10003; Suara Berhasil Dikirim</div>

        <h1>Terima Kasih!<br>Suara Anda <span>Telah Tercatat</span></h1>
        <p class="subtitle">Partisipasi Anda sangat berarti bagi masa depan<br>Paskibra SMKN 6 Jember. Pilihan Anda bersifat rahasia.</p>

        <div class="divider"></div>

        {{-- Countdown --}}
        <div class="timer-section">
            <p class="timer-label">Anda akan diarahkan kembali ke halaman utama dalam <strong id="countdown-secs">5</strong> detik.</p>
            <div class="progress-track">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            <p class="countdown-text">Atau klik tombol di bawah jika tidak ingin menunggu.</p>
        </div>

        <a href="{{ route('voting.index') }}" class="manual-link" id="back-link">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Halaman Utama
        </a>

        <div class="luber-badge">
            <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            LUBER JURDIL — Langsung · Umum · Bebas · Rahasia · Jujur · Adil
        </div>

        <p class="footer-text">SMK Negeri 6 Jember &bull; Sistem E-Voting Paskibra &bull; {{ date('Y') }}</p>
    </div>

    <script>
        // ─── Countdown ────────────────────────────────────────
        let secs = 5;
        const secsEl = document.getElementById('countdown-secs');

        const interval = setInterval(function () {
            secs--;
            if (secsEl) { secsEl.textContent = secs; }
            if (secs <= 0) {
                clearInterval(interval);
                window.location.href = '{{ route('voting.index') }}';
            }
        }, 1000);

        // ─── Confetti ─────────────────────────────────────────
        (function spawnConfetti() {
            const container = document.getElementById('confetti');
            const colors = ['#c0152a','#22c55e','#ffffff','#fbbf24','#60a5fa','#f0abfc'];
            for (let i = 0; i < 60; i++) {
                const dot = document.createElement('div');
                dot.className = 'confetti-dot';
                const size = Math.random() * 8 + 4;
                dot.style.cssText = `
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * -20}%;
                    width: ${size}px;
                    height: ${size}px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    animation-duration: ${Math.random() * 4 + 3}s;
                    animation-delay: ${Math.random() * 3}s;
                    opacity: ${Math.random() * 0.6 + 0.4};
                    border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
                `;
                container.appendChild(dot);
            }
        })();
    </script>
</body>
</html>
