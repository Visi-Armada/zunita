@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif text-gray-900 mb-4">Inisiatif & Program</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Program dan inisiatif yang sedang dijalankan untuk manfaat komuniti Pilah</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 p-6 rounded-lg mb-8">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-64">
                <input type="text" placeholder="Cari inisiatif..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                <option value="">Semua Kategori</option>
                <option value="pendidikan">Pendidikan</option>
                <option value="kesihatan">Kesihatan</option>
                <option value="infrastruktur">Infrastruktur</option>
                <option value="sosial">Sosial</option>
                <option value="ekonomi">Ekonomi</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="akan-datang">Akan Datang</option>
                <option value="tamat">Tamat</option>
            </select>
        </div>
    </div>

    <!-- Initiatives Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($initiatives as $initiative)
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            @if($initiative->image)
            <div class="h-48 bg-gray-200">
                <img src="{{ $initiative->image }}" alt="{{ $initiative->title }}" class="w-full h-full object-cover">
            </div>
            @endif
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        @if($initiative->status === 'aktif') bg-green-100 text-green-800
                        @elseif($initiative->status === 'akan-datang') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($initiative->status) }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $initiative->category }}</span>
                </div>
                
                <h3 class="text-xl font-serif text-gray-900 mb-2">{{ $initiative->title }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-3">{{ $initiative->description }}</p>
                
                <div class="space-y-2 mb-4">
                    @if($initiative->deadline)
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Tarikh Tutup: {{ \Carbon\Carbon::parse($initiative->deadline)->format('d M Y') }}
                    </div>
                    @endif
                    
                    @if($initiative->budget)
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Bajet: RM {{ number_format($initiative->budget, 0) }}
                    </div>
                    @endif
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('initiatives.show', $initiative->slug) }}" 
                       class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                        Lihat Butiran
                    </a>
                    @if($initiative->status === 'aktif')
                    <a href="{{ route('initiatives.apply', $initiative->slug) }}" 
                       class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                        Mohon
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Inisiatif Dijumpai</h3>
            <p class="text-gray-500">Tiada inisiatif yang memenuhi kriteria carian anda.</p>
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
@endsection
