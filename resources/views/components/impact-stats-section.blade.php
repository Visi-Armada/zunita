@props(['statistics'])

<section class="impact-stats-section bg-deep-blue py-20 md:py-32" id="impact-stats">
    <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-montserrat font-bold text-white mb-6">Impak Kami</h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed font-open-sans">
                Melihat kesan sumbangan kami dalam membantu komuniti dan individu yang memerlukan
            </p>
        </div>

        <!-- Two-Column Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-20">
            <!-- Left Column - Contributions -->
            <div class="impact-stat-card text-center p-12 lg:p-16">
                <!-- Icon Container with Proper Sizing -->
                <div class="icon-container mb-8 flex justify-center">
                    <div class="w-32 h-32 lg:w-40 lg:h-40 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto border border-white/20">
                        <svg class="w-16 h-16 lg:w-20 lg:h-20 text-white fill-current" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Statistics Content -->
                <div class="stat-content">
                    <div class="stat-number text-5xl md:text-6xl lg:text-7xl font-montserrat font-bold text-white mb-4" id="impact-contributions" data-target="{{ $statistics['contributions'] ?? 0 }}">
                        {{ $statistics['contributions'] ?? 0 }}
                    </div>
                    <div class="stat-label text-2xl md:text-3xl font-montserrat font-semibold text-white mb-3">Sumbangan</div>
                    <div class="stat-description text-lg text-blue-100 font-open-sans leading-relaxed">
                        Bantuan kewangan yang telah diagihkan
                    </div>
                </div>
            </div>

            <!-- Right Column - Recipients -->
            <div class="impact-stat-card text-center p-12 lg:p-16">
                <!-- Icon Container with Proper Sizing -->
                <div class="icon-container mb-8 flex justify-center">
                    <div class="w-32 h-32 lg:w-40 lg:h-40 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto border border-white/20">
                        <svg class="w-16 h-16 lg:w-20 lg:h-20 text-white fill-current" viewBox="0 0 24 24">
                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.54 8H17c-.8 0-1.54.37-2.01 1l-1.7 2.26c-.17.22-.27.48-.29.76V16h-1v6h-2v-6h-1v-1.5c0-.28-.12-.54-.29-.76L9.01 9A2.5 2.5 0 0 0 7 8H5.46c-.8 0-1.54.37-2.01 1L.96 16.37A1.5 1.5 0 0 0 2.5 18H5v6h2v-6h1v6h2v-6h1v6h2v-6h1z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Statistics Content -->
                <div class="stat-content">
                    <div class="stat-number text-5xl md:text-6xl lg:text-7xl font-montserrat font-bold text-white mb-4" id="impact-recipients" data-target="{{ $statistics['recipients'] ?? 0 }}">
                        {{ $statistics['recipients'] ?? 0 }}
                    </div>
                    <div class="stat-label text-2xl md:text-3xl font-montserrat font-semibold text-white mb-3">Penerima</div>
                    <div class="stat-description text-lg text-blue-100 font-open-sans leading-relaxed">
                        Individu dan keluarga yang dibantu
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Impact Stats Section Specific Styles */
.impact-stats-section {
    background: linear-gradient(135deg, #163E93 0%, #1e40af 100%);
    position: relative;
    overflow: hidden;
}

.impact-stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
    pointer-events: none;
}

.impact-stat-card {
    position: relative;
    z-index: 10;
    transition: all 0.3s ease;
}

.impact-stat-card:hover {
    transform: translateY(-4px);
}

.icon-container {
    position: relative;
}

.icon-container::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    z-index: -1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .impact-stat-card {
        padding: 2rem;
    }
    
    .icon-container .w-32 {
        width: 6rem;
        height: 6rem;
    }
    
    .icon-container .w-16 {
        width: 3rem;
        height: 3rem;
    }
    
    .stat-number {
        font-size: 3rem;
    }
    
    .stat-label {
        font-size: 1.5rem;
    }
    
    .stat-description {
        font-size: 1rem;
    }
}

@media (max-width: 640px) {
    .impact-stat-card {
        padding: 1.5rem;
    }
    
    .icon-container .w-32 {
        width: 5rem;
        height: 5rem;
    }
    
    .icon-container .w-16 {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
    
    .stat-label {
        font-size: 1.25rem;
    }
}
</style>
