/**
 * Charts Component
 * Handles chart initialization and data visualization
 */
class Charts {
    constructor() {
        this.charts = {};
        this.chartData = null;
        this.init();
    }

    async init() {
        try {
            await this.loadChartData();
            this.initializeCharts();
        } catch (error) {
            console.error('Failed to initialize charts:', error);
            this.showFallbackContent();
        }
    }

    async loadChartData() {
        try {
            const response = await fetch('/api/chart-data');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            this.chartData = await response.json();
        } catch (error) {
            console.error('Error loading chart data:', error);
            throw error;
        }
    }

    initializeCharts() {
        this.initializeCategoryChart();
        this.initializeTrendChart();
    }

    initializeCategoryChart() {
        const categoryCtx = document.getElementById('categoryChart');
        if (!categoryCtx || !this.chartData?.categoryData) {
            this.showFallbackContent('categoryChartFallback');
            return;
        }

        try {
            this.charts.categoryChart = new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(this.chartData.categoryData),
                    datasets: [{
                        data: Object.values(this.chartData.categoryData),
                        backgroundColor: [
                            '#3B82F6', // blue
                            '#10B981', // green
                            '#8B5CF6', // purple
                            '#F59E0B', // yellow
                            '#EF4444', // red
                            '#06B6D4'  // cyan
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error initializing category chart:', error);
            this.showFallbackContent('categoryChartFallback');
        }
    }

    initializeTrendChart() {
        const trendCtx = document.getElementById('trendChart');
        if (!trendCtx || !this.chartData?.monthlyData) {
            this.showFallbackContent('trendChartFallback');
            return;
        }

        try {
            this.charts.trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: this.chartData.monthlyData.map(item => item.month),
                    datasets: [{
                        label: 'Sumbangan Bulanan',
                        data: this.chartData.monthlyData.map(item => item.count),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#3B82F6',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6B7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6B7280'
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        } catch (error) {
            console.error('Error initializing trend chart:', error);
            this.showFallbackContent('trendChartFallback');
        }
    }

    showFallbackContent(fallbackId = null) {
        if (fallbackId) {
            const fallback = document.getElementById(fallbackId);
            if (fallback) {
                fallback.style.display = 'flex';
            }
        } else {
            // Show all fallbacks
            document.querySelectorAll('.chart-fallback').forEach(fallback => {
                fallback.style.display = 'flex';
            });
        }
    }

    updateCharts(newData) {
        this.chartData = newData;
        
        if (this.charts.categoryChart) {
            this.charts.categoryChart.destroy();
        }
        if (this.charts.trendChart) {
            this.charts.trendChart.destroy();
        }
        
        this.initializeCharts();
    }

    destroy() {
        Object.values(this.charts).forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        this.charts = {};
    }
}

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.chartsInstance = new Charts();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Charts;
}
