<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- User Info --}}
    <div class="w-full max-w-7xl mx-auto p-8 bg-white rounded-lg shadow space-y-8">

        {{-- Top Section: Profile --}}
        <div class="flex flex-col md:flex-row items-center gap-8">
            {{-- Profile Logo --}}
            <div class="flex-shrink-0">
                @if($user->profile && $user->profile->logo_path)
                    <img src="{{ asset('storage/' . $user->profile->logo_path) }}" 
                        alt="{{ $user->name }}" class="w-36 h-36 rounded-full object-cover border-4 border-gray-100 shadow-md">
                @else
                    <div class="w-36 h-36 rounded-full bg-gray-300 flex items-center justify-center text-white text-5xl font-bold shadow-inner">
                        {{ $user->initials() }}
                    </div>
                @endif
            </div>

            {{-- Profile Info --}}
            <div class="flex-1 space-y-3">
                <h1 class="text-4xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-lg text-gray-600 font-medium">{{ $user->profile->organization_type ?? 'Organization Type not set' }}</p>
                <p class="text-gray-500">{{ $user->profile->about_us ?? 'No description available.' }}</p>

                {{-- Rating for Company --}}
                @role('Company')
                <div class="flex items-center gap-3 mt-3">
                    <span class="font-semibold text-gray-700">Rating:</span>

                    {{-- Numeric rating with one decimal --}}
                    <span class="text-yellow-500 font-medium">{{ number_format($user->averageRating(), 1) }} / 5</span>

                    {{-- 5 Stars SVG --}}
                    <div class="flex items-center gap-1">
                        @php
                            $avg = round($user->averageRating());
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="{{ $i <= $avg ? '#facc15' : '#e5e7eb' }}">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>

                    <span class="text-gray-400 ml-2">({{ $user->feedbackCount() }} reviews)</span>
                </div>
                @endrole

            </div>
        </div>

        {{-- Divider --}}
        <hr class="border-gray-200">

        {{-- Additional Info Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-gray-700 text-sm">
            @if($user->profile->industry_type)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Industry:</span> {{ $user->profile->industry_type }}
                </div>
            @endif
            @if($user->profile->team_size)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Team Size:</span> {{ $user->profile->team_size }}
                </div>
            @endif
            @if($user->profile->year_established)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Founded:</span> {{ $user->profile->year_established->format('Y') }}
                </div>
            @endif
            @if($user->profile->website)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Website:</span>
                    <a href="{{ $user->profile->website }}" target="_blank" class="text-blue-600 hover:underline truncate">
                        {{ $user->profile->website }}
                    </a>
                </div>
            @endif
            @if($user->profile->address)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Address:</span> {{ $user->profile->address }}
                </div>
            @endif
            @if($user->profile->phone)
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Phone:</span> {{ $user->profile->phone }}
                </div>
            @endif
            @if($user->profile->vision)
                <div class="flex items-center gap-2 col-span-full">
                    <span class="font-semibold">Vision:</span> {{ $user->profile->vision }}
                </div>
            @endif
        </div>
    </div>


    @role('Agency')
    {{-- Posts --}}
    <div class="space-y-4">
        <h2 class="text-xl font-semibold">Posts</h2>

        @forelse($posts as $post)
            <div class="p-4 bg-white rounded shadow hover:shadow-lg transition flex justify-between items-start space-x-4">

                {{-- Left: Profile + Post Info --}}
                <div class="flex-1 space-y-2">
                    <div class="flex items-center space-x-3">
                        {{-- Profile Image --}}
                        @if($post->user && $post->user->profile && $post->user->profile->logo_path)
                            <img src="{{ asset('storage/' . $post->user->profile->logo_path) }}" 
                                alt="{{ $post->user->name }}" class="w-12 h-12 rounded-full">
                        @else
                            <div class="w-12 h-12 rounded-md bg-gray-300 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($post->user->name ?? 'C', 0, 1)) }}
                            </div>
                        @endif

                        {{-- Name + Company + Address + Description --}}
                        <div>
                            <h4 class="font-semibold">
                                <a href="{{ route('profile.visit', $post->user->id) }}" class="hover:underline">
                                    {{ $post->user->profile->company_name ?? $post->user->name }}
                                </a>
                            </h4>
                            <p class="text-xs text-gray-400">
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                            <p class="text-sm text-gray-500 flex items-center space-x-1">
                                <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-gray-600"/>
                                <span>{{ $post->user->profile->address ?? 'N/A' }}</span>
                                 <span class="px-2 py-0.5 rounded-full text-xs max-w-[400px] truncate inline-block">{{ $post->description ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Guard Needs --}}
                    <div class="flex flex-wrap gap-2 text-sm text-gray-700">
                        @forelse ($post->guardNeeds as $need)
                            <span class="bg-gray-200/60 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $need->guardType->name }} — {{ $need->quantity }}
                            </span>
                        @empty
                            <p class="text-gray-400 text-xs">No guard needs specified</p>
                        @endforelse
                    </div>
                </div>

                {{-- Right: View Post Button --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('company-profile', $post->id) }}" 
                    class="flex items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-200">
                        View Post
                        <x-phosphor.icons::regular.arrow-right class="w-5 h-5 ml-2" />
                    </a>
                </div>

            </div>
        @empty
            <p class="text-gray-500">No posts available.</p>
        @endforelse
    </div>
    @endrole

    @role('Company')
    {{-- Feedbacks --}}
    <div class="relative w-full bg-white p-4 rounded-lg shadow" x-data="profileVisitCarousel()">
        <!-- HEADER + BUTTONS WRAPPER -->
        <div class="w-full flex items-center justify-between mb-3 relative">

            <h2 class="text-xl font-semibold">Feedbacks</h2>

            <!-- Buttons aligned with container -->
            <div class="flex items-center gap-2">
                <button @click="prev"
                    class="bg-gray-900 p-2 rounded-full shadow-md hover:bg-gray-800">
                    <x-phosphor.icons::regular.caret-left class="w-5 h-5 text-white" />
                </button>

                <button @click="next"
                    class="bg-gray-900 p-2 rounded-full shadow-md hover:bg-gray-800">
                    <x-phosphor.icons::regular.caret-right class="w-5 h-5 text-white" />
                </button>
            </div>
        </div>

        <!-- Carousel Container -->
        <div class="overflow-hidden w-full py-2">
            <div class="flex space-x-4 transition-transform duration-500"
                :style="`transform: translateX(-${currentIndex * itemWidth}px)`"
                x-ref="carousel">

                @forelse($feedbacks as $feedback)
                    <div class="min-w-[320px] bg-white p-4 rounded-lg shadow border hover:border-black hover:shadow-lg transition">

                        <!-- Sender + Rating -->
                        <div class="flex items-center gap-2">
                            <img src="{{ $feedback->sender->profile && $feedback->sender->profile->logo_path 
                                        ? asset('storage/' . $feedback->sender->profile->logo_path) 
                                        : 'https://via.placeholder.com/40' }}"
                                class="w-10 h-10 rounded-full object-cover">

                            <span class="font-semibold">{{ $feedback->sender->name }}</span>

                            <!-- 5 Stars -->
                            <div class="flex items-center ml-auto gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                        viewBox="0 0 20 20"
                                        fill="{{ $i <= $feedback->rating ? '#facc15' : '#e5e7eb' }}">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <!-- Message -->
                        <p class="mt-2 text-gray-600 text-sm">
                            "{{ Str::limit($feedback->message, 160) }}"
                        </p>

                    </div>
                @empty
                    <p class="text-gray-500">No feedbacks yet.</p>
                @endforelse

            </div>
        </div>

    </div>
     @endrole
    <script>
    function profileVisitCarousel() {
        return {
            currentIndex: 0,
            itemWidth: 340,
            prev() { this.currentIndex = Math.max(this.currentIndex - 1, 0); },
            next() {
                const visibleCards = Math.floor(this.$refs.carousel.parentElement.offsetWidth / this.itemWidth);
                const maxIndex = this.$refs.carousel.children.length - visibleCards;
                this.currentIndex = Math.min(this.currentIndex + 1, Math.max(maxIndex, 0));
            }
        }
    }
    </script>



</div>
