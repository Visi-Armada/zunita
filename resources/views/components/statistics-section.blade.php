@props(['statistics'])

<section class="statistics-section bg-white py-20 md:py-32" id="statistics">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-montserrat font-bold text-deep-blue mb-8">Statistik Impak</h2>
            <p class="text-xl text-dark-gray max-w-4xl mx-auto leading-relaxed font-open-sans">
                Melihat kesan sumbangan kami dalam membantu komuniti dan individu yang memerlukan
            </p>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
            <!-- Contributions Card -->
            <div class="stat-card-primary bg-white rounded-2xl p-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-primary mb-8">
                    <div class="w-12 h-12 bg-deep-blue rounded-xl flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-primary mb-6 text-center text-deep-blue" id="total-contributions-large" data-target="{{ $statistics['contributions'] ?? 0 }}">{{ $statistics['contributions'] ?? 0 }}</div>
                <div class="stat-label-primary mb-4 text-center text-dark-gray">Sumbangan</div>
                <div class="stat-description-primary text-center text-gray-600">Bantuan kewangan yang telah diagihkan</div>
            </div>

            <!-- Recipients Card -->
            <div class="stat-card-primary bg-white rounded-2xl p-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-primary mb-8">
                    <div class="w-12 h-12 bg-deep-blue rounded-xl flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-primary mb-6 text-center text-deep-blue" id="total-recipients-large" data-target="{{ $statistics['recipients'] ?? 0 }}">{{ $statistics['recipients'] ?? 0 }}</div>
                <div class="stat-label-primary mb-4 text-center text-dark-gray">Penerima</div>
                <div class="stat-description-primary text-center text-gray-600">Individu dan keluarga yang dibantu</div>
            </div>

            <!-- Initiatives Card -->
            <div class="stat-card-primary bg-white rounded-2xl p-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-primary mb-8">
                    <div class="w-12 h-12 bg-deep-blue rounded-xl flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-primary mb-6 text-center text-deep-blue" id="total-initiatives-large" data-target="{{ $statistics['initiatives'] ?? 0 }}">{{ $statistics['initiatives'] ?? 0 }}</div>
                <div class="stat-label-primary mb-4 text-center text-dark-gray">Inisiatif</div>
                <div class="stat-description-primary text-center text-gray-600">Program yang sedang dijalankan</div>
            </div>

            <!-- Total Amount Card -->
            <div class="stat-card-primary bg-white rounded-2xl p-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-primary mb-8">
                    <div class="w-12 h-12 bg-deep-blue rounded-xl flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-primary mb-6 text-center text-deep-blue" id="total-amount-large" data-target="{{ $statistics['amount'] ?? 0 }}">RM {{ number_format($statistics['amount'] ?? 0) }}</div>
                <div class="stat-label-primary mb-4 text-center text-dark-gray">Jumlah Dana</div>
                <div class="stat-description-primary text-center text-gray-600">Nilai bantuan yang telah diagihkan</div>
            </div>
        </div>

        <!-- Additional Impact Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Average Contribution -->
            <div class="stat-card-secondary bg-white rounded-xl p-8 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-secondary mb-6">
                    <div class="w-10 h-10 bg-muted-gold rounded-lg flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-secondary mb-4 text-deep-blue">RM {{ number_format($statistics['average_contribution'] ?? 0) }}</div>
                <div class="stat-label-secondary mb-3 text-dark-gray">Purata Sumbangan</div>
                <div class="stat-description-secondary text-gray-600">Nilai purata setiap bantuan</div>
            </div>

            <!-- Success Rate -->
            <div class="stat-card-secondary bg-white rounded-xl p-8 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-secondary mb-6">
                    <div class="w-10 h-10 bg-deep-blue rounded-lg flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-secondary mb-4 text-deep-blue">{{ number_format($statistics['success_rate'] ?? 0, 1) }}%</div>
                <div class="stat-label-secondary mb-3 text-dark-gray">Kadar Kejayaan</div>
                <div class="stat-description-secondary text-gray-600">Program yang berjaya diselesaikan</div>
            </div>

            <!-- Recent Activity -->
            <div class="stat-card-secondary bg-white rounded-xl p-8 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                <div class="stat-icon-secondary mb-6">
                    <div class="w-10 h-10 bg-deep-blue rounded-lg flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number-secondary mb-4 text-deep-blue">{{ is_array($statistics['recent_activity'] ?? 0) ? ($statistics['recent_activity']['last_30_days'] ?? 0) : ($statistics['recent_activity'] ?? 0) }}</div>
                <div class="stat-label-secondary mb-3 text-dark-gray">Aktiviti Terkini</div>
                <div class="stat-description-secondary text-gray-600">Sumbangan dalam 30 hari lepas</div>
            </div>
        </div>
    </div>
</section>
