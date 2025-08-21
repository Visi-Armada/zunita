@extends('layouts.app')

@section('title', 'Application Details - YB Dato\' Zunita Begum')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-serif font-light text-gray-900 mb-2">
                        Application Details
                    </h1>
                    <p class="text-gray-600">
                        View detailed information about your application.
                    </p>
                </div>
                <div class="text-right">
                    <a href="{{ route('my-applications.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>
            </div>
        </div>

        <!-- Application Status -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">
                        {{ $application->initiative->title }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        Application #{{ $application->application_number }}
                    </p>
                </div>
                <div class="text-right">
                    @if($application->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Pending Review
                        </span>
                    @elseif($application->status === 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Approved
                        </span>
                    @elseif($application->status === 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Rejected
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($application->status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Application Timeline -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Application Timeline</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Application submitted</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ $application->created_at->toISOString() }}">
                                            {{ $application->created_at->format('M j, Y g:i A') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    @if($application->status !== 'pending')
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        @if($application->status === 'approved')
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Application {{ $application->status }}
                                                @if($application->reviewed_at)
                                                    by admin
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            @if($application->reviewed_at)
                                                <time datetime="{{ $application->reviewed_at->toISOString() }}">
                                                    {{ $application->reviewed_at->format('M j, Y g:i A') }}
                                                </time>
                                            @else
                                                <time datetime="{{ $application->updated_at->toISOString() }}">
                                                    {{ $application->updated_at->format('M j, Y g:i A') }}
                                                </time>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Application Details -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Application Information</h3>
            
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Initiative</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->initiative->title }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Application Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->application_number }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Submitted Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->created_at->format('M j, Y g:i A') }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Contact Preference</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($application->contact_preference) }}</dd>
                </div>
                
                @if($application->priority_score)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Priority Score</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->priority_score }}/5</dd>
                    </div>
                @endif
                
                @if($application->is_urgent)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Urgency</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Urgent
                            </span>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        <!-- Application Data -->
        @if($application->application_data)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Information</h3>
                
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    @foreach($application->application_data as $field => $value)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', $field)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if(is_array($value))
                                    {{ implode(', ', $value) }}
                                @else
                                    {{ $value }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        @endif

        <!-- Admin Notes -->
        @if($application->status === 'rejected' && $application->rejection_reason)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-red-900 mb-4">Rejection Reason</h3>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">{{ $application->rejection_reason }}</p>
                </div>
            </div>
        @endif

        @if($application->status === 'approved' && $application->approval_notes)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-green-900 mb-4">Approval Notes</h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-800">{{ $application->approval_notes }}</p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('initiatives.show', $application->initiative->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Initiative
                </a>
                
                <a href="{{ route('my-applications.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Back to Applications
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
