<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Surat Suara E-Voting Pemilihan Ketua Umum Paskibra SMKN 6 Jember">
    <title>Surat Suara — E-Voting Paskibra SMKN 6 Jember</title>

    {{-- Offline Local Fonts & Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    <style>
        /* ═══════════════════════════════════════════════════════
           BASE & TYPOGRAPHY
        ═══════════════════════════════════════════════════════ */
        :root {
            --navy: #0F172A;
            --navy-mid: #1E293B;
            --navy-light: #334155;
            --emerald: #10B981;
            --emerald-dk: #059669;
            --emerald-lt: #d1fae5;
            --gold: #c40f0fff;
            --surface: #F8FAFC;
            --border: #E2E8F0;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            --card-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
            --card-hover: 0 16px 48px rgba(15, 23, 42, 0.16);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* ═══════════════════════════════════════════════════════
           HEADER / NAVBAR
        ═══════════════════════════════════════════════════════ */
        .site-header {
            background: var(--navy);
            border-bottom: 3px solid var(--emerald);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 0;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        /* Logo placeholder — ganti dengan <img> setelah logo tersedia */
        .logo-wrap {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--gold);
            background: var(--navy-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Jika logo sudah ada di public/images/logo-paskibra.png, ganti div ini dengan img */
        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Fallback icon saat logo belum ada */
        .logo-fallback {
            color: var(--gold);
            font-size: 24px;
            line-height: 1;
        }

        .header-titles {
            line-height: 1.3;
        }

        .header-titles .school-name {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gold);
            display: block;
        }

        .header-titles .event-name {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            display: block;
        }

        @media (max-width: 575px) {
            .header-titles .event-name {
                font-size: 13px;
            }

            .header-titles .school-name {
                font-size: 10px;
            }
        }

        .header-badge {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: var(--emerald);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            padding: 5px 12px;
            border-radius: 100px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════════════════
           INSTRUCTION BANNER
        ═══════════════════════════════════════════════════════ */
        .instruction-bar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }

        .instruction-bar .inner {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .instruction-bar .inner i {
            color: var(--emerald);
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════════════════
           SECTION TITLE
        ═══════════════════════════════════════════════════════ */
        .section-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--emerald);
        }

        .section-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.3;
        }

        @media (max-width: 575px) {
            .section-title {
                font-size: 20px;
            }
        }

        /* ═══════════════════════════════════════════════════════
           CANDIDATE CARD
        ═══════════════════════════════════════════════════════ */
        .candidate-card {
            border: 2px solid var(--border);
            border-radius: 20px;
            background: #fff;
            box-shadow: var(--card-shadow);
            transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.28s ease,
                border-color 0.25s ease;
            height: 100%;
            overflow: hidden;
            cursor: default;
        }

        .candidate-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-hover);
            border-color: #c7d2fe;
        }

        .candidate-card.selected {
            border-color: var(--emerald);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15), var(--card-hover);
        }

        /* ── Photo area ──────────────────────────────────────── */
        .photo-wrapper {
            position: relative;
            padding: 20px 20px 0;
        }

        .photo-frame {
            position: relative;
            width: 100%;
            padding-bottom: 133%;
            /* rasio 3:4 */
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(160deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .photo-frame img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform 0.4s ease;
        }

        .candidate-card:hover .photo-frame img {
            transform: scale(1.04);
        }

        .photo-placeholder-inner {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #94a3b8;
        }

        .photo-placeholder-inner i {
            font-size: 48px;
        }

        .photo-placeholder-inner span {
            font-size: 12px;
            font-weight: 500;
        }

        /* ── Number Badge ────────────────────────────────────── */
        .paslon-badge {
            position: absolute;
            top: 28px;
            left: 28px;
            background: var(--navy);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 8px;
            line-height: 1.4;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.4);
        }

        .paslon-badge .number {
            display: block;
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
            color: var(--gold);
        }

        /* ── Card Body ───────────────────────────────────────── */
        .card-body-custom {
            padding: 18px 20px 20px;
        }

        .paslon-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--emerald);
            margin-bottom: 10px;
        }

        .name-block {
            margin-bottom: 14px;
        }

        .name-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 5px;
        }

        .name-role {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-light);
            min-width: 52px;
            flex-shrink: 0;
        }

        .name-val {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.3;
        }

        .divider-thin {
            border: none;
            border-top: 1px solid var(--border);
            margin: 14px 0;
        }

        .vision-preview {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.65;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 16px;
        }

        /* ── Card Buttons ────────────────────────────────────── */
        .btn-visi {
            border: 1.5px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 14px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-visi:hover {
            border-color: var(--navy-light);
            background: #f1f5f9;
            color: var(--navy);
        }

        .btn-pilih {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dk) 100%);
            border: none;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.04em;
            border-radius: 10px;
            padding: 9px 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
            flex: 1;
        }

        .btn-pilih:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.45);
            color: #fff;
        }

        .btn-pilih:active {
            transform: translateY(0);
        }

        /* ═══════════════════════════════════════════════════════
           MODAL — VISI MISI
        ═══════════════════════════════════════════════════════ */
        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .modal-header-custom {
            background: var(--navy);
            padding: 20px 24px;
            border: none;
        }

        .modal-header-custom .modal-title {
            color: #fff;
            font-size: 16px;
            font-weight: 800;
        }

        .modal-header-custom .btn-close {
            filter: invert(1) grayscale(1) brightness(2);
            opacity: 0.7;
        }

        .modal-header-custom .paslon-sub {
            font-size: 12px;
            color: var(--gold);
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .modal-body-custom {
            padding: 24px;
        }

        .vm-section-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--emerald);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .vm-section-title i {
            font-size: 14px;
        }

        .vm-content {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.75;
            color: var(--text-main);
            white-space: pre-line;
        }

        /* ═══════════════════════════════════════════════════════
           MODAL — KONFIRMASI PILIHAN
        ═══════════════════════════════════════════════════════ */
        .confirm-modal .modal-content {
            border-radius: 24px;
        }

        .confirm-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--emerald-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .confirm-icon-wrap i {
            font-size: 36px;
            color: var(--emerald-dk);
        }

        .confirm-paslon-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1.5px solid #86efac;
            border-radius: 14px;
            padding: 16px 20px;
            margin: 20px 0;
            text-align: left;
        }

        .confirm-paslon-box .number-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--emerald-dk);
            margin-bottom: 4px;
        }

        .confirm-paslon-box .names {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.4;
        }

        .confirm-warning {
            font-size: 12.5px;
            color: #b45309;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .confirm-warning i {
            flex-shrink: 0;
            margin-top: 1px;
        }

        .btn-batal {
            border: 1.5px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            padding: 11px 20px;
            transition: all 0.2s;
        }

        .btn-batal:hover {
            background: #f1f5f9;
            border-color: var(--navy-light);
            color: var(--navy);
        }

        .btn-konfirmasi {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dk) 100%);
            border: none;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 800;
            border-radius: 12px;
            padding: 11px 24px;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
            transition: transform 0.2s, box-shadow 0.2s;
            flex: 1;
        }

        .btn-konfirmasi:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5);
            color: #fff;
        }

        /* ═══════════════════════════════════════════════════════
           LUBER JURDIL FOOTER STRIP
        ═══════════════════════════════════════════════════════ */
        .footer-strip {
            background: var(--navy);
            padding: 14px 0;
            margin-top: 60px;
        }

        .footer-strip .inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
        }

        .footer-strip .inner i {
            color: var(--emerald);
            font-size: 15px;
        }

        .footer-strip .luber-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .luber-pill {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.06em;
            padding: 3px 10px;
            color: rgba(255, 255, 255, 0.55);
        }

        /* ═══════════════════════════════════════════════════════
           MISC
        ═══════════════════════════════════════════════════════ */
        .empty-state {
            background: #fff;
            border: 2px dashed var(--border);
            border-radius: 20px;
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            color: var(--text-light);
            margin-bottom: 12px;
        }

        .empty-state h5 {
            font-weight: 700;
            color: var(--text-main);
        }

        /* Smooth modal animation */
        .modal.fade .modal-dialog {
            transition: transform 0.28s cubic-bezier(0.34, 1.1, 0.64, 1), opacity 0.2s;
        }

        .modal.fade:not(.show) .modal-dialog {
            transform: scale(0.9) translateY(20px);
        }
    </style>
