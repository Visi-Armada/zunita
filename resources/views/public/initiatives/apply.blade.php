@extends('layouts.app')

@section('title', 'Apply for ' . $initiative->title . ' - YB Dato\' Zunita Begum')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-900 mb-4">
                Apply for {{ $initiative->title }}
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Please fill out the application form below. All fields marked with an asterisk (*) are required.
            </p>
        </div>

        <!-- Application Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('initiatives.store-application', $initiative->slug) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Initiative Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-blue-900 mb-4">Initiative Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Initiative Name</label>
                            <p class="text-blue-900 font-medium">{{ $initiative->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Category</label>
                            <p class="text-blue-900">{{ ucfirst(str_replace('_', ' ', $initiative->category)) }}</p>
                        </div>
                        @if($initiative->application_deadline)
                            <div>
                                <label class="block text-sm font-medium text-blue-800">Application Deadline</label>
                                <p class="text-blue-900">{{ $initiative->application_deadline->format('F j, Y') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Current Applications</label>
                            <p class="text-blue-900">
                                {{ $initiative->current_applications }}
                                @if($initiative->max_applications)
                                    / {{ $initiative->max_applications }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Form Fields -->
                @php
                    $formFields = $initiative->application_form_data ?? [];
                @endphp

                @if(!empty($formFields))
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Application Information</h2>
                        
                        @foreach($formFields as $fieldName => $fieldType)
                            <div>
                                @php
                                    $label = ucwords(str_replace('_', ' ', $fieldName));
                                    $fieldId = 'field_' . $fieldName;
                                    $fieldValue = old($fieldName);
                                @endphp
                                
                                <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $label }} <span class="text-red-500">*</span>
                                </label>
                                
                                @switch($fieldType)
                                    @case('text')
                                        <input type="text" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               placeholder="Enter {{ strtolower($label) }}">
                                        @break
                                        
                                    @case('email')
                                        <input type="email" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               placeholder="Enter email address">
                                        @break
                                        
                                    @case('phone')
                                        <input type="tel" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               placeholder="Enter phone number">
                                        @break
                                        
                                    @case('number')
                                        <input type="number" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               placeholder="Enter number">
                                        @break
                                        
                                    @case('date')
                                        <input type="date" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror">
                                        @break
                                        
                                    @case('textarea')
                                        <textarea id="{{ $fieldId }}"
                                                  name="{{ $fieldName }}"
                                                  rows="4"
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                                  placeholder="Enter {{ strtolower($label) }}">{{ $fieldValue }}</textarea>
                                        @break
                                        
                                    @case('select')
                                        <select id="{{ $fieldId }}"
                                                name="{{ $fieldName }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror">
                                            <option value="">Select {{ strtolower($label) }}</option>
                                            <!-- Add options based on field name -->
                                            @if(str_contains($fieldName, 'gender'))
                                                <option value="male" {{ $fieldValue == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ $fieldValue == 'female' ? 'selected' : '' }}>Female</option>
                                            @elseif(str_contains($fieldName, 'marital'))
                                                <option value="single" {{ $fieldValue == 'single' ? 'selected' : '' }}>Single</option>
                                                <option value="married" {{ $fieldValue == 'married' ? 'selected' : '' }}>Married</option>
                                                <option value="divorced" {{ $fieldValue == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                <option value="widowed" {{ $fieldValue == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                            @elseif(str_contains($fieldName, 'education'))
                                                <option value="primary" {{ $fieldValue == 'primary' ? 'selected' : '' }}>Primary School</option>
                                                <option value="secondary" {{ $fieldValue == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                                <option value="diploma" {{ $fieldValue == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                                <option value="degree" {{ $fieldValue == 'degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="postgraduate" {{ $fieldValue == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                                            @endif
                                        </select>
                                        @break
                                        
                                    @case('file')
                                        <input type="file" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <p class="text-sm text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                                        @break
                                        
                                    @default
                                        <input type="text" 
                                               id="{{ $fieldId }}"
                                               name="{{ $fieldName }}"
                                               value="{{ $fieldValue }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                               placeholder="Enter {{ strtolower($label) }}">
                                @endswitch
                                
                                @error($fieldName)
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Additional Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Additional Information</h2>
                    
                    <!-- Contact Preference -->
                    <div>
                        <label for="contact_preference" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Contact Method <span class="text-red-500">*</span>
                        </label>
                        <select id="contact_preference" 
                                name="contact_preference" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('contact_preference') border-red-500 @enderror">
                            <option value="email" {{ old('contact_preference') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="phone" {{ old('contact_preference') == 'phone' ? 'selected' : '' }}>Phone</option>
                            <option value="sms" {{ old('contact_preference') == 'sms' ? 'selected' : '' }}>SMS</option>
                        </select>
                        @error('contact_preference')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority Score -->
                    <div>
                        <label for="priority_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Priority Level
                        </label>
                        <select id="priority_score" 
                                name="priority_score" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('priority_score') border-red-500 @enderror">
                            <option value="1" {{ old('priority_score') == '1' ? 'selected' : '' }}>Low Priority</option>
                            <option value="2" {{ old('priority_score') == '2' ? 'selected' : '' }}>Below Average</option>
                            <option value="3" {{ old('priority_score', '3') == '3' ? 'selected' : '' }}>Normal Priority</option>
                            <option value="4" {{ old('priority_score') == '4' ? 'selected' : '' }}>High Priority</option>
                            <option value="5" {{ old('priority_score') == '5' ? 'selected' : '' }}>Critical Priority</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Please select the priority level that best reflects your situation</p>
                        @error('priority_score')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Urgent Application -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_urgent" 
                               name="is_urgent" 
                               value="1"
                               {{ old('is_urgent') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_urgent" class="ml-2 block text-sm text-gray-700">
                            This is an urgent application requiring immediate attention
                        </label>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="terms_accepted" 
                               name="terms_accepted" 
                               value="1"
                               required
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                        <label for="terms_accepted" class="ml-3 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">terms and conditions</a> 
                            and confirm that all information provided is accurate and complete. 
                            I understand that providing false information may result in the rejection of my application.
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white px-8 py-3 rounded-md font-semibold hover:bg-blue-700 transition-colors duration-200">
                        Submit Application
                    </button>
                    
                    <a href="{{ route('initiatives.show', $initiative->slug) }}" 
                       class="flex-1 bg-gray-300 text-gray-700 px-8 py-3 rounded-md font-semibold hover:bg-gray-400 transition-colors duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Application Tips -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Application Tips</h3>
            <ul class="space-y-2 text-blue-800">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Ensure all required fields are completed accurately
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Upload clear, legible documents if required
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    You will receive a confirmation email upon successful submission
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Application review typically takes 3-5 business days
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
