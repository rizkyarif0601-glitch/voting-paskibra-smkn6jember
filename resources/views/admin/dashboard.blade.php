<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin E-Voting Paskibra SMKN 6 Jember">
    <title>Dashboard Admin — E-Voting Paskibra SMKN 6 Jember</title>

    {{-- Offline Local Fonts & Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    <style>
        :root {
            --navy:       #0F172A;
            --navy-mid:   #1E293B;
            --navy-light: #334155;
            --emerald:    #10B981;
            --emerald-dk: #059669;
            --gold:       #F59E0B;
            --blue:       #3B82F6;
            --red:        #EF4444;
            --purple:     #8B5CF6;
            --surface:    #F1F5F9;
            --border:     #E2E8F0;
            --sidebar-w:  260px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--navy);
            min-height: 100vh;
            display: flex;
        }

        /* ═══════════════════════════════
           SIDEBAR
        ═══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--navy);
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--emerald), var(--emerald-dk));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-icon i { color: #fff; font-size: 20px; }

        .brand-text .title { font-size: 13px; font-weight: 800; color: #fff; }
        .brand-text .sub   { font-size: 10.5px; color: rgba(255,255,255,0.4); margin-top: 1px; }

        .sidebar-nav { padding: 16px 12px; flex: 1; }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 10px 8px 6px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all 0.2s;
        }

        .nav-item-link i { font-size: 17px; width: 20px; text-align: center; }
        .nav-item-link:hover  { background: rgba(255,255,255,0.07); color: #fff; }
        .nav-item-link.active { background: rgba(16,185,129,0.15); color: var(--emerald); }
        .nav-item-link.active i { color: var(--emerald); }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 11px;
            color: rgba(255,255,255,0.25);
            text-align: center;
        }

        /* ═══════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title { font-size: 17px; font-weight: 800; color: var(--navy); }
        .topbar-sub   { font-size: 12px; color: #64748b; margin-top: 1px; }

        .topbar-actions { display: flex; align-items: center; gap: 10px; }

        .btn-print-all {
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 9px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-print-all:hover { background: var(--navy-mid); color: #fff; }

        .content-area { padding: 28px; }

        /* ═══════════════════════════════
           STAT CARDS
        ═══════════════════════════════ */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(15,23,42,0.1);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 24px;
        }

        .stat-icon.green  { background: #d1fae5; color: var(--emerald-dk); }
        .stat-icon.blue   { background: #dbeafe; color: var(--blue); }
        .stat-icon.amber  { background: #fef3c7; color: var(--gold); }
        .stat-icon.purple { background: #ede9fe; color: var(--purple); }

        .stat-value { font-size: 28px; font-weight: 900; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 12.5px; color: #64748b; font-weight: 500; }
        .stat-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 100px;
            margin-top: 4px;
        }

        /* ═══════════════════════════════
           PROGRESS BAR
        ═══════════════════════════════ */
        .participation-bar {
            background: #e2e8f0;
            border-radius: 100px;
            height: 8px;
            overflow: hidden;
            margin-top: 6px;
        }

        .participation-fill {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(to right, var(--emerald), #34d399);
            transition: width 1s ease;
        }

        /* ═══════════════════════════════
           SECTION CARDS
        ═══════════════════════════════ */
        .section-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .section-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-card-title i { color: var(--emerald); }

        .section-card-body { padding: 22px; }

        /* ═══════════════════════════════
           VOTE TABLE (Quick Count)
        ═══════════════════════════════ */
        .vote-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .vote-row:last-child { border-bottom: none; }

        .vote-number {
            width: 38px; height: 38px;
            background: var(--navy);
            color: var(--gold);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .vote-info { flex: 1; min-width: 0; }
        .vote-names { font-size: 13.5px; font-weight: 700; color: var(--navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .vote-count-bar { margin-top: 5px; }

        .vote-bar-track {
            background: #f1f5f9;
            border-radius: 100px;
            height: 7px;
            overflow: hidden;
        }

        .vote-bar-fill {
            height: 100%;
            border-radius: 100px;
            transition: width 1s ease;
        }

        .vote-badge {
            text-align: right;
            flex-shrink: 0;
        }

        .vote-count-num { font-size: 22px; font-weight: 900; line-height: 1; }
        .vote-count-pct { font-size: 11px; color: #64748b; }

        /* ═══════════════════════════════
           TOKEN GENERATOR
        ═══════════════════════════════ */
        .token-gen-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .form-group-inline { flex: 1; min-width: 160px; }
        .form-label-sm { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; }

        .input-token {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-token:focus {
            border-color: var(--emerald);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
        }

        .btn-generate {
            background: linear-gradient(135deg, var(--emerald), var(--emerald-dk));
            border: none;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(16,185,129,0.35);
            transition: transform 0.2s, box-shadow 0.2s;
            white-space: nowrap;
        }

        .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(16,185,129,0.45); }

        /* ═══════════════════════════════
           TOKEN TABLE
        ═══════════════════════════════ */
        .token-table { width: 100%; border-collapse: collapse; }
        .token-table th {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .token-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            vertical-align: middle;
        }

        .token-table tr:last-child td { border-bottom: none; }
        .token-table tr:hover td { background: #f8fafc; }

        .token-code {
            font-family: 'Courier New', monospace;
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: 0.15em;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-voted     { background: #d1fae5; color: #065f46; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }
        .badge-not-voted { background: #fef3c7; color: #92400e; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }

        .btn-delete {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #ef4444;
            border-radius: 7px;
            padding: 5px 10px;
            font-size: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-delete:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        /* ═══════════════════════════════
           ALERT FLASH
        ═══════════════════════════════ */
        .flash-alert {
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .flash-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
        .flash-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

        /* ═══════════════════════════════
           CHART CONTAINER
        ═══════════════════════════════ */
        .chart-container {
            position: relative;
            height: 280px;
        }

        /* ═══════════════════════════════
           RESPONSIVE
        ═══════════════════════════════ */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-shield-check-fill"></i></div>
            <div class="brand-text">
                <div class="title">Admin Panel</div>
                <div class="sub">E-Voting Paskibra</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <p class="nav-section-label">Menu</p>

            <a href="{{ route('admin.dashboard') }}" class="nav-item-link active">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.realtime') }}" class="nav-item-link" target="_blank">
                <i class="bi bi-broadcast text-success"></i>
                Perolehan Suara (Live)
            </a>

            <a href="{{ route('admin.tokens.print') }}" class="nav-item-link" target="_blank">
                <i class="bi bi-printer"></i>
                Cetak Semua Token
            </a>

            <p class="nav-section-label mt-2">Navigasi</p>

            <a href="{{ route('voting.index') }}" class="nav-item-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                Halaman Voting
            </a>

            <p class="nav-section-label mt-2">Sesi</p>

            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0" onsubmit="return confirm('Keluar dari sesi admin?')">
                @csrf
                <button type="submit" class="nav-item-link w-100 text-start" style="background:transparent;border:none;cursor:pointer;color:#f87171">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">
            &copy; Rizqi Arif Ardiansyah &bull; {{ date('Y') }}
        </div>
    </aside>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════ --}}
    <div class="main-wrap">

        {{-- Top Bar --}}
        <div class="topbar">
            <div>
                <div class="topbar-title">
                    <i class="bi bi-speedometer2 me-2" style="color:var(--emerald)"></i>
                    Dashboard Admin
                </div>
                <div class="topbar-sub">E-Voting Pemilihan Ketua Umum Paskibra SMKN 6 Jember</div>
            </div>
            <div class="topbar-actions">
                {{-- Tombol Reset Hasil Pemilihan --}}
                <form method="POST" action="{{ route('admin.results.clear') }}"
                    id="form-clear-results" style="margin:0"
                    onsubmit="return confirm('⚠️ RESET HASIL PEMILIHAN\n\nIni akan menghapus SEMUA data suara dan mereset status semua token ke belum memilih.\n\nLanjutkan?')"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="
                        background:#fee2e2;border:1.5px solid #fca5a5;color:#dc2626;
                        border-radius:10px;padding:9px 16px;
                        font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                        display:flex;align-items:center;gap:6px;cursor:pointer;transition:all 0.2s;
                    " onmouseover="this.style.background='#dc2626';this.style.color='#fff'"
                       onmouseout="this.style.background='#fee2e2';this.style.color='#dc2626'">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Hasil
                    </button>
                </form>

                <a href="{{ route('admin.realtime') }}" target="_blank" style="
                    background:#0F172A;border:1.5px solid #334155;color:#fff;
                    border-radius:10px;padding:9px 16px;
                    font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                    display:flex;align-items:center;gap:6px;text-decoration:none;transition:all 0.2s;
                " onmouseover="this.style.background='#1E293B';this.style.borderColor='var(--emerald)'"
                   onmouseout="this.style.background='#0F172A';this.style.borderColor='#334155'"
                   title="Buka Layar Live Perolehan Suara (Bisa untuk proyektor)">
                    <i class="bi bi-broadcast" style="color:var(--emerald)"></i>
                    Layar Live
                </a>

                <a href="{{ route('admin.tokens.print') }}" target="_blank" class="btn-print-all">
                    <i class="bi bi-printer-fill"></i>
                    Cetak Token
                </a>

                {{-- Admin Profile & Logout --}}
                <div class="d-flex align-items-center gap-2 px-3 py-2" style="background:#f1f5f9;border-radius:10px;font-size:12.5px;font-weight:700;color:var(--navy)">
                    <i class="bi bi-person-circle" style="color:var(--emerald);font-size:15px"></i>
                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Rizqi Arif' }}</span>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST" style="margin:0" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sesi admin?')">
                    @csrf
                    <button type="submit" style="
                        background:#f1f5f9;border:1.5px solid #e2e8f0;color:#64748b;
                        border-radius:10px;padding:9px 14px;
                        font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                        display:flex;align-items:center;gap:6px;cursor:pointer;transition:all 0.2s;
                    " onmouseover="this.style.background='#ef4444';this.style.color='#fff';this.style.borderColor='#ef4444'"
                       onmouseout="this.style.background='#f1f5f9';this.style.color='#64748b';this.style.borderColor='#e2e8f0'"
                       title="Keluar dari sesi Admin">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Content --}}
        <div class="content-area">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="flash-alert flash-success">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="flash-alert flash-error">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ══ STAT CARDS ══════════════════════════════════ --}}
            <div class="row g-3 mb-4">

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="stat-value" style="color:var(--blue)">{{ number_format($totalVoters) }}</div>
                            <div class="stat-label">Total Pemilih Terdaftar</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <div class="stat-value" style="color:var(--emerald)">{{ number_format($totalVoted) }}</div>
                            <div class="stat-label">Sudah Memilih</div>
                            <span class="stat-badge" style="background:#d1fae5;color:#065f46">
                                {{ $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0 }}% dari total
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="stat-value" style="color:var(--gold)">{{ number_format($totalNotVoted) }}</div>
                            <div class="stat-label">Belum Memilih</div>
                            <span class="stat-badge" style="background:#fef3c7;color:#92400e">
                                {{ $totalVoters > 0 ? round(($totalNotVoted / $totalVoters) * 100, 1) : 0 }}% dari total
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="stat-value" style="color:var(--purple)">{{ $participationRate }}%</div>
                            <div class="stat-label">Tingkat Partisipasi</div>
                            <div class="participation-bar mt-2">
                                <div class="participation-fill" style="width:{{ $participationRate }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══ QUICK COUNT + CHART ═══════════════════════════ --}}
            <div class="row g-3 mb-4">

                {{-- Tabel Perolehan Suara --}}
                <div class="col-lg-5">
                    <div class="section-card h-100">
                        <div class="section-card-header">
                            <span class="section-card-title">
                                <i class="bi bi-bar-chart-fill"></i>
                                Perolehan Suara
                            </span>
                            <span style="font-size:12px;color:#64748b;font-weight:600">
                                Total: <strong style="color:var(--navy)">{{ $totalVotes }}</strong> suara
                            </span>
                        </div>
                        <div class="section-card-body">

                            @if ($candidates->isEmpty())
                                <p class="text-muted text-center py-4" style="font-size:13px">Belum ada kandidat terdaftar.</p>
                            @else
                                @foreach ($candidates as $index => $candidate)
                                    @php
                                        $pct = $totalVotes > 0
                                            ? round(($candidate->votes_count / $totalVotes) * 100, 1)
                                            : 0;
                                        $barColors = ['#10B981','#3B82F6','#F59E0B','#EF4444','#8B5CF6'];
                                        $color = $barColors[$index % count($barColors)];
                                    @endphp
                                    <div class="vote-row">
                                        <div class="vote-number">{{ $candidate->paslon_number }}</div>
                                        <div class="vote-info">
                                            <div class="vote-names">
                                                {{ $candidate->leader_name }}
                                            </div>
                                            <div class="vote-count-bar">
                                                <div class="vote-bar-track">
                                                    <div class="vote-bar-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vote-badge">
                                            <div class="vote-count-num" style="color:{{ $color }}">{{ $candidate->votes_count }}</div>
                                            <div class="vote-count-pct">{{ $pct }}%</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                {{-- Chart.js --}}
                <div class="col-lg-7">
                    <div class="section-card h-100">
                        <div class="section-card-header">
                            <span class="section-card-title">
                                <i class="bi bi-pie-chart-fill"></i>
                                Grafik Perolehan Suara Real-Time
                            </span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" id="chartTypeBar" onclick="switchChart('bar')" style="font-size:11px;font-weight:700">Bar</button>
                                <button class="btn btn-sm btn-outline-secondary" id="chartTypePie" onclick="switchChart('doughnut')" style="font-size:11px;font-weight:700">Donut</button>
                            </div>
                        </div>
                        <div class="section-card-body d-flex align-items-center justify-content-center">
                            @if ($candidates->isEmpty())
                                <p class="text-muted" style="font-size:13px">Belum ada data untuk ditampilkan.</p>
                            @else
                                <div class="chart-container w-100">
                                    <canvas id="voteChart"></canvas>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══ MANAJEMEN KANDIDAT ═══════════════════════════ --}}
            <div class="section-card mb-4">
                <div class="section-card-header">
                    <span class="section-card-title">
                        <i class="bi bi-people-fill"></i>
                        Manajemen Data Kandidat (1 - 4)
                    </span>
                    <span style="font-size:12px;color:#64748b;font-weight:600">
                        Klik tombol <strong>Edit</strong> untuk mengubah Nama, Foto, Visi, atau Misi
                    </span>
                </div>
                <div class="section-card-body">
                    <div class="row g-3">
                        @foreach ($candidates as $candidate)
                        <div class="col-sm-6 col-xl-3">
                            <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:16px;height:100%;display:flex;flex-direction:column;justify-content:space-between">
                                <div>
                                    <div style="position:relative;margin-bottom:12px;border-radius:10px;overflow:hidden;background:#e2e8f0;aspect-ratio:3/4;display:flex;align-items:center;justify-content:center">
                                        @if ($candidate->photo_url)
                                            <img src="{{ $candidate->photo_url }}" alt="Foto {{ $candidate->leader_name }}" style="width:100%;height:100%;object-fit:cover">
                                        @else
                                            <div style="text-align:center;color:#94a3b8">
                                                <i class="bi bi-person-circle" style="font-size:44px"></i>
                                                <div style="font-size:11px;font-weight:600;margin-top:2px">Belum Ada Foto</div>
                                            </div>
                                        @endif
                                        <span style="position:absolute;top:8px;left:8px;background:var(--navy);color:#fff;font-size:11px;font-weight:800;padding:3px 8px;border-radius:6px">
                                            No. {{ $candidate->paslon_number }}
                                        </span>
                                    </div>
                                    <h6 style="font-size:14.5px;font-weight:700;color:var(--navy);margin-bottom:4px">
                                        {{ $candidate->leader_name }}
                                    </h6>
                                    <p style="font-size:11.5px;color:#64748b;line-height:1.4;margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                        <strong>Visi:</strong> {{ $candidate->vision }}
                                    </p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary w-100"
                                    style="border-radius:8px;font-weight:700;font-size:12px"
                                    data-bs-toggle="modal" data-bs-target="#modalEditCandidate-{{ $candidate->id }}">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Data &amp; Foto
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ══ TOKEN GENERATOR ══════════════════════════════ --}}
            <div class="section-card mb-4">
                <div class="section-card-header">
                    <span class="section-card-title">
                        <i class="bi bi-key-fill"></i>
                        Generator Token Pemilih
                    </span>
                    <span style="font-size:12px;color:#64748b;font-weight:600">
                        Token aktif: <strong style="color:var(--navy)">{{ $totalNotVoted }}</strong>
                        &bull; Sudah dipakai: <strong style="color:var(--emerald)">{{ $totalVoted }}</strong>
                    </span>
                </div>
                <div class="section-card-body">

                    {{-- Form: Generate Token --}}
                    <form method="POST" action="{{ route('admin.tokens.generate') }}" id="form-generate" class="mb-4">
                        @csrf
                        <div class="token-gen-form">

                            <div class="form-group-inline">
                                <p class="form-label-sm">Jumlah Token yang Digenerate</p>
                                <input
                                    type="number"
                                    name="amount"
                                    class="input-token"
                                    placeholder="Contoh: 100"
                                    min="1"
                                    max="500"
                                    value="{{ old('amount', 50) }}"
                                    required
                                    id="amount-input"
                                >
                                @error('amount')
                                    <p style="font-size:12px;color:#ef4444;margin-top:5px">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn-generate" id="gen-btn">
                                <i class="bi bi-lightning-fill"></i>
                                Generate Token
                            </button>

                            {{-- Tombol Hapus Token Kosong --}}
                            <button
                                type="button"
                                id="btn-hapus-kosong"
                                style="background:#fef2f2;border:1.5px solid #fecaca;color:#ef4444;
                                       border-radius:10px;padding:10px 16px;font-family:'Plus Jakarta Sans',sans-serif;
                                       font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;
                                       white-space:nowrap;transition:all 0.2s;"
                                onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                onmouseout="this.style.background='#fef2f2';this.style.color='#ef4444'"
                            >
                                <i class="bi bi-trash3-fill"></i> Hapus Token Kosong
                            </button>

                        </div>
                    </form>

                    {{-- Form Hapus Token Kosong — terpisah dari form generate (nested form tidak valid HTML) --}}
                    <form method="POST"
                        action="{{ route('admin.tokens.delete-unused') }}"
                        id="form-delete-unused"
                        style="display:none">
                        @csrf
                        @method('DELETE')
                    </form>

                    {{-- ── Token Table ──────────────────────────── --}}
                    <div style="overflow-x:auto;border-radius:12px;border:1px solid var(--border)">
                        <table class="token-table">
                            <thead style="background:#f8fafc">
                                <tr>
                                    <th>#</th>
                                    <th>Token</th>
                                    <th>Status</th>
                                    <th>Waktu Dibuat</th>
                                    <th>Waktu Vote</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($voters as $voter)
                                    <tr>
                                        <td style="color:#94a3b8;font-size:12px">
                                            {{ ($voters->currentPage() - 1) * $voters->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            <span class="token-code">{{ $voter->token }}</span>
                                        </td>
                                        <td>
                                            @if ($voter->is_voted)
                                                <span class="badge-voted">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Sudah Memilih
                                                </span>
                                            @else
                                                <span class="badge-not-voted">
                                                    <i class="bi bi-clock me-1"></i>Belum Memilih
                                                </span>
                                            @endif
                                        </td>
                                        <td style="font-size:12.5px;color:#64748b">
                                            {{ $voter->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td style="font-size:12.5px;color:#64748b">
                                            {{ $voter->voted_at ? $voter->voted_at->format('d M Y, H:i') : '—' }}
                                        </td>
                                        <td>
                                            @unless ($voter->is_voted)
                                                <form method="POST"
                                                    action="{{ route('admin.tokens.delete', $voter) }}"
                                                    onsubmit="return confirm('Hapus token {{ $voter->token }}?')"
                                                    style="margin:0;display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span style="font-size:12px;color:#cbd5e1">—</span>
                                            @endunless
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5" style="color:#94a3b8;font-size:13px">
                                            <i class="bi bi-key d-block mb-2" style="font-size:32px"></i>
                                            Belum ada token. Generate token di atas untuk memulai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($voters->hasPages())
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $voters->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>

        </div>{{-- /content-area --}}
    </div>{{-- /main-wrap --}}

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chart.umd.min.js') }}"></script>

    <script>
    // ── Chart.js Setup ────────────────────────────────────────
    const labels     = @json($chartLabels);
    const dataValues = @json($chartData);
    const colors     = @json($chartColors);

    const candidateNames = @json($chartCandidateNames);

    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

    let currentChart = null;
    const ctx = document.getElementById('voteChart');

    function buildChart(type) {
        if (currentChart) { currentChart.destroy(); }

        const isBar = type === 'bar';

        currentChart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: dataValues,
                    backgroundColor: colors,
                    borderColor: colors.map(c => c.replace('0.85', '1')),
                    borderWidth: isBar ? 0 : 2,
                    borderRadius: isBar ? 10 : 0,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: ! isBar,
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            font: { size: 12, weight: '600' },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                return data.labels.map((label, i) => ({
                                    text: `${label}: ${dataValues[i]} suara`,
                                    fillStyle: colors[i],
                                    strokeStyle: colors[i],
                                    index: i
                                }));
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleColor: '#fff',
                        bodyColor: '#94a3b8',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            title: (items) => labels[items[0].dataIndex],
                            label: (item) => {
                                const total = dataValues.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((item.raw / total) * 100).toFixed(1) : 0;
                                return [`Kandidat: ${candidateNames[item.dataIndex]}`, `${item.raw} suara (${pct}%)`];
                            }
                        }
                    }
                },
                scales: isBar ? {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 } },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12, weight: '700' } }
                    }
                } : {}
            }
        });
    }

    function switchChart(type) {
        buildChart(type);
        document.getElementById('chartTypeBar').classList.toggle('active', type === 'bar');
        document.getElementById('chartTypePie').classList.toggle('active', type === 'doughnut');
    }

    // Default: Bar chart
    if (ctx) { buildChart('bar'); }

    // ── Generate button loading state ────────────────────────
    document.getElementById('form-generate')
        ?.addEventListener('submit', function () {
            const btn = document.getElementById('gen-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Generating…';
        });

    // ── Hapus Token Kosong Event Listener ────────────────────
    document.getElementById('btn-hapus-kosong')
        ?.addEventListener('click', function () {
            if (confirm('Hapus semua token yang belum digunakan? Tindakan ini tidak dapat dibatalkan.')) {
                document.getElementById('form-delete-unused')?.submit();
            }
        });

    // ── Auto refresh setiap 30 detik (quick count real-time) ─
    setTimeout(() => window.location.reload(), 30000);
    </script>

    {{-- ══ MODAL EDIT KANDIDAT ══════════════════════════════ --}}
    @foreach ($candidates as $candidate)
    <div class="modal fade" id="modalEditCandidate-{{ $candidate->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 40px rgba(0,0,0,0.15)">
                <form action="{{ route('admin.candidates.update', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background:#0F172A;color:#fff;border-radius:16px 16px 0 0;padding:16px 24px">
                        <h5 class="modal-title" style="font-size:16px;font-weight:700">
                            <i class="bi bi-pencil-square me-2" style="color:var(--emerald)"></i>
                            Edit Kandidat Nomor Urut {{ $candidate->paslon_number }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding:24px">
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:700;font-size:13px;color:var(--navy)">Nama Kandidat</label>
                            <input type="text" name="leader_name" class="form-control" value="{{ old('leader_name', $candidate->leader_name) }}" required style="border-radius:8px;font-size:14px">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight:700;font-size:13px;color:var(--navy)">Upload Foto Kandidat (Opsional)</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" style="border-radius:8px;font-size:13px">
                            <small class="text-muted d-block mt-1" style="font-size:11.5px">
                                Format: JPG, PNG, WEBP (Maksimal 3MB). Foto saat ini:
                                @if ($candidate->photo_url)
                                    <strong style="color:var(--emerald)">Sudah terpasang</strong>
                                @else
                                    <span class="text-secondary">Belum ada foto</span>
                                @endif
                                &bull; Atau Anda juga dapat langsung menaruh file di <code>public/images/candidates/kandidat-{{ $candidate->paslon_number }}.jpg</code>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight:700;font-size:13px;color:var(--navy)">Visi</label>
                            <textarea name="vision" class="form-control" rows="3" required style="border-radius:8px;font-size:13px">{{ old('vision', $candidate->vision) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight:700;font-size:13px;color:var(--navy)">Misi</label>
                            <textarea name="mission" class="form-control" rows="5" required style="border-radius:8px;font-size:13px">{{ old('mission', $candidate->mission) }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size:11.5px">Gunakan nomor (1, 2, 3...) atau baris baru untuk memisahkan butir misi.</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="background:#f8fafc;border-top:1px solid #e2e8f0;border-radius:0 0 16px 16px;padding:12px 24px">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;font-weight:600;font-size:13px">Batal</button>
                        <button type="submit" class="btn btn-primary" style="background:var(--emerald);border-color:var(--emerald);border-radius:8px;font-weight:700;font-size:13px">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</body>
</html>
