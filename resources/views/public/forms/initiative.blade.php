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
            <li><a href="{{ route('initiatives.show', $initiative->slug) }}" class="hover:text-gray-700">{{ $initiative->title }}</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">Mohon</li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif text-gray-900 mb-4">Permohonan Program</h1>
            <h2 class="text-xl text-gray-600 mb-6">{{ $initiative->title }}</h2>
            
            @if($initiative->deadline)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 inline-block">
                <div class="flex items-center text-red-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Tarikh Tutup: {{ \Carbon\Carbon::parse($initiative->deadline)->format('d M Y') }}</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Application Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form method="POST" action="{{ route('initiatives.store-application', $initiative->slug) }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information -->
                <div class="mb-8">
                    <h3 class="text-xl font-serif text-gray-900 mb-6">Maklumat Peribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penuh <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name', auth('public')->user()->name ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                   required>
                            @error('full_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombor IC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="ic_number" 
                                   name="ic_number" 
                                   value="{{ old('ic_number', auth('public')->user()->ic_number ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                   placeholder="000000-00-0000"
                                   required>
                            @error('ic_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombor Telefon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', auth('public')->user()->phone ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                   required>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Emel <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth('public')->user()->email ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Penuh <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                  required>{{ old('address', auth('public')->user()->address ?? '') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mb-8">
                    <h3 class="text-xl font-serif text-gray-900 mb-6">Maklumat Tambahan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan
                            </label>
                            <input type="text" 
                                   id="occupation" 
                                   name="occupation" 
                                   value="{{ old('occupation') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            @error('occupation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="monthly_income" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendapatan Bulanan (RM)
                            </label>
                            <select id="monthly_income" 
                                    name="monthly_income"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                <option value="">Pilih pendapatan</option>
                                <option value="0-1000" {{ old('monthly_income') == '0-1000' ? 'selected' : '' }}>RM 0 - RM 1,000</option>
                                <option value="1001-2000" {{ old('monthly_income') == '1001-2000' ? 'selected' : '' }}>RM 1,001 - RM 2,000</option>
                                <option value="2001-3000" {{ old('monthly_income') == '2001-3000' ? 'selected' : '' }}>RM 2,001 - RM 3,000</option>
                                <option value="3001-5000" {{ old('monthly_income') == '3001-5000' ? 'selected' : '' }}>RM 3,001 - RM 5,000</option>
                                <option value="5001-10000" {{ old('monthly_income') == '5001-10000' ? 'selected' : '' }}>RM 5,001 - RM 10,000</option>
                                <option value="10001+" {{ old('monthly_income') == '10001+' ? 'selected' : '' }}>RM 10,001 ke atas</option>
                            </select>
                            @error('monthly_income')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="family_size" class="block text-sm font-medium text-gray-700 mb-2">
                                Saiz Keluarga
                            </label>
                            <input type="number" 
                                   id="family_size" 
                                   name="family_size" 
                                   value="{{ old('family_size') }}"
                                   min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            @error('family_size')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombor Kecemasan
                            </label>
                            <input type="tel" 
                                   id="emergency_contact" 
                                   name="emergency_contact" 
                                   value="{{ old('emergency_contact') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            @error('emergency_contact')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="mb-8">
                    <h3 class="text-xl font-serif text-gray-900 mb-6">Butiran Permohonan</h3>
                    
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Sebab Permohonan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="reason" 
                                  name="reason" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                  placeholder="Terangkan mengapa anda memerlukan bantuan ini..."
                                  required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="expected_benefits" class="block text-sm font-medium text-gray-700 mb-2">
                            Manfaat yang Diharapkan
                        </label>
                        <textarea id="expected_benefits" 
                                  name="expected_benefits" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                  placeholder="Terangkan manfaat yang anda harapkan dari program ini...">{{ old('expected_benefits') }}</textarea>
                        @error('expected_benefits')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Document Upload -->
                <div class="mb-8">
                    <h3 class="text-xl font-serif text-gray-900 mb-6">Muat Naik Dokumen</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-gray-900 mb-2">Dokumen Diperlukan:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Salinan IC (depan & belakang)</li>
                            <li>• Slip gaji atau surat pengesahan pendapatan</li>
                            <li>• Surat pengesahan alamat (jika berbeza dengan IC)</li>
                            <li>• Dokumen sokongan lain (jika ada)</li>
                        </ul>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="ic_copy" class="block text-sm font-medium text-gray-700 mb-2">
                                Salinan IC <span class="text-red-500">*</span>
                            </label>
                            <input type="file" 
                                   id="ic_copy" 
                                   name="ic_copy" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (Maksimum 5MB)</p>
                            @error('ic_copy')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="income_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Pendapatan
                            </label>
                            <input type="file" 
                                   id="income_proof" 
                                   name="income_proof" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (Maksimum 5MB)</p>
                            @error('income_proof')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="additional_documents" class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen Tambahan
                            </label>
                            <input type="file" 
                                   id="additional_documents" 
                                   name="additional_documents[]" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   multiple
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (Maksimum 5MB setiap fail)</p>
                            @error('additional_documents')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Declaration -->
                <div class="mb-8">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-serif text-gray-900 mb-4">Deklarasi</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="declaration_truth" 
                                       value="1"
                                       class="mt-1 mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                       required>
                                <span class="text-sm text-gray-700">
                                    Saya mengesahkan bahawa semua maklumat yang diberikan adalah benar dan tepat. 
                                    Saya memahami bahawa maklumat palsu boleh menyebabkan permohonan saya ditolak.
                                </span>
                            </label>
                            
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="declaration_consent" 
                                       value="1"
                                       class="mt-1 mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                       required>
                                <span class="text-sm text-gray-700">
                                    Saya memberikan kebenaran untuk maklumat saya digunakan untuk tujuan pemprosesan permohonan ini.
                                </span>
                            </label>
                            
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="declaration_updates" 
                                       value="1"
                                       class="mt-1 mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                                <span class="text-sm text-gray-700">
                                    Saya bersetuju untuk menerima kemas kini mengenai status permohonan saya melalui emel atau SMS.
                                </span>
                            </label>
                        </div>
                        
                        @error('declaration_truth')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        @error('declaration_consent')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Hantar Permohonan
                    </button>
                    
                    <a href="{{ route('initiatives.show', $initiative->slug) }}" 
                       class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-md hover:bg-gray-200 transition-colors duration-200 font-medium text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection