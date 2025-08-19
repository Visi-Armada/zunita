@props(['statistics'])

<section class="stats bg-gray-50 py-16 md:py-24" id="statistics" 
         data-contributions="{{ $statistics['contributions'] ?? 0 }}"
         data-recipients="{{ $statistics['recipients'] ?? 0 }}"
         data-initiatives="{{ $statistics['initiatives'] ?? 0 }}"
         data-amount="{{ $statistics['amount'] ?? 0 }}">
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
                <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-contributions-large" data-target="{{ $statistics['contributions'] ?? 0 }}">{{ $statistics['contributions'] ?? 0 }}</div>
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
                <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-recipients-large" data-target="{{ $statistics['recipients'] ?? 0 }}">{{ $statistics['recipients'] ?? 0 }}</div>
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
                <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-initiatives-large" data-target="{{ $statistics['initiatives'] ?? 0 }}">{{ $statistics['initiatives'] ?? 0 }}</div>
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
                <div class="stat-number text-3xl md:text-4xl font-bold text-gray-900 mb-2" id="total-amount" data-target="{{ $statistics['amount'] ?? 0 }}">RM {{ number_format($statistics['amount'] ?? 0, 0) }}</div>
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
