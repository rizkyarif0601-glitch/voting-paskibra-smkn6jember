<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Token — E-Voting Paskibra SMKN 6 Jember</title>
    {{-- Offline Local Fonts --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">

    <style>
        /* ═══════════════════════════════════════════
           SCREEN STYLES (preview sebelum print)
        ═══════════════════════════════════════════ */
        :root {
            --navy:    #0F172A;
            --emerald: #10B981;
            --gold:    #F59E0B;
            --border:  #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            color: var(--navy);
        }

        /* ── Print Toolbar (hanya tampil di layar) ──────────── */
        .print-toolbar {
            background: var(--navy);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
        }

        .toolbar-left .title { font-size: 15px; font-weight: 800; }
        .toolbar-left .sub   { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 2px; }

        .toolbar-right { display: flex; gap: 10px; }

        .btn-toolbar {
            border: none;
            border-radius: 10px;
            padding: 9px 18px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-toolbar:hover { opacity: 0.85; }

        .btn-print  { background: var(--emerald); color: #fff; }
        .btn-back   { background: rgba(255,255,255,0.1); color: #fff; }

        /* ── A4 Page Preview ──────────────────────────────── */
        .page-container {
            max-width: 800px;
            margin: 24px auto;
            padding: 0 16px 40px;
        }

        .a4-page {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.12);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        /* ── Page Header (Kop Surat) ─────────────────────── */
        .kop-surat {
            border-bottom: 3px solid var(--navy);
            padding-bottom: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .kop-logo {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 2px solid var(--navy);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #f8fafc;
        }

        .kop-logo img { width: 100%; height: 100%; object-fit: cover; }
        .kop-logo .logo-icon { font-size: 28px; color: var(--navy); }

        .kop-text { flex: 1; text-align: center; }
        .kop-text .school { font-size: 17px; font-weight: 900; letter-spacing: 0.02em; text-transform: uppercase; }
        .kop-text .event  { font-size: 13px; font-weight: 700; margin-top: 2px; }
        .kop-text .address { font-size: 10.5px; color: #64748b; margin-top: 3px; }

        .print-meta {
            text-align: center;
            font-size: 11.5px;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* ── Token Grid ──────────────────────────────────── */
        .token-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .token-ticket {
            border: 1.5px dashed #94a3b8;
            border-radius: 8px;
            padding: 10px 8px;
            text-align: center;
            background: #fafafa;
            position: relative;
            page-break-inside: avoid;
        }

        .ticket-header {
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 5px;
        }

        .ticket-event {
            font-size: 7px;
            color: #cbd5e1;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .ticket-divider {
            border: none;
            border-top: 1px dashed #e2e8f0;
            margin: 6px 0;
        }

        .ticket-token {
            font-family: 'Courier Prime', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: 0.2em;
            display: block;
            margin: 4px 0;
        }

        .ticket-footer {
            font-size: 7px;
            color: #94a3b8;
            margin-top: 5px;
            line-height: 1.4;
        }

        .ticket-number {
            position: absolute;
            top: 5px;
            right: 6px;
            font-size: 7px;
            color: #cbd5e1;
            font-weight: 700;
        }

        /* ── Empty State ─────────────────────────────────── */
        .empty-print {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-print .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-print h4 { font-weight: 700; color: var(--navy); }

        /* ── Screen info panels ──────────────────────────── */
        .screen-info {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
        }

        .screen-info .icon-wrap {
            width: 38px; height: 38px;
            background: #d1fae5;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--emerald);
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════
           PRINT STYLES
        ═══════════════════════════════════════════ */
        @media print {
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

            body { background: #fff; }

            .print-toolbar,
            .screen-info,
            .page-container > *:not(.a4-page) { display: none !important; }

            .page-container { margin: 0; padding: 0; max-width: 100%; }

            .a4-page {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                padding: 20mm 18mm;
                page-break-after: always;
            }

            .a4-page:last-child { page-break-after: auto; }

            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    {{-- ── Print Toolbar (screen only) ───────────────────────── --}}
    <div class="print-toolbar">
        <div class="toolbar-left">
            <div>
                <div class="title">&#x1F4C4; Cetak Token Pemilih</div>
                <div class="sub">Total {{ $voters->count() }} token belum digunakan siap cetak</div>
            </div>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('admin.dashboard') }}" class="btn-toolbar btn-back">
                &#8592; Kembali
            </a>
            <button onclick="window.print()" class="btn-toolbar btn-print">
                &#x1F5A8; Cetak Sekarang
            </button>
        </div>
    </div>

    <div class="page-container">

        @if ($voters->isEmpty())
            {{-- Empty state --}}
            <div class="a4-page">
                <div class="empty-print">
                    <div class="icon">&#x1F511;</div>
                    <h4>Tidak ada token untuk dicetak</h4>
                    <p style="margin-top:8px;font-size:13px">Semua token sudah digunakan, atau belum ada token yang digenerate.</p>
                </div>
            </div>
        @else
            {{-- Info panel (screen only) --}}
            <div class="screen-info">
                <div class="icon-wrap">&#x2139;</div>
                <div>
                    <strong>Petunjuk:</strong> Setiap halaman memuat <strong>40 token</strong> dalam susunan 4 kolom × 10 baris.
                    Gunakan gunting untuk memotong antar token sesuai garis putus-putus.
                    Token yang sudah digunakan tidak ditampilkan di sini.
                </div>
            </div>

            @php
                // Kelompokkan per 40 token = 1 halaman A4
                $chunks = $voters->chunk(40);
                $pageNumber = 1;
            @endphp

            @foreach ($chunks as $chunk)
                <div class="a4-page">

                    {{-- Kop Surat --}}
                    <div class="kop-surat">
                        <div class="kop-logo">
                            @if (file_exists(public_path('images/logo-paskibra.png')))
                                <img src="{{ asset('images/logo-paskibra.png') }}" alt="Logo">
                            @else
                                <span class="logo-icon">&#127988;</span>
                            @endif
                        </div>
                        <div class="kop-text">
                            <div class="school">SMK Negeri 6 Jember</div>
                            <div class="event">Pemilihan Ketua Umum Paskibra</div>
                            <div class="address">Halaman {{ $pageNumber }} dari {{ $chunks->count() }} &bull; Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
                        </div>
                    </div>

                    {{-- Token Grid --}}
                    <div class="token-grid">
                        @foreach ($chunk as $index => $voter)
                            <div class="token-ticket">
                                <span class="ticket-number">#{{ $voter->id }}</span>
                                <div class="ticket-header">&#x1F511; Token Pemilih</div>
                                <div class="ticket-event">Paskibra SMKN 6 Jember<br>{{ date('Y') }}</div>
                                <hr class="ticket-divider">
                                <span class="ticket-token">{{ $voter->token }}</span>
                                <hr class="ticket-divider">
                                <div class="ticket-footer">
                                    Masukkan token ini di<br>
                                    <strong>{{ url('/voting') }}</strong><br>
                                    Satu token = satu suara. Rahasia.
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                @php $pageNumber++; @endphp
            @endforeach

        @endif

    </div>

    <script>
        // Auto-trigger print dialog jika ada query ?autoprint=1
        if (new URLSearchParams(window.location.search).get('autoprint') === '1') {
            window.addEventListener('load', () => window.print());
        }
    </script>
</body>
</html>
