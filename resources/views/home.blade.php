@extends('layouts.app')

@section('content')
    <!-- Carousel Section -->
    @if($carousels->count() > 0)
        <section class="carousel-section">
            <div class="carousel-container">
                <div class="carousel-wrapper" id="homeCarousel">
                    @foreach($carousels as $carousel)
                        <div class="carousel-slide">
                            <img src="{{ asset('storage/' . $carousel->image) }}" 
                                 alt="{{ $carousel->alt_text ?? $carousel->title }}"
                                 class="carousel-image">
                            <div class="carousel-content">
                                <div class="carousel-text">
                                    <h2 class="carousel-title">{{ $carousel->title }}</h2>
                                    @if($carousel->description)
                                        <p class="carousel-description">{{ $carousel->description }}</p>
                                    @endif
                                    @if($carousel->button_text && $carousel->link_url)
                                        <a href="{{ $carousel->link_url }}" class="carousel-button">
                                            {{ $carousel->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Carousel Navigation -->
                <button class="carousel-nav carousel-prev" onclick="changeSlide(-1)">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="carousel-nav carousel-next" onclick="changeSlide(1)">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach($carousels as $index => $carousel)
                        <button class="carousel-indicator {{ $index === 0 ? 'active' : '' }}" 
                                onclick="goToSlide({{ $index }})"></button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Transparensi & Impak</h1>
                <p class="hero-subtitle">Laman web rasmi YB Dato' Zunita Begum, Ahli Dewan Undangan Negeri Pilah. Memaparkan transparensi penuh dalam pengurusan dana awam dan inisiatif komuniti.</p>
                <div class="hero-buttons">
                    <a href="#statistics" class="btn btn-primary">Lihat Statistik</a>
                    <a href="{{ route('initiatives.index') }}" class="btn btn-secondary">Program Aktif</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" id="total-contributions">0</div>
                        <div class="stat-label">Sumbangan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="total-recipients">0</div>
                        <div class="stat-label">Penerima</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="total-initiatives">0</div>
                        <div class="stat-label">Inisiatif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats" id="statistics">
        <div class="container">
            <div class="section-header">
                <h2>Statistik Transparensi</h2>
                <p>Data terkini mengenai sumbangan dan impak untuk komuniti Pilah</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-contributions-large" data-target="{{ $statistics['contributions'] ?? 0 }}">0</div>
                    <div class="stat-label">Jumlah Sumbangan</div>
                    <div class="stat-description">Bantuan kewangan yang telah diagihkan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-recipients-large" data-target="{{ $statistics['recipients'] ?? 0 }}">0</div>
                    <div class="stat-label">Penerima Manfaat</div>
                    <div class="stat-description">Individu dan keluarga yang dibantu</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-initiatives-large" data-target="{{ $statistics['initiatives'] ?? 0 }}">0</div>
                    <div class="stat-label">Inisiatif Aktif</div>
                    <div class="stat-description">Program yang sedang dijalankan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-amount" data-target="{{ $statistics['amount'] ?? 0 }}">RM 0</div>
                    <div class="stat-label">Jumlah Dana</div>
                    <div class="stat-description">Nilai bantuan yang telah diagihkan</div>
                </div>
            </div>
            
            <div class="charts-grid">
                <div class="chart-container">
                    <h3 class="chart-title">Sumbangan Mengikut Kategori</h3>
                    <canvas id="categoryChart"></canvas>
                    <div id="categoryChartFallback" class="chart-fallback" style="display: none;">
                        <div class="fallback-content">
                            <p>Data sedang dimuatkan...</p>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <h3 class="chart-title">Trend Bulanan</h3>
                    <canvas id="trendChart"></canvas>
                    <div id="trendChartFallback" class="chart-fallback" style="display: none;">
                        <div class="fallback-content">
                            <p>Data sedang dimuatkan...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="section-header">
                <h2>Tentang YB Dato' Zunita Begum</h2>
                <p>Ahli Dewan Undangan Negeri Pilah yang komited kepada transparensi dan pembangunan komuniti</p>
            </div>
            
            <div class="about-content">
                <div class="about-text">
                    <h3>Visi & Misi</h3>
                    <p>YB Dato' Zunita Begum komited untuk memastikan transparensi penuh dalam pengurusan dana awam dan pembangunan komuniti di kawasan Pilah.</p>
                    <p>Dengan pengalaman bertahun-tahun dalam perkhidmatan awam, beliau bertekad untuk membawa perubahan positif kepada masyarakat melalui inisiatif yang berkesan dan akauntabiliti yang tinggi.</p>
                    <p>Setiap ringgit yang diperuntukkan akan dipantau dan dilaporkan secara terbuka untuk memastikan akauntabiliti kepada rakyat.</p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Transparensi Penuh</h4>
                                <p>Setiap transaksi dan keputusan dipaparkan secara terbuka</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Komuniti Teras</h4>
                                <p>Fokus kepada keperluan dan pembangunan komuniti setempat</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Impak Berkesan</h4>
                                <p>Program yang dirancang untuk memberikan impak maksimum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p>YB Dato' Zunita Begum</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Initiatives Section -->
    <section class="initiatives" id="initiatives">
        <div class="container">
            <div class="section-header">
                <h2>Inisiatif Terkini</h2>
                <p>Program dan inisiatif yang sedang dijalankan untuk manfaat komuniti</p>
            </div>
            
            <div class="initiatives-grid" id="initiatives-grid">
                <!-- Initiatives will be loaded dynamically -->
            </div>
            
            <div class="initiatives-cta">
                <a href="{{ route('initiatives.index') }}" class="btn btn-primary">Lihat Semua Inisiatif</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header">
                <h2>Hubungi Kami</h2>
                <p>Berkongsi maklum balas, aduan, atau cadangan untuk pembangunan komuniti</p>
            </div>
            
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Maklumat Perhubungan</h3>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Alamat</h4>
                                <p>Pejabat ADUN Pilah<br>Jalan Besar, 71600 Pilah, Negeri Sembilan</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Telefon</h4>
                                <p>06-481 1234</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Emel</h4>
                                <p>zunita.pilah@ns.gov.my</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4>Waktu Operasi</h4>
                                <p>Isnin - Jumaat: 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Hantar Maklum Balas</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Penuh</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Emel</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nombor Telefon</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <select id="subject" name="subject" required>
                                <option value="">Pilih subjek</option>
                                <option value="aduan">Aduan</option>
                                <option value="cadangan">Cadangan</option>
                                <option value="maklum-balas">Maklum Balas</option>
                                <option value="lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Mesej</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Hantar Mesej</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Carousel Section */
        .carousel-section {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-wrapper {
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
            position: relative;
            height: 100%;
        }

        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .carousel-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-text {
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 2rem;
        }

        .carousel-title {
            font-family: 'Georgia', serif;
            font-size: 3rem;
            font-weight: 400;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .carousel-description {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .carousel-button {
            display: inline-block;
            background: var(--accent-gold);
            color: var(--text-dark);
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .carousel-button:hover {
            background: var(--accent-orange);
            transform: translateY(-2px);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 1rem;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .carousel-nav:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .carousel-prev {
            left: 2rem;
        }

        .carousel-next {
            right: 2rem;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
        }

        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator.active {
            background: var(--accent-gold);
        }

        .carousel-indicator:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%);
            color: var(--text-light);
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }
        
        .hero .container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .hero-title {
            font-family: 'Georgia', serif;
            font-size: 3.5rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .hero-visual {
            display: flex;
            justify-content: center;
        }
        
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-item .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-gold);
        }
        
        .stat-item .stat-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        /* Statistics Section */
        .stats {
            padding: 6rem 0;
            background: var(--bg-secondary);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        
        .section-header p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .stat-card {
            background: var(--bg-primary);
            border: 1px solid var(--neutral-200);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-teal));
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-teal));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
        }
        
        .stat-number {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-description {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }
        
        .chart-container {
            background: var(--bg-primary);
            border: 1px solid var(--neutral-200);
            border-radius: 1rem;
            padding: 2rem;
            position: relative;
            min-height: 400px;
        }

        .chart-container canvas {
            max-height: 350px;
            width: 100% !important;
            height: 100% !important;
        }

        .chart-fallback {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-primary);
        }

        .fallback-content {
            text-align: center;
            color: var(--text-secondary);
        }

        .fallback-content p {
            font-size: 1.125rem;
            margin: 0;
        }
        
        .chart-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        /* About Section */
        .about {
            padding: 6rem 0;
            background: var(--bg-primary);
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .about-text h3 {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }
        
        .about-text p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .about-features {
            margin-top: 2rem;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .feature-item h4 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }
        
        .feature-item p {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }
        
        .about-image {
            text-align: center;
        }
        
        .image-placeholder {
            background: linear-gradient(135deg, var(--neutral-100), var(--neutral-200));
            border-radius: 1rem;
            padding: 3rem;
            color: var(--text-secondary);
        }
        
        .image-placeholder p {
            margin-top: 1rem;
            font-weight: 500;
        }
        
        /* Initiatives Section */
        .initiatives {
            padding: 6rem 0;
            background: var(--bg-secondary);
        }
        
        .initiatives-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .initiative-card {
    background: var(--bg-primary);
    border: 1px solid var(--neutral-200);
    border-radius: 1rem;
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.initiative-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-blue), var(--secondary-teal));
}

