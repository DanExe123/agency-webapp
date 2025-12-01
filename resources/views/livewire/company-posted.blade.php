<div class="relative w-full " x-data="carousel()">

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

        <div class="flex space-x-6 transition-transform duration-500" :style="`transform: translateX(-${currentIndex * itemWidth}px)`" x-ref="carousel" data-aos="fade-up" data-aos-duration="2000">
            @forelse($posts as $post)
                <div class="min-w-[300px] flex-shrink-0 bg-white p-6 rounded-lg shadow-lg border border-transparent hover:border-black hover:shadow-xl hover:scale-[1.02] transition-transform duration-300">
                    <!-- Top section: Avatar, name, arrow -->
                    @php 
                        $canVisit = auth()->check() && auth()->user()->account_status === 'verified'; 
                    @endphp
                    <a  href="{{ $canVisit ? route('profile.visit', $post->user->id) : '#' }}" wire:navigate class="flex items-center justify-between w-full space-x-4">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-12 h-12 bg-white flex items-center justify-center rounded-md overflow-hidden">
                                @if($post->user->profile && $post->user->profile->logo_path)
                                    <img src="{{ asset('storage/'.$post->user->profile->logo_path) }}" class="w-10 h-10 object-cover rounded-full" />
                                @else
                                    <img src="https://via.placeholder.com/40" class="w-10 h-10" />
                                @endif
                            </div>

                            <div class="text-sm text-gray-700 transition duration-300 hover:text-gray-900">
                                <p class="font-medium">{{ $post->user->name }}</p>
                                <div class="flex justify-start gap-2">
                                    <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-gray-400" />
                                    <p class="text-xs">{{ $post->user->profile->address ?? 'No address provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-phosphor.icons::regular.arrow-right class="w-5 h-5 text-gray-400 transition hover:text-gray-700" />
                        </div>
                    </a>

                    <!-- Description -->
                    <div class="mt-3">
                        <p class="text-sm text-gray-600">{{ Str::limit($post->description, 30, '...') }}</p>
                    </div>

                    <!-- Open For More Info -->
                    @auth
                        @php 
                            $canVisit = auth()->check() && auth()->user()->account_status === 'verified'; 
                        @endphp
                    
                        <a href="{{ $canVisit ? route('company-profile', $post->id) : '#' }}" wire:navigate
                        class="mt-4 block text-center bg-[#0000006B] text-[#1E1E1E] text-sm py-2 px-4 rounded-md w-full font-bold transition-colors duration-300 hover:bg-black hover:text-white">
                            Open For More Info...
                        </a>
                    @else
                        <button onclick="Swal.fire({
                                icon: 'info',
                                title: 'Sign In Required',
                                text: 'You need to sign in first to view this info.',
                                confirmButtonText: 'Sign In',
                                confirmButtonColor: '#000000',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('loginform') }}';
                                }
                            })"
                            class="mt-4 block text-center bg-[#0000006B] text-[#1E1E1E] text-sm py-2 px-4 rounded-md w-full font-bold transition-colors duration-300 hover:bg-black hover:text-white">
                            Open For More Info...
                        </button>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @endauth
                </div>

            @empty
                <p class="text-center text-gray-500">No company posts found.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
function carousel() {
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
