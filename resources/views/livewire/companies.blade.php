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
                <div 
                x-data="{ open: false }" 
                class="relative"
            >
                <button 
                    @click="open = !open" 
                    class="flex items-center px-2 py-1 text-sm hover:bg-gray-100"
                >
                    <!-- Static PH flag -->
                    <img src="{{ asset('ph.png') }}" alt="PH Flag" class="w-5 h-3 mr-1">
                    
                    <x-phosphor.icons::regular.caret-down class="w-4 h-4 text-gray-900 ml-1" />
                </button>
            </div>
            
                        
      
                <!-- Divider -->
                <div class="w-px h-6 bg-gray-300 mx-2"></div>
      
                <!-- Search Input -->
                <div class="relative flex-1">
                  <input 
                    type="text" 
                    placeholder="agency title, keyword, company"
                    class="w-[500px] pl-8 pr-3 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 border-0"
                  >
                  <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-400 absolute left-2 top-3" />
                </div>
              </div>
            </div>
      
            <!-- Right: Sign In Button -->
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border bg-black rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black text-white">
                        Log Out
                    </button>
                </form> 
            </div>
      
          </div>
        </div>
      </header>
      
     <!-- Navbar -->
     <header class="bg-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
            <h2 class="text-lg font-semibold">Find Companies</h2>
            <nav class="text-sm text-gray-500">Home / Company</nav>
        </div>
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
                >
            </div>
            <div class="relative w-1/3">
                <x-phosphor.icons::regular.map-pin 
                    class="w-7 h-7 text-gray-900 absolute left-3 top-[50px] transform -translate-y-1/2" />
                <input 
                    type="text" 
                    placeholder="Location"
                    class="w-full border-t border-b border-r pl-16 pr-6 py-6 bg-white focus:outline-none"
                >
            </div>
                <button class="bg-black text-white px-5 py-5 rounded-r-md">Find</button>
            </div>

        </div>
    </header>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6">
        <!-- Sidebar Filters -->
        <aside class="col-span-3 bg-white border rounded-md p-4">
            <h3 class="font-semibold mb-2">Location:</h3>
            <hr class="py-2">
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Bacolod City
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Talisay
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Silay City
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Victorias City
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Others
                </label>
            </div>
        </aside>

        <!-- Main Listings -->
        <main class="col-span-9 space-y-4">
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
                        <h4 class="font-semibold">{{ $profile->company_name ?? $post->user->name }}</h4>
                        <p class="text-sm text-gray-500 flex items-center space-x-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-gray-600"/>
                            <span>{{ $profile->address ?? 'N/A' }}</span>
        
                            <span class="px-2 py-0.5 rounded-full text-xs">
                                {{ $post->description ?? 'N/A' }}
                            </span>
                        </p>
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
    <div class="flex justify-center py-6 space-x-2">
        <button class="px-3 py-1 rounded">
            <x-phosphor.icons::regular.arrow-left class="w-5 h-5" />
        </button>
        <button class="px-3 py-1  hover:rounded-full hover:bg-gray-400 hover:text-gray-600 text-black">01</button>
        <button class="px-3 py-1   hover:rounded-full hover:bg-gray-400 hover:text-gray-600 text-black">02</button>
        <button class="px-3 py-1   hover:rounded-full hover:bg-gray-400 hover:text-gray-600 text-black">03</button>
        <button class="px-3 py-1  hover:rounded-full hover:bg-gray-400 hover:text-gray-600 text-black">
            <x-phosphor.icons::regular.arrow-right class="w-5 h-5" />
        </button>
    </div>

</div>
