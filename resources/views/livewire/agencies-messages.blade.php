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
            <h2 class="text-lg font-semibold">Agency Messages</h2>
            <nav class="text-sm text-gray-500">Home / </nav>
        </div>
    </header>
    
   <!-- <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6"> -->
        <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Company Details -->
        <!--<aside class="col-span-4 bg-white border rounded-md p-6">-->
            <aside class="md:col-span-4 bg-white border rounded-md p-6 flex flex-col h-[600px]">
               <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">People</h2>
                    <span class="text-sm text-gray-500">{{ $onlineCount }} Online</span>
                </div>

            
                <!-- Search -->
                <div class="mb-4">
                    <input type="text" 
                           placeholder="Search people..." 
                           class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-gray-300">
                </div>
            
                <div wire:poll.10s>
                    <div class="mb-2 text-sm text-gray-600">
                        Online Users: {{ $onlineCount }}
                    </div>
                
                    <div class="flex-1 overflow-y-auto space-y-4">
                        @foreach ($users as $user)
                            @php
                                $isOnline = $user->last_seen && now()->diffInMinutes($user->last_seen) < 5;
                            @endphp
                            <div class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded-md cursor-pointer">
                                <div class="relative">
                                    <img src="https://i.pravatar.cc/40?u={{ $user->id }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-10 h-10 rounded-full">
                                    <span class="absolute bottom-0 right-0 block w-3 h-3 
                                        {{ $isOnline ? 'bg-green-500' : 'bg-gray-400' }}
                                        border-2 border-white rounded-full">
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $isOnline ? 'Online' : 'Offline' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </aside>
            
    
        <section class="md:col-span-8 bg-gray-50 border rounded-md flex flex-col h-[600px]">
            <!-- Header -->
            <div class="flex items-center justify-between p-3 border-b">
                <button class="p-2 rounded-full hover:bg-gray-200">
                    <x-phosphor.icons::regular.arrow-left class="w-5 h-5" />
                </button>
                <h2 class="font-semibold text-gray-700">Messages (4)</h2>
                <button class="p-2 rounded-full hover:bg-gray-200">
                    <x-phosphor.icons::regular.video-camera class="w-5 h-5" />
                </button>
            </div>
    
            <!-- Messages -->
            <div class="flex-1 p-4 space-y-4 overflow-y-auto">
                <!-- Incoming -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
                    <div class="bg-gray-600 text-white px-3 py-2 rounded-lg max-w-xs">
                        Hello! How are you?
                        <span class="block text-xs text-gray-300 text-right">11:42 pm</span>
                    </div>
                </div>
    
                <!-- Incoming -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
                    <div class="bg-gray-600 text-white px-3 py-2 rounded-lg max-w-xs">
                        Can we discuss the details tomorrow?
                    </div>
                </div>
    
                <!-- Outgoing -->
                <div class="flex justify-end items-start space-x-2">
                    <div class="bg-black text-white px-3 py-2 rounded-lg max-w-xs">
                        Sure, that works for me ✅
                    </div>
                </div>
    
                <!-- Incoming -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
                    <div class="bg-gray-600 text-white px-3 py-2 rounded-lg max-w-xs">
                        Great! See you then.
                    </div>
                </div>
            </div>
    
            <!-- Footer Input -->
            <div class="p-3 border-t flex items-center space-x-2">
                <button class="p-2 rounded-full hover:bg-gray-200">
                    <x-phosphor.icons::regular.image class="w-6 h-6 text-gray-600" />
                </button>
                <input type="text" placeholder="Write message here"
                    class="flex-1 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
                <button class="p-2 rounded-md bg-gray-800 hover:bg-gray-900">
                    <x-phosphor.icons::regular.paper-plane-right class="w-5 h-5 text-white" />
                </button>
            </div>
        </section>
        
        
    </div>
    