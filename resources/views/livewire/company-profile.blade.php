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
    <!-- Left: Logo + Company Info -->
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
                <span class="text-xs font-medium text-gray-800 bg-gray-400 py-1 px-3 rounded-full">Full Time</span>
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

    <!-- Right: Chat Button -->
    <div class="flex justify-end gap-2">
    <button class="px-4 py-2 bg-gray-400 text-white rounded-md">
        <x-phosphor.icons::regular.bookmark-simple
        class="w-4 h-4 text-black" />
    </button>
    <button class="px-4 py-2 bg-gray-900 text-white rounded-md flex justify-start gap-2">
        Chat With Company
        <x-phosphor.icons::regular.arrow-right
        class="w-4 h-4 text-white mt-1" />
    </button>
    </div>
</div>


    <div class="mt-4">
        <h3 class="text-xl font-semibold text-gray-700">Company Description</h3>
        <p class="text-sm text-gray-600 mt-2">
            Rush, We Need 5 Security Guards in this Company, especially these days, since we lack of security, <br>preferable with complete requirements and instant report.
        </p>
    </div>

    <!-- Requirements -->
    <div class="mt-6 grid grid-cols-2 gap-6">
    <div class="mt-4">
        <h3 class="text-xl font-semibold text-gray-700">Requirements</h3>
        <ul class="list-disc pl-5 mt-2 text-sm text-gray-600">
            <li>Has NBI Clearance</li>
            <li>Has meet police records</li>
            <li>Police Clearance</li>
            <li>Age above 21</li>
        </ul>
    </div>

    <!-- Company Overview -->
    <div class="mt-6 grid grid-cols-2 gap-4">
        <div class="border border-gray-100 p-4 rounded-md shadow-sm gap-2">
            <h1 class="font-bold text-xl">Company Overview</h1>
            
        <div class="py-2">
            <x-phosphor.icons::bold.calendar-blank class="w-4 h-4 text-gray-500" />
            <p class="text-sm font-medium text-gray-800">Posted:</p>
            <p class="text-sm text-gray-600">14 June, 2021</p>
        </div>
        <div class="py-2">
            <x-phosphor.icons::bold.map-pin class="w-4 h-4 text-gray-500" />
            <p class="text-sm font-medium text-gray-800">Location:</p>
            <p class="text-sm text-gray-600">Bacolod City, Mandaluyong</p>
        </div>
        <div class="py-2">
            <x-phosphor.icons::bold.suitcase-simple class="w-4 h-4 text-gray-500" />
            <p class="text-sm font-medium text-gray-700">Needs:</p>
            <p class="text-sm text-gray-600">Full Time Security Guards</p>
        </div>
        </div>

        <div class="border  border-gray-100 p-4 rounded-md shadow-sm gap-2">
            <h1 class="font-bold text-xl">Company Name</h1>
        <div class="py-2 whitespace-nowrap flex justify-between">
            <p class="text-sm font-medium text-gray-800">Founded In:</p>
            <p class="text-sm text-gray-600">March 21, 2005</p>
        </div>
        <div class="py-2 whitespace-nowrap flex justify-between">
            <p class="text-sm font-medium text-gray-800">Company Size:</p>
            <p class="text-sm text-gray-600">120-300 Employers</p>
        </div>
        <div class="py-2 whitespace-nowrap flex justify-between">
            <p class="text-sm font-medium text-gray-800">Phone:</p>
            <p class="text-sm text-gray-600">+63 912 345 6789</p>
        </div>
        <div class="py-2 whitespace-nowrap flex justify-between">
            <p class="text-sm font-medium text-gray-800">Email:</p>
            <p class="text-sm text-gray-600">CompanyName@gmail.com</p>
        </div>
        <div class="py-2 whitespace-nowrap flex justify-between">
            <p class="text-sm font-medium text-gray-800">Website:</p>
            <a href="https://CompanyName.com" class="text-sm text-blue-600">https://CompanyName.com</a>
        </div>
    </div>

    </div>
</div>

<hr class="mt-6">
<!-- Related Companies Section -->
<div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h3 class="text-xl font-semibold text-gray-700 mb-6">Related Companies</h3>

    <!-- Grid for Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Company Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
                    transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
                <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
                     alt="logo"
                     class="w-10 h-10 rounded-full bg-gray-700">
                <div class="flex flex-col">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                        Company Name
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                    </h2>
                    <div class="flex flex-col mt-2 space-y-1">
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">Bacolod City</p>
                        </div>
                        <p class="text-sm text-gray-800">Need Security Guard</p>
                        <p class="text-xs text-gray-400">Full Time</p>
                    </div>
                </div>
            </div>
        </div>

                    <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
                    transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
                <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
                    alt="logo"
                    class="w-10 h-10 rounded-full bg-gray-700">
                <div class="flex flex-col">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                        Company Name
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                    </h2>
                    <div class="flex flex-col mt-2 space-y-1">
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">Bacolod City</p>
                        </div>
                        <p class="text-sm text-gray-800">Need Security Guard</p>
                        <p class="text-xs text-gray-400">Full Time</p>
                    </div>
                </div>
            </div>
            </div>


            <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
            transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
            <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
            alt="logo"
            class="w-10 h-10 rounded-full bg-gray-700">
            <div class="flex flex-col">
            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                Company Name
                <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
            </h2>
            <div class="flex flex-col mt-2 space-y-1">
                <div class="flex items-center gap-1">
                    <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                    <p class="text-sm text-gray-500">Bacolod City</p>
                </div>
                <p class="text-sm text-gray-800">Need Security Guard</p>
                <p class="text-xs text-gray-400">Full Time</p>
            </div>
            </div>
            </div>
            </div>


            <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
            transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
            <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
            alt="logo"
            class="w-10 h-10 rounded-full bg-gray-700">
            <div class="flex flex-col">
            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                Company Name
                <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
            </h2>
            <div class="flex flex-col mt-2 space-y-1">
                <div class="flex items-center gap-1">
                    <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                    <p class="text-sm text-gray-500">Bacolod City</p>
                </div>
                <p class="text-sm text-gray-800">Need Security Guard</p>
                <p class="text-xs text-gray-400">Full Time</p>
            </div>
            </div>
            </div>
            </div>


        <!-- Repeat More Cards -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
                    transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
                <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
                     alt="logo"
                     class="w-10 h-10 rounded-full bg-gray-700">
                <div class="flex flex-col">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                        Company Name
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                    </h2>
                    <div class="flex flex-col mt-2 space-y-1">
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">Bacolod City</p>
                        </div>
                        <p class="text-sm text-gray-800">Need Security Guard</p>
                        <p class="text-xs text-gray-400">Full Time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Another Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-b-gray-100 
                    transition ease-in-out duration-300 hover:shadow-lg hover:scale-105">
            <div class="flex items-start gap-4">
                <img src="https://d2jhcfgvzjqsa8.cloudfront.net/storage/2022/04/download.png"
                     alt="logo"
                     class="w-10 h-10 rounded-full bg-gray-700">
                <div class="flex flex-col">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 whitespace-nowrap">
                        Company Name
                        <span class="text-xs font-medium text-red-600 bg-red-50 py-1 px-3 rounded-full">Featured</span>
                    </h2>
                    <div class="flex flex-col mt-2 space-y-1">
                        <div class="flex items-center gap-1">
                            <x-phosphor.icons::regular.map-pin class="w-4 h-4 text-black" />
                            <p class="text-sm text-gray-500">Bacolod City</p>
                        </div>
                        <p class="text-sm text-gray-800">Need Security Guard</p>
                        <p class="text-xs text-gray-400">Full Time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>