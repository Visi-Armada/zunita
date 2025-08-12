<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - YB Dato' Zunita Begum</title>
    
    <!-- McKinsey Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
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
            --mckinsey-error: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--mckinsey-navy);
            line-height: 1.6;
            background-color: var(--mckinsey-light-gray);
        }

        .header {
            background: white;
            border-bottom: 1px solid var(--mckinsey-light-gray);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--mckinsey-navy);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--mckinsey-navy);
        }

        .btn-logout {
            background: var(--mckinsey-blue);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: var(--mckinsey-navy);
        }

        .main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-section {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-title {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--mckinsey-gray);
            font-size: 1.125rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-title {
            font-family: 'Georgia', serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 1rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-card {
            background: white;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: var(--mckinsey-navy);
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .action-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .action-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .action-description {
            color: var(--mckinsey-gray);
            font-size: 0.875rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--mckinsey-light-gray);
            border-radius: 4px;
        }

        .stat-number {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--mckinsey-blue);
        }

        .stat-label {
            color: var(--mckinsey-gray);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .notification-item {
            padding: 0.75rem;
            border-bottom: 1px solid var(--mckinsey-light-gray);
            font-size: 0.875rem;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-time {
            color: var(--mckinsey-gray);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-item {
            padding: 1rem;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-info h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .form-info p {
            color: var(--mckinsey-gray);
            font-size: 0.875rem;
        }

        .form-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending {
            background: var(--mckinsey-warning);
            color: white;
        }

        .status-approved {
            background: var(--mckinsey-success);
            color: white;
        }

        .status-rejected {
            background: var(--mckinsey-error);
            color: white;
        }

        .btn-primary {
            background: var(--mckinsey-blue);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--mckinsey-navy);
        }

        .empty-state {
            text-align: center;
            color: var(--mckinsey-gray);
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="brand">YB Dato' Zunita Begum</div>
            <div class="user-menu">
                <span class="user-name">{{ Auth::guard('public')->user()->full_name }}</span>
                <a href="{{ route('public.logout') }}" class="btn-logout">Logout</a>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome back, {{ Auth::guard('public')->user()->full_name }}</h1>
            <p class="welcome-subtitle">Access services, track your submissions, and stay connected with your constituency.</p>
        </div>

        <div class="dashboard-grid">
            <div class="main-content">
                <!-- Quick Actions -->
                <div class="card">
                    <h2 class="card-title">Quick Actions</h2>
                    <div class="quick-actions">
                        <a href="{{ route('public.forms.complaint') }}" class="action-card">
                            <div class="action-icon">📝</div>
                            <div class="action-title">File Complaint</div>
                            <div class="action-description">Report issues in your area</div>
                        </a>
                        <a href="{{ route('public.forms.application') }}" class="action-card">
                            <div class="action-icon">🤝</div>
                            <div class="action-title">Apply for Aid</div>
                            <div class="action-description">Request financial assistance</div>
                        </a>
                        <a href="{{ route('public.forms.initiative') }}" class="action-card">
                            <div class="action-icon">💡</div>
                            <div class="action-title">Propose Initiative</div>
                            <div class="action-description">Suggest community projects</div>
                        </a>
                        <a href="{{ route('public.forms.contribution') }}" class="action-card">
                            <div class="action-icon">💰</div>
                            <div class="action-title">Request Funding</div>
                            <div class="action-description">Apply for program funding</div>
                        </a>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="card">
                    <h2 class="card-title">Recent Submissions</h2>
                    <div class="form-list">
                        @forelse($recentSubmissions as $submission)
                            <div class="form-item">
                                <div class="form-info">
                                    <h4>{{ $submission->title }}</h4>
                                    <p>Submitted {{ $submission->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="form-status status-{{ $submission->status }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>No submissions yet. Start by using one of the quick actions above.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="card">
                    <h2 class="card-title">Profile Information</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <strong>Full Name:</strong><br>
                            {{ Auth::guard('public')->user()->full_name }}
                        </div>
                        <div>
                            <strong>IC Number:</strong><br>
                            {{ Auth::guard('public')->user()->ic_number }}
                        </div>
                        <div>
                            <strong>Email:</strong><br>
                            {{ Auth::guard('public')->user()->email }}
                        </div>
                        <div>
                            <strong>Phone:</strong><br>
                            {{ Auth::guard('public')->user()->phone }}
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <strong>Address:</strong><br>
                        {{ Auth::guard('public')->user()->address }}
                    </div>
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('public.profile.edit') }}" class="btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <!-- Statistics -->
                <div class="card">
                    <h2 class="card-title">Your Statistics</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['total_submissions'] }}</div>
                            <div class="stat-label">Total Submissions</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['pending_submissions'] }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['approved_submissions'] }}</div>
                            <div class="stat-label">Approved</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['recent_submissions'] }}</div>
                            <div class="stat-label">This Month</div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card">
                    <h2 class="card-title">Recent Notifications</h2>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse($notifications as $notification)
                            <div class="notification-item">
                                <div>{{ $notification->message }}</div>
                                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>No notifications yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card">
                    <h2 class="card-title">Need Help?</h2>
                    <p style="color: var(--mckinsey-gray); margin-bottom: 1rem;">
                        Contact our office for assistance with any of your submissions or questions.
                    </p>
                    <div style="font-size: 0.875rem;">
                        <strong>Phone:</strong> 06-123 4567<br>
                        <strong>Email:</strong> info@zunitabegum.my<br>
                        <strong>Office Hours:</strong><br>
                        Mon-Fri: 9:00 AM - 5:00 PM
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>