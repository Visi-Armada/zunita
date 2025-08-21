@extends('layouts.app')

@section('content')
    <!-- Carousel Section -->
    <x-carousel :carousels="$carousels" />

    <!-- Hero Section -->
    <x-hero-section :statistics="$statistics" />

    <!-- Impact Statistics Section -->
    <x-impact-stats-section :statistics="$statistics" />

    <!-- Statistics Section -->
    <x-statistics-section :statistics="$statistics" />

    <!-- About Section -->
    <section class="about bg-white py-16 md:py-24" id="about">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Tentang YB Dato' Zunita Begum</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Ahli Dewan Undangan Negeri Pilah yang komited kepada transparensi dan pembangunan komuniti</p>
            </div>
            
            <div class="about-content grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="about-text space-y-8">
                    <div class="space-y-6">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Visi & Misi</h3>
                        <div class="space-y-4 text-gray-600 leading-relaxed">
                            <p>YB Dato' Zunita Begum komited untuk memastikan transparensi penuh dalam pengurusan dana awam dan pembangunan komuniti di kawasan Pilah.</p>
                            <p>Dengan pengalaman bertahun-tahun dalam perkhidmatan awam, beliau bertekad untuk membawa perubahan positif kepada masyarakat melalui inisiatif yang berkesan dan akauntabiliti yang tinggi.</p>
                            <p>Setiap ringgit yang diperuntukkan akan dipantau dan dilaporkan secara terbuka untuk memastikan akauntabiliti kepada rakyat.</p>
                        </div>
                    </div>
                    
                    <div class="about-features space-y-6">
                        <div class="feature-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="feature-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Transparensi Penuh</h4>
                                <p class="text-gray-600">Setiap transaksi dan keputusan dipaparkan secara terbuka</p>
                            </div>
                        </div>
                        <div class="feature-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="feature-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>

                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Komuniti Teras</h4>
                                <p class="text-gray-600">Fokus kepada keperluan dan pembangunan komuniti setempat</p>
                            </div>
                        </div>
                        <div class="feature-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="feature-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Impak Berkesan</h4>
                                <p class="text-gray-600">Program yang dirancang untuk memberikan impak maksimum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl p-12 text-center border-2 border-dashed border-blue-300">
                        <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold text-blue-900">YB Dato' Zunita Begum</p>
                        <p class="text-blue-700 mt-2">Ahli Dewan Undangan Negeri Pilah</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Initiatives Section -->
    <section class="initiatives bg-gray-50 py-16 md:py-24" id="initiatives">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Inisiatif Terkini</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Program dan inisiatif yang sedang dijalankan untuk manfaat komuniti</p>
            </div>
            
            <div class="initiatives-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" id="initiatives-grid">
                <!-- Initiatives will be loaded dynamically -->
                <div class="initiative-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="animate-pulse">
                        <div class="h-48 bg-gray-200 rounded-xl mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-3 bg-gray-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                    </div>
                </div>
                <div class="initiative-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="animate-pulse">
                        <div class="h-48 bg-gray-200 rounded-xl mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-3 bg-gray-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                    </div>
                </div>
                <div class="initiative-card bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="animate-pulse">
                        <div class="h-48 bg-gray-200 rounded-xl mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-3 bg-gray-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                    </div>
                </div>
            </div>
            
            <div class="initiatives-cta text-center">
                <a href="{{ route('initiatives.index') }}" 
                   class="btn btn-primary bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Lihat Semua Inisiatif
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact bg-white py-16 md:py-24" id="contact">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Berkongsi maklum balas, aduan, atau cadangan untuk pembangunan komuniti</p>
            </div>
            
            <div class="contact-grid grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                <div class="contact-info">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Maklumat Perhubungan</h3>
                    <div class="contact-items space-y-6">
                        <div class="contact-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="contact-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h4>
                                <p class="text-gray-600">Pejabat ADUN Pilah<br>Jalan Besar, 71600 Pilah, Negeri Sembilan</p>
                            </div>
                        </div>
                        <div class="contact-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="contact-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Telefon</h4>
                                <p class="text-gray-600">06-481 1234</p>
                            </div>
                        </div>
                        <div class="contact-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="contact-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Emel</h4>
                                <p class="text-gray-600">zunita.pilah@ns.gov.my</p>
                            </div>
                        </div>
                        <div class="contact-item flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="contact-icon flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Waktu Operasi</h4>
                                <p class="text-gray-600">Isnin - Jumaat: 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Hantar Maklum Balas</h3>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Penuh</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Emel</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nombor Telefon</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                            <select id="subject" name="subject" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Pilih subjek</option>
                                <option value="aduan">Aduan</option>
                                <option value="cadangan">Cadangan</option>
                                <option value="maklum-balas">Maklum Balas</option>
                                <option value="lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mesej</label>
                            <textarea id="message" name="message" required rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Hantar Mesej
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Bar -->
    <div class="progress-bar fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-600 to-yellow-500 z-50 transition-all duration-300" id="progressBar"></div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform scale-0 opacity-0 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 z-40">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #f59e0b);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #d97706);
        }

        /* Loading animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Enhanced button hover effects */
        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover-effect:hover::before {
            left: 100%;
        }

        /* Carousel improvements */
        .carousel-section {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
            z-index: 10;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .carousel-slide {
            min-width: 100%;
            position: relative;
        }

        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-content {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            background: linear-gradient(to right, rgba(0,0,0,0.6), transparent);
        }

        .carousel-text {
            color: white;
            padding: 0 6rem;
            max-width: 32rem;
        }

        .carousel-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .carousel-description {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .carousel-button {
            display: inline-block;
            background: white;
            color: #1f2937;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .carousel-button:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.75rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            backdrop-filter: blur(4px);
            transition: all 0.2s;
        }

        .carousel-nav:hover {
            background: rgba(255,255,255,0.3);
        }

        .carousel-nav.carousel-prev {
            left: 1rem;
        }

        .carousel-nav.carousel-next {
            right: 1rem;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
        }

        .carousel-indicator {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .carousel-indicator.active {
            background: white;
        }

        .carousel-indicator:not(.active) {
            background: rgba(255,255,255,0.5);
        }

        .carousel-indicator:not(.active):hover {
            background: rgba(255,255,255,0.75);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .carousel-section {
                height: 400px;
            }

            .carousel-text {
                padding: 0 2rem;
            }

            .carousel-title {
                font-size: 1.875rem;
            }

            .carousel-description {
                font-size: 1rem;
            }

            .carousel-nav {
                padding: 0.5rem;
            }

            .carousel-nav.carousel-prev {
                left: 0.5rem;
            }

            .carousel-nav.carousel-next {
                right: 0.5rem;
            }
        }

        @media (max-width: 640px) {
            .carousel-section {
                height: 300px;
            }

            .carousel-text {
                padding: 0 1rem;
            }

            .carousel-title {
                font-size: 1.5rem;
            }

            .carousel-description {
                font-size: 0.875rem;
            }
            
            /* Chart styling */
            .chart-container {
                min-height: 400px;
            }
            
            .chart-container canvas {
                max-height: 320px;
            }
            
            @media (max-width: 768px) {
                .chart-container {
                    min-height: 350px;
                }
                
                .chart-container canvas {
                    max-height: 280px;
                }
            }
        }
    </style>


@endsection@endsection
