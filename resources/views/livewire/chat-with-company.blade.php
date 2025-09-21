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
            <h2 class="text-lg font-semibold">Chat with the Agency</h2>
            <nav class="text-sm text-gray-500">Home / Chat</nav>
        </div>
    </header>
    
   <!-- <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6"> -->
        <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Company Details -->
        <!--<aside class="col-span-4 bg-white border rounded-md p-6">-->
            <aside class="md:col-span-4 bg-white border rounded-md p-6">
            <!-- Header -->
            <div class="flex items-start gap-4">
                <!-- Logo -->
                <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png" 
                     alt="logo" 
                     class="w-20 h-20 rounded-full bg-gray-700">
    
                <!-- Company Name + Tags + Links -->
                <div class="flex flex-col">
                    <!-- Company Name + Tags -->
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        Company Name 
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                        <span class="text-xs whitespace-nowrap font-medium text-gray-800 bg-gray-400 py-1 px-3 rounded-full">Full Time</span>
                    </h2>
    
                    <!-- Links Row -->
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.link class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">https://Company.com</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.phone class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">09123456789</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.envelope class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">CompanyName@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button class="px-4 py-2 bg-gray-400 text-white rounded-md">
                    <x-phosphor.icons::regular.bookmark-simple class="w-4 h-4 text-black" />
                </button>
            </div>
    
            <!-- Description -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-700">Company Description</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Rush, We Need 5 Security Guards in this Company, especially these days, since we lack of security, <br>
                    preferable with complete requirements and instant report.
                </p>
            </div>
    
            <!-- Requirements -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-700">Requirements</h3>
                <ul class="list-disc pl-5 mt-2 text-sm text-gray-600">
                    <li>Has NBI Clearance</li>
                    <li>Has meet police records</li>
                    <li>Police Clearance</li>
                    <li>Age above 21</li>
                </ul>
            </div>
        </aside>
    
        <!-- Chatbox 
        <section class="col-span-8 bg-gray-50 border rounded-md flex flex-col h-[600px]">-->
            <section class="md:col-span-8 bg-gray-50 border rounded-md flex flex-col h-[600px]">
                <!-- Header -->
                <div class="flex items-center justify-between p-3 border-b">
                    <button class="p-2 rounded-full hover:bg-gray-200">
                        <x-phosphor.icons::regular.arrow-left class="w-5 h-5" />
                    </button>
                    <h2 class="font-semibold text-gray-700">Messages </h2>
                    <button class="p-2 rounded-full hover:bg-gray-200">
                        <x-phosphor.icons::regular.video-camera class="w-5 h-5" />
                    </button>
                </div>
            
                <!-- Messages -->
                <div class="flex-1 p-4 space-y-4 overflow-y-auto">
                {{--    @foreach($messages as $message) --}} 
                      {{--  @if($message->sender_id === auth()->id()) --}} 
                            <!-- Outgoing -->
                            <div class="flex justify-end">
                                <div class="bg-black text-white px-3 py-2 rounded-lg max-w-xs">
                                   
                                    <span class="block text-xs text-gray-300 text-right">
                                            {{--   {{ $message->created_at->format('h:i a') }} --}}
                                    </span>
                                </div>
                            </div>
                      {{-- @else --}}  
                            <!-- Incoming -->
                            <div class="flex items-start space-x-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
                                <div class="bg-gray-600 text-white px-3 py-2 rounded-lg max-w-xs">
                                  
                                    <span class="block text-xs text-gray-300 text-right">
                                      {{--   {{ $message->created_at->format('h:i a') }} --}}
                                    </span>
                                </div>
                            </div>
                      {{--   @endif --}}
                   {{--  @endforeach --}}
                </div>
            
                <!-- Footer Input -->
                <form wire:submit.prevent="sendMessage" class="p-3 border-t flex items-center space-x-2">
                    <button type="button" class="p-2 rounded-full hover:bg-gray-200">
                        <x-phosphor.icons::regular.image class="w-6 h-6 text-gray-600" />
                    </button>
                    <input type="text"
                           placeholder="Write message here"
                           wire:model.defer="messageText"
                           class="flex-1 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    <button type="submit" class="p-2 rounded-md bg-gray-800 hover:bg-gray-900">
                        <x-phosphor.icons::regular.paper-plane-right class="w-5 h-5 text-white" />
                    </button>
                </form>
            </section>
            ection>

            
    </div>
    