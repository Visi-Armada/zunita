<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YB Dato\' Zunita Begum - Ahli Dewan Undangan Negeri Pilah')</title>
    <meta name="description" content="@yield('description', 'Laman web rasmi YB Dato\' Zunita Begum, Ahli Dewan Undangan Negeri Pilah. Transparensi, inisiatif, dan impak untuk komuniti.')">
    
    <!-- McKinsey Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <style>
        /* Professional Color Palette */
        :root {
            /* Primary Colors */
            --primary-navy: #1e3a8a;
            --primary-blue: #2563eb;
            --primary-light-blue: #3b82f6;
            --primary-dark-blue: #1e40af;
            
            /* Secondary Colors */
            --secondary-teal: #0d9488;
            --secondary-emerald: #059669;
            --secondary-amber: #d97706;
            --secondary-rose: #e11d48;
            
            /* Neutral Colors */
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;
            
            /* Accent Colors */
            --accent-gold: #f59e0b;
            --accent-orange: #ea580c;
            --accent-purple: #7c3aed;
            --accent-pink: #ec4899;
            
            /* Status Colors */
            --success-green: #10b981;
            --success-light: #d1fae5;
            --warning-yellow: #f59e0b;
            --warning-light: #fef3c7;
            --error-red: #ef4444;
            --error-light: #fee2e2;
            --info-blue: #3b82f6;
            --info-light: #dbeafe;
            
            /* Background Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --bg-dark: #0f172a;
            
            /* Text Colors */
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-tertiary: #64748b;
            --text-light: #ffffff;
            --text-muted: #94a3b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            background-color: var(--bg-primary);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%);
            color: var(--text-light);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
            color: var(--text-light);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: var(--accent-gold);
            color: var(--text-light);
        }
        
        .btn-primary:hover {
            background: var(--accent-orange);
            transform: translateY(-1px);
        }
        
        .btn-outline {
            border: 2px solid var(--text-light);
            color: var(--text-light);
            background: transparent;
        }
        
        .btn-outline:hover {
            background: var(--text-light);
            color: var(--primary-navy);
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--neutral-900) 0%, var(--neutral-800) 100%);
            color: var(--text-light);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
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
            color: var(--accent-gold);
        }
        
        .footer-section p,
        .footer-section a {
            color: var(--neutral-300);
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
            transition: color 0.2s;
        }
        
        .footer-section a:hover {
            color: var(--accent-gold);
        }
        
        .footer-bottom {
            border-top: 1px solid var(--neutral-700);
            padding-top: 1rem;
            text-align: center;
            color: var(--neutral-400);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
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
            color: var(--text-light);
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
                background: var(--primary-navy);
                flex-direction: column;
                padding: 2rem;
                border-top: 1px solid var(--primary-light-blue);
                transform: translateY(-100%);
                transition: transform 0.3s;
            }
            
            .nav-links.active {
                transform: translateY(0);
            }
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-12 { margin-bottom: 3rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mt-16 { margin-top: 4rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-md { border-radius: 0.375rem; }
        .border { border-width: 1px; }
        .border-gray-200 { border-color: var(--neutral-200); }
        .border-gray-300 { border-color: var(--neutral-300); }
        .bg-white { background-color: var(--bg-primary); }
        .bg-gray-50 { background-color: var(--bg-secondary); }
        .bg-gray-100 { background-color: var(--bg-tertiary); }
        .bg-blue-50 { background-color: var(--info-light); }
        .bg-blue-600 { background-color: var(--primary-blue); }
        .bg-blue-700 { background-color: var(--primary-dark-blue); }
        .bg-green-100 { background-color: var(--success-light); }
        .bg-green-600 { background-color: var(--success-green); }
        .bg-green-700 { background-color: var(--secondary-emerald); }
        .bg-red-50 { background-color: var(--error-light); }
        .bg-red-200 { background-color: var(--error-light); }
        .bg-yellow-50 { background-color: var(--warning-light); }
        .bg-amber-50 { background-color: var(--warning-light); }
        .bg-teal-50 { background-color: #ccfbf1; }
        .bg-purple-50 { background-color: #f3e8ff; }
        .text-gray-500 { color: var(--text-tertiary); }
        .text-gray-600 { color: var(--text-secondary); }
        .text-gray-700 { color: var(--text-secondary); }
        .text-gray-900 { color: var(--text-primary); }
        .text-blue-600 { color: var(--primary-blue); }
        .text-blue-700 { color: var(--primary-dark-blue); }
        .text-green-600 { color: var(--success-green); }
        .text-green-700 { color: var(--secondary-emerald); }
        .text-green-800 { color: var(--secondary-emerald); }
        .text-red-500 { color: var(--error-red); }
        .text-red-700 { color: var(--error-red); }
        .text-white { color: var(--text-light); }
        .text-amber-600 { color: var(--accent-gold); }
        .text-teal-600 { color: var(--secondary-teal); }
        .text-purple-600 { color: var(--accent-purple); }
        .font-medium { font-weight: 500; }
        .font-serif { font-family: 'Georgia', serif; }
        .text-sm { font-size: 0.875rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }
        .max-w-2xl { max-width: 42rem; }
        .max-w-4xl { max-width: 56rem; }
        .max-w-none { max-width: none; }
        .w-full { width: 100%; }
        .h-5 { height: 1.25rem; }
        .h-16 { height: 4rem; }
        .w-5 { width: 1.25rem; }
        .w-16 { width: 4rem; }
        .flex { display: flex; }
        .grid { display: grid; }
        .hidden { display: none; }
        .block { display: block; }
        .inline-block { display: inline-block; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .space-y-1 > * + * { margin-top: 0.25rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .col-span-1 { grid-column: span 1 / span 1; }
        .col-span-2 { grid-column: span 2 / span 2; }
        .col-span-full { grid-column: 1 / -1; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .md\:grid-cols-2 { @media (min-width: 768px) { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .md\:grid-cols-3 { @media (min-width: 768px) { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .lg\:grid-cols-2 { @media (min-width: 1024px) { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .lg\:grid-cols-3 { @media (min-width: 1024px) { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .lg\:col-span-2 { @media (min-width: 1024px) { grid-column: span 2 / span 2; } }
        .lg\:col-span-1 { @media (min-width: 1024px) { grid-column: span 1 / span 1; } }
        .flex-col { flex-direction: column; }
        .flex-row { flex-direction: row; }
        .flex-1 { flex: 1 1 0%; }
        .flex-wrap { flex-wrap: wrap; }
        .transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; }
        .transition-shadow { transition-property: box-shadow; }
        .duration-200 { transition-duration: 200ms; }
        .duration-300 { transition-duration: 300ms; }
        .hover\:bg-blue-700:hover { background-color: var(--primary-dark-blue); }
        .hover\:bg-gray-200:hover { background-color: var(--neutral-200); }
        .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .hover\:text-gray-700:hover { color: var(--text-secondary); }
        .hover\:text-blue-800:hover { color: var(--primary-dark-blue); }
        .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .focus\:ring-2:focus { box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.5); }
        .focus\:ring-blue-600:focus { box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.5); }
        .focus\:border-blue-600:focus { border-color: var(--primary-blue); }
        .placeholder-gray-500::placeholder { color: var(--text-tertiary); }
        .resize-vertical { resize: vertical; }
        .min-h-screen { min-height: 100vh; }
        .sticky { position: sticky; }
        .top-0 { top: 0px; }
        .top-8 { top: 2rem; }
        .z-1000 { z-index: 1000; }
        .overflow-hidden { overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Prose styles for content */
        .prose { color: var(--text-secondary); }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 { color: var(--text-primary); font-weight: 600; }
        .prose p { margin-bottom: 1.25em; }
        .prose ul, .prose ol { margin-bottom: 1.25em; padding-left: 1.625em; }
        .prose li { margin-bottom: 0.5em; }
        .prose a { color: var(--primary-blue); text-decoration: underline; }
        .prose a:hover { color: var(--primary-dark-blue); }
        
        /* Responsive utilities */
        @media (min-width: 640px) {
            .sm\:flex-row { flex-direction: row; }
            .sm\:text-center { text-align: center; }
        }
        
        @media (min-width: 768px) {
            .md\:flex-row { flex-direction: row; }
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:col-span-1 { grid-column: span 1 / span 1; }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav-container">
                <div class="brand">YB Dato' Zunita Begum</div>
                
                <div class="nav-links" id="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">Utama</a>
                    <a href="{{ route('home') }}#about" class="nav-link">Tentang</a>
                    <a href="{{ route('home') }}#statistics" class="nav-link">Statistik</a>
                    <a href="{{ route('home') }}#initiatives" class="nav-link">Inisiatif</a>
                    <a href="{{ route('home') }}#contact" class="nav-link">Hubungi</a>
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

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
                    <a href="{{ route('home') }}">Utama</a>
                    <a href="{{ route('home') }}#statistics">Statistik</a>
                    <a href="{{ route('home') }}#initiatives">Inisiatif</a>
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
    </script>
    
    @stack('scripts')
</body>
</html>
