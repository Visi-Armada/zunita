@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('description', $page->meta_description)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-primary-blue">Laman Utama</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('pages.index') }}" class="hover:text-primary-blue">Halaman</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ $page->title }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-serif font-light text-gray-900 mb-4">{{ $page->title }}</h1>
        
        @if($page->meta_description)
            <p class="text-lg text-gray-600 mb-6">{{ $page->meta_description }}</p>
        @endif

        <!-- Page Meta -->
        <div class="flex items-center space-x-4 text-sm text-gray-500">
            <span>Diterbitkan: {{ $page->published_at ? $page->published_at->format('d M Y') : $page->created_at->format('d M Y') }}</span>
            @if($page->updated_at && $page->updated_at->diffInDays($page->created_at) > 0)
                <span>• Dikemas kini: {{ $page->updated_at->format('d M Y') }}</span>
            @endif
        </div>
    </div>

    <!-- Featured Image -->
    @if($page->featured_image)
        <div class="mb-8">
            <img src="{{ asset('storage/' . $page->featured_image) }}" 
                 alt="{{ $page->title }}" 
                 class="w-full h-64 object-cover rounded-lg shadow-lg">
        </div>
    @endif

    <!-- Page Content -->
    <div class="prose prose-lg max-w-none">
        {!! $page->content !!}
    </div>

    <!-- Page Footer -->
    <div class="mt-12 pt-8 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                <span>Halaman ini adalah sebahagian daripada laman web rasmi YB Dato' Zunita Begum</span>
            </div>
            
            <div class="flex space-x-4">
                <a href="{{ route('home') }}" class="text-primary-blue hover:text-primary-navy">
                    ← Kembali ke Laman Utama
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
