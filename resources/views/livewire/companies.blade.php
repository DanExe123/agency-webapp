<div>
           <!-- Navbar -->
     <header class="bg-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <!-- Search -->
            <div class="flex w-full justify-center mx-6">
                <!-- Title / Keyword Input -->
                <div class="relative w-1/2">
                    <x-phosphor.icons::regular.magnifying-glass 
                        class="w-7 h-7 text-gray-900 absolute left-3 top-[50px] transform -translate-y-1/2 " />
                    <input 
                        type="text" 
                        placeholder="Title, keyword, company"
                        class="w-full border rounded-l-md pl-16 pr-6 py-6 bg-white focus:outline-none"
                        wire:model.defer="searchKeyword"
                    >
                </div>

                <!-- Location Input -->
                <div class="relative w-1/3">
                    <x-phosphor.icons::regular.map-pin 
                        class="w-7 h-7 text-gray-900 absolute left-3 top-[50px] transform -translate-y-1/2" />
                    <input 
                        type="text" 
                        placeholder="Location"
                        class="w-full border-t border-b border-r pl-16 pr-6 py-6 bg-white focus:outline-none"
                        wire:model.defer="searchLocation"
                    >
                </div>

                <!-- Search Button -->
                <button 
                    class="bg-black text-white px-5 py-5 rounded-r-md"
                    wire:click="applySearch"
                >
                    Find
                </button>
            </div>

        </div>

    </header>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6">
        <!-- Sidebar Filters -->
        <!-- Sidebar Filters -->
        <aside class="col-span-3 bg-white border rounded-md p-4">
            <h3 class="font-semibold mb-2">Location:</h3>
            <hr class="py-2">
            <div class="space-y-2">
                @foreach($allLocations as $location)
                    <label class="flex items-center">
                        <input type="checkbox" 
                            class="mr-2" 
                            value="{{ $location }}" 
                            wire:model.live="searchLocation">
                        {{ $location }}
                    </label>
                @endforeach
            </div>
        </aside>



        <!-- Main Listings -->
        <main wire:poll class="col-span-9 space-y-4">
            @forelse ($posts as $post)
            @php
                $profile = $post->user->profile ?? null;
            @endphp
        
            <div class="flex items-center justify-between bg-white border rounded-md p-4">
                <!-- Left -->
                <div class="flex items-center space-x-3">
                    @if($profile && $profile->logo_path)
                        <img src="{{ $profile->logo_path ? asset('storage/' . $profile->logo_path) : 'https://via.placeholder.com/40' }}" 
                             alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full">
                    @else
                        <div class="w-10 h-10 rounded-md bg-gray-300 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($post->user->name ?? 'C', 0, 1)) }}
                        </div>
                    @endif
        
                    <div>
                        <h4 class="font-semibold">
                                <a 
                                    href="{{ route('profile.visit', $post->user->id) }}" 
                                    class="hover:underline"
                                    wire:navigate
                                >
                                    {{ $profile->company_name ?? $post->user->name }}
                                </a>
                            </h4>

                        <p class="text-sm text-gray-500 flex items-center space-x-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-gray-600"/>
                            <span>{{ $profile->address ?? 'N/A' }}</span>
        
                            <span class="px-2 py-0.5 rounded-full text-xs max-w-[200px] truncate inline-block">
                                {{ $post->description ?? 'N/A' }}
                            </span>

                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="text-sm text-gray-700">
                        <div class="flex flex-wrap gap-2">
                            @forelse ($post->guardNeeds as $need)
                                <span class="bg-gray-200/60 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $need->guardType->name }} — {{ $need->quantity }}
                                </span>
                            @empty
                                <p class="text-gray-400 text-xs">No guard needs specified</p>
                            @endforelse
                        </div>
                    </div>

                </div>
        
                <!-- Right -->
                <button wire:click="goToCompanyProfile({{ $post->id }})" 
                        class="flex items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-200">
                    Open
                    <x-phosphor.icons::regular.arrow-right class="w-5 h-5 ml-2" />
                </button>
            </div>
            @empty
            <div class="text-center py-6 bg-gray-50 border rounded-md">
                <div class="flex items-center justify-center space-x-2 text-gray-500">
                    <x-phosphor.icons::regular.building-office class="w-5 h-5" />
                    <span>No companies have posted right now.</span>
                </div>
            </div>        
            @endforelse        

        </main>
        
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-4 py-6 max-w-7xl mx-auto flex items-center justify-between">
        <!-- Showing info on the left -->
        <div class="text-sm text-gray-600">
            
        </div>

        <!-- Pagination links on the right -->
        <div>
            {{ $posts->links() }}
        </div>
    </div>


</div>
