<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - YB Dato' Zunita Begum</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-inter">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('favicon.svg') }}" alt="Logo" class="h-8 w-8 mr-3">
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Admin Dashboard</h1>
                        <p class="text-xs text-gray-600">YB Dato' Zunita Begum</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Contributions</p>
                        <p class="text-2xl font-bold text-gray-900" id="admin-total-contributions">RM 0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Recipients</p>
                        <p class="text-2xl font-bold text-gray-900" id="admin-total-recipients">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-amber-100 rounded-lg">
                        <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Today's Entries</p>
                        <p class="text-2xl font-bold text-gray-900" id="admin-today-entries">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Review</p>
                        <p class="text-2xl font-bold text-gray-900" id="admin-pending-review">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contribution Entry Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">New Contribution Entry</h2>
                        <p class="text-sm text-gray-600 mt-1">Quick entry for daily contributions</p>
                    </div>
                    <div class="p-6">
                        <form x-data="contributionForm()" @submit.prevent="submitForm" class="space-y-6">
                            <!-- IC Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    IC Number <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           x-model="form.recipient_ic" 
                                           @input="lookupRecipient"
                                           class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 901234567890"
                                           required>
                                    <button type="button" 
                                            @click="scanIC"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Scan
                                    </button>
                                </div>
                                <div x-show="recipientFound" class="mt-2 text-sm text-green-600">
                                    ✓ Recipient found - details auto-filled
                                </div>
                            </div>

                            <!-- Recipient Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           x-model="form.recipient_name" 
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           x-model="form.recipient_phone" 
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea x-model="form.recipient_address" 
                                          rows="2"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          required></textarea>
                            </div>

                            <!-- Contribution Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Amount (RM) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           x-model="form.amount" 
                                           step="0.01"
                                           min="0"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="form.category" 
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                        <option value="">Select category</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Education">Education</option>
                                        <option value="Emergency">Emergency</option>
                                        <option value="Business">Business</option>
                                        <option value="Housing">Housing</option>
                                        <option value="Food">Food</option>
                                        <option value="Transport">Transport</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Contribution Type <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="form.contribution_type" 
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                        <option value="">Select type</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="In-Kind">In-Kind</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Payment Method <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="form.payment_method" 
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                        <option value="">Select method</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea x-model="form.description" 
                                          rows="3"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Brief description of the contribution"
                                          required></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Location
                                </label>
                                <input type="text" 
                                       x-model="form.location" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="e.g., Kampung Baru, Pilah">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contribution Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       x-model="form.contribution_date" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" 
                                        @click="resetForm"
                                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Reset
                                </button>
                                <button type="submit" 
                                        :disabled="loading"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
                                    <span x-show="!loading">Save Contribution</span>
                                    <span x-show="loading">Saving...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recent Entries -->
            <div>
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Entries</h2>
                        <p class="text-sm text-gray-600 mt-1">Latest contributions added</p>
                    </div>
                    <div class="divide-y divide-gray-200" id="recent-entries">
                        <div class="p-4 text-center text-gray-500">
                            Loading recent entries...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function contributionForm() {
            return {
                loading: false,
                recipientFound: false,
                form: {
                    recipient_name: '',
                    recipient_ic: '',
                    recipient_phone: '',
                    recipient_address: '',
                    amount: '',
                    category: '',
                    contribution_type: '',
                    payment_method: '',
                    description: '',
                    location: '',
                    contribution_date: new Date().toISOString().split('T')[0]
                },
                
                async lookupRecipient() {
                    if (this.form.recipient_ic.length < 12) return;
                    
                    try {
                        const response = await fetch(`/api/recipients/${this.form.recipient_ic}`);
                        const data = await response.json();
                        
                        if (data.success && data.data) {
                            this.form.recipient_name = data.data.name;
                            this.form.recipient_phone = data.data.phone;
                            this.form.recipient_address = data.data.address;
                            this.recipientFound = true;
                        } else {
                            this.recipientFound = false;
                        }
                    } catch (error) {
                        console.error('Error looking up recipient:', error);
                        this.recipientFound = false;
                    }
                },
                
                async scanIC() {
                    // Placeholder for camera integration
                    alert('Camera integration coming soon!');
                },
                
                async submitForm() {
                    this.loading = true;
                    
                    try {
                        const response = await fetch('/contributions', {
                            method: 'POST',
                            headers: {
                                'Content-Type': application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.form)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            alert('Contribution saved successfully!');
                            this.resetForm();
                            loadRecentEntries();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch (error) {
                        alert('Error saving contribution: ' + error.message);
                    } finally {
                        this.loading = false;
                    }
                },
                
                resetForm() {
                    this.form = {
                        recipient_name: '',
                        recipient_ic: '',
                        recipient_phone: '',
                        recipient_address: '',
                        amount: '',
                        category: '',
                        contribution_type: '',
                        payment_method: '',
                        description: '',
                        location: '',
                        contribution_date: new Date().toISOString().split('T')[0]
                    };
                    this.recipientFound = false;
                }
            }
        }
        
        async function loadAdminStats() {
            try {
                const response = await fetch('/api/admin-stats');
                const data = await response.json();
                
                document.getElementById('admin-total-contributions').textContent = 
                    'RM ' + data.total_contributions.toLocaleString();
                document.getElementById('admin-total-recipients').textContent = 
                    data.total_recipients.toLocaleString();
                document.getElementById('admin-today-entries').textContent = 
                    data.today_entries.toLocaleString();
                document.getElementById('admin-pending-review').textContent = 
                    data.pending_review.toLocaleString();
            } catch (error) {
                console.error('Error loading admin stats:', error);
            }
        }
        
        async function loadRecentEntries() {
            try {
                const response = await fetch('/api/recent-entries');
                const data = await response.json();
                
                const container = document.getElementById('recent-entries');
                if (data.entries.length === 0) {
                    container.innerHTML = '<div class="p-4 text-center text-gray-500">No entries yet</div>';
                    return;
                }
                
                container.innerHTML = data.entries.map(entry => `
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900">${entry.category}</p>
                                <p class="text-sm text-gray-600">${entry.description}</p>
                                <p class="text-xs text-gray-500">${entry.recipient_name}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">RM ${entry.amount.toLocaleString()}</p>
                                <p class="text-xs text-gray-500">${entry.date}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error loading recent entries:', error);
            }
        }
        
        // Load data on page load
        loadAdminStats();
        loadRecentEntries();
        
        // Refresh every 30 seconds
        setInterval(() => {
            loadAdminStats();
            loadRecentEntries();
        }, 30000);
    </script>
</body>
</html>