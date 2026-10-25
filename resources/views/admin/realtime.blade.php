<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Live Quick Count Perolehan Suara E-Voting Paskibra SMKN 6 Jember">
    <title>Live Quick Count — E-Voting Paskibra SMKN 6 Jember</title>

    {{-- Offline Local Fonts & Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    @php
    // ── SISTEM SLIDESHOW FOTO LATAR BELAKANG (JPG / PNG) ──
    $bgSlides = [];

    // Prioritas 1: Foto terpisah per kandidat di public/images/candidates/kandidat-1.jpg, .png, dst
    foreach (range(1, 4) as $num) {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $p = "images/candidates/kandidat-{$num}.{$ext}";
            if (file_exists(public_path($p))) {
                $bgSlides[] = asset($p);
                break;
            }
        }
    }

    // Prioritas 2: File bg-realtime-1.jpg, bg-realtime-2.jpg, dst di public/images/
    if (empty($bgSlides)) {
        foreach (range(1, 4) as $num) {
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                $p = "images/bg-realtime-{$num}.{$ext}";
                if (file_exists(public_path($p))) {
                    $bgSlides[] = asset($p);
                    break;
                }
            }
        }
    }

    // Prioritas 3: Foto kandidat dari database (jika diupload via admin)
    if (empty($bgSlides)) {
        foreach ($candidates as $c) {
            if ($c->photo_url) {
                $bgSlides[] = $c->photo_url;
            }
        }
    }

    // Prioritas 4: Satu file background umum (misal: bg-realtime.jpg yang sudah ada)
    if (empty($bgSlides)) {
        $bgFiles = glob(public_path('images/bg-realtime*'));
        if (!empty($bgFiles)) {
            foreach ($bgFiles as $bf) {
                $ext = strtolower(pathinfo($bf, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $bgSlides[] = asset('images/' . basename($bf));
                    break;
                }
            }
        }
    }
    @endphp

    <style>
        :root {
            --navy-deep: #050811;
            --navy-base: #0B1120;
            --navy-card: rgba(15, 23, 42, 0.78);
            --navy-card-border: rgba(255, 255, 255, 0.12);
            --emerald: #10B981;
            --blue: #3B82F6;
            --amber: #F59E0B;
            --rose: #F43F5E;
            --purple: #8B5CF6;
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
            overflow-x: hidden;
            position: relative;
        }

        /* ── BACKGROUND SLIDESHOW LAYER (JPG/PNG dengan Blur & Anti-Kontras) ── */
        .bg-slide-wrapper {
            position: fixed;
            top: -40px;
            left: -40px;
            right: -40px;
            bottom: -40px;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
            filter: blur(8px) brightness(0.46);
            transform: scale(1.06);
            background: radial-gradient(circle at 50% 10%, #1e293b 0%, #0b1120 60%, #030712 100%);
        }

        .bg-slide-item {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            will-change: opacity;
        }

        .bg-slide-item.active {
            opacity: 1;
        }

        /* Lapisan peneduh anti-kontras agar teks dan bar tetap terbaca tajam dan nyaman di mata */
        .bg-slide-overlay-tint {
            position: fixed;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 8, 17, 0.60) 0%, rgba(5, 8, 17, 0.72) 50%, rgba(5, 8, 17, 0.84) 100%);
            z-index: 1;
            pointer-events: none;
        }

        /* Overlay tekstur garis halus khas proyektor panggung */
        .bg-grid-overlay {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 28px 28px;
            z-index: 1;
            pointer-events: none;
        }

        .screen-container {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px 20px 40px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* ── TOP HEADER SCREEN ── */
        .live-header {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--navy-card-border);
            border-radius: 20px;
            padding: 16px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-logo i {
            font-size: 26px;
            color: var(--emerald);
        }

        .header-title-box h1 {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.01em;
            margin-bottom: 2px;
        }

        .header-title-box p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 500;
        }

        /* Header Badges & Actions */
        .header-stats-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #FCA5A5;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 100px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background-color: #EF4444;
            border-radius: 50%;
            box-shadow: 0 0 10px #EF4444;
            animation: pulse-dot 1.4s ease infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(1.3);
            }
        }

        .clock-badge {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #E2E8F0;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #FFFFFF;
            padding: 8px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #FFFFFF;
            transform: translateY(-1px);
        }

        /* ── SUMMARY STAT CARDS (Atas Bar) ── */
        .summary-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card-live {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--navy-card-border);
            border-radius: 18px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 24px -6px rgba(0, 0, 0, 0.4);
            transition: transform 0.2s;
        }

        .stat-card-live:hover {
            transform: translateY(-2px);
        }

        .stat-card-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .stat-card-val {
            font-size: 26px;
            font-weight: 900;
            color: #FFFFFF;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* ── CANDIDATE CARDS & BARS (Megah & Clean) ── */
        .candidates-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 28px;
        }

        .candidate-row-card {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1.5px solid var(--navy-card-border);
            border-radius: 22px;
            padding: 20px 24px;
            box-shadow: 0 14px 34px -10px rgba(0, 0, 0, 0.55);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .candidate-row-card.is-leading {
            border-color: rgba(245, 158, 11, 0.6);
            box-shadow: 0 16px 38px -10px rgba(245, 158, 11, 0.25), 0 0 0 1px rgba(245, 158, 11, 0.3);
        }

        /* Leading Ribbon */
        .leading-ribbon {
            position: absolute;
            top: 14px;
            right: 20px;
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .candidate-content {
            display: grid;
            grid-template-columns: 80px 1fr auto;
            align-items: center;
            gap: 24px;
        }

        @media (max-width: 768px) {
            .candidate-content {
                grid-template-columns: 60px 1fr;
            }

            .candidate-stat-right {
                grid-column: 1 / -1;
                text-align: left !important;
                display: flex;
                align-items: baseline;
                gap: 12px;
                margin-top: 4px;
            }
        }

        /* Avatar & Number */
        .candidate-avatar-wrap {
            position: relative;
            width: 80px;
            height: 98px;
            border-radius: 16px;
            background: #1E293B;
            border: 2px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 768px) {
            .candidate-avatar-wrap {
                width: 60px;
                height: 74px;
            }
        }

        .candidate-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-avatar-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            font-size: 34px;
        }

        .candidate-num-badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
            padding: 3px 0;
            letter-spacing: 0.05em;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Bar & Names */
        .candidate-bar-area {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .candidate-title-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            flex-wrap: wrap;
        }

        .candidate-name {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .candidate-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Progress Bar Track */
        .bar-track {
            width: 100%;
            height: 28px;
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 100px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.4);
        }

        .bar-fill {
            height: 100%;
            border-radius: 100px;
            transition: width 0.9s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            min-width: 6px;
        }

        /* Pilihan Warna Mewah tiap Paslon */
        .bar-color-1 {
            background: linear-gradient(90deg, #E11D48, #F43F5E);
            box-shadow: 0 0 16px rgba(244, 63, 94, 0.4);
        }

        .bar-color-2 {
            background: linear-gradient(90deg, #059669, #10B981);
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.4);
        }

        .bar-color-3 {
            background: linear-gradient(90deg, #2563EB, #3B82F6);
            box-shadow: 0 0 16px rgba(59, 130, 246, 0.4);
        }

        .bar-color-4 {
            background: linear-gradient(90deg, #D97706, #F59E0B);
            box-shadow: 0 0 16px rgba(245, 158, 11, 0.4);
        }

        /* Stat Right Side */
        .candidate-stat-right {
            text-align: right;
            min-width: 140px;
        }

        .percentage-num {
            font-size: 38px;
            font-weight: 900;
            color: #FFFFFF;
            line-height: 1;
            letter-spacing: -0.03em;
        }

        .votes-num {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 700;
            margin-top: 4px;
            letter-spacing: 0.02em;
        }

        .votes-num strong {
            color: #FFFFFF;
            font-size: 15px;
        }

        /* ── FOOTER BAR & HELPER ── */
        .live-footer {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid var(--navy-card-border);
            border-radius: 16px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .bg-hint-box {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            color: #CBD5E1;
        }

        .bg-hint-box code {
            color: var(--emerald);
            background: rgba(16, 185, 129, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    {{-- ════ BACKGROUND SLIDESHOW LAYER (JPG/PNG) ════ --}}
    <div class="bg-slide-wrapper" id="bgSlideWrapper">
        <div id="bgSlideA" class="bg-slide-item active" @if (!empty($bgSlides)) style="background-image: url('{{ $bgSlides[0] }}');" @endif></div>
        <div id="bgSlideB" class="bg-slide-item"></div>
    </div>
    <div class="bg-slide-overlay-tint"></div>
    <div class="bg-grid-overlay"></div>

    <div class="screen-container">

        {{-- ════ TOP HEADER SCREEN ════ --}}
        <header class="live-header">
            <div class="header-brand">
                <div class="header-logo">
                    @if (file_exists(public_path('images/logo-paskibra.png')))
                    <img src="{{ asset('images/logo-paskibra.png') }}" alt="Logo Paskibra">
                    @else
                    <i class="bi bi-shield-fill-check"></i>
                    @endif
                </div>
                <div class="header-title-box">
                    <h1>HASIL PEROLEHAN SUARA (QUICK COUNT)</h1>
                    <p>Pemilihan Ketua Umum &amp; Wakil Ketua Umum Paskibra SMKN 6 Jember</p>
                </div>
            </div>

            <div class="header-stats-wrap">
                <div class="live-pill">
                    <span class="live-dot"></span>
                    <span>Live Real-Time</span>
                </div>

                <div class="clock-badge">
                    <i class="bi bi-clock-fill" style="color:var(--emerald)"></i>
                    <span id="liveClock">--:--:-- WIB</span>
                </div>

                <button type="button" class="header-btn" id="btnFullscreen" title="Tampilkan Layar Penuh (F11)">
                    <i class="bi bi-fullscreen" id="fullscreenIcon"></i>
                    <span id="fullscreenText">Fullscreen</span>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="header-btn" title="Kembali ke Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </header>

        {{-- ════ SUMMARY STATS ════ --}}
        <section class="summary-row">
            {{-- Total Suara Masuk --}}
            <div class="stat-card-live">
                <div>
                    <div class="stat-card-label">Total Suara Masuk</div>
                    <div class="stat-card-val" id="totalVotesVal">{{ $totalVotes }}</div>
                </div>
                <div class="stat-card-icon" style="background:rgba(16, 185, 129, 0.15);color:var(--emerald)">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>

            {{-- Partisipasi Pemilih --}}
            <div class="stat-card-live">
                <div>
                    <div class="stat-card-label">Partisipasi Pemilih</div>
                    <div class="stat-card-val" id="participationRateVal">{{ $participationRate }}%</div>
                </div>
                <div class="stat-card-icon" style="background:rgba(59, 130, 246, 0.15);color:var(--blue)">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
            </div>

            {{-- Belum Memilih --}}
            <div class="stat-card-live">
                <div>
                    <div class="stat-card-label">Belum Memilih</div>
                    <div class="stat-card-val" id="totalNotVotedVal">{{ $totalNotVoted }}</div>
                </div>
                <div class="stat-card-icon" style="background:rgba(245, 158, 11, 0.15);color:var(--amber)">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>

            {{-- Total DPT (Hak Pilih) --}}
            <div class="stat-card-live">
                <div>
                    <div class="stat-card-label">Total Pemilih (DPT)</div>
                    <div class="stat-card-val" id="totalVotersVal">{{ $totalVoters }}</div>
                </div>
                <div class="stat-card-icon" style="background:rgba(139, 92, 246, 0.15);color:var(--purple)">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </section>

        {{-- ════ 4 CANDIDATE SCOREBOARD BARS ════ --}}
        <main class="candidates-list" id="candidatesContainer">
            @php
            // Cari suara terbanyak untuk badge unggul sementara
            $maxVotes = $candidates->max('votes_count') ?? 0;
            $barColors = ['bar-color-1', 'bar-color-2', 'bar-color-3', 'bar-color-4'];
            @endphp

            @forelse ($candidates as $index => $candidate)
            @php
            $pct = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0;
            $isLeading = $maxVotes > 0 && $candidate->votes_count === $maxVotes;
            $colorClass = $barColors[$index % count($barColors)];
            @endphp

            <article class="candidate-row-card {{ $isLeading ? 'is-leading' : '' }}" id="candidate-card-{{ $candidate->id }}">
                {{-- Leading Ribbon --}}
                @if ($isLeading)
                <div class="leading-ribbon" id="ribbon-{{ $candidate->id }}">
                    <i class="bi bi-trophy-fill"></i> Unggul Sementara
                </div>
                @else
                <div class="leading-ribbon d-none" id="ribbon-{{ $candidate->id }}">
                    <i class="bi bi-trophy-fill"></i> Unggul Sementara
                </div>
                @endif

                <div class="candidate-content">
                    {{-- Foto & Nomor Urut --}}
                    <div class="candidate-avatar-wrap">
                        @if ($candidate->photo_url)
                        <img src="{{ $candidate->photo_url }}" alt="Foto {{ $candidate->leader_name }}" id="photo-{{ $candidate->id }}">
                        @else
                        <div class="candidate-avatar-fallback">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        @endif
                        <div class="candidate-num-badge">NO. {{ $candidate->paslon_number }}</div>
                    </div>

                    {{-- Bar Perolehan Suara --}}
                    <div class="candidate-bar-area">
                        <div class="candidate-title-row">
                            <h2 class="candidate-name" id="name-{{ $candidate->id }}">{{ $candidate->leader_name }}</h2>
                            <span class="candidate-subtitle">Kandidat {{ $candidate->paslon_number }}</span>
                        </div>

                        <div class="bar-track">
                            <div class="bar-fill {{ $colorClass }}"
                                id="bar-{{ $candidate->id }}"
                                style="width: {{ max($pct, 1.5) }}%"
                                data-percentage="{{ $pct }}">
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Angka Persentase & Suara --}}
                    <div class="candidate-stat-right">
                        <div class="percentage-num" id="pct-{{ $candidate->id }}">{{ $pct }}%</div>
                        <div class="votes-num">
                            <strong id="votes-{{ $candidate->id }}">{{ $candidate->votes_count }}</strong> suara
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="text-center py-5">
                <p class="text-muted">Belum ada kandidat yang terdaftar.</p>
            </div>
            @endforelse
        </main>

        {{-- ════ FOOTER ════ --}}
        <footer class="live-footer">
            <div>
                &copy; {{ date('Y') }} <strong>Rizqi Arif Ardiansyah</strong> &bull; E-Voting Paskibra SMK Negeri 6 Jember
            </div>

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-arrow-repeat text-success"></i>
                <span>Sinkronisasi Otomatis Setiap 3 Detik</span>
            </div>
        </footer>

    </div>

    {{-- ════ SCRIPT: Real-Time Polling, Slideshow Fade & Clock ════ --}}
    <script>
        // ── SLIDESHOW FOTO KANDIDAT BERGANTIAN DENGAN EFEK FADE (JPG / PNG) ──
        const bgSlides = @json($bgSlides);
        if (bgSlides && bgSlides.length > 1) {
            const slideA = document.getElementById('bgSlideA');
            const slideB = document.getElementById('bgSlideB');

            if (slideA && slideB) {
                let currentSlideIdx = 0;
                let activeSlide = slideA;
                let standbySlide = slideB;

                // Ganti foto setiap 6 detik dengan transisi cross-fade 2 detik
                setInterval(function() {
                    currentSlideIdx = (currentSlideIdx + 1) % bgSlides.length;
                    const nextImgUrl = bgSlides[currentSlideIdx];

                    // Pasang foto baru pada standby layer
                    standbySlide.style.backgroundImage = "url('" + nextImgUrl + "')";

                    // Fade in standby, fade out active
                    standbySlide.classList.add('active');
                    activeSlide.classList.remove('active');

                    // Tukar peran layer
                    const temp = activeSlide;
                    activeSlide = standbySlide;
                    standbySlide = temp;
                }, 6000);
            }
        }

        // ── JAM DIGITAL WIB ──
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour12: false
            }) + ' WIB';
            document.getElementById('liveClock').textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // ── FULLSCREEN TOGGLE (Cross-Browser Supported) ──
        const btnFullscreen = document.getElementById('btnFullscreen');
        const fullscreenIcon = document.getElementById('fullscreenIcon');
        const fullscreenText = document.getElementById('fullscreenText');

        function isFullscreenActive() {
            return !!(
                document.fullscreenElement ||
                document.webkitFullscreenElement ||
                document.mozFullScreenElement ||
                document.msFullscreenElement
            );
        }

        function updateFullscreenUI() {
            const isFull = isFullscreenActive();
            if (fullscreenIcon) {
                if (isFull) {
                    fullscreenIcon.classList.remove('bi-fullscreen');
                    fullscreenIcon.classList.add('bi-fullscreen-exit');
                } else {
                    fullscreenIcon.classList.remove('bi-fullscreen-exit');
                    fullscreenIcon.classList.add('bi-fullscreen');
                }
            }
            if (fullscreenText) {
                fullscreenText.textContent = isFull ? 'Keluar Fullscreen' : 'Fullscreen';
            }
        }

        function toggleFullscreen() {
            const docEl = document.documentElement;

            if (!isFullscreenActive()) {
                // Masuk Layar Penuh (Dukungan W3C, WebKit, Gecko, Trident)
                const requestMethod = docEl.requestFullscreen ||
                    docEl.webkitRequestFullscreen ||
                    docEl.mozRequestFullScreen ||
                    docEl.msRequestFullscreen;

                if (requestMethod) {
                    try {
                        const res = requestMethod.call(docEl);
                        if (res && typeof res.then === 'function') {
                            res.then(updateFullscreenUI).catch(function(err) {
                                console.warn('Request fullscreen dicegah oleh browser:', err);
                            });
                        }
                    } catch (e) {
                        console.warn('Fullscreen call error:', e);
                    }
                }
            } else {
                // Keluar Layar Penuh
                const exitMethod = document.exitFullscreen ||
                    document.webkitExitFullscreen ||
                    document.mozCancelFullScreen ||
                    document.msExitFullscreen;

                if (exitMethod) {
                    try {
                        const res = exitMethod.call(document);
                        if (res && typeof res.then === 'function') {
                            res.then(updateFullscreenUI).catch(function(err) {
                                console.warn('Exit fullscreen dicegah oleh browser:', err);
                            });
                        }
                    } catch (e) {
                        console.warn('Exit fullscreen error:', e);
                    }
                }
            }
        }

        if (btnFullscreen) {
            btnFullscreen.addEventListener('click', function(e) {
                e.preventDefault();
                toggleFullscreen();
            });
        }

        // Event listener saat fullscreen berubah (baik via tombol, tombol ESC, maupun F11)
        ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(function(evt) {
            document.addEventListener(evt, updateFullscreenUI);
        });

        // ── POLLING DATA REAL-TIME TANPA RELOAD HALAMAN (Setiap 3 Detik) ──
        async function fetchRealtimeData() {
            try {
                const response = await fetch("{{ route('admin.realtime.data') }}", {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) return;

                const data = await response.json();

                // Update summary stats
                document.getElementById('totalVotesVal').textContent = data.total_votes;
                document.getElementById('participationRateVal').textContent = data.participation_rate + '%';
                document.getElementById('totalNotVotedVal').textContent = data.total_not_voted;
                document.getElementById('totalVotersVal').textContent = data.total_voters;

                // Hitung suara tertinggi untuk leading ribbon
                let maxVotes = 0;
                data.candidates.forEach(c => {
                    if (c.votes_count > maxVotes) maxVotes = c.votes_count;
                });

                // Update setiap kandidat
                data.candidates.forEach(c => {
                    const bar = document.getElementById('bar-' + c.id);
                    const pctEl = document.getElementById('pct-' + c.id);
                    const votesEl = document.getElementById('votes-' + c.id);
                    const nameEl = document.getElementById('name-' + c.id);
                    const card = document.getElementById('candidate-card-' + c.id);
                    const ribbon = document.getElementById('ribbon-' + c.id);

                    if (nameEl) nameEl.textContent = c.leader_name;
                    if (votesEl) votesEl.textContent = c.votes_count;
                    if (pctEl) pctEl.textContent = c.percentage + '%';

                    if (bar) {
                        bar.style.width = Math.max(c.percentage, 1.5) + '%';
                        bar.setAttribute('data-percentage', c.percentage);
                    }

                    // Status leading
                    const isLeading = maxVotes > 0 && c.votes_count === maxVotes;
                    if (card) {
                        card.classList.toggle('is-leading', isLeading);
                    }
                    if (ribbon) {
                        ribbon.classList.toggle('d-none', !isLeading);
                    }
                });

            } catch (err) {
                console.warn('Gagal menyinkronkan data perolehan suara:', err);
            }
        }

        // Jalankan polling setiap 3 detik
        setInterval(fetchRealtimeData, 3000);
    </script>

</body>

</html>