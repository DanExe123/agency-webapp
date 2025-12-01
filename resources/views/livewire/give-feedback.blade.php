<div>
    <!-- Default Button -->
    <button 
        wire:click="openModal({{ $postId }})"
        class="w-full text-left px-4 py-2 font-bold text-green-700 hover:text-white hover:bg-green-600 rounded"
    >
        Finish Negotiation
    </button>

    <!-- Modal -->
    <div 
        x-data="{ open: @entangle('showModal') }"
        x-show="open"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
        <div 
            class="bg-white rounded-xl shadow-xl p-6 w-96 max-w-full"
            @click.away="open = false"
           >
           
            <!-- Replace ENTIRE modal content (inside the white modal div) -->
<div class="max-h-[80vh] overflow-y-auto p-2">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 pb-4 sticky top-0 bg-white border-b">
        <h3 class="text-xl font-bold text-gray-800">Rate All Agencies</h3>
        <button @click="open = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Agencies List - EACH with Stars + Textarea -->
    <div class="space-y-4 mb-6">
        @forelse($acceptedResponses as $response)
            <div class="bg-gray-50 p-4 rounded-lg border wire:key='agency-{{ $response['id'] }}'">
                <!-- Agency Header -->
                <div class="flex items-center gap-3 mb-3 pb-3 border-b">
                    @if($response['logo_path'])
                        <img src="{{ asset('storage/' . $response['logo_path']) }}" 
                             class="w-10 h-10 rounded-full object-cover" 
                             alt="{{ $response['agency_name'] }}">
                    @else
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">
                            {{ substr($response['agency_name'], 0, 2) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 truncate">{{ $response['agency_name'] }}</h4>
                        <p class="text-xs text-gray-500">Response #{{ $response['id'] }}</p>
                    </div>
                </div>

                <!-- Stars for THIS agency -->
                <div class="flex items-center justify-center mb-3 space-x-1">
    @for($i = 1; $i <= 5; $i++)
        <button 
            type="button"
            wire:click="$set('ratings.{{ $response['id'] }}', {{ $i }})"
            class="p-1 rounded-full hover:bg-yellow-100 transition-all duration-200 focus:outline-none"
        >
            <svg 
                class="w-7 h-7 {{ data_get($ratings, $response['id']) >= $i ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" 
                fill="currentColor" 
                viewBox="0 0 20 20"
            >
                <path d="M9.049 2.927a1 1 0 011.902 0l1.07 3.286a1 1 0 00.95.69h3.462c.97 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.286c.3.922-.755 1.688-1.54 1.118L10 13.347l-3.197 1.624c-.784.57-1.838-.196-1.539-1.118l1.07-3.286a1 1 0 00-.364-1.118L3.17 8.713c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.286z"/>
            </svg>
        </button>
    @endfor

    <span class="ml-2 text-sm font-medium text-gray-600">
        {{ data_get($ratings, $response['id'], 0) }}/5
    </span>
</div>


                <!-- Feedback Textarea for THIS agency -->
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">Feedback</label>
                    <textarea 
                        wire:model.live="messages.{{ $response['id'] }}"
                        rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Feedback for {{ $response['agency_name'] }}..."
                    ></textarea>
                    @error('messages.' . $response['id'])
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No accepted agencies found
            </div>
        @endforelse
    </div>

    <!-- SINGLE Submit Button -->
    <div class="flex justify-end gap-3 pt-4 border-t sticky bottom-0 bg-white py-3">
        <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            Cancel
        </button>
        <button 
            wire:click="submitAllFeedback"
            wire:loading.attr="disabled"
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 flex items-center gap-2"
        >
            <span wire:loading.remove>Submit All ({{ count($acceptedResponses) }})</span>
            <span wire:loading>Submitting...</span>
        </button>
    </div>
</div>

        </div>
    </div>


</div>
