<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 relative" data-aos="fade-up" data-aos-duration="2000">
    @forelse($posts as $post)
        <div class="group bg-white p-6 rounded-lg shadow-lg border border-transparent transition ease-in-out duration-300 hover:border-black hover:shadow-xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white flex items-center justify-center rounded-md overflow-hidden">
                    <img src="{{ $post->logo ?? 'https://via.placeholder.com/40' }}" alt="{{ $post->company_name }}" class="w-8 h-8">
                </div>
                <div class="text-sm text-gray-700 group-hover:text-gray-900 transition duration-300">
                    <p class="font-medium">{{ $post->company_name }}</p>
                    <div class="flex justify-start gap-2">
                        <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-gray-400" />
                        <p class="text-xs">{{ $post->location }}</p>
                    </div>
                </div>
            </div>

            @auth
            <!-- Only authenticated users see the link -->
            <a wire:navigate href="{{ route('company-profile', $post->id) }}"
               class="mt-4 block text-center bg-[#0000006B] text-[#1E1E1E] text-sm py-2 px-4 rounded-md w-full font-bold transition-colors duration-300 group-hover:bg-black group-hover:text-white">
                Open For More Info...
            </a>
        @else
            <!-- Guests see a button that triggers an alert or redirects to login -->
                <button 
                onclick="Swal.fire({
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
                class="mt-4 block text-center bg-[#0000006B] text-[#1E1E1E] text-sm py-2 px-4 rounded-md w-full font-bold transition-colors duration-300 group-hover:bg-black group-hover:text-white">
                Open For More Info...
                </button>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        @endauth
                        
        </div>
    @empty
        <p class="text-center text-gray-500 col-span-full">No company posts found.</p>
    @endforelse
</div>