</head>

<body>

    {{-- ══════════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════════ --}}
    <header class="site-header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('voting.index') }}" class="header-brand">
                    {{-- Logo wrapper: taruh file logo Anda di public/images/logo-paskibra.png --}}
                    <div class="logo-wrap">
                        @if (file_exists(public_path('images/logo-paskibra.png')))
                        <img src="{{ asset('images/logo-paskibra.png') }}" alt="Logo Paskibra SMKN 6 Jember">
                        @else
                        {{-- Fallback sementara —akan terganti otomatis setelah logo ditaruh --}}
                        <span class="logo-fallback">
                            <i class="bi bi-flag-fill"></i>
                        </span>
                        @endif
                    </div>

                    <div class="header-titles">
                        <span class="school-name">Paskibra SMK Negeri 6 Jember</span>
                        <span class="event-name">E-Pemilihan Ketua Umum</span>
                    </div>
                </a>

                <div class="header-badge d-none d-sm-block">
                    <i class="bi bi-circle-fill me-1" style="font-size:8px;color:var(--emerald);vertical-align:middle;animation:pulse 1.5s ease infinite;"></i>
                    Sesi Aktif
                </div>
            </div>
        </div>
    </header>

    {{-- ══════════════════════════════════════════════════
         INSTRUCTION BAR
    ══════════════════════════════════════════════════ --}}
    <div class="instruction-bar">
        <div class="container">
            <div class="inner">
                <i class="bi bi-info-circle-fill"></i>
                <span>
                    Pilih <strong>satu kandidat</strong> dengan menekan tombol
                    <strong style="color:var(--emerald)">PILIH</strong>.
                    Konfirmasi pilihan Anda sebelum dikirim — suara bersifat <strong>rahasia &amp; tidak dapat diubah</strong>.
                </span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════ --}}
    <main class="py-5">
        <div class="container">

            {{-- Section Header --}}
            <div class="text-center mb-5">
                <p class="section-eyebrow mb-2">
                    <i class="bi bi-check2-square me-1"></i> Surat Suara Digital
                </p>
                <h1 class="section-title">Pilih Kandidat Terbaik Anda</h1>
                <p class="text-muted mt-2" style="font-size:15px">
                    Klik <em>"Lihat Visi Misi"</em> untuk membaca visi misi kandidat sebelum menentukan pilihan Anda.
                </p>
            </div>

            {{-- ── Candidate Grid ─────────────────────────────── --}}
            @if ($candidates->isEmpty())
            <div class="empty-state">
                <div><i class="bi bi-person-badge"></i></div>
                <h5>Belum ada kandidat yang terdaftar</h5>
                <p class="mb-0 mt-2" style="font-size:13px">Silakan hubungi panitia pelaksana.</p>
            </div>
            @else
            <div class="row g-4 justify-content-center">
                @foreach ($candidates as $candidate)
                <div class="col-sm-6 col-xl-3 d-flex">

                    <article class="candidate-card w-100" id="card-{{ $candidate->id }}">

                        {{-- Photo --}}
                        <div class="photo-wrapper">
                            <div class="photo-frame">
                                @if ($candidate->photo_url)
                                <img
                                    src="{{ $candidate->photo_url }}"
                                    alt="Foto {{ $candidate->leader_name }}"
                                    loading="lazy">
                                @else
                                <div class="photo-placeholder-inner">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Foto Kandidat</span>
                                </div>
                                @endif
                            </div>

                            {{-- Number badge --}}
                            <div class="paslon-badge">
                                No.
                                <span class="number">{{ $candidate->paslon_number }}</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="card-body-custom">
                            <div class="paslon-label">
                                <i class="bi bi-person-fill me-1"></i>
                                Kandidat {{ $candidate->paslon_number }}
                            </div>

                            <div class="name-block">
                                <div class="name-row">
                                    <span class="name-val" style="font-size:16px">{{ $candidate->leader_name }}</span>
                                </div>
                            </div>

                            <hr class="divider-thin">

                            <p class="vision-preview">{{ $candidate->vision }}</p>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2">
                                {{-- Tombol Visi Misi --}}
                                <button
                                    type="button"
                                    class="btn-visi"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalVisiMisi"
                                    data-paslon-number="{{ $candidate->paslon_number }}"
                                    data-leader="{{ $candidate->leader_name }}"
                                    data-vision="{{ $candidate->vision }}"
                                    data-mission="{{ $candidate->mission }}"
                                    aria-label="Lihat Visi Misi Kandidat {{ $candidate->paslon_number }}">
                                    <i class="bi bi-journal-text"></i>
                                    Visi Misi
                                </button>

                                {{-- Tombol Pilih --}}
                                <button
                                    type="button"
                                    class="btn-pilih"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalKonfirmasi"
                                    data-candidate-id="{{ $candidate->id }}"
                                    data-paslon-number="{{ $candidate->paslon_number }}"
                                    data-leader="{{ $candidate->leader_name }}"
                                    aria-label="Pilih Kandidat {{ $candidate->paslon_number }}">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    PILIH
                                </button>
                            </div>
                        </div>

                    </article>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </main>

    {{-- ══════════════════════════════════════════════════
         MODAL — VISI MISI
    ══════════════════════════════════════════════════ --}}
    <div class="modal fade" id="modalVisiMisi" tabindex="-1" aria-labelledby="modalVisiMisiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header-custom d-flex align-items-start justify-content-between">
                    <div>
                        <p class="paslon-sub mb-1" id="vm-paslon-label">Kandidat —</p>
                        <h5 class="modal-title" id="modalVisiMisiLabel">Visi &amp; Misi</h5>
                        <p style="font-size:13px;color:rgba(255,255,255,0.65);margin-top:4px;margin-bottom:0" id="vm-names">—</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body modal-body-custom">
                    {{-- Visi --}}
                    <div class="mb-4">
                        <p class="vm-section-title">
                            <i class="bi bi-eye-fill"></i> Visi
                        </p>
                        <div class="vm-content" id="vm-vision">—</div>
                    </div>

                    {{-- Misi --}}
                    <div>
                        <p class="vm-section-title">
                            <i class="bi bi-list-check"></i> Misi
                        </p>
                        <div class="vm-content" id="vm-mission">—</div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn-batal w-100" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         MODAL — KONFIRMASI PILIHAN
    ══════════════════════════════════════════════════ --}}
    <div class="modal fade confirm-modal" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content p-4">

                <div class="text-center">
                    <div class="confirm-icon-wrap">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold mb-1" id="modalKonfirmasiLabel" style="font-size:18px;color:var(--navy)">
                        Konfirmasi Pilihan
                    </h5>
                    <p class="text-muted" style="font-size:13.5px">Anda akan memberikan suara kepada:</p>
                </div>

                <div class="confirm-paslon-box">
                    <p class="number-label mb-1" id="confirm-number-label">Kandidat —</p>
                    <p class="names mb-0" id="confirm-names">—</p>
                </div>

                <div class="confirm-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Suara yang sudah dikirim <strong>tidak dapat diubah</strong>. Pastikan pilihan Anda sudah benar.</span>
                </div>

                {{-- Hidden form — submit di sini --}}
                <form method="POST" action="{{ route('voting.submit') }}" id="vote-form">
                    @csrf
                    <input type="hidden" name="candidate_id" id="confirm-candidate-id">

                    <div class="d-flex gap-2">
                        <button type="button" class="btn-batal" data-bs-dismiss="modal" id="btn-batal">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn-konfirmasi" id="btn-konfirmasi">
                            <i class="bi bi-send-check-fill me-1"></i> Ya, Kirim Suara
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         FOOTER STRIP
    ══════════════════════════════════════════════════ --}}
    <footer class="footer-strip">
        <div class="container">
            <div class="inner flex-column flex-sm-row gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-fill-check"></i>
                    <span>Asas LUBER JURDIL &mdash;</span>
                </div>
                <div class="luber-pills">
                    <span class="luber-pill">Langsung</span>
                    <span class="luber-pill">Umum</span>
                    <span class="luber-pill">Bebas</span>
                    <span class="luber-pill">Rahasia</span>
                    <span class="luber-pill">Jujur</span>
                    <span class="luber-pill">Adil</span>
                </div>
                <span class="d-none d-md-inline">&mdash; Website by: Rizqi Arif Ardiansyah {{ date('Y') }}</span>
            </div>
        </div>
    </footer>

    {{-- Bootstrap 5 JS --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        (function() {
            'use strict';

            /* ── Modal Visi Misi ──────────────────────────────── */
            const modalVisiMisi = document.getElementById('modalVisiMisi');
            modalVisiMisi.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                const number = btn.dataset.paslonNumber;
                const leader = btn.dataset.leader;
                const vision = btn.dataset.vision;
                const mission = btn.dataset.mission;

                this.querySelector('#vm-paslon-label').textContent = `Kandidat ${number}`;
                this.querySelector('#vm-names').textContent = leader;
                this.querySelector('#vm-vision').textContent = vision || '(Tidak tersedia)';
                this.querySelector('#vm-mission').textContent = mission || '(Tidak tersedia)';
            });

            /* ── Modal Konfirmasi ─────────────────────────────── */
            const modalKonfirmasi = document.getElementById('modalKonfirmasi');
            modalKonfirmasi.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                const candId = btn.dataset.candidateId;
                const number = btn.dataset.paslonNumber;
                const leader = btn.dataset.leader;

                this.querySelector('#confirm-candidate-id').value = candId;
                this.querySelector('#confirm-number-label').textContent = `Kandidat ${number}`;
                this.querySelector('#confirm-names').textContent = leader;

                // Highlight card yang dipilih
                document.querySelectorAll('.candidate-card').forEach(c => c.classList.remove('selected'));
                const card = document.getElementById(`card-${candId}`);
                if (card) {
                    card.classList.add('selected');
                }
            });

            /* ── Prevent double submit ────────────────────────── */
            document.getElementById('vote-form').addEventListener('submit', function() {
                const btn = document.getElementById('btn-konfirmasi');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengirim…';
            });

        })();

        /* Pulse animation for the "Sesi Aktif" dot */
        const style = document.createElement('style');
        style.textContent = `@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.4)}}`;
        document.head.appendChild(style);
    </script>
</body>

</html>