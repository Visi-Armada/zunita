/**
 * Carousel Component
 * Handles carousel functionality for the homepage
 */
class Carousel {
    constructor(containerId = 'homeCarousel') {
        this.container = document.getElementById(containerId);
        this.currentSlide = 0;
        this.slides = [];
        this.indicators = [];
        this.autoPlayInterval = null;
        this.autoPlayDelay = 5000; // 5 seconds
        
        this.init();
    }

    init() {
        if (!this.container) {
            console.warn('Carousel container not found');
            return;
        }

        this.slides = this.container.querySelectorAll('.carousel-slide');
        this.indicators = document.querySelectorAll('.carousel-indicator');
        
        if (this.slides.length === 0) {
            return;
        }

        this.setupEventListeners();
        this.startAutoPlay();
        this.updateIndicators();
    }

    setupEventListeners() {
        // Navigation buttons
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');

        if (prevButton) {
            prevButton.addEventListener('click', () => this.changeSlide(-1));
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => this.changeSlide(1));
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                this.changeSlide(-1);
            } else if (e.key === 'ArrowRight') {
                this.changeSlide(1);
            }
        });

        // Touch/swipe support
        let startX = 0;
        let endX = 0;

        this.container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        this.container.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            this.handleSwipe(startX, endX);
        });

        // Pause autoplay on hover
        this.container.addEventListener('mouseenter', () => this.pauseAutoPlay());
        this.container.addEventListener('mouseleave', () => this.startAutoPlay());
    }

    changeSlide(direction) {
        const totalSlides = this.slides.length;
        
        if (direction === 1) {
            this.currentSlide = (this.currentSlide + 1) % totalSlides;
        } else {
            this.currentSlide = (this.currentSlide - 1 + totalSlides) % totalSlides;
        }

        this.updateSlide();
        this.updateIndicators();
        this.resetAutoPlay();
    }

    goToSlide(index) {
        if (index >= 0 && index < this.slides.length) {
            this.currentSlide = index;
            this.updateSlide();
            this.updateIndicators();
            this.resetAutoPlay();
        }
    }

    updateSlide() {
        const translateX = -this.currentSlide * 100;
        this.container.style.transform = `translateX(${translateX}%)`;
    }

    updateIndicators() {
        this.indicators.forEach((indicator, index) => {
            if (index === this.currentSlide) {
                indicator.classList.add('bg-white');
                indicator.classList.remove('bg-white/50');
            } else {
                indicator.classList.remove('bg-white');
                indicator.classList.add('bg-white/50');
            }
        });
    }

    handleSwipe(startX, endX) {
        const threshold = 50;
        const diff = startX - endX;

        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                this.changeSlide(1); // Swipe left
            } else {
                this.changeSlide(-1); // Swipe right
            }
        }
    }

    startAutoPlay() {
        if (this.slides.length <= 1) return;
        
        this.autoPlayInterval = setInterval(() => {
            this.changeSlide(1);
        }, this.autoPlayDelay);
    }

    pauseAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }

    resetAutoPlay() {
        this.pauseAutoPlay();
        this.startAutoPlay();
    }

    destroy() {
        this.pauseAutoPlay();
        // Remove event listeners if needed
    }
}

// Global functions for backward compatibility
window.changeSlide = function(direction) {
    if (window.carouselInstance) {
        window.carouselInstance.changeSlide(direction);
    }
};

window.goToSlide = function(index) {
    if (window.carouselInstance) {
        window.carouselInstance.goToSlide(index);
    }
};

// Initialize carousel when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.carouselInstance = new Carousel();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Carousel;
}
