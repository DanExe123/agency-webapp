<div class="relative flex items-center">
    
    <!-- Left Button -->
    <button class="absolute left-0 z-10 w-12 h-12 bg-gray-500 rounded-md flex items-center justify-center -ml-12">
        <x-phosphor.icons::regular.arrow-left class="w-6 h-6 text-gray-900" />
    </button>

    <!-- Carousel -->
    <div class="flex gap-4 w-full overflow-x-auto scroll-smooth scrollbar-hide" data-aos="fade-up" data-aos-duration="2000">
        @foreach($feedbacks as $feedback)
        <div class="flex-none w-full md:w-1/3 px-4">
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 relative">

                <!-- Stars -->
                <div class="flex space-x-1 mb-5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $feedback->rating)
                            <span class="text-yellow-500">★</span>
                        @else
                            <span class="text-gray-300">★</span>
                        @endif
                    @endfor
                </div>

                <!-- Feedback Message -->
                <p class="text-sm text-gray-600 mb-12">
                    "{{ Str::limit($feedback->message, 120) }}"
                </p>

                <!-- Profile at Bottom Left -->
                <div class="absolute bottom-4 left-4 flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gray-300 rounded-full overflow-hidden">
                        @if($feedback->sender && $feedback->sender->profile && $feedback->sender->profile->logo_path)
                            <img src="{{ asset('storage/' . $feedback->sender->profile->logo_path) }}" alt="{{ $feedback->sender->name }}" class="w-full h-full object-cover" />
                        @else
                            <img src="https://via.placeholder.com/40" alt="profile" class="w-full h-full object-cover" />
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $feedback->sender->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $feedback->sender->profile->organization_type ?? 'Agency' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!-- Right Button -->
    <button class="absolute right-0 z-10 w-12 h-12 bg-gray-500 rounded-md flex items-center justify-center -mr-16">
        <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-gray-900" />
    </button>

</div>
