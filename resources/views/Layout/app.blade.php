<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#102d3a">
    <meta name="description" content="Sampaikan pengaduan layanan Trans Semarang dengan mudah, cepat, dan transparan.">
    <title>@yield('title', 'Lapor Trans Semarang | Suara Anda Berarti')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #102d3a;
            --navy-light: #193f4d;
            --teal: #078b80;
            --teal-dark: #06746b;
            --mint: #e6f5f1;
            --cream: #f7f9f8;
            --text: #243b43;
            --muted: #73838a;
            --line: #e5ecea;
            --white: #ffffff;
            --yellow: #f4c969;
            --shadow: 0 14px 40px rgba(16, 45, 58, .07);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--white);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input, textarea, select {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        .container {
            width: min(1120px, calc(100% - 40px));
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            height: 78px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.94);
            border-bottom: 1px solid rgba(229,236,234,.8);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(14px);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -.5px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .brand-mark {
            width: 43px;
            height: 43px;
            background: var(--teal);
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: white;
            box-shadow: 0 6px 15px rgba(7,139,128,.2);
        }

        .brand-mark svg {
            width: 25px;
            height: 25px;
        }

        .brand small {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.7px;
            color: var(--muted);
            margin-top: -3px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
            font-size: 13px;
            font-weight: 600;
            color: #64757b;
        }

        .nav-links a:hover {
            color: var(--teal);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 10px;
            padding: 13px 19px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            transition: .2s ease;
        }

        .btn-primary {
            color: white;
            background: var(--teal);
            box-shadow: 0 7px 16px rgba(7,139,128,.15);
        }

        .btn-primary:hover {
            background: var(--teal-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            color: var(--navy);
            border: 1px solid #dce7e4;
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid var(--line);
            background: white;
            border-radius: 10px;
            font-size: 22px;
            cursor: pointer;
            color: var(--navy);
        }

        /* HERO */
        .hero {
            background:
                radial-gradient(ellipse at 88% 10%, rgba(7,139,128,.09), transparent 35%),
                linear-gradient(180deg, #fbfdfc, #f6faf8);
            padding: 78px 0 64px;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.04fr .96fr;
            align-items: center;
            gap: 54px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--teal-dark);
            background: var(--mint);
            padding: 8px 12px;
            border-radius: 100px;
            font-size: 10px;
            letter-spacing: 1.4px;
            font-weight: 800;
            margin-bottom: 23px;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal);
        }

        .hero h1 {
            font-size: clamp(36px, 4.4vw, 55px);
            line-height: 1.16;
            letter-spacing: -2.1px;
            color: var(--navy);
            margin-bottom: 21px;
        }

        .hero h1 span {
            color: var(--teal);
        }

        .hero-description {
            color: #6b7d82;
            font-size: 15px;
            line-height: 1.9;
            max-width: 480px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 31px;
        }

        .hero-note {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            color: #7a898e;
        }

        .hero-note svg {
            color: var(--teal);
            flex-shrink: 0;
        }

        /* ILUSTRASI BUS */
        .hero-visual {
            position: relative;
            min-width: 0;
        }

        .visual-card {
            position: relative;
            min-height: 365px;
            border-radius: 28px;
            background: linear-gradient(145deg, #dff2ec, #eff7f3 65%, #d8ebe5);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            isolation: isolate;
        }

        .visual-circle {
            position: absolute;
            width: 290px;
            height: 290px;
            border: 1px solid rgba(7,139,128,.15);
            border-radius: 50%;
            top: 24px;
            right: -20px;
            z-index: -1;
        }

        .visual-circle::before {
            content: "";
            position: absolute;
            inset: 30px;
            border: 1px solid rgba(7,139,128,.14);
            border-radius: 50%;
        }

        .visual-circle::after {
            content: "";
            position: absolute;
            inset: 62px;
            border: 1px solid rgba(7,139,128,.12);
            border-radius: 50%;
        }

        .bus-art {
            width: 100%;
            max-width: 475px;
            padding: 12px;
            filter: drop-shadow(0 18px 14px rgba(16,45,58,.12));
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 13px 16px;
            border-radius: 14px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 11px;
            z-index: 2;
        }

        .floating-card.top {
            top: 24px;
            left: -20px;
        }

        .floating-card.bottom {
            bottom: 23px;
            right: -15px;
        }

        .float-icon {
            width: 37px;
            height: 37px;
            border-radius: 11px;
            background: var(--mint);
            color: var(--teal);
            display: grid;
            place-items: center;
            font-size: 19px;
        }

        .floating-card strong {
            display: block;
            font-size: 11px;
            color: var(--navy);
        }

        .floating-card small {
            display: block;
            color: var(--muted);
            font-size: 10px;
        }

        /* QUICK INFO */
        .quick-info {
            position: relative;
            margin-top: -1px;
            background: white;
            padding: 27px 0;
            border-bottom: 1px solid var(--line);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 13px;
            padding: 8px 20px;
        }

        .info-item + .info-item {
            border-left: 1px solid var(--line);
        }

        .info-icon {
            width: 45px;
            height: 45px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: #edf7f4;
            color: var(--teal);
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 22px;
            height: 22px;
        }

        .info-item strong {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            color: var(--navy);
            display: block;
        }

        .info-item p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* SECTION GLOBAL */
        section.content-section {
            padding: 83px 0;
        }

        .section-heading {
            text-align: center;
            max-width: 570px;
            margin: 0 auto 38px;
        }

        .section-kicker {
            color: var(--teal);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
            margin-bottom: 12px;
        }

        .section-heading h2 {
            color: var(--navy);
            font-size: clamp(25px, 3vw, 34px);
            line-height: 1.3;
            letter-spacing: -.8px;
            margin-bottom: 12px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.85;
        }

        /* CATEGORY */
        .categories {
            background: white;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 17px;
        }

        .category-card {
            border: 1px solid var(--line);
            border-radius: 17px;
            padding: 24px 20px;
            background: white;
            transition: .22s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            border-color: #a5d9cf;
            box-shadow: var(--shadow);
        }

        .category-icon {
            width: 51px;
            height: 51px;
            display: grid;
            place-items: center;
            background: var(--mint);
            color: var(--teal);
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .category-icon svg {
            width: 25px;
            height: 25px;
        }

        .category-card h3 {
            font-size: 14px;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .category-card p {
            font-size: 11px;
            line-height: 1.8;
            color: var(--muted);
        }

        /* HOW IT WORKS */
        .how-section {
            background: var(--cream);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 23px;
        }

        .step-card {
            background: white;
            border: 1px solid var(--line);
            border-radius: 19px;
            padding: 27px;
            position: relative;
        }

        .step-number {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            background: var(--navy);
            color: white;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .step-card h3 {
            font-size: 15px;
            color: var(--navy);
            margin-bottom: 9px;
        }

        .step-card p {
            font-size: 12px;
            line-height: 1.9;
            color: var(--muted);
        }

        /* QR BANNER */
        .qr-section {
            padding: 65px 0;
            background: white;
        }

        .qr-banner {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 30px;
            background: var(--navy);
            border-radius: 23px;
            padding: 37px 43px;
            color: white;
            overflow: hidden;
            position: relative;
        }

        .qr-banner::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 50%;
            right: 50px;
            top: -115px;
        }

        .qr-banner h2 {
            font-size: 24px;
            line-height: 1.4;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .qr-banner p {
            color: #c0d2d5;
            font-size: 12px;
            line-height: 1.9;
            max-width: 570px;
            position: relative;
            z-index: 1;
        }

        .qr-visual {
            width: 94px;
            height: 94px;
            background: white;
            border-radius: 13px;
            display: grid;
            place-items: center;
            color: var(--navy);
            padding: 10px;
            position: relative;
            z-index: 1;
        }

        .qr-visual svg {
            width: 100%;
            height: 100%;
        }

        /* CTA */
        .final-cta {
            padding: 70px 0 82px;
            text-align: center;
            background: #f6faf8;
        }

        .final-cta h2 {
            color: var(--navy);
            font-size: clamp(26px, 3vw, 35px);
            line-height: 1.35;
            margin-bottom: 13px;
        }

        .final-cta p {
            color: var(--muted);
            font-size: 13px;
            max-width: 490px;
            margin: 0 auto 25px;
            line-height: 1.9;
        }

        /* FOOTER */
        footer {
            background: #0b2430;
            color: white;
            padding: 33px 0;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 13px;
        }

        .footer-brand span {
            display: block;
            color: #9db4b9;
            font-family: 'DM Sans', sans-serif;
            font-size: 10px;
            font-weight: 400;
            margin-top: 5px;
        }

        .footer-note {
            color: #a8bdc1;
            font-size: 10px;
            text-align: right;
        }

        /* ANIMASI */
        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-copy {
            animation: rise .6s ease both;
        }

        .hero-visual {
            animation: rise .8s ease both;
        }

        /* RESPONSIVE TABLET */
        @media (max-width: 900px) {
            .hero {
                padding-top: 60px;
            }

            .hero-grid {
                gap: 28px;
            }

            .hero h1 {
                font-size: 39px;
            }

            .visual-card {
                min-height: 300px;
            }

            .floating-card.top {
                left: -7px;
            }

            .floating-card.bottom {
                right: -7px;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .nav-links {
                gap: 17px;
            }
        }

        /* RESPONSIVE HP */
        @media (max-width: 650px) {
            .container {
                width: min(100% - 32px, 520px);
            }

            .navbar {
                height: 69px;
            }

            .brand {
                font-size: 13px;
                gap: 8px;
            }

            .brand-mark {
                width: 39px;
                height: 39px;
                border-radius: 12px;
            }

            .brand small {
                font-size: 9px;
                letter-spacing: 1.2px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-inner > .btn {
                display: none;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 68px;
                left: 0;
                right: 0;
                padding: 17px 22px 21px;
                background: white;
                border-bottom: 1px solid var(--line);
                box-shadow: 0 12px 22px rgba(16,45,58,.06);
                flex-direction: column;
                align-items: stretch;
                gap: 0;
            }

            .nav-links.open {
                display: flex;
            }

            .nav-links a {
                padding: 12px 0;
                border-bottom: 1px solid #f0f3f2;
            }

            .nav-links a:last-child {
                border-bottom: 0;
            }

            .hero {
                padding: 47px 0 42px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 37px;
            }

            .eyebrow {
                font-size: 9px;
                margin-bottom: 18px;
            }

            .hero h1 {
                font-size: clamp(34px, 9vw, 43px);
                letter-spacing: -1.5px;
                margin-bottom: 17px;
            }

            .hero-description {
                font-size: 13px;
                margin-bottom: 23px;
            }

            .hero-actions {
                gap: 10px;
                margin-bottom: 22px;
            }

            .btn {
                padding: 12px 15px;
                font-size: 12px;
            }

            .hero-note {
                font-size: 10px;
            }

            .visual-card {
                min-height: 265px;
                border-radius: 21px;
            }

            .bus-art {
                max-width: 370px;
            }

            .visual-circle {
                width: 230px;
                height: 230px;
            }

            .floating-card {
                padding: 10px 12px;
                border-radius: 12px;
            }

            .floating-card.top {
                top: 13px;
                left: 9px;
            }

            .floating-card.bottom {
                bottom: 12px;
                right: 9px;
            }

            .float-icon {
                width: 31px;
                height: 31px;
                font-size: 16px;
            }

            .floating-card strong {
                font-size: 10px;
            }

            .floating-card small {
                font-size: 9px;
            }

            .quick-info {
                padding: 15px 0;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .info-item {
                justify-content: flex-start;
                padding: 13px 4px;
            }

            .info-item + .info-item {
                border-left: 0;
                border-top: 1px solid var(--line);
            }

            .info-icon {
                width: 39px;
                height: 39px;
            }

            .info-item strong {
                font-size: 12px;
            }

            .info-item p {
                font-size: 10px;
            }

            section.content-section {
                padding: 59px 0;
            }

            .section-heading {
                margin-bottom: 27px;
            }

            .section-heading h2 {
                font-size: 26px;
            }

            .section-heading p {
                font-size: 12px;
            }

            .category-grid {
                gap: 11px;
            }

            .category-card {
                padding: 18px 15px;
                border-radius: 15px;
            }

            .category-icon {
                width: 44px;
                height: 44px;
                margin-bottom: 15px;
            }

            .category-card h3 {
                font-size: 12px;
            }

            .category-card p {
                font-size: 10px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .step-card {
                padding: 21px;
            }

            .step-number {
                margin-bottom: 14px;
            }

            .qr-section {
                padding: 45px 0;
            }

            .qr-banner {
                grid-template-columns: 1fr auto;
                gap: 15px;
                padding: 26px 20px;
                border-radius: 18px;
            }

            .qr-banner h2 {
                font-size: 19px;
            }

            .qr-banner p {
                font-size: 11px;
            }

            .qr-visual {
                width: 65px;
                height: 65px;
                padding: 7px;
            }

            .final-cta {
                padding: 56px 0 62px;
            }

            .final-cta h2 {
                font-size: 27px;
            }

            .final-cta p {
                font-size: 12px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .footer-note {
                text-align: left;
                line-height: 1.8;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="container nav-inner">

            <a href="{{ url('/') }}" class="brand">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="3" width="16" height="15" rx="4"/>
                        <path d="M7 7h10M7 12h3m4 0h3M8 21l2-3m6 3-2-3"/>
                        <circle cx="8" cy="15" r="1"/>
                        <circle cx="16" cy="15" r="1"/>
                    </svg>
                </div>
                <div>
                    LAPOR TRANS
                    <small>SEMARANG</small>
                </div>
            </a>


            <nav class="nav-links" id="navLinks">
                <a href="{{ route('aduan.index') }}">Beranda</a>
                <a href="{{ route('aduan.index') }}#alur">Cara Mengadu</a>
                <a href="{{ route('aduan.track') }}">Lacak Aduan</a>

                @auth('web')
                    <a href="{{ route('aduan.history') }}">Riwayat Aduan</a>
                {{-- @endauth

                @auth('web') --}}
                    <a href="{{ route('profile') }}" class="btn btn-primary">
                        Akun <span aria-hidden="true">↗</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Masuk <span aria-hidden="true">↗</span>
                    </a>
                @endauth
            </nav>


            <button class="menu-toggle" id="menuToggle"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false">
                ☰
            </button>

        </div>
    </header>

    <main>
        @yield('content')
    </main>
<br><br><br><br><br><br><br><br>

    {{-- FOOTER --}}
    <footer>
        <div class="container footer-inner">

            <div class="footer-brand">
                LAPOR TRANS SEMARANG
                <span>Ruang untuk menyampaikan pengalaman dan mendorong perbaikan.</span>
            </div>

            <div class="footer-note">
                Pengembangan Sistem Informasi Pengaduan Layanan Trans Semarang Berbasis Web Dengan Qr Code Dan Dashboard Visualisasi.<br>
                © {{ date('Y') }} · Grup C kelas 52
            </div>

        </div>
    </footer>

    <script>
        // Navigasi responsif pada perangkat seluler
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', function () {
            const isOpen = navLinks.classList.toggle('open');

            menuToggle.setAttribute('aria-expanded', isOpen);
            menuToggle.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'
            );
            menuToggle.textContent = isOpen ? '✕' : '☰';
        });

        // Tutup menu setelah tautan dipilih
        navLinks.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navLinks.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.setAttribute('aria-label', 'Buka menu navigasi');
                menuToggle.textContent = '☰';
            });
        });
    </script>

    @stack('scripts')
</body>
</html>