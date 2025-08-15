@extends('layouts.app')

@section('content')
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
                    <div class="stat-number" id="total-contributions-large">0</div>
                    <div class="stat-label">Jumlah Sumbangan</div>
                    <div class="stat-description">Bantuan kewangan yang telah diagihkan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-recipients-large">0</div>
                    <div class="stat-label">Penerima Manfaat</div>
                    <div class="stat-description">Individu dan keluarga yang dibantu</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-initiatives-large">0</div>
                    <div class="stat-label">Inisiatif Aktif</div>
                    <div class="stat-description">Program yang sedang dijalankan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="stat-number" id="total-amount">RM 0</div>
                    <div class="stat-label">Jumlah Dana</div>
                    <div class="stat-description">Nilai bantuan yang telah diagihkan</div>
                </div>
            </div>
            
            <div class="charts-grid">
                <div class="chart-container">
                    <h3 class="chart-title">Sumbangan Mengikut Kategori</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3 class="chart-title">Trend Bulanan</h3>
                    <canvas id="trendChart"></canvas>
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
        }
        
        .initiative-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .initiative-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        
        .initiative-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .initiative-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-tertiary);
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
            // Sample data - replace with actual API calls
            const stats = {
                contributions: 1247,
                recipients: 892,
                initiatives: 15,
                amount: 2450000
            };

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
            loadInitiatives();
        });

        // Initialize charts
        function initializeCharts() {
            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pendidikan', 'Kesihatan', 'Infrastruktur', 'Sosial', 'Ekonomi'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            '#2563eb',
                            '#0d9488',
                            '#f59e0b',
                            '#7c3aed',
                            '#ec4899'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Sumbangan Bulanan',
                        data: [120, 150, 180, 200, 220, 250],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Load initiatives
        function loadInitiatives() {
            const initiativesGrid = document.getElementById('initiatives-grid');
            
            // Sample initiatives data - replace with actual API call
            const initiatives = [
                {
                    title: 'Program Bantuan Pendidikan',
                    description: 'Bantuan kewangan untuk pelajar miskin di kawasan Pilah',
                    status: 'Aktif',
                    deadline: '31 Dis 2025'
                },
                {
                    title: 'Inisiatif Kesihatan Komuniti',
                    description: 'Program pemeriksaan kesihatan percuma untuk warga emas',
                    status: 'Aktif',
                    deadline: '30 Nov 2025'
                },
                {
                    title: 'Pembangunan Infrastruktur',
                    description: 'Pembaikan jalan dan sistem saliran di kampung-kampung',
                    status: 'Dalam Perancangan',
                    deadline: '28 Feb 2026'
                }
            ];

            initiatives.forEach(initiative => {
                const card = document.createElement('div');
                card.className = 'initiative-card';
                card.innerHTML = `
                    <h3 class="initiative-title">${initiative.title}</h3>
                    <p class="initiative-description">${initiative.description}</p>
                    <div class="initiative-meta">
                        <span>Status: ${initiative.status}</span>
                        <span>Tarikh Tutup: ${initiative.deadline}</span>
                    </div>
                `;
                initiativesGrid.appendChild(card);
            });
        }
    </script>
@endsection