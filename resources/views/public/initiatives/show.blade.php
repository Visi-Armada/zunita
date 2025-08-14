@extends('layouts.app')

@section('title', $initiative->title . ' - YB Dato\' Zunita Begum')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    @if($initiative->is_featured)
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-400 text-yellow-900">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Featured Initiative
                            </span>
                        </div>
                    @endif
                    
                    <h1 class="text-4xl md:text-5xl font-serif font-light mb-4">
                        {{ $initiative->title }}
                    </h1>
                    
                    <p class="text-xl text-blue-100 mb-6">
                        {{ $initiative->short_description }}
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst(str_replace('_', ' ', $initiative->category)) }}
                        </span>
                        
                        @if($initiative->location)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $initiative->location }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        @if($canApply && !$hasApplied)
                            <a href="{{ route('initiatives.apply', $initiative->slug) }}" 
                               class="bg-yellow-400 text-yellow-900 px-8 py-3 rounded-md font-semibold hover:bg-yellow-300 transition-colors duration-200">
                                Apply Now
                            </a>
                        @elseif($hasApplied)
                            <span class="bg-green-100 text-green-800 px-8 py-3 rounded-md font-semibold">
                                ✓ Already Applied
                            </span>
                        @else
                            <span class="bg-gray-300 text-gray-600 px-8 py-3 rounded-md font-semibold cursor-not-allowed">
                                Applications Closed
                            </span>
                        @endif
                        
                        <a href="{{ route('initiatives.index') }}" 
                           class="border border-white text-white px-8 py-3 rounded-md font-semibold hover:bg-white hover:text-blue-900 transition-colors duration-200">
                            Back to Initiatives
                        </a>
                    </div>
                </div>
                
                @if($initiative->featured_image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $initiative->featured_image) }}" 
                             alt="{{ $initiative->title }}"
                             class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-lg">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-serif font-light text-gray-900 mb-6">About This Initiative</h2>
                    <div class="prose prose-lg max-w-none">
                        {!! $initiative->description !!}
                    </div>
                </div>

                <!-- Eligibility & Requirements -->
                @if($initiative->eligibility_criteria || $initiative->requirements)
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-serif font-light text-gray-900 mb-6">Eligibility & Requirements</h2>
                        
                        @if($initiative->eligibility_criteria)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Eligibility Criteria</h3>
                                <div class="prose max-w-none">
                                    {!! $initiative->eligibility_criteria !!}
                                </div>
                            </div>
                        @endif
                        
                        @if($initiative->requirements)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Requirements</h3>
                                <div class="prose max-w-none">
                                    {!! $initiative->requirements !!}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Benefits -->
                @if($initiative->benefits)
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-serif font-light text-gray-900 mb-6">Benefits</h2>
                        <div class="prose prose-lg max-w-none">
                            {!! $initiative->benefits !!}
                        </div>
                    </div>
                @endif

                <!-- Related Initiatives -->
                @if($relatedInitiatives->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-serif font-light text-gray-900 mb-6">Related Initiatives</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedInitiatives as $related)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $related->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">
                                        {{ Str::limit(strip_tags($related->short_description ?: $related->description), 100) }}
                                    </p>
                                    <a href="{{ route('initiatives.show', $related->slug) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Learn More →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Application Status -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Status</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Status:</span>
                            @if($canApply)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Open for Applications
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Closed
                                </span>
                            @endif
                        </div>
                        
                        @if($initiative->application_deadline)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Deadline:</span>
                                <span class="font-medium">{{ $initiative->application_deadline->format('M j, Y') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Days Left:</span>
                                <span class="font-medium {{ $initiative->days_until_deadline <= 7 ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $initiative->days_until_deadline }} days
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Applications:</span>
                            <span class="font-medium">
                                {{ $initiative->current_applications }}
                                @if($initiative->max_applications)
                                    / {{ $initiative->max_applications }}
                                @endif
                            </span>
                        </div>
                        
                        @if($initiative->max_applications)
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" 
                                     style="width: {{ min(100, ($initiative->current_applications / $initiative->max_applications) * 100) }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                @if($initiative->contact_person || $initiative->contact_email || $initiative->contact_phone)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        
                        <div class="space-y-3">
                            @if($initiative->contact_person)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $initiative->contact_person }}</span>
                                </div>
                            @endif
                            
                            @if($initiative->contact_email)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $initiative->contact_email }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $initiative->contact_email }}
                                    </a>
                                </div>
                            @endif
                            
                            @if($initiative->contact_phone)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <a href="tel:{{ $initiative->contact_phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $initiative->contact_phone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Timeline -->
                @if($initiative->start_date || $initiative->end_date)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                        
                        <div class="space-y-3">
                            @if($initiative->start_date)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Start Date:</span>
                                    <span class="font-medium">{{ $initiative->start_date->format('M j, Y') }}</span>
                                </div>
                            @endif
                            
                            @if($initiative->end_date)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">End Date:</span>
                                    <span class="font-medium">{{ $initiative->end_date->format('M j, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
