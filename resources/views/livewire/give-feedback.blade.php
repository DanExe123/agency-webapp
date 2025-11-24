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
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Feedback & Rating</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

         <div class="flex flex-col items-center mb-6">
    @if($user && $user->profile)
        <img 
            src="{{ asset('storage/' . $user->profile->logo_path) }}" 
            alt="{{ $userName ?? 'User' }}" 
            class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 mb-2"
        />
    @else
        <img 
            src="https://via.placeholder.com/80" 
            alt="No User" 
            class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 mb-2"
        />
    @endif

    <p class="text-gray-600 text-sm text-center">
        For: <span class="font-medium text-gray-800">{{ $userName ?? 'Unknown' }}</span>
    </p>
</div>


            
            <!-- Star Rating -->
            <div class="flex justify-center mb-6 space-x-2">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transform hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.172L12 18.896l-7.334 3.873 1.4-8.172L.132 9.21l8.2-1.192z"/>
                        </svg>
                    </button>
                @endfor
            </div>

            <!-- Feedback Textarea -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Feedback</label>
                <textarea wire:model="message" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Write your feedback here..."></textarea>
                @error('message') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <button 
                    @click="open = false"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <button 
                    wire:click="submitFeedback"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>


</div>
