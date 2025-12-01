{{-- resources/views/livewire/admin-dashboard.blade.php - ✅ NO EMOJI, PURE SVG --}}
<div class="min-h-screen bg-gray-100">
    <main class="max-w-7xl mx-auto p-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Agencies</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Verification -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Verification</h2>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingVerification }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Verified Agency -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Verified Agency</h2>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $verifiedAgencies }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Verified Company -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Verified Company</h2>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $verifiedCompanies }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ✅ Completed Negotiating -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Completed Negotiation</h2>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $completedNegotiatingCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Top 5 Agencies by completed_negotiating -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Top 5 Agencies</h3>
            <div class="space-y-3">
                @forelse($topAgencies as $agency)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all">
                        <div class="flex items-center gap-4">
                            @if($agency->profile?->logo_path && Storage::disk('public')->exists($agency->profile->logo_path))
                    <!-- ✅ SHOW LOGO -->
                    <img src="{{ Storage::url($agency->profile->logo_path) }}" 
                         alt="{{ $agency->name }}" 
                         class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-white ring-2 ring-gray-200">
                @else
                    <!-- ✅ FALLBACK INITIALS -->
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                        {{ $agency->initials() }}
                    </div>
                @endif
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 truncate">{{ Str::limit($agency->name, 25) }}</p>
                                @if($agency->profile?->company_name)
                                    <p class="text-sm text-gray-500 truncate">{{ Str::limit($agency->profile->company_name, 30) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-purple-600">{{ $agency->completed_negotiating_count }}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Completed Negotiation</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <p class="text-lg font-medium mb-2">No completed negotiations yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
