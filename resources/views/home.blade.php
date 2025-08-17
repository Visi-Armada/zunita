@extends('layouts.app')

@section('content')
    <!-- Carousel Section -->
    @if($carousels->count() > 0)
        <section class="carousel-section relative overflow-hidden">
            <div class="carousel-container relative">
                <div class="carousel-wrapper flex transition-transform duration-500 ease-in-out" id="homeCarousel">
                    @foreach($carousels as $carousel)
                        <div class="carousel-slide min-w-full relative">
                            <img src="{{ asset('storage/' . $carousel->image) }}" 
                                 alt="{{ $carousel->alt_text ?? $carousel->title }}"
                                 class="carousel-image w-full h-64 md:h-96 lg:h-[500px] object-cover"
                                 loading="lazy">
                            <div class="carousel-content absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                                <div class="carousel-text text-white px-6 md:px-12 lg:px-16 max-w-2xl">
                                    <h2 class="carousel-title text-2xl md:text-3xl lg:text-4xl font-bold mb-4 leading-tight">{{ $carousel->title }}</h2>
                                    @if($carousel->description)
                                        <p class="carousel-description text-sm md:text-base lg:text-lg mb-6 opacity-90">{{ $carousel->description }}</p>
                                    @endif
                                    @if($carousel->button_text && $carousel->link_url)
                                        <a href="{{ $carousel->link_url }}" 
                                           class="carousel-button inline-block bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent">
                                            {{ $carousel->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Carousel Navigation -->
                <button class="carousel-nav carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2" 
                        onclick="changeSlide(-1)"
                        aria-label="Previous slide">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="carousel-nav carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2" 
                        onclick="changeSlide(1)"
                        aria-label="Next slide">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    @foreach($carousels as $index => $carousel)
                        <button class="carousel-indicator w-3 h-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 {{ $index === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white/75' }}" 
                                onclick="goToSlide({{ $index }})"
                                aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Hero Section -->
    <section class="hero bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white py-16 md:py-24 lg:py-32 relative overflow-hidden" id="home">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="hero-content space-y-8">
                    <div class="space-y-6">
                        <h1 class="hero-title text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            <span class="bg-gradient-to-r from-white via-yellow-200 to-yellow-400 bg-clip-text text-transparent">
                                Transparensi & Impak
                            </span>
                        </h1>
                        <p class="hero-subtitle text-lg md:text-xl text-blue-100 leading-relaxed max-w-2xl">
                            Laman web rasmi YB Dato' Zunita Begum, Ahli Dewan Undangan Negeri Pilah. Memaparkan transparensi penuh dalam pengurusan dana awam dan inisiatif komuniti.
                        </p>
                    </div>
                    
                    <div class="hero-buttons flex flex-col sm:flex-row gap-4">
                        <a href="#statistics" 
                           class="btn btn-primary bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-gray-900 font-semibold px-8 py-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 focus:ring-offset-blue-900 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Lihat Statistik
                        </a>
                        <a href="{{ route('initiatives.index') }}" 
                           class="btn btn-secondary bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-900 font-semibold px-8 py-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Program Aktif
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="hero-stats grid grid-cols-3 gap-4 md:gap-6">
                        <div class="stat-item bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105">
                            <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-contributions">0</div>
                            <div class="stat-label text-sm md:text-base text-blue-100">Sumbangan</div>
                        </div>
                        <div class="stat-item bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105">
                            <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-recipients">0</div>
                            <div class="stat-label text-sm md:text-base text-blue-100">Penerima</div>
                        </div>
                        <div class="stat-item bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105">
                            <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-initiatives">0</div>
                            <div class="stat-label text-sm md:text-base text-blue-100">Inisiatif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats bg-gray-50 py-16 md:py-24" id="statistics">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Statistik Transparensi</h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Data terkini mengenai sumbangan dan impak untuk komuniti Pilah</p>
            </div>
            
            <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-16">
                <div class="stat-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="stat-icon mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-contributions-large" data-target="{{ $statistics['contributions'] ?? 0 }}">0</div>
                    <div class="stat-label text-lg font-semibold text-gray-700 mb-2">Jumlah Sumbangan</div>
                    <div class="stat-description text-gray-500">Bantuan kewangan yang telah diagihkan</div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="stat-icon mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-recipients-large" data-target="{{ $statistics['recipients'] ?? 0 }}">0</div>
                    <div class="stat-label text-lg font-semibold text-gray-700 mb-2">Penerima Manfaat</div>
                    <div class="stat-description text-gray-500">Individu dan keluarga yang dibantu</div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="stat-icon mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-initiatives-large" data-target="{{ $statistics['initiatives'] ?? 0 }}">0</div>
                    <div class="stat-label text-lg font-semibold text-gray-700 mb-2">Inisiatif Aktif</div>
                    <div class="stat-description text-gray-500">Program yang sedang dijalankan</div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="stat-icon mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-amount" data-target="{{ $statistics['amount'] ?? 0 }}">RM 0</div>
                    <div class="stat-label text-lg font-semibold text-gray-700 mb-2">Jumlah Dana</div>
                    <div class="stat-description text-gray-500">Nilai bantuan yang telah diagihkan</div>
                </div>
            </div>
            
            <div class="charts-grid grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="chart-container bg-white rounded-2xl p-6 md:p-8 shadow-lg">
                    <h3 class="chart-title text-xl md:text-2xl font-bold text-gray-900 mb-6">Sumbangan Mengikut Kategori</h3>
                    <div class="relative h-64 md:h-80">
                        <canvas id="categoryChart" class="w-full h-full"></canvas>
                        <div id="categoryChartFallback" class="chart-fallback absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg" style="display: none;">
                            <div class="fallback-content text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                <p class="text-gray-600">Data sedang dimuatkan...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chart-container bg-white rounded-2xl p-6 md:p-8 shadow-lg">
                    <h3 class="chart-title text-xl md:text-2xl font-bold text-gray-900 mb-6">Trend Bulanan</h3>
                    <div class="relative h-64 md:h-80">
                        <canvas id="trendChart" class="w-full h-full"></canvas>
                        <div id="trendChartFallback" class="chart-fallback absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg" style="display: none;">
                            <div class="fallback-content text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                <p class="text-gray-600">Data sedang dimuatkan...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        }
    </style>

    <script>
        // Progress bar functionality
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                progressBar.style.width = scrollPercent + '%';
            }
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('scale-0', 'opacity-0');
                backToTopButton.classList.add('scale-100', 'opacity-100');
            } else {
                backToTopButton.classList.add('scale-0', 'opacity-0');
                backToTopButton.classList.remove('scale-100', 'opacity-100');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const wrapper = document.getElementById('homeCarousel');

        function showSlide(index) {
            if (index >= slides.length) index = 0;
            if (index < 0) index = slides.length - 1;
            
            currentSlide = index;
            wrapper.style.transform = `translateX(-${index * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('active');
                    indicator.classList.remove('bg-white/50');
                    indicator.classList.add('bg-white');
                } else {
                    indicator.classList.remove('active');
                    indicator.classList.remove('bg-white');
                    indicator.classList.add('bg-white/50');
                }
            });
        }

        function changeSlide(direction) {
            showSlide(currentSlide + direction);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        // Auto-advance carousel
        setInterval(() => {
            changeSlide(1);
        }, 5000);

        // Statistics counter animation
        function animateCounter(element, target, prefix = '', suffix = '') {
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                if (prefix === 'RM ') {
                    element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                } else {
                    element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                }
            }, 16);
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    
                    // Animate statistics when they come into view
                    if (entry.target.id === 'statistics') {
                        const statElements = [
                            { element: document.getElementById('total-contributions-large'), target: parseInt(entry.target.dataset.contributions || 0) },
                            { element: document.getElementById('total-recipients-large'), target: parseInt(entry.target.dataset.recipients || 0) },
                            { element: document.getElementById('total-initiatives-large'), target: parseInt(entry.target.dataset.initiatives || 0) },
                            { element: document.getElementById('total-amount'), target: parseInt(entry.target.dataset.amount || 0), prefix: 'RM ' }
                        ];
                        
                        statElements.forEach(stat => {
                            if (stat.element && stat.target > 0) {
                                animateCounter(stat.element, stat.target, stat.prefix || '', stat.suffix || '');
                            }
                        });
                    }
                }
            });
        }, observerOptions);

        // Observe sections for animation
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                observer.observe(section);
            });
        });

        // Enhanced form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.contact-form form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Add loading state
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Menghantar...';
                    submitButton.disabled = true;
                    
                    // Simulate form submission (replace with actual form handling)
                    setTimeout(() => {
                        submitButton.textContent = 'Mesej Dihantar!';
                        submitButton.classList.remove('from-blue-600', 'to-blue-700', 'hover:from-blue-700', 'hover:to-blue-800');
                        submitButton.classList.add('from-green-600', 'to-green-700');
                        
                        setTimeout(() => {
                            submitButton.textContent = originalText;
                            submitButton.disabled = false;
                            submitButton.classList.remove('from-green-600', 'to-green-700');
                            submitButton.classList.add('from-blue-600', 'to-blue-700', 'hover:from-blue-700', 'hover:to-blue-800');
                            form.reset();
                        }, 2000);
                    }, 1500);
                });
            }
        });

        // Keyboard navigation for carousel
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                changeSlide(-1);
            } else if (e.key === 'ArrowRight') {
                changeSlide(1);
            }
        });

        // Touch/swipe support for carousel
        let touchStartX = 0;
        let touchEndX = 0;

        wrapper.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        wrapper.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left
                    changeSlide(1);
                } else {
                    // Swipe right
                    changeSlide(-1);
                }
            }
        }
    </script>
@endsection