.initiative-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.initiative-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.initiative-title {
    font-family: 'Georgia', serif;
    font-size: 1.25rem;
    font-weight: 400;
    color: var(--text-primary);
    margin: 0;
    flex: 1;
}

.initiative-category {
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 1rem;
}

.initiative-description {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
    font-size: 0.875rem;
}

.initiative-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
}

.initiative-status {
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.initiative-status.aktif {
    background: var(--success-light);
    color: var(--success-green);
}

.initiative-status.dalam-perancangan {
    background: var(--warning-light);
    color: var(--warning-yellow);
}

.initiative-deadline {
    color: var(--text-tertiary);
    font-size: 0.75rem;
}
        
        .initiatives-cta {
            text-align: center;
        }
        
        /* Contact Section */
        .contact {
            padding: 6rem 0;
            background: var(--bg-primary);
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }
        
        .contact-info h3 {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 2rem;
        }
        
        .contact-items {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .contact-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-teal));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .contact-item h4 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .contact-item p {
            color: var(--text-secondary);
            line-height: 1.6;
        }
        
        .contact-form {
            background: var(--bg-secondary);
            padding: 2rem;
            border-radius: 1rem;
        }
        
        .contact-form h3 {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--neutral-300);
            border-radius: 0.5rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-group textarea {
            height: 120px;
            resize: vertical;
        }
        
        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
            color: var(--text-light);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--text-light);
        }
        
        .btn-secondary:hover {
            background: var(--text-light);
            color: var(--primary-navy);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero .container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .about-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
        }
    </style>

    <script>
        // Carousel functionality
        let currentSlide = 0;
        let slideInterval;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const totalSlides = slides.length;

        function showSlide(index) {
            if (index >= totalSlides) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = totalSlides - 1;
            } else {
                currentSlide = index;
            }

            const wrapper = document.getElementById('homeCarousel');
            wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Update indicators
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });
        }

        function changeSlide(direction) {
            showSlide(currentSlide + direction);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        function startAutoSlide() {
            slideInterval = setInterval(() => {
                changeSlide(1);
            }, 5000); // Change slide every 5 seconds
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Initialize carousel
        document.addEventListener('DOMContentLoaded', function() {
            if (slides.length > 0) {
                startAutoSlide();
                
                // Pause auto-slide on hover
                const carouselContainer = document.querySelector('.carousel-container');
                carouselContainer.addEventListener('mouseenter', stopAutoSlide);
                carouselContainer.addEventListener('mouseleave', startAutoSlide);
            }
        });

        // Animated statistics counter
        function animateCounter(element, target, prefix = '', suffix = '') {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
            }, 20);
        }

        // Initialize statistics when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Load real data from backend
            loadStatistics();
            loadChartData();
            loadRecentInitiatives();
        });

        // Load statistics from backend
        async function loadStatistics() {
            try {
                const response = await fetch('/api/statistics');
                const stats = await response.json();
                updateStatistics(stats);
            } catch (error) {
                console.error('Error loading statistics:', error);
                // Fallback to dummy data if API fails
                const stats = {
                    contributions: 2847,
                    recipients: 1892,
                    initiatives: 23,
                    amount: 3245000
                };
                updateStatistics(stats);
            }
        }

        // Update statistics display
        function updateStatistics(stats) {
            // Animate large counters (these are the ones displayed on the page)
            animateCounter(document.getElementById('total-contributions-large'), stats.contributions);
            animateCounter(document.getElementById('total-recipients-large'), stats.recipients);
            animateCounter(document.getElementById('total-initiatives-large'), stats.initiatives);
            animateCounter(document.getElementById('total-amount'), stats.amount, 'RM ');
        }

        // Load chart data from backend
        async function loadChartData() {
            try {
                const response = await fetch('/api/chart-data');
                const data = await response.json();
                initializeCharts(data);
            } catch (error) {
                console.error('Error loading chart data:', error);
                // Fallback to dummy data if API fails
                const fallbackData = {
                    categoryData: {
                        'Pendidikan & Latihan': 42,
                        'Kesihatan & Kebajikan': 28,
                        'Infrastruktur & Pembangunan': 18,
                        'Bantuan Sosial': 8,
                        'Program Ekonomi': 3,
                        'Sukan & Rekreasi': 1
                    },
                    monthlyData: [
                        { month: 'Jan 2025', count: 156 },
                        { month: 'Feb 2025', count: 189 },
                        { month: 'Mar 2025', count: 234 },
                        { month: 'Apr 2025', count: 198 },
                        { month: 'Mei 2025', count: 267 },
                        { month: 'Jun 2025', count: 312 },
                        { month: 'Jul 2025', count: 289 },
                        { month: 'Ogos 2025', count: 345 },
                        { month: 'Sep 2025', count: 298 },
                        { month: 'Okt 2025', count: 376 },
                        { month: 'Nov 2025', count: 423 },
                        { month: 'Dis 2025', count: 389 }
                    ]
                };
                initializeCharts(fallbackData);
            }
        }

        // Load recent initiatives from backend
        async function loadRecentInitiatives() {
            try {
                const response = await fetch('/api/recent-initiatives');
                const initiatives = await response.json();
                displayInitiatives(initiatives);
            } catch (error) {
                console.error('Error loading initiatives:', error);
                // Fallback to dummy data if API fails
                const fallbackInitiatives = [
                    {
                        title: 'Program Bantuan Pendidikan',
                        description: 'Bantuan kewangan untuk pelajar miskin di kawasan Pilah',
                        category: 'Pendidikan & Latihan',
                        status: 'Aktif',
                        deadline: '31 Dis 2025'
                    },
                    {
                        title: 'Inisiatif Kesihatan Komuniti',
                        description: 'Program pemeriksaan kesihatan percuma untuk warga emas',
                        category: 'Kesihatan & Kebajikan',
                        status: 'Aktif',
                        deadline: '30 Nov 2025'
                    }
                ];
                displayInitiatives(fallbackInitiatives);
            }
        }

            // Animate counters
            animateCounter(document.getElementById('total-contributions'), stats.contributions);
            animateCounter(document.getElementById('total-recipients'), stats.recipients);
            animateCounter(document.getElementById('total-initiatives'), stats.initiatives);
            animateCounter(document.getElementById('total-amount'), stats.amount, 'RM ');

            // Animate large counters
            animateCounter(document.getElementById('total-contributions-large'), stats.contributions);
            animateCounter(document.getElementById('total-recipients-large'), stats.recipients);
            animateCounter(document.getElementById('total-initiatives-large'), stats.initiatives);

            // Initialize charts
            initializeCharts();
        });

        // Initialize charts with real data
        function initializeCharts(data = null) {
            try {
                // Check if Chart.js is loaded
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded');
                    showChartFallbacks();
                    return;
                }

                // Check if canvas elements exist
                const categoryCanvas = document.getElementById('categoryChart');
                const trendCanvas = document.getElementById('trendChart');
                
                if (!categoryCanvas || !trendCanvas) {
                    console.error('Chart canvas elements not found');
                    showChartFallbacks();
                    return;
                }

                // Use provided data or fallback to dummy data
                const chartData = data || {
                    categoryData: {
                        'Pendidikan & Latihan': 42,
                        'Kesihatan & Kebajikan': 28,
                        'Infrastruktur & Pembangunan': 18,
                        'Bantuan Sosial': 8,
                        'Program Ekonomi': 3,
                        'Sukan & Rekreasi': 1
                    },
                    monthlyData: [
                        { month: 'Jan 2025', count: 156 },
                        { month: 'Feb 2025', count: 189 },
                        { month: 'Mar 2025', count: 234 },
                        { month: 'Apr 2025', count: 198 },
                        { month: 'Mei 2025', count: 267 },
                        { month: 'Jun 2025', count: 312 },
                        { month: 'Jul 2025', count: 289 },
                        { month: 'Ogos 2025', count: 345 },
                        { month: 'Sep 2025', count: 298 },
                        { month: 'Okt 2025', count: 376 },
                        { month: 'Nov 2025', count: 423 },
                        { month: 'Dis 2025', count: 389 }
                    ]
                };

                // Category Chart - Sumbangan Mengikut Kategori
                const categoryCtx = categoryCanvas.getContext('2d');
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(chartData.categoryData),
                        datasets: [{
                            data: Object.values(chartData.categoryData),
                            backgroundColor: [
                                '#2563eb', // Blue - Education
                                '#0d9488', // Teal - Health
                                '#f59e0b', // Amber - Infrastructure
                                '#7c3aed', // Purple - Social
                                '#ec4899', // Pink - Economy
                                '#10b981'  // Green - Sports
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Trend Chart - Trend Bulanan
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: chartData.monthlyData.map(item => item.month),
                    datasets: [
                        {
                            label: 'Bilangan Sumbangan',
                            data: chartData.monthlyData.map(item => item.count),
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y;
                                    if (label.includes('Sumbangan')) {
                                        return `${label}: RM ${value.toLocaleString()}`;
                                    } else {
                                        return `${label}: ${value} orang`;
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Jumlah Sumbangan (RM)',
                                font: {
                                    size: 12,
                                    family: 'Inter, sans-serif'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'RM ' + value.toLocaleString();
                                },
                                font: {
                                    size: 11,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Bilangan Penerima',
                                font: {
                                    size: 12,
                                    family: 'Inter, sans-serif'
                                }
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + ' orang';
                                },
                                font: {
                                    size: 11,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        }
                    }
                }
            });
            } catch (error) {
                console.error('Error initializing charts:', error);
                showChartFallbacks();
            }
        }

        // Show fallback content when charts fail to load
        function showChartFallbacks() {
            const categoryFallback = document.getElementById('categoryChartFallback');
            const trendFallback = document.getElementById('trendChartFallback');
            
            if (categoryFallback) categoryFallback.style.display = 'flex';
            if (trendFallback) trendFallback.style.display = 'flex';
        }

        // Display initiatives in the grid
        function displayInitiatives(initiatives) {
            const initiativesGrid = document.getElementById('initiatives-grid');
            initiativesGrid.innerHTML = ''; // Clear existing content
            
            initiatives.forEach(initiative => {
                const card = document.createElement('div');
                card.className = 'initiative-card';
                card.innerHTML = `
                    <div class="initiative-header">
                        <h3 class="initiative-title">${initiative.title}</h3>
                        <span class="initiative-category">${initiative.category || 'Umum'}</span>
                    </div>
                    <p class="initiative-description">${initiative.description}</p>
                    <div class="initiative-meta">
                        <span class="initiative-status ${(initiative.status || 'Aktif').toLowerCase().replace(' ', '-')}">${initiative.status || 'Aktif'}</span>
                        <span class="initiative-deadline">Tarikh Tutup: ${initiative.deadline || 'Tidak ditetapkan'}</span>
                    </div>
                `;
                initiativesGrid.appendChild(card);
            });
        }
    </script>
@endsection