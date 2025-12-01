<!-- Header -->
<div>
    <!-- Back Button -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <button 
        onclick="history.back()" 
        class="flex items-center gap-2 px-4 py-2 text-gray-800 rounded hover:bg-gray-300 transition"
    >
        <x-phosphor.icons::regular.arrow-left class="w-4 h-4" />
        Back
    </button>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Company Details -->
    <div class="flex justify-between items-center py-8">
        <div class="flex items-start gap-4">
            <!-- Logo -->
            <a href="{{ route('profile.visit', $post->user->id) }}" wire:navigate><img src="{{ $post->user->profile?->logo_path ? asset('storage/' . $post->user->profile->logo_path) : 'https://via.placeholder.com/80' }}" 
                 alt="{{ $post->user->profile?->organization_type ?? $post->user->name }}" 
                 class="w-20 h-20 rounded-full bg-gray-700 object-cover"></a>

            <div class="flex flex-col">
                <a href="{{ route('profile.visit', $post->user->id) }}" wire:navigate class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    {{ $post->user->name ?? 'N/A' }}
                </a>

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
           

             <!-- Respond Button (Opens Modal) -->
            @if ($this->hasApplied($post->id))
                <button 
                    disabled
                    class="px-4 py-2 bg-green-600 text-white rounded-md w-32 h-10 cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <x-phosphor.icons::regular.check-circle class="w-5 h-5 text-white" />
                    Applied
                </button>

            @else
                <livewire:post-response-form :postId="$post->id" />
            @endif


            <a href="{{ url('chatify', $post->user_id) }}" 
                class="px-4 py-2 bg-gray-900 text-white rounded-md flex justify-start hover:bg-gray-700 gap-2 w-50 h-10"
                target="_blank" 
                rel="noopener noreferrer">
                 Chat With Company
                 <x-phosphor.icons::regular.arrow-right class="w-4 h-4 text-white mt-1" />
             </a>  

        </div>

    </div>

    <div class="mt-2 flex flex-wrap items-start gap-6 text-sm text-gray-700">
        <!-- Company Description -->
        <div class="min-w-[250px]">
            <h3 class="text-xl font-semibold text-gray-700">Company Description</h3>
            <p class="text-sm text-gray-600 mt-2">{{ $post->description ?? 'No description provided.' }}</p>
        </div>

        <!-- Guard Needs -->
        <div class="min-w-[250px]">
            <p class="font-semibold mb-2">Guard Needs:</p>
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
                <p class="text-sm text-gray-600">Location: {{ $post->user->profile?->address ?? 'N/A' }}</p>
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



 