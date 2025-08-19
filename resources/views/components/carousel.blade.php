@props(['carousels'])

@if($carousels->count() > 0)
    <section class="carousel-section relative overflow-hidden">
        <div class="carousel-container relative">
            <div class="carousel-wrapper flex transition-transform duration-500 ease-in-out" id="homeCarousel">
                @foreach($carousels as $carousel)
                    <div class="carousel-slide min-w-full relative">
                        <img src="{{ asset('storage/' . $carousel->image) }}" 
                             alt="{{ $carousel->alt_text ?? $carousel->title }}"
                             class="carousel-image w-full h-64 md:h-96 lg:h-[500px] object-cover"
                             loading="lazy"
                             decoding="async"
                             fetchpriority="high">
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
