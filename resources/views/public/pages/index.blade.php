@extends('layouts.app')

@section('title', 'Halaman - YB Dato\' Zunita Begum')
@section('description', 'Senarai halaman rasmi YB Dato\' Zunita Begum')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif font-light text-gray-900 mb-4">Halaman Rasmi</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Senarai halaman rasmi YB Dato' Zunita Begum yang mengandungi maklumat penting dan terkini
        </p>
    </div>

    <!-- Pages Grid -->
    @if($pages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($pages as $page)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($page->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $page->featured_image) }}" 
                                 alt="{{ $page->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-blue text-white">
                                {{ ucfirst($page->template) }}
                            </span>
                            @if($page->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    Dipaparkan
                                </span>
                            @endif
                        </div>
                        
                        <h2 class="text-xl font-serif font-medium text-gray-900 mb-2">
                            <a href="{{ route('pages.show', $page->slug) }}" 
                               class="hover:text-primary-blue transition-colors duration-200">
                                {{ $page->title }}
                            </a>
                        </h2>
                        
                        @if($page->meta_description)
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $page->meta_description }}
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $page->published_at ? $page->published_at->format('d M Y') : $page->created_at->format('d M Y') }}</span>
                            <a href="{{ route('pages.show', $page->slug) }}" 
                               class="text-primary-blue hover:text-primary-navy font-medium">
                                Baca Lagi →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($pages->hasPages())
            <div class="flex justify-center">
                {{ $pages->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Halaman Dijumpai</h3>
            <p class="text-gray-600">Tiada halaman yang diterbitkan pada masa ini.</p>
        </div>
    @endif

    <!-- Back to Home -->
    <div class="text-center mt-12">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-blue hover:bg-primary-navy transition-colors duration-200">
            ← Kembali ke Laman Utama
        </a>
    </div>
</div>
@endsection
