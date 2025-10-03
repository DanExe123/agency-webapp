<!-- Header -->
<div>
<header class="bg-white shadow-sm relative py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Icon + Search with Flag -->
            <div class="flex items-center space-x-3">
                <!-- Icon -->
                <div class="flex gap-1 justify-start">
                    <x-phosphor.icons::regular.briefcase class="w-6 h-6 text-gray-600" />
                    <h1 class="font-bold text-gray-700">ESecurityJobs</h1>
                </div>

                <!-- Search Box with Flag Selector -->
                <div class="relative flex items-center border border-gray-300 rounded-md overflow-hidden">
                    <!-- Flag Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center px-2 py-1 text-sm hover:bg-gray-100">
                            <!-- Static PH flag -->
                            <img src="{{ asset('ph.png') }}" alt="PH Flag" class="w-5 h-3 mr-1">
                            <x-phosphor.icons::regular.caret-down class="w-4 h-4 text-gray-900 ml-1" />
                        </button>
                    </div>
                    <!-- Divider -->
                    <div class="w-px h-6 bg-gray-300 mx-2"></div>

                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <input type="text" placeholder="agency title, keyword, company"
                               class="w-[500px] pl-8 pr-3 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 border-0">
                        <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-400 absolute left-2 top-3" />
                    </div>
                </div>
            </div>

            <!-- Right: Sign In Button -->
            <div>
                <a wire:navigate href="{{ route('loginform') }}">
                    <button class="px-4 py-2 border bg-black rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black text-white">
                        Log Out
                    </button>
                </a>
            </div>

        </div>
    </div>
</header>

 <!-- Navbar -->
 <header class="bg-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
        <h2 class="text-lg font-semibold">Company Details</h2>
        <nav class="text-sm text-gray-500">Home / Company</nav>
    </div>
</header>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Company Details -->
    <div class="flex justify-between items-center py-8">
        <div class="flex items-start gap-4">
            <!-- Logo -->
            <img src="{{ $post->user->profile?->logo_path ? asset('storage/' . $post->user->profile->logo_path) : 'https://via.placeholder.com/80' }}" 
                 alt="{{ $post->user->profile?->organization_type ?? $post->user->name }}" 
                 class="w-20 h-20 rounded-full bg-gray-700 object-cover">

            <div class="flex flex-col">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    {{ $post->user->name ?? 'N/A' }}
                   
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                    
                    <span class="text-xs font-medium text-gray-800 bg-gray-400 py-1 px-3 rounded-full">{{ $post->job_type }} Full Time</span>
                </h2>

                <!-- Links Row -->
                <div class="flex flex-wrap items-center gap-4 mt-2">
                    @if($post->user->profile?->website)
                        <div class="flex items-center gap-1 mt-1">
                            <x-phosphor.icons::regular.link class="w-4 h-4 text-black flex-shrink-0" />
                            <p class="text-sm text-gray-500 break-all">
                                <a href="{{ $post->user->profile->website }}" target="_blank" class="hover:underline">
                                    {{ $post->user->profile->website }}
                                </a>
                            </p>
                        </div>
                    @endif

                    @if($post->user->profile?->phone)
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.phone class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">{{ $post->user->profile->phone }}</p>
                        </div>
                    @endif

                    @if($post->user?->email)
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.envelope class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">{{ $post->user->email }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button class="px-4 py-2 bg-gray-400 text-white rounded-md w-14 h-10">
                <x-phosphor.icons::regular.bookmark-simple class="w-4 h-4 text-black" />
            </button>

            <a href="{{ route('chatify') }}" class="px-4 py-2 bg-gray-900 text-white rounded-md flex justify-start gap-2 w-50 h-10" target="_blank" rel="noopener noreferrer">
                Chat With Company
                <x-phosphor.icons::regular.arrow-right class="w-4 h-4 text-white mt-1" />
            </a>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-4">
        <h3 class="text-xl font-semibold text-gray-700">Company Description</h3>
        <p class="text-sm text-gray-600 mt-2">{{ $post->description ?? 'No description provided.' }}</p>
    </div>

    <!-- Requirements -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-gray-700">Requirements</h3>
        <ul class="list-disc pl-5 mt-2 text-sm text-gray-600">
            @if($post->requirements)
                @foreach(explode(',', $post->requirements) as $requirement)
                    <li>{{ $requirement }}</li>
                @endforeach
            @else
                <li>No requirements specified.</li>
            @endif
        </ul>
    </div>

    <!-- Overview -->
    <div class="mt-6 grid grid-cols-2 gap-4">
        <!-- Company Overview -->
        <div class="border border-gray-100 p-4 rounded-md shadow-sm gap-2">
            <h1 class="font-bold text-xl">Company Overview</h1>
            <div class="py-2 flex items-center gap-2">
                <x-phosphor.icons::bold.calendar-blank class="w-4 h-4 text-gray-500" />
                <p class="text-sm text-gray-600">Posted: {{ $post->created_at?->format('d M, Y') ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex items-center gap-2">
                <x-phosphor.icons::bold.map-pin class="w-4 h-4 text-gray-500" />
                <p class="text-sm text-gray-600">Location: {{ $post->location ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex items-center gap-2">
                <x-phosphor.icons::bold.suitcase-simple class="w-4 h-4 text-gray-500" />
                <p class="text-sm text-gray-600">Needs: {{ $post->needs ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Company Details -->
        <div class="border border-gray-100 p-4 rounded-md shadow-sm gap-2">
            <h1 class="font-bold text-xl">Company Details</h1>
            <div class="py-2 flex justify-between">
                <p class="text-sm font-medium text-gray-800">Founded In:</p>
                <p class="text-sm text-gray-600">{{ $post->user->profile?->year_established?->format('Y') ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex justify-between">
                <p class="text-sm font-medium text-gray-800">Company Size:</p>
                <p class="text-sm text-gray-600">{{ $post->user->profile?->team_size ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex justify-between">
                <p class="text-sm font-medium text-gray-800">Phone:</p>
                <p class="text-sm text-gray-600">{{ $post->user->profile?->phone ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex justify-between">
                <p class="text-sm font-medium text-gray-800">Email:</p>
                <p class="text-sm text-gray-600">{{ $post->user->email ?? 'N/A' }}</p>
            </div>
            <div class="py-2 flex justify-between">
                <p class="text-sm font-medium text-gray-800">Website:</p>
                <p class="text-sm text-blue-600 break-all">
                    <a href="{{ $post->user->profile?->website ?? '#' }}" class="hover:underline" target="_blank">
                        {{ $post->user->profile?->website ?? 'N/A' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>



 