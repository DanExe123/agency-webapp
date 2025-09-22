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
        <h2 class="text-lg font-semibold">Create Job Post</h2>
        <nav class="text-sm text-gray-500">Home / </nav>
    </div>
</header>

    @if ($toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endif

<div class="p-6 space-y-4 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold">Create Job Post</h2>
    <div class="p-6 space-y-4 max-w-3xl mx-auto">
        <x-textarea label="Job Description" placeholder="Enter company description..." wire:model.defer="description" />
        <x-textarea label="Requirements" placeholder="Enter job requirements..." wire:model.defer="requirements" />
        <x-input label="Needs" placeholder="Number of employees needed" wire:model.defer="needs" />
    
        <x-button wire:click="submit" text="white" class="!bg-black !text-white !w-full">
            Submit Post
        </x-button>
    </div>
    
</div>


</div>