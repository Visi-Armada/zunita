@extends('layouts.app')

@section('title', 'Daftar - YB Dato\' Zunita Begum')

@section('content')
<div class="auth-container">
    <div class="auth-background">
        <div class="auth-pattern"></div>
    </div>
    
    <div class="auth-content">
        <div class="auth-card register-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <div class="logo-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h1 class="auth-title">Daftar Akaun Baru</h1>
                    <p class="auth-subtitle">Sertai platform kami untuk mengakses inisiatif kerajaan dan perkhidmatan</p>
                </div>
            </div>

            <!-- Register Form -->
            <form class="auth-form register-form" method="POST" action="{{ route('public.register') }}">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        Maklumat Peribadi
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nama Penuh <span class="required">*</span>
                            </label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   required 
                                   value="{{ old('name') }}"
                                   class="form-input @error('name') form-input-error @enderror"
                                   placeholder="Masukkan nama penuh anda">
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Alamat Emel <span class="required">*</span>
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   required 
                                   value="{{ old('email') }}"
                                   class="form-input @error('email') form-input-error @enderror"
                                   placeholder="Masukkan alamat emel anda">
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                Nombor Telefon <span class="required">*</span>
                            </label>
                            <input id="phone" 
                                   name="phone" 
                                   type="tel" 
                                   required 
                                   value="{{ old('phone') }}"
                                   class="form-input @error('phone') form-input-error @enderror"
                                   placeholder="Masukkan nombor telefon anda">
                            @error('phone')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="occupation" class="form-label">
                                Pekerjaan
                            </label>
                            <input id="occupation" 
                                   name="occupation" 
                                   type="text" 
                                   value="{{ old('occupation') }}"
                                   class="form-input @error('occupation') form-input-error @enderror"
                                   placeholder="Masukkan pekerjaan anda">
                            @error('occupation')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        Maklumat Alamat
                    </h3>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">
                            Alamat <span class="required">*</span>
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3" 
                                  required
                                  class="form-input @error('address') form-input-error @enderror"
                                  placeholder="Masukkan alamat penuh anda">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="postcode" class="form-label">
                                Poskod <span class="required">*</span>
                            </label>
                            <input id="postcode" 
                                   name="postcode" 
                                   type="text" 
                                   required 
                                   value="{{ old('postcode') }}"
                                   class="form-input @error('postcode') form-input-error @enderror"
                                   placeholder="Masukkan poskod">
                            @error('postcode')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                                                <div class="form-group">
                            <label for="city" class="form-label">
                                Bandar <span class="required">*</span>
                            </label>
                            <input id="city" 
                                   name="city" 
                                   type="text" 
                                   required 
                                   value="{{ old('city') }}"
                                   class="form-input @error('city') form-input-error @enderror"
                                   placeholder="Masukkan bandar">
                            @error('city')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="state" class="form-label">
                                Negeri <span class="required">*</span>
                            </label>
                            <select id="state" 
                                    name="state" 
                                    required
                                    class="form-input @error('state') form-input-error @enderror">
                                <option value="">Pilih negeri</option>
                                <option value="Johor" {{ old('state') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ old('state') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ old('state') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                <option value="Melaka" {{ old('state') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                <option value="Negeri Sembilan" {{ old('state') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                <option value="Pahang" {{ old('state') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Perak" {{ old('state') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ old('state') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Pulau Pinang" {{ old('state') == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                <option value="Sabah" {{ old('state') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ old('state') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ old('state') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                <option value="Terengganu" {{ old('state') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                <option value="Kuala Lumpur" {{ old('state') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                <option value="Labuan" {{ old('state') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                <option value="Putrajaya" {{ old('state') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                            </select>
                            @error('state')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        Maklumat Tambahan
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="household_size" class="form-label">
                                Saiz Isi Rumah
                            </label>
                            <input id="household_size" 
                                   name="household_size" 
                                   type="number" 
                                   min="1" 
                                   max="20"
                                   value="{{ old('household_size') }}"
                                   class="form-input @error('household_size') form-input-error @enderror"
                                   placeholder="Bilangan ahli keluarga">
                            @error('household_size')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="preferred_language" class="form-label">
                                Bahasa Pilihan <span class="required">*</span>
                            </label>
                            <select id="preferred_language" 
                                    name="preferred_language" 
                                    required
                                    class="form-input @error('preferred_language') form-input-error @enderror">
                                <option value="">Pilih bahasa</option>
                                <option value="malay" {{ old('preferred_language') == 'malay' ? 'selected' : '' }}>Bahasa Malaysia</option>
                                <option value="english" {{ old('preferred_language') == 'english' ? 'selected' : '' }}>English</option>
                                <option value="chinese" {{ old('preferred_language') == 'chinese' ? 'selected' : '' }}>Chinese</option>
                                <option value="tamil" {{ old('preferred_language') == 'tamil' ? 'selected' : '' }}>Tamil</option>
                            </select>
                            @error('preferred_language')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="form-section">
                    <h3 class="section-title">
                        Keselamatan
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Kata Laluan <span class="required">*</span>
                            </label>
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   required
                                   class="form-input @error('password') form-input-error @enderror"
                                   placeholder="Cipta kata laluan">
                            <p class="form-hint">Mestilah sekurang-kurangnya 8 aksara</p>
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Sahkan Kata Laluan <span class="required">*</span>
                            </label>
                            <input id="password_confirmation" 
                                   name="password_confirmation" 
                                   type="password" 
                                   required
                                   class="form-input"
                                   placeholder="Sahkan kata laluan anda">
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-section">
                    <label class="checkbox-label terms-checkbox">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               required
                               class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">
                            Saya bersetuju dengan 
                            <a href="#" class="link">Terma Perkhidmatan</a> 
                            dan 
                            <a href="#" class="link">Dasar Privasi</a>
                            <span class="required">*</span>
                        </span>
                    </label>
                </div>

                <button type="submit" class="auth-button">
                    Cipta Akaun
                </button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">
                <span>Atau</span>
            </div>

            <!-- Login Link -->
            <div class="auth-footer">
                <p class="auth-footer-text">Sudah ada akaun? 
                    <a href="{{ route('public.login') }}" class="auth-footer-link">Log masuk sekarang</a>
                </p>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="auth-side-panel">
            <div class="side-panel-content">
                <h2 class="side-panel-title">Sertai Platform Transparensi</h2>
                <p class="side-panel-description">Daftar untuk mengakses semua perkhidmatan dan inisiatif yang disediakan oleh YB Dato' Zunita Begum dengan akauntabiliti penuh.</p>
                
                <div class="side-panel-features">
                    <div class="feature-item">
                        <div>
                            <h3>Akses Penuh</h3>
                            <p>Dapatkan akses kepada semua inisiatif dan program</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div>
                            <h3>Permohonan Cepat</h3>
                            <p>Mohon bantuan dan program dengan mudah</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div>
                            <h3>Statistik Terkini</h3>
                            <p>Lihat data transparensi dan kemajuan</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div>
                            <h3>Maklum Balas</h3>
                            <p>Hantar aduan dan cadangan secara langsung</p>
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
    max-height: 90vh;
    overflow-y: auto;
}

.register-card {
    padding: 2rem;
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    width: 4rem;
    height: 4rem;
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4);
}

.auth-title {
    font-family: 'Georgia', serif;
    font-size: 1.75rem;
    font-weight: 400;
    color: var(--text-primary);
    margin: 0;
}

.auth-subtitle {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

/* Form Sections */
.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--neutral-200);
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    font-family: 'Georgia', serif;
    font-size: 1.25rem;
    font-weight: 400;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Form Styles */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
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

.required {
    color: var(--error-red);
}

.form-input {
    padding: 0.75rem 1rem;
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

.form-hint {
    color: var(--text-tertiary);
    font-size: 0.75rem;
    margin: 0;
}

/* Checkbox Styles */
.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
}

.terms-checkbox {
    margin-top: 1rem;
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
    flex-shrink: 0;
    margin-top: 0.125rem;
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
    line-height: 1.5;
}

.link {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.link:hover {
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
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.feature-item p {
    opacity: 0.8;
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.5;
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
    
    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-card {
        padding: 1.5rem;
    }
    
    .auth-title {
        font-size: 1.5rem;
    }
    
    .side-panel-title {
        font-size: 2rem;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .section-title {
        font-size: 1.125rem;
    }
}

/* Scrollbar Styling */
.auth-card::-webkit-scrollbar {
    width: 6px;
}

.auth-card::-webkit-scrollbar-track {
    background: var(--neutral-100);
    border-radius: 3px;
}

.auth-card::-webkit-scrollbar-thumb {
    background: var(--neutral-300);
    border-radius: 3px;
}

.auth-card::-webkit-scrollbar-thumb:hover {
    background: var(--neutral-400);
}
</style>
@endsection