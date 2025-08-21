@extends('layouts.app')

@section('title', 'My Applications - YB Dato\' Zunita Begum')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-serif font-light text-gray-900 mb-2">
                        My Applications
                    </h1>
                    <p class="text-gray-600">
                        Track the status of your initiative applications and view details.
                    </p>
                </div>
                <div class="text-right">
                    <a href="{{ route('initiatives.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Browse Initiatives
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Applications List -->
        @if($applications->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Your Applications ({{ $applications->total() }})</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ $application->initiative->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Application #{{ $application->application_number }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Submitted on {{ $application->created_at->format('M j, Y g:i A') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            @if($application->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending Review
                                                </span>
                                            @elseif($application->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @elseif($application->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($application->status === 'rejected' && $application->rejection_reason)
                                        <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                            <p class="text-sm text-red-800">
                                                <strong>Reason for rejection:</strong> {{ $application->rejection_reason }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if($application->status === 'approved' && $application->approval_notes)
                                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <p class="text-sm text-green-800">
                                                <strong>Approval notes:</strong> {{ $application->approval_notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="ml-6 flex-shrink-0">
                                    <a href="{{ route('my-applications.show', $application->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        View Details
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                <p class="text-gray-600 mb-6">
                    You haven't applied for any initiatives yet. Browse available initiatives and submit your first application.
                </p>
                <a href="{{ route('initiatives.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Browse Initiatives
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
