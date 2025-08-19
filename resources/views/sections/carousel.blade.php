@if($section && $section->hasImages())
    <section class="mckinsey-hero relative overflow-hidden">
        <div class="mckinsey-container relative z-10">
            <div class="carousel-wrapper flex transition-transform duration-500 ease-in-out" id="homeCarousel">
                @foreach($section->images_array as $image)
                    <div class="carousel-slide min-w-full relative">
                        <img src="{{ asset('storage/' . $image) }}" 
                             alt="{{ $section->title }}"
                             class="carousel-image w-full h-64 md:h-96 lg:h-[600px] object-cover"
                             loading="lazy">
                        <div class="carousel-content absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                            <div class="carousel-text text-white px-6 md:px-12 lg:px-16 max-w-3xl">
                                <h1 class="carousel-title text-3xl md:text-4xl lg:text-5xl font-bold mb-6 leading-tight">{{ $section->title }}</h1>
                                @if($section->content)
                                    <div class="carousel-description text-lg md:text-xl mb-8 opacity-90 leading-relaxed">
                                        {!! $section->content !!}
                                    </div>
                                @endif
                                <div class="carousel-buttons flex flex-col sm:flex-row gap-4">
                                    <a href="#statistics" class="mckinsey-btn-primary inline-flex items-center justify-center">
                                        Lihat Statistik
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </a>
                                    <a href="#initiatives" class="mckinsey-btn-secondary inline-flex items-center justify-center">
                                        Program Aktif
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(count($section->images_array) > 1)
                <!-- Carousel Navigation -->
                <button class="carousel-nav carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-4 rounded-full backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2" 
                        onclick="changeSlide(-1)"
                        aria-label="Previous slide">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="carousel-nav carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-4 rounded-full backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2" 
                        onclick="changeSlide(1)"
                        aria-label="Next slide">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    @foreach($section->images_array as $index => $image)
                        <button class="carousel-indicator w-4 h-4 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 {{ $index === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white/75' }}" 
                                onclick="goToSlide({{ $index }})"
                                aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
