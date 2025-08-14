@extends('layouts.app')

@section('title', 'Government Initiatives - YB Dato\' Zunita Begum')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-serif font-light mb-4">
                    Government Initiatives
                </h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Discover and apply for government programs and initiatives available in Pilah constituency.
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('initiatives.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Initiatives</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by title or description..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" 
                                id="category" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing {{ $initiatives->firstItem() ?? 0 }} to {{ $initiatives->lastItem() ?? 0 }} 
                of {{ $initiatives->total() }} initiatives
            </p>
        </div>

        <!-- Initiatives Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($initiatives as $initiative)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @if($initiative->featured_image)
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $initiative->featured_image) }}" 
                                 alt="{{ $initiative->title }}"
                                 class="w-full h-48 object-cover">
                        </div>
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        @if($initiative->is_featured)
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Featured
                                </span>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $categories[$initiative->category] ?? $initiative->category }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                            {{ $initiative->title }}
                        </h3>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $initiative->short_description ?: Str::limit(strip_tags($initiative->description), 120) }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($initiative->application_deadline)
                                    Deadline: {{ $initiative->application_deadline->format('M j, Y') }}
                                @else
                                    No deadline
                                @endif
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                {{ $initiative->current_applications }} applications
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ route('initiatives.show', $initiative->slug) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Learn More →
                            </a>
                            
                            @if($initiative->is_open_for_applications)
                                <a href="{{ route('initiatives.apply', $initiative->slug) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    Apply Now
                                </a>
                            @else
                                <span class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md cursor-not-allowed">
                                    Closed
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No initiatives found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Try adjusting your search criteria or check back later for new initiatives.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($initiatives->hasPages())
            <div class="mt-8">
                {{ $initiatives->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
