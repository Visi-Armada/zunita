@if($section)
    <section class="mckinsey-contact" id="contact">
        <div class="mckinsey-container">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-mckinsey-navy mb-6">{{ $section->title }}</h2>
                @if($section->content)
                    <p class="text-lg md:text-xl text-mckinsey-gray max-w-3xl mx-auto leading-relaxed">{{ $section->content }}</p>
                @endif
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20">
                <div class="contact-info">
                    <h3 class="text-3xl font-bold text-mckinsey-navy mb-10">Maklumat Perhubungan</h3>
                    <div class="space-y-8">
                        @if($section->getSetting('address'))
                            <div class="flex items-start space-x-6 p-8 bg-mckinsey-light-gray rounded-xl hover:bg-mckinsey-light-blue transition-colors duration-200">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-mckinsey-light-blue rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-mckinsey-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-mckinsey-navy mb-3">Alamat</h4>
                                    <p class="text-mckinsey-gray leading-relaxed">{!! nl2br(e($section->getSetting('address'))) !!}</p>
                                </div>
                            </div>
                        @endif

                        @if($section->getSetting('phone'))
                            <div class="flex items-start space-x-6 p-8 bg-mckinsey-light-gray rounded-xl hover:bg-mckinsey-light-blue transition-colors duration-200">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-mckinsey-light-blue rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-mckinsey-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-mckinsey-navy mb-3">Telefon</h4>
                                    <p class="text-mckinsey-gray">{{ $section->getSetting('phone') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($section->getSetting('email'))
                            <div class="flex items-start space-x-6 p-8 bg-mckinsey-light-gray rounded-xl hover:bg-mckinsey-light-blue transition-colors duration-200">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-mckinsey-light-blue rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-mckinsey-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-mckinsey-navy mb-3">Emel</h4>
                                    <p class="text-mckinsey-gray">{{ $section->getSetting('email') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($section->getSetting('hours'))
                            <div class="flex items-start space-x-6 p-8 bg-mckinsey-light-gray rounded-xl hover:bg-mckinsey-light-blue transition-colors duration-200">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-mckinsey-light-blue rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-mckinsey-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-mckinsey-navy mb-3">Waktu Operasi</h4>
                                    <p class="text-mckinsey-gray">{{ $section->getSetting('hours') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mckinsey-contact-form">
                    <h3 class="text-3xl font-bold text-mckinsey-navy mb-10">Hantar Maklum Balas</h3>
                    <form action="#" method="POST" class="space-y-8">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-mckinsey-navy mb-3">Nama Penuh</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-4 border border-mckinsey-border rounded-lg focus:ring-2 focus:ring-mckinsey-navy focus:border-mckinsey-navy transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-mckinsey-navy mb-3">Emel</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-4 border border-mckinsey-border rounded-lg focus:ring-2 focus:ring-mckinsey-navy focus:border-mckinsey-navy transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="block text-sm font-medium text-mckinsey-navy mb-3">Nombor Telefon</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-4 border border-mckinsey-border rounded-lg focus:ring-2 focus:ring-mckinsey-navy focus:border-mckinsey-navy transition-colors duration-200">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="block text-sm font-medium text-mckinsey-navy mb-3">Subjek</label>
                            <select id="subject" name="subject" required 
                                    class="w-full px-4 py-4 border border-mckinsey-border rounded-lg focus:ring-2 focus:ring-mckinsey-navy focus:border-mckinsey-navy transition-colors duration-200">
                                <option value="">Pilih subjek</option>
                                <option value="aduan">Aduan</option>
                                <option value="cadangan">Cadangan</option>
                                <option value="maklum-balas">Maklum Balas</option>
                                <option value="lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message" class="block text-sm font-medium text-mckinsey-navy mb-3">Mesej</label>
                            <textarea id="message" name="message" required rows="4"
                                      class="w-full px-4 py-4 border border-mckinsey-border rounded-lg focus:ring-2 focus:ring-mckinsey-navy focus:border-mckinsey-navy transition-colors duration-200 resize-none"></textarea>
                        </div>
                        <button type="submit" 
                                class="mckinsey-btn-primary w-full text-lg py-4">
                            Hantar Mesej
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endif
