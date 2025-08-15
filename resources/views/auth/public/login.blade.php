@extends('layouts.app')

@section('title', 'Log Masuk - YB Dato\' Zunita Begum')

@section('content')
<div class="auth-container">
    <div class="auth-background">
        <div class="auth-pattern"></div>
    </div>
    
    <div class="auth-content">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <div class="logo-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h1 class="auth-title">Selamat Datang Kembali</h1>
                    <p class="auth-subtitle">Log masuk ke akaun anda untuk mengakses inisiatif kerajaan dan perkhidmatan</p>
                </div>
            </div>

            <!-- Login Form -->
            <form class="auth-form" method="POST" action="{{ route('public.login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        Alamat Emel
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           class="form-input @error('email') form-input-error @enderror"
                           placeholder="Masukkan alamat emel anda">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        Kata Laluan
                    </label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           autocomplete="current-password" 
                           required
                           class="form-input @error('password') form-input-error @enderror"
                           placeholder="Masukkan kata laluan anda">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Ingat saya</span>
                    </label>

                    <a href="#" class="forgot-link">Lupa kata laluan?</a>
                </div>

                <button type="submit" class="auth-button">
                    Log Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">
                <span>Atau</span>
            </div>

            <!-- Register Link -->
            <div class="auth-footer">
                <p class="auth-footer-text">Tiada akaun? 
                    <a href="{{ route('public.register') }}" class="auth-footer-link">Daftar sekarang</a>
                </p>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="auth-side-panel">
            <div class="side-panel-content">
                <h2 class="side-panel-title">Akses Penuh kepada Inisiatif Kerajaan</h2>
                <p class="side-panel-description">Log masuk untuk mengakses semua perkhidmatan dan inisiatif yang disediakan oleh YB Dato' Zunita Begum.</p>
                
                                <div class="side-panel-features">
                    <div class="feature-item">
                        <div>
                            <h3>Permohonan Inisiatif</h3>
                            <p>Mohon program dan bantuan yang tersedia</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div>
                            <h3>Statistik Transparensi</h3>
                            <p>Lihat data dan statistik terkini</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div>
                            <h3>Maklum Balas</h3>
                            <p>Hantar aduan dan cadangan anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Auth Container */
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%);
    padding: 2rem;
}

.auth-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
}

.auth-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 1px, transparent 1px),
        radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.auth-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    max-width: 1200px;
    width: 100%;
    position: relative;
    z-index: 1;
}

/* Auth Card */
.auth-card {
    background: var(--bg-primary);
    border-radius: 1.5rem;
    padding: 3rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.auth-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4);
}

.auth-title {
    font-family: 'Georgia', serif;
    font-size: 2rem;
    font-weight: 400;
    color: var(--text-primary);
    margin: 0;
}

.auth-subtitle {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

/* Form Styles */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.form-input {
    padding: 0.875rem 1rem;
    border: 2px solid var(--neutral-200);
    border-radius: 0.75rem;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: var(--bg-primary);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-input-error {
    border-color: var(--error-red);
}

.form-input-error:focus {
    border-color: var(--error-red);
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-error {
    color: var(--error-red);
    font-size: 0.75rem;
    margin: 0;
}

/* Form Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1rem 0;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-input {
    display: none;
}

.checkbox-custom {
    width: 1rem;
    height: 1rem;
    border: 2px solid var(--neutral-300);
    border-radius: 0.25rem;
    position: relative;
    transition: all 0.2s;
}

.checkbox-input:checked + .checkbox-custom {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
}

.checkbox-input:checked + .checkbox-custom::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 0.75rem;
    font-weight: bold;
}

.checkbox-text {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.forgot-link {
    font-size: 0.875rem;
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.forgot-link:hover {
    color: var(--primary-dark-blue);
}

/* Auth Button */
.auth-button {
    width: 100%;
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 1rem;
}

.auth-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4);
}

/* Divider */
.auth-divider {
    position: relative;
    text-align: center;
    margin: 2rem 0;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--neutral-200);
}

.auth-divider span {
    background: var(--bg-primary);
    padding: 0 1rem;
    color: var(--text-tertiary);
    font-size: 0.875rem;
}

/* Auth Footer */
.auth-footer {
    text-align: center;
}

.auth-footer-text {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

.auth-footer-link {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.auth-footer-link:hover {
    color: var(--primary-dark-blue);
}

/* Side Panel */
.auth-side-panel {
    display: flex;
    align-items: center;
    color: white;
}

.side-panel-content {
    max-width: 400px;
}

.side-panel-title {
    font-family: 'Georgia', serif;
    font-size: 2.5rem;
    font-weight: 400;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.side-panel-description {
    font-size: 1.125rem;
    margin-bottom: 3rem;
    opacity: 0.9;
    line-height: 1.6;
}

.side-panel-features {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.feature-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item h3 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
    color: white;
}

.feature-item p {
    opacity: 0.9;
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.8);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .auth-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .auth-side-panel {
        display: none;
    }
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-card {
        padding: 2rem;
    }
    
    .auth-title {
        font-size: 1.75rem;
    }
    
    .side-panel-title {
        font-size: 2rem;
    }
    
    .form-options {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
@endsection