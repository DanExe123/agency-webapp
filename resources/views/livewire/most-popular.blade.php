<div>
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-duration="2000">

        @foreach($posts as $agency)
       
        @php 
    $canVisit = auth()->check() && auth()->user()->account_status === 'verified'; 
@endphp

        <a  href="{{ $canVisit ? route('profile.visit', $agency->id) : '#' }}" wire:navigate 
            class="p-5 bg-white border rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 space-y-3 block">


            <!-- Logo + Name -->
            <div class="flex items-center gap-3">
                @if($agency->profile && $agency->profile->logo_path)
                    <img src="{{ asset('storage/'.$agency->profile->logo_path) }}" 
                        class="h-14 w-14 rounded-full object-cover border">
                @else
                    <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                        {{ $agency->initials() }}
                    </div>
                @endif

                <div class="min-w-0">
                    <h3 class="font-semibold text-gray-900 text-lg truncate hover:underline">{{ $agency->name }}</h3>

                    <p class="text-sm text-gray-500 truncate">
                        {{ $agency->profile->address ?? 'No address provided' }}
                    </p>
                </div>
            </div>

            <!-- Completed + Rating -->
            <div class="flex items-center justify-between pt-1">
                @if($agency->completed_posts_count >= 1)
                    <span class="px-3 py-1 text-xs font-semibold">
                        {{ $agency->completed_posts_count }} Completed Transactions
                    </span>
                @endif

                <!-- Rating -->
                <div class="flex items-center gap-1 font-bold text-yellow-500">
                    ★ <span class="text-gray-800">{{ number_format($agency->averageRating(), 1) }}</span>
                </div>

            </div>

        </a>
        @endforeach

    </div>

</div>
