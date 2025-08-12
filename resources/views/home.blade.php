<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YB Dato' Zunita Begum - Transparency Dashboard</title>
    <meta name="description" content="Real-time transparency dashboard showing contributions, initiatives, and impact statistics for YB Dato' Zunita Begum's constituency work.">
    
    <!-- McKinsey Fonts with Color -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <style>
        /* McKinsey Color Palette with Accents */
        :root {
            --mckinsey-navy: #0f1419;
            --mckinsey-blue: #1f4e79;
            --mckinsey-teal: #0078d4;
            --mckinsey-gold: #ffb900;
            --mckinsey-gray: #6e6e6e;
            --mckinsey-light-gray: #f3f2f1;
            --mckinsey-white: #ffffff;
            --mckinsey-success: #107c10;
            --mckinsey-warning: #ff8c00;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--mckinsey-navy);
            line-height: 1.6;
            margin: 0;
            background-color: var(--mckinsey-white);
        }
        
        .header {
            background: linear-gradient(135deg, var(--mckinsey-navy) 0%, var(--mckinsey-blue) 100%);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .brand {
            font-family: 'Georgia', serif;
            font-size: 1.75rem;
            font-weight: 700;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        
        .nav-link:hover {
            opacity: 0.8;
        }
        
        .hero {
            background: linear-gradient(135deg, var(--mckinsey-blue) 0%, var(--mckinsey-teal) 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .hero-title {
            font-family: 'Georgia', serif;
            font-size: 3rem;
            font-weight: 400;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background: var(--mckinsey-gold);
            color: var(--mckinsey-navy);
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-weight: 600;
            border-radius: 4px;
            transition: transform 0.2s;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-weight: 600;
            border-radius: 4px;
            margin-left: 1rem;
            transition: background 0.2s;
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        
        .section-title {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--mckinsey-gray);
            margin-bottom: 3rem;
            max-width: 600px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: white;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .stat-value {
            font-family: 'Georgia', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--mckinsey-blue);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--mckinsey-gray);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }
        
        .chart-container {
            background: white;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .chart-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 1.5rem;
        }
        
        .table-container {
            background: white;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            background: var(--mckinsey-light-gray);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--mckinsey-navy);
            border-bottom: 1px solid var(--mckinsey-light-gray);
        }
        
        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--mckinsey-light-gray);
            color: var(--mckinsey-gray);
        }
        
        .table tr:hover {
            background: rgba(31, 78, 121, 0.05);
        }
        
        .footer {
            background: var(--mckinsey-navy);
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .footer-section h3 {
            font-family: 'Georgia', serif;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--mckinsey-gold);
        }
        
        .footer-section p, .footer-section a {
            color: #ccc;
            text-decoration: none;
            line-height: 1.6;
        }
        
        .footer-section a:hover {
            color: var(--mckinsey-gold);
        }
        
        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #ccc;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header with McKinsey Colors -->
    <header class="header">
        <div class="nav-container">
            <div class="brand">YB Dato' Zunita Begum</div>
            <nav class="nav-links">
                <a href="#overview" class="nav-link">Overview</a>
                <a href="#statistics" class="nav-link">Statistics</a>
                <a href="#initiatives" class="nav-link">Initiatives</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero with Gradient -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Transparency in Constituency Development</h1>
            <p class="hero-subtitle">
                Real-time insights into contributions, initiatives, and community impact across Pilah constituency.
            </p>
            <div>
                <a href="#statistics" class="btn-primary">View Dashboard</a>
                <a href="#contact" class="btn-secondary">Get in Touch</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main">
        
        <!-- Overview Section -->
        <section id="overview">
            <h2 class="section-title">Constituency Overview</h2>
            <p class="section-subtitle">
                Comprehensive tracking of development initiatives, financial contributions, and community impact across all programs.
            </p>

            <!-- Statistics Cards with Color -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value" id="total-contributions">RM 0</div>
                    <div class="stat-label">Total Contributions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="total-recipients">0</div>
                    <div class="stat-label">Recipients Served</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="total-initiatives">0</div>
                    <div class="stat-label">Active Programs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="monthly-average">RM 0</div>
                    <div class="stat-label">Monthly Average</div>
                </div>
            </div>
        </section>

        <!-- Statistics Section with Color -->
        <section id="statistics">
            <h2 class="section-title">Financial Transparency</h2>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="chart-container">
                    <h3 class="chart-title">Monthly Contribution Trends</h3>
                    <canvas id="contributionChart" width="400" height="200"></canvas>
                </div>
                
                <div class="chart-container">
                    <h3 class="chart-title">By Category</h3>
                    <canvas id="categoryChart" width="300" height="300"></canvas>
                </div>
            </div>

            <div class="chart-container">
                <h3 class="chart-title">Geographic Distribution</h3>
                <canvas id="geographicChart" width="400" height="200"></canvas>
            </div>
        </section>

        <!-- Recent Activity with Color -->
        <section id="initiatives">
            <h2 class="section-title">Recent Contributions</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody id="recent-contributions">
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: var(--mckinsey-gray);">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Footer with Color -->
    <footer class="footer">
        <div class="footer-content">
            <div>
                <h3>YB Dato' Zunita Begum</h3>
                <p>State Legislative Assembly Member for Pilah Constituency<br>
                Committed to transparency and accountability in public service.</p>
            </div>
            <div>
                <h3>Quick Links</h3>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="#overview">Overview</a>
                    <a href="#statistics">Statistics</a>
                    <a href="#initiatives">Initiatives</a>
                </div>
            </div>
            <div>
                <h3>Contact</h3>
                <p>Constituency Office<br>
                Pilah, Negeri Sembilan<br>
                Email: info@zunitabegum.my</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 YB Dato' Zunita Begum. Built for transparency and accountability.</p>
        </div>
    </footer>

    <script>
        // McKinsey Color Chart Configuration
        const mckinseyColors = {
            primary: '#1f4e79',
            secondary: '#0078d4',
            accent: '#ffb900',
            neutral: '#6e6e6e',
            light: '#f3f2f1'
        };

        // Format functions
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-MY', {
                style: 'currency',
                currency: 'MYR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('en-MY').format(num);
        }

        // Load dashboard data
        async function loadDashboardData() {
            try {
                const response = await fetch('/api/dashboard-data');
                const data = await response.json();
                
                // Update statistics with color
                document.getElementById('total-contributions').textContent = formatCurrency(data.totalContributions);
                document.getElementById('total-recipients').textContent = formatNumber(data.totalRecipients);
                document.getElementById('total-initiatives').textContent = formatNumber(data.activeInitiatives);
                document.getElementById('monthly-average').textContent = formatCurrency(data.monthlyAverage);
                
                // Initialize colorful charts
                initializeCharts(data);
                
                // Update recent contributions
                updateRecentContributions(data.recentContributions);
                
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        }

        function initializeCharts(data) {
            // Contribution Trends Chart with McKinsey Colors
            const contributionCtx = document.getElementById('contributionChart').getContext('2d');
            new Chart(contributionCtx, {
                type: 'line',
                data: {
                    labels: data.monthlyLabels,
                    datasets: [{
                        label: 'Monthly Contributions',
                        data: data.monthlyContributions,
                        borderColor: mckinseyColors.primary,
                        backgroundColor: mckinseyColors.primary + '20',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: mckinseyColors.primary,
                        pointBorderColor: mckinseyColors.accent,
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatCurrency(value);
                                }
                            }
                        }
                    }
                }
            });

            // Category Chart with McKinsey Colors
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data.categoryBreakdown),
                    datasets: [{
                        data: Object.values(data.categoryBreakdown),
                        backgroundColor: [
                            mckinseyColors.primary,
                            mckinseyColors.secondary,
                            mckinseyColors.accent,
                            mckinseyColors.neutral
                        ],
                        borderWidth: 0
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
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Geographic Chart with McKinsey Colors
            const geographicCtx = document.getElementById('geographicChart').getContext('2d');
            new Chart(geographicCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data.geographicData),
                    datasets: [{
                        label: 'Contributions by Location',
                        data: Object.values(data.geographicData),
                        backgroundColor: mckinseyColors.secondary,
                        borderColor: mckinseyColors.primary,
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatCurrency(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateRecentContributions(contributions) {
            const tbody = document.getElementById('recent-contributions');
            tbody.innerHTML = contributions.map(contribution => `
                <tr>
                    <td style="color: var(--mckinsey-navy);">${new Date(contribution.date).toLocaleDateString('en-MY')}</td>
                    <td>
                        <span style="background: ${mckinseyColors.primary}20; color: ${mckinseyColors.primary}; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                            ${contribution.category}
                        </span>
                    </td>
                    <td style="font-weight: 600; color: ${mckinseyColors.primary};">${formatCurrency(contribution.amount)}</td>
                    <td style="color: var(--mckinsey-gray);">${contribution.location || 'Pilah'}</td>
                </tr>
            `).join('');
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', loadDashboardData);
    </script>
</body>
</html>