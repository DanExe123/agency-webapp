<div class="relative w-full" x-data="feedbackCarousel()">

    <!-- Left Button -->
    <button @click="prev" 
            class="absolute -left-8 top-1/2 -translate-y-1/2 bg-gray-900 p-3 rounded-full shadow-md z-10 hover:bg-gray-800">
        <x-phosphor.icons::regular.caret-left class="w-6 h-6 text-white" />
    </button>

    <!-- Right Button -->
    <button @click="next" 
            class="absolute -right-8 top-1/2 -translate-y-1/2 bg-gray-900 p-3 rounded-full shadow-md z-10 hover:bg-gray-800">
        <x-phosphor.icons::regular.caret-right class="w-6 h-6 text-white" />
    </button>

    <!-- Carousel Container -->
    <div class="overflow-hidden w-full p-2">
        <div class="flex space-x-6 transition-transform duration-500" :style="`transform: translateX(-${currentIndex * itemWidth}px)`" x-ref="carousel">

            @forelse($feedbacks as $feedback)
            <div class="min-w-[300px] flex-shrink-0 bg-white p-6 rounded-lg shadow-lg border border-transparent hover:border-black hover:shadow-xl flex flex-col justify-between">

                <!-- Agency Info (Top) -->
                <a href="{{ route('profile.visit', $feedback->receiver->id) }}" wire:navigate  class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gray-300 rounded-full overflow-hidden">
                        @if($feedback->receiver && $feedback->receiver->profile && $feedback->receiver->profile->logo_path)
                            <img src="{{ asset('storage/' . $feedback->receiver->profile->logo_path) }}" alt="{{ $feedback->receiver->name }}" class="w-full h-full object-cover" />
                        @else
                            <img src="https://via.placeholder.com/40" alt="agency" class="w-full h-full object-cover" />
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $feedback->receiver->name ?? 'Unknown Agency' }}</p>
                        <p class="text-xs text-gray-500">{{ $feedback->receiver->profile->organization_type ?? 'Agency' }}</p>
                    </div>
                </a>

                <!-- Stars -->
                <div class="flex space-x-1 mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                    @endfor
                </div>

                <!-- Feedback Message -->
                <p class="text-sm text-gray-600 mb-4">
                    "{{ Str::limit($feedback->message, 120) }}"
                </p>

                <!-- Rated By (Bottom) -->
                <div class="mt-auto pt-2 border-t border-gray-200 flex items-center gap-2 text-xs text-gray-500">
                    <span>Rated by</span>
                    <span class="font-semibold text-gray-700">{{ $feedback->sender->name ?? 'Unknown Company' }}</span>
                </div>

            </div>
            @empty
                <p class="text-center text-gray-500">No feedback found.</p>
            @endforelse

        </div>
    </div>

</div>

<script>
function feedbackCarousel() {
    return {
        currentIndex: 0,
        itemWidth: 330, // same as min-w-[300px] + spacing
        prev() {
            this.currentIndex = Math.max(this.currentIndex - 1, 0);
        },
        next() {
            const maxIndex = this.$refs.carousel.children.length - Math.floor(this.$refs.carousel.parentElement.offsetWidth / this.itemWidth);
            this.currentIndex = Math.min(this.currentIndex + 1, maxIndex);
        }
    }
}
</script>
