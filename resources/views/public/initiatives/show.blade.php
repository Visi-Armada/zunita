@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-gray-700">Utama</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('initiatives.index') }}" class="hover:text-gray-700">Inisiatif</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ $initiative->title }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full 
                        @if($initiative->status === 'aktif') bg-green-100 text-green-800
                        @elseif($initiative->status === 'akan-datang') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($initiative->status) }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $initiative->category }}</span>
                </div>
                
                <h1 class="text-3xl font-serif text-gray-900 mb-4">{{ $initiative->title }}</h1>
                
                @if($initiative->short_description)
                <p class="text-xl text-gray-600 mb-6">{{ $initiative->short_description }}</p>
                @endif
            </div>

            <!-- Featured Image -->
            @if($initiative->image)
            <div class="mb-8">
                <img src="{{ $initiative->image }}" alt="{{ $initiative->title }}" 
                     class="w-full h-64 lg:h-96 object-cover rounded-lg">
            </div>
            @endif

            <!-- Description -->
            <div class="prose prose-lg max-w-none mb-8">
                <h2 class="text-2xl font-serif text-gray-900 mb-4">Penerangan Program</h2>
                <div class="text-gray-700 leading-relaxed">
                    {!! $initiative->description !!}
                </div>
            </div>

            <!-- Eligibility -->
            @if($initiative->eligibility_criteria)
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h3 class="text-xl font-serif text-gray-900 mb-4">Kriteria Kelayakan</h3>
                <div class="text-gray-700">
                    {!! $initiative->eligibility_criteria !!}
                </div>
            </div>
            @endif

            <!-- Benefits -->
            @if($initiative->benefits)
            <div class="bg-blue-50 p-6 rounded-lg mb-8">
                <h3 class="text-xl font-serif text-gray-900 mb-4">Manfaat Program</h3>
                <div class="text-gray-700">
                    {!! $initiative->benefits !!}
                </div>
            </div>
            @endif

            <!-- Required Documents -->
            @if($initiative->required_documents)
            <div class="bg-yellow-50 p-6 rounded-lg mb-8">
                <h3 class="text-xl font-serif text-gray-900 mb-4">Dokumen Diperlukan</h3>
                <div class="text-gray-700">
                    {!! $initiative->required_documents !!}
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Application Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 sticky top-8">
                <h3 class="text-lg font-serif text-gray-900 mb-4">Permohonan</h3>
                
                <div class="space-y-4 mb-6">
                    @if($initiative->deadline)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Tarikh Tutup</div>
                            <div>{{ \Carbon\Carbon::parse($initiative->deadline)->format('d M Y') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($initiative->budget)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Bajet Program</div>
                            <div>RM {{ number_format($initiative->budget, 0) }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($initiative->max_applications)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Kuota Permohonan</div>
                            <div>{{ $initiative->max_applications }} orang</div>
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($initiative->status === 'aktif')
                    @auth('public')
                        <a href="{{ route('initiatives.apply', $initiative->slug) }}" 
                           class="w-full bg-blue-600 text-white text-center py-3 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium">
                            Mohon Sekarang
                        </a>
                    @else
                        <div class="space-y-3">
                            <a href="{{ route('public.login') }}" 
                               class="w-full bg-blue-600 text-white text-center py-3 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium block">
                                Log Masuk untuk Mohon
                            </a>
                            <a href="{{ route('public.register') }}" 
                               class="w-full bg-gray-100 text-gray-700 text-center py-3 px-4 rounded-md hover:bg-gray-200 transition-colors duration-200 font-medium block">
                                Daftar Akaun Baru
                            </a>
                        </div>
                    @endauth
                @else
                    <div class="bg-gray-100 text-gray-600 text-center py-3 px-4 rounded-md">
                        Permohonan Ditutup
                    </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-serif text-gray-900 mb-4">Maklumat Perhubungan</h3>
                
                <div class="space-y-3">
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Pejabat ADUN Pilah</div>
                            <div>06-481 1234</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Emel</div>
                            <div>zunita.pilah@ns.gov.my</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Alamat</div>
                            <div>Jalan Besar, 71600 Pilah, Negeri Sembilan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Initiatives -->
    @if($relatedInitiatives->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-serif text-gray-900 mb-8">Inisiatif Berkaitan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedInitiatives as $related)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($related->status === 'aktif') bg-green-100 text-green-800
                            @elseif($related->status === 'akan-datang') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($related->status) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $related->category }}</span>
                    </div>
                    
                    <h3 class="text-lg font-serif text-gray-900 mb-2">{{ $related->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($related->description, 100) }}</p>
                    
                    <a href="{{ route('initiatives.show', $related->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Butiran →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
