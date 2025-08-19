@if($section)
    <section class="mckinsey-about" id="about">
        <div class="mckinsey-container">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-mckinsey-navy mb-6">{{ $section->title }}</h2>
                @if($section->content)
                    <div class="text-lg md:text-xl text-mckinsey-gray max-w-3xl mx-auto prose prose-lg leading-relaxed">
                        {!! $section->content !!}
                    </div>
                @endif
            </div>
            
            @if($section->hasImages())
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center">
                    <div class="space-y-12">
                        @if($section->getSetting('vision_mission'))
                            <div class="space-y-8">
                                <h3 class="text-3xl font-bold text-mckinsey-navy">Visi & Misi</h3>
                                <div class="space-y-6 text-mckinsey-gray leading-relaxed">
                                    {!! $section->getSetting('vision_mission') !!}
                                </div>
                            </div>
                        @endif
                        
                        @if($section->getSetting('features'))
                            <div class="space-y-8">
                                @foreach($section->getSetting('features', []) as $feature)
                                    <div class="flex items-start space-x-6 p-8 bg-mckinsey-light-gray rounded-xl hover:bg-mckinsey-light-blue transition-colors duration-200">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 bg-mckinsey-light-blue rounded-xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-mckinsey-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-semibold text-mckinsey-navy mb-3">{{ $feature['title'] ?? 'Feature' }}</h4>
                                            <p class="text-mckinsey-gray leading-relaxed">{{ $feature['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        @if($section->first_image)
                            <div class="rounded-2xl overflow-hidden shadow-lg">
                                <img src="{{ asset('storage/' . $section->first_image) }}" 
                                     alt="{{ $section->title }}"
                                     class="w-full h-auto object-cover">
                            </div>
                        @else
                            <div class="bg-mckinsey-light-blue rounded-2xl p-16 text-center border-2 border-dashed border-mckinsey-border">
                                <div class="w-32 h-32 bg-mckinsey-navy rounded-full flex items-center justify-center mx-auto mb-8">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <p class="text-2xl font-semibold text-mckinsey-navy">YB Dato' Zunita Begum</p>
                                <p class="text-mckinsey-gray mt-3 text-lg">Ahli Dewan Undangan Negeri Pilah</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="max-w-4xl mx-auto">
                    <div class="space-y-12">
                        @if($section->content)
                            <div class="prose prose-lg mx-auto text-mckinsey-gray leading-relaxed">
                                {!! $section->content !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
