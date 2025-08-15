<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YB Dato' Zunita Begum - Ahli Dewan Undangan Negeri Pilah</title>
    <meta name="description" content="Laman web rasmi YB Dato' Zunita Begum, Ahli Dewan Undangan Negeri Pilah. Transparensi, inisiatif, dan impak untuk komuniti.">
    
    <!-- McKinsey Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <style>
        /* McKinsey Color Palette */
        :root {
            --mckinsey-navy: #0f1419;
            --mckinsey-blue: #1f4e79;
            --mckinsey-teal: #0078d4;
            --mckinsey-gold: #ffb900;
            --mckinsey-gray: #6e6e6e;
            --mckinsey-light-gray: #f3f2f1;
            --mckinsey-white: #ffffff;
            --mckinsey-success: #107c10;
            --mckinsey-warning: #ff8c00;
            --mckinsey-black: #1a1a1a;
            --mckinsey-dark-gray: #4a4a4a;
            --mckinsey-medium-gray: #8a8a8a;
            --mckinsey-lightest-gray: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--mckinsey-black);
            line-height: 1.6;
            background-color: var(--mckinsey-white);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Header */
        .header {
            background: var(--mckinsey-white);
            border-bottom: 1px solid var(--mckinsey-light-gray);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .brand {
            font-family: 'Georgia', serif;
            font-size: 1.75rem;
            font-weight: 400;
            color: var(--mckinsey-black);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--mckinsey-black);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            font-size: 0.875rem;
        }
        
        .nav-link:hover {
            color: var(--mckinsey-blue);
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: var(--mckinsey-blue);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--mckinsey-navy);
        }
        
        .btn-outline {
            border: 1px solid var(--mckinsey-blue);
            color: var(--mckinsey-blue);
            background: transparent;
        }
        
        .btn-outline:hover {
            background: var(--mckinsey-blue);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: var(--mckinsey-lightest-gray);
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-family: 'Georgia', serif;
            font-size: 3rem;
            font-weight: 400;
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--mckinsey-dark-gray);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Statistics Section */
        .stats {
            padding: 4rem 0;
            background: var(--mckinsey-white);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-header h2 {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 400;
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        .section-header p {
            font-size: 1.125rem;
            color: var(--mckinsey-dark-gray);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: var(--mckinsey-white);
            border: 1px solid var(--mckinsey-light-gray);
            padding: 2rem;
            text-align: center;
        }
        
        .stat-number {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--mckinsey-blue);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1rem;
            color: var(--mckinsey-dark-gray);
            font-weight: 500;
        }
        
        /* Charts Section */
        .charts {
            padding: 4rem 0;
            background: var(--mckinsey-lightest-gray);
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }
        
        .chart-container {
            background: var(--mckinsey-white);
            border: 1px solid var(--mckinsey-light-gray);
            padding: 2rem;
        }
        
        .chart-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        /* Initiatives Section */
        .initiatives {
            padding: 4rem 0;
            background: var(--mckinsey-white);
        }
        
        .initiatives-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .initiative-card {
            background: var(--mckinsey-white);
            border: 1px solid var(--mckinsey-light-gray);
            padding: 2rem;
            transition: transform 0.2s;
        }
        
        .initiative-card:hover {
            transform: translateY(-2px);
        }
        
        .initiative-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        .initiative-description {
            color: var(--mckinsey-dark-gray);
            margin-bottom: 1.5rem;
        }
        
        .initiative-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--mckinsey-medium-gray);
        }
        
        /* About Section */
        .about {
            padding: 4rem 0;
            background: var(--mckinsey-lightest-gray);
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .about-text h3 {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        .about-text p {
            color: var(--mckinsey-dark-gray);
            margin-bottom: 1.5rem;
        }
        
        .about-image {
            text-align: center;
        }
        
        .about-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        /* Contact Section */
        .contact {
            padding: 4rem 0;
            background: var(--mckinsey-white);
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
            color: var(--mckinsey-black);
            margin-bottom: 1rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .contact-item i {
            margin-right: 1rem;
            color: var(--mckinsey-blue);
        }
        
        .contact-form {
            background: var(--mckinsey-lightest-gray);
            padding: 2rem;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--mckinsey-black);
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
        }
        
        .form-group textarea {
            height: 120px;
            resize: vertical;
        }
        
        /* Footer */
        .footer {
            background: var(--mckinsey-black);
            color: var(--mckinsey-white);
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h4 {
            font-family: 'Georgia', serif;
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 1rem;
        }
        
        .footer-section p,
        .footer-section a {
            color: var(--mckinsey-light-gray);
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .footer-section a:hover {
            color: var(--mckinsey-white);
        }
        
        .footer-bottom {
            border-top: 1px solid var(--mckinsey-dark-gray);
            padding-top: 1rem;
            text-align: center;
            color: var(--mckinsey-medium-gray);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .about-content,
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 1rem;
            }
        }
        
        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--mckinsey-black);
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--mckinsey-white);
                flex-direction: column;
                padding: 2rem;
                border-top: 1px solid var(--mckinsey-light-gray);
                transform: translateY(-100%);
                transition: transform 0.3s;
            }
            
            .nav-links.active {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav-container">
                <div class="brand">YB Dato' Zunita Begum</div>
                
                <div class="nav-links" id="nav-links">
                    <a href="#home" class="nav-link">Utama</a>
                    <a href="#about" class="nav-link">Tentang</a>
                    <a href="#statistics" class="nav-link">Statistik</a>
                    <a href="#initiatives" class="nav-link">Inisiatif</a>
                    <a href="#contact" class="nav-link">Hubungi</a>
                    <a href="{{ route('initiatives.index') }}" class="nav-link">Program</a>
                </div>
                
                <div class="auth-buttons">
                    @auth('public')
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                        <form method="POST" action="{{ route('public.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline">Log Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('public.login') }}" class="btn btn-outline">Log Masuk</a>
                        <a href="{{ route('public.register') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
                
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    ☰
                </button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>Transparensi & Impak</h1>
            <p>Laman web rasmi YB Dato' Zunita Begum, Ahli Dewan Undangan Negeri Pilah. Memaparkan transparensi penuh dalam pengurusan dana awam dan inisiatif komuniti.</p>
            <a href="#statistics" class="btn btn-primary">Lihat Statistik</a>
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
                    <div class="stat-number" id="total-contributions">0</div>
                    <div class="stat-label">Jumlah Sumbangan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="total-recipients">0</div>
                    <div class="stat-label">Penerima Manfaat</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="total-initiatives">0</div>
                    <div class="stat-label">Inisiatif Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="total-amount">RM 0</div>
                    <div class="stat-label">Jumlah Dana</div>
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
                </div>
                <div class="about-image">
                    <img src="/images/placeholder-profile.jpg" alt="YB Dato' Zunita Begum" onerror="this.style.display='none'">
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
            
            <div style="text-align: center; margin-top: 2rem;">
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
                    <div class="contact-item">
                        <i>📍</i>
                        <span>Pejabat ADUN Pilah<br>Jalan Besar, 71600 Pilah, Negeri Sembilan</span>
                    </div>
                    <div class="contact-item">
                        <i>📞</i>
                        <span>06-481 1234</span>
                    </div>
                    <div class="contact-item">
                        <i>✉️</i>
                        <span>zunita.pilah@ns.gov.my</span>
                    </div>
                    <div class="contact-item">
                        <i>🕒</i>
                        <span>Isnin - Jumaat: 8:00 AM - 5:00 PM</span>
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>YB Dato' Zunita Begum</h4>
                    <p>Ahli Dewan Undangan Negeri Pilah</p>
                    <p>Komited kepada transparensi dan pembangunan komuniti</p>
                </div>
                <div class="footer-section">
                    <h4>Pautan Pantas</h4>
                    <a href="#home">Utama</a>
                    <a href="#statistics">Statistik</a>
                    <a href="#initiatives">Inisiatif</a>
                    <a href="{{ route('initiatives.index') }}">Program</a>
                </div>
                <div class="footer-section">
                    <h4>Perhubungan</h4>
                    <p>Pejabat ADUN Pilah</p>
                    <p>Jalan Besar, 71600 Pilah</p>
                    <p>Negeri Sembilan</p>
                </div>
                <div class="footer-section">
                    <h4>Media Sosial</h4>
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">Twitter</a>
                    <a href="#">YouTube</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 YB Dato' Zunita Begum. Hak cipta terpelihara. | Laman web ini dibangunkan dengan transparensi penuh.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const navLinks = document.getElementById('nav-links');
            navLinks.classList.toggle('active');
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
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
                            '#1f4e79',
                            '#0078d4',
                            '#6e6e6e',
                            '#8a8a8a',
                            '#c4c4c4'
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
                        borderColor: '#1f4e79',
                        backgroundColor: 'rgba(31, 78, 121, 0.1)',
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
</body>
</html>