/**
 * Statistics Component
 * Handles statistics counter animations and interactions
 */
class Statistics {
    constructor() {
        this.animated = false;
        this.init();
    }

    init() {
        this.setupIntersectionObserver();
        this.setupEventListeners();
    }

    setupIntersectionObserver() {
        const statisticsSection = document.getElementById('statistics');
        if (!statisticsSection) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.animated) {
                    this.animateCounters();
                    this.animated = true;
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        });

        observer.observe(statisticsSection);
    }

    setupEventListeners() {
        // Refresh statistics on window focus (for real-time updates)
        window.addEventListener('focus', () => {
            this.refreshStatistics();
        });

        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.refreshStatistics();
            }
        });
    }

    animateCounters() {
        const counters = document.querySelectorAll('.stat-number[data-target]');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target')) || 0;
            const duration = 2000; // 2 seconds
            const step = target / (duration / 16); // 60fps
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    // Format number based on content
                    if (counter.textContent.includes('RM')) {
                        counter.textContent = `RM ${Math.floor(current).toLocaleString()}`;
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString();
                    }
                    requestAnimationFrame(updateCounter);
                } else {
                    // Final value
                    if (counter.textContent.includes('RM')) {
                        counter.textContent = `RM ${target.toLocaleString()}`;
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                }
            };

            updateCounter();
        });
    }

    async refreshStatistics() {
        try {
            const response = await fetch('/api/statistics');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const newStats = await response.json();
            this.updateStatisticsDisplay(newStats);
        } catch (error) {
            console.error('Error refreshing statistics:', error);
        }
    }

    updateStatisticsDisplay(newStats) {
        // Update hero section statistics
        const heroStats = {
            'total-contributions': newStats.contributions,
            'total-recipients': newStats.recipients,
            'total-initiatives': newStats.initiatives
        };

        Object.entries(heroStats).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value || 0;
            }
        });

        // Update main statistics section
        const mainStats = {
            'total-contributions-large': newStats.contributions,
            'total-recipients-large': newStats.recipients,
            'total-initiatives-large': newStats.initiatives,
            'total-amount': newStats.amount
        };

        Object.entries(mainStats).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                if (id === 'total-amount') {
                    element.textContent = `RM ${(value || 0).toLocaleString()}`;
                } else {
                    element.textContent = value || 0;
                }
                element.setAttribute('data-target', value || 0);
            }
        });

        // Update data attributes on statistics section
        const statisticsSection = document.getElementById('statistics');
        if (statisticsSection) {
            statisticsSection.setAttribute('data-contributions', newStats.contributions || 0);
            statisticsSection.setAttribute('data-recipients', newStats.recipients || 0);
            statisticsSection.setAttribute('data-initiatives', newStats.initiatives || 0);
            statisticsSection.setAttribute('data-amount', newStats.amount || 0);
        }
    }

    // Method to manually trigger animation (for testing)
    triggerAnimation() {
        this.animated = false;
        this.animateCounters();
    }

    // Method to reset animation state
    resetAnimation() {
        this.animated = false;
    }
}

// Initialize statistics when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.statisticsInstance = new Statistics();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Statistics;
}
