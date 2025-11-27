<div class="bg-white shadow-lg rounded-lg p-6 mt-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Evaluating Proposals for: {{ $post->description }}
        </h2>
        <button 
            wire:click="$dispatch('backToList')" 
            class="px-3 py-1 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg">
            ← Back
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-2 text-left">Agency</th>
                    <th class="px-4 py-2 text-center">Agency Ratings</th>
                    <th class="px-4 py-2 text-left">Message</th>
                    <th class="px-4 py-2 text-left">Proposed Rates</th>
                    <th class="px-4 py-2 text-left">Submitted</th>
                    <th class="px-4 py-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @forelse($post->responses as $response)
                    <tr class="border-t hover:bg-gray-50 align-top">
                        <td class="px-4 py-2 font-medium align-top">
                            <a href="{{ route('profile.visit', $response->agency->id) }}" wire:navigate class="flex items-center gap-2">
                                <img 
                                    src="{{ asset('storage/' . ($response->agency->profile->logo_path ?? 'images/default-logo.png')) }}" 
                                    alt="Logo" 
                                    class="w-8 h-8 rounded-full object-cover border"
                                >
                                <span>{{ $response->agency->name ?? 'N/A' }}</span>
                            </a>
                        </td>

                        <td class="px-4 py-2 text-center font-medium align-top flex items-center justify-center gap-2">
                            <!-- yellow star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="color: #f6c23e;">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.285a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.285c.3.922-.755 1.688-1.54 1.118L10 13.347l-2.893 2.02c-.784.57-1.838-.196-1.54-1.118l1.07-3.285a1 1 0 00-.364-1.118L3.47 8.712c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.079-3.285z"/>
                            </svg>

                            <span>{{ number_format($response->agency->averageRating() ?? 0, 1) }}</span>
                        </td>


                        <td class="px-4 py-2 align-top w-64 max-w-xs whitespace-normal break-words">
                            {{ $response->message ?? 'No summary provided.' }}
                        </td>

                        <td class="px-4 py-2 align-top">
                            @if($response->proposedRates && $response->proposedRates->count())
                                <table class="w-full text-xs border border-gray-200 rounded">
                                    <thead class="bg-gray-100 text-gray-600">
                                        <tr>
                                            <th class="px-2 py-1 text-left">Guard Type</th>
                                            <th class="px-2 py-1 text-left">Proposed Rate (₱)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($response->proposedRates as $rate)
                                            <tr class="border-t">
                                                <td class="px-2 py-1">{{ $rate->guardType->name ?? 'N/A' }}</td>
                                                <td class="px-2 py-1">₱{{ number_format($rate->proposed_rate, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <span class="text-gray-500">No rates submitted</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-gray-500 align-top">
                            {{ $response->created_at->diffForHumans() }}
                        </td>
                       <td class="px-4 py-2 text-center align-top">
                            @php
                                $status = $response->status ?? 'pending';
                                $colors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'not_selected' => 'bg-yellow-100 text-yellow-800',
                                    'negotiating' => 'bg-blue-100 text-blue-800',
                                    'closed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                            @endphp

                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                            No proposals submitted yet.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Button to open DSS modal -->
    <div class="flex justify-end mt-4">
        @php
            $hasNegotiating = $post->responses->contains('status', 'negotiating');
        @endphp

        @if(!$hasNegotiating)
            <button 
                wire:click="openDssModal"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                Select Agency
            </button>
        @endif
    </div>                  

    <!-- DSS Modal -->
    <div x-data="{ open: @entangle('showDssModal') }" x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Select Agency</h3>

            @if($recommendedAgency)
                <div class="mb-4 p-3 bg-green-50 text-green-800 border border-green-200 rounded">
                    <strong>Recommended Agency:</strong> {{ $recommendedAgency }}
                    <p class="text-sm mt-1 text-gray-700">{!! $dssExplanation !!}</p>
                </div>
            @endif

            <div class="relative w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Agency</label>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button type="button" @click="dropdownOpen = !dropdownOpen"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500">
                        <span>
                            @if($selectedAgencyId)
                                {{ collect($dssResults)->firstWhere('agency_id', $selectedAgencyId)['agency_name'] ?? 'Select an agency' }}
                            @else
                                Select an agency
                            @endif
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition
                        class="absolute z-10 mt-1 w-full max-h-60 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg">
                        @foreach($dssResults as $result)
                            <div 
                                wire:click="chooseAgency({{ $result['agency_id'] }})"
                                @click="dropdownOpen = false"
                                class="cursor-pointer px-4 py-2 transition border-b border-gray-100
                                    {{ $selectedAgencyId === $result['agency_id'] ? 'bg-blue-100' : 'hover:bg-blue-50' }}">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('storage/' . $result['agency_logo']) }}" 
                                            alt="Logo"
                                            class="w-8 h-8 rounded-full object-cover border">
                                        
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $result['agency_name'] }}</span>
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 20 20"
                                                        fill="{{ $i <= round($result['rating'] ?? 0) ? '#f6c23e' : '#e5e7eb' }}">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.285a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.285c.3.922-.755 1.688-1.54 1.118L10 13.347l-2.893 2.02c-.784.57-1.838-.196-1.54-1.118l1.07-3.285a1 1 0 00-.364-1.118L3.47 8.712c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.079-3.285z" />
                                                    </svg>
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">
                                                    ({{ number_format($result['rating'] ?? 0, 1) }})
                                                </span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <span class="text-sm text-gray-500">₱{{ number_format($result['average_rate'], 2) }}</span>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
                @error('selectedAgencyId')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button x-on:click="open = false"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm">
                    Cancel
                </button>
                <button wire:click="proceedDssSelection"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    Proceed
                </button>
            </div>
        </div>
    </div>

</div>
