@extends('layout.app')

@section('title', 'Lapor Trans Semarang | Suara Anda Berarti')

@section('content')

    {{-- HERO --}}
    <section class="hero" id="beranda">
        <div class="container hero-grid">

            <div class="hero-copy">
                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    SUARA ANDA, PERBAIKAN KAMI
                </div>

                <h1>
                    Perjalanan lebih nyaman,
                    <span>dimulai dari suara Anda.</span>
                </h1>

                <p class="hero-description">
                    Temukan cara mudah untuk menyampaikan pengaduan
                    layanan Trans Semarang. Setiap laporan membantu
                    kami memahami masalah dan meningkatkan kualitas
                    perjalanan bersama.
                </p>

                <div class="hero-actions">
                <a href="{{ route('aduan.create') }}" class="btn btn-primary">
                Sampaikan Aduan
                <span aria-hidden="true">→</span>
            </a>

                <a href="{{ route('qr.scan') }}" class="btn btn-outline">
                    Scan QR Code
                </a>
                </div>

                <div class="hero-note">
                    <svg width="17" height="17" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m8 12 3 3 5-6"/>
                    </svg>
                    Mudah diakses, praktis, dan berorientasi pada perbaikan.
                </div>
            </div>

            {{-- ILUSTRASI BUS SVG --}}
            <div class="hero-visual">
                <div class="visual-card">

                    <div class="visual-circle"></div>

                    <svg class="bus-art" viewBox="0 0 480 330"
                         role="img"
                         aria-label="Ilustrasi bus perkotaan di halte">

                        <!-- Jalan -->
                        <ellipse cx="245" cy="276" rx="205" ry="20"
                                 fill="#b8d7ce" opacity=".65"/>

                        <!-- Awan -->
                        <path d="M75 81c-1-11 8-20 19-20
                                 5-15 27-17 35-2 13-4 24 6 23 17
                                 H75Z"
                              fill="#ffffff" opacity=".75"/>

                        <!-- Halte -->
                        <path d="M356 88h69v167h-69z"
                              fill="#b6d9d0" opacity=".6"/>
                        <path d="M348 88h84" stroke="#729e96"
                              stroke-width="5" stroke-linecap="round"/>
                        <path d="M364 95v155M416 95v155"
                              stroke="#ffffff" stroke-width="4"/>
                        <path d="M354 255h76" stroke="#729e96"
                              stroke-width="5" stroke-linecap="round"/>

                        <!-- Orang -->
                        <circle cx="395" cy="153" r="10" fill="#d6a17d"/>
                        <path d="M384 165q11-9 22 0l5 38h-32z"
                              fill="#078b80"/>
                        <path d="M386 202l-3 32m20-32 5 32"
                              stroke="#193f4d" stroke-width="7"
                              stroke-linecap="round"/>
                        <path d="M384 174l-12 22m32-22 9 18"
                              stroke="#d6a17d" stroke-width="5"
                              stroke-linecap="round"/>

                        <!-- Badan bus -->
                        <path d="M46 126Q46 104 70 104H311
                                 Q333 104 346 127L373 181
                                 V238Q373 253 357 253H58
                                 Q43 253 43 237V142Q43 131 46 126Z"
                              fill="#ffffff" stroke="#c8dcd7"
                              stroke-width="3"/>

                        <!-- Atap bus -->
                        <path d="M68 109H309Q326 109 336 127H57Q57 115 68 109Z"
                              fill="#078b80"/>

                        <!-- Kaca depan -->
                        <path d="M312 132L343 132L365 179H312Z"
                              fill="#c6e5e6"/>
                        <path d="M318 139h19l15 33h-34z"
                              fill="#eaf8f5"/>

                        <!-- Jendela samping -->
                        <rect x="70" y="132" width="64" height="46"
                              rx="5" fill="#d6ecea"/>
                        <rect x="140" y="132" width="64" height="46"
                              rx="5" fill="#d6ecea"/>
                        <rect x="210" y="132" width="63" height="46"
                              rx="5" fill="#d6ecea"/>

                        <!-- Garis jendela -->
                        <path d="M134 134v42m70-42v42m69-42v42"
                              stroke="#ffffff" stroke-width="4"/>

                        <!-- Kursi di dalam bus -->
                        <path d="M83 154h13v17H83zM154 154h13v17h-13zM224 154h13v17h-13z"
                              fill="#078b80" opacity=".5"/>

                        <!-- Logo dekoratif -->
                        <circle cx="104" cy="205" r="13" fill="#e5f4ef"/>
                        <path d="M97 202h14m-14 5h14"
                              stroke="#078b80" stroke-width="3"
                              stroke-linecap="round"/>

                        <text x="126" y="210" font-size="12"
                              font-family="Arial, sans-serif"
                              font-weight="700" fill="#193f4d">
                            TRANS SEMARANG
                        </text>

                        <!-- Lampu -->
                        <rect x="355" y="188" width="11" height="17"
                              rx="4" fill="#f4c969"/>
                        <rect x="46" y="188" width="8" height="15"
                              rx="3" fill="#f4c969"/>

                        <!-- Roda -->
                        <circle cx="106" cy="251" r="27" fill="#193f4d"/>
                        <circle cx="106" cy="251" r="13" fill="#b8cfcb"/>
                        <circle cx="106" cy="251" r="5" fill="#ffffff"/>

                        <circle cx="310" cy="251" r="27" fill="#193f4d"/>
                        <circle cx="310" cy="251" r="13" fill="#b8cfcb"/>
                        <circle cx="310" cy="251" r="5" fill="#ffffff"/>

                        <!-- Aksen -->
                        <path d="M62 226H350"
                              stroke="#078b80" stroke-width="4"
                              stroke-linecap="round"/>

                        <!-- Daun kecil -->
                        <path d="M57 281q-17-17-24-4 9 14 24 4Z"
                              fill="#078b80" opacity=".65"/>
                        <path d="M57 281q-3-15 7-21 8 13-7 21Z"
                              fill="#4baf91" opacity=".75"/>
                    </svg>

                    <div class="floating-card top">
                        <div class="float-icon">✦</div>
                        <div>
                            <strong>Suara Anda Berarti</strong>
                            <small>Untuk layanan yang lebih baik</small>
                        </div>
                    </div>

                    <div class="floating-card bottom">
                        <div class="float-icon">✓</div>
                        <div>
                            <strong>Laporkan dengan Mudah</strong>
                            <small>Mulai dari pengalaman Anda</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    {{-- KEUNGGULAN --}}
    <div class="quick-info">
        <div class="container info-grid">

            <div class="info-item">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v18M3 12h18"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
                <div>
                    <strong>Pelaporan Praktis</strong>
                    <p>Sampaikan masalah dengan mudah.</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <strong>Informasi Terarah</strong>
                    <p>Lokasi dan kategori lebih jelas.</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18"/>
                        <path d="m8 15 4-4 4 3 5-7"/>
                    </svg>
                </div>
                <div>
                    <strong>Evaluasi Layanan</strong>
                    <p>Laporan mendukung perbaikan.</p>
                </div>
            </div>

        </div>
    </div>


    {{-- KATEGORI PENGADUAN --}}
    <section class="content-section categories" id="kategori">
        <div class="container">

            <div class="section-heading">
                <div class="section-kicker">KATEGORI PENGADUAN</div>
                <h2>Apa yang ingin Anda sampaikan?</h2>
                <p>
                    Pilih kategori yang paling sesuai dengan pengalaman
                    Anda agar laporan dapat ditangani dengan lebih terarah.
                </p>
            </div>

            <div class="category-grid">

                <article class="category-card">
                    <div class="category-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18M5 21V7l7-4 7 4v14"/>
                            <path d="M9 21v-5h6v5M9 9h.01M15 9h.01M9 12h.01M15 12h.01"/>
                        </svg>
                    </div>
                    <h3>Fasilitas</h3>
                    <p>Kursi, AC, halte, sarana bus, atau fasilitas yang rusak.</p>
                </article>

                <article class="category-card">
                    <div class="category-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                            <path d="m9 7 2 2 4-4"/>
                        </svg>
                    </div>
                    <h3>Pengemudi</h3>
                    <p>Perilaku berkendara, kedisiplinan, dan sikap pengemudi.</p>
                </article>

                <article class="category-card">
                    <div class="category-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M8 6V4h8v2"/>
                            <path d="m5 6 1 14h12l1-14"/>
                            <path d="M10 10v6m4-6v6"/>
                        </svg>
                    </div>
                    <h3>Kebersihan</h3>
                    <p>Kondisi kebersihan bus, halte, dan area pelayanan.</p>
                </article>

                <article class="category-card">
                    <div class="category-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                            <path d="M12 8v4m0 4h.01"/>
                        </svg>
                    </div>
                    <h3>Keamanan & Pelayanan</h3>
                    <p>Gangguan keamanan, sikap petugas, dan kualitas pelayanan.</p>
                </article>

            </div>
        </div>
    </section>


    {{-- ALUR PENGADUAN --}}
    <section class="content-section how-section" id="alur">
        <div class="container">

            <div class="section-heading">
                <div class="section-kicker">LANGKAH SEDERHANA</div>
                <h2>Pengaduan dalam tiga langkah</h2>
                <p>
                    Proses pelaporan dirancang sederhana agar Anda
                    dapat menyampaikan pengalaman tanpa langkah yang rumit.
                </p>
            </div>

            <div class="steps-grid">

                <article class="step-card">
                    <div class="step-number">01</div>
                    <h3>Pilih lokasi</h3>
                    <p>
                        Pindai QR Code pada bus atau halte untuk membantu
                        mengidentifikasi lokasi pengaduan.
                    </p>
                </article>

                <article class="step-card">
                    <div class="step-number">02</div>
                    <h3>Ceritakan kendala</h3>
                    <p>
                        Pilih kategori, jelaskan kejadian dengan jelas,
                        dan sertakan foto pendukung jika diperlukan.
                    </p>
                </article>

                <article class="step-card">
                    <div class="step-number">03</div>
                    <h3>Proses tindak lanjut</h3>
                    <p>
                        Petugas memeriksa laporan dan mencatat tindak lanjut
                        sesuai prosedur pengelolaan pengaduan.
                    </p>
                </article>

            </div>
        </div>
    </section>


    {{-- QR CODE --}}
    <section class="qr-section" id="tentang">
        <div class="container">
            <div class="qr-banner">

                <div>
                    <h2>Sedang berada di bus atau halte?</h2>
                    <p>
                        QR Code dapat membantu mengarahkan Anda ke halaman
                        pengaduan dengan informasi lokasi yang sesuai.
                        Pilih lokasi secara manual jika informasi belum
                        terisi otomatis.
                    </p>
                </div>

                <div class="qr-visual" aria-label="Ilustrasi QR Code">
                    <svg viewBox="0 0 100 100" fill="none"
                         stroke="#102d3a" stroke-width="7">
                        <path d="M7 35V7h28M65 7h28v28M7 65v28h28M93 65v28H65"/>
                        <path d="M17 17h8v8h-8zM75 17h8v8h-8zM17 75h8v8h-8z"
                              fill="#102d3a"/>
                        <path d="M48 7v12m0 8v7m-9 8h9m8-5v9m9-9h8m-34 9v9m17 0h9m8 0v9m-25 0v9m-9 0h9m17 8h9m-9-17h9"
                              stroke-linecap="square"/>
                    </svg>
                </div>

            </div>
        </div>
    </section>


    {{-- CTA --}}
    <section class="final-cta">
        <div class="container">
            <div class="section-kicker">BERSAMA MENJADI LEBIH BAIK</div>

            <h2>Satu laporan, langkah menuju<br>perjalanan yang lebih baik.</h2>

            <p>
                Pengalaman Anda penting. Bantu mendorong perbaikan layanan
                transportasi melalui informasi yang jelas dan bertanggung jawab.
            </p>

            <a href="#kategori" class="btn btn-primary">
                Kenali Kategori Aduan
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>

@endsection