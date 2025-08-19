@props(['statistics'])

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
                        <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-contributions">{{ $statistics['contributions'] ?? 0 }}</div>
                        <div class="stat-label text-sm md:text-base text-blue-100">Sumbangan</div>
                    </div>
                    <div class="stat-item bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105">
                        <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-recipients">{{ $statistics['recipients'] ?? 0 }}</div>
                        <div class="stat-label text-sm md:text-base text-blue-100">Penerima</div>
                    </div>
                    <div class="stat-item bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105">
                        <div class="stat-number text-3xl md:text-4xl font-bold text-yellow-400 mb-2" id="total-initiatives">{{ $statistics['initiatives'] ?? 0 }}</div>
                        <div class="stat-label text-sm md:text-base text-blue-100">Inisiatif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
