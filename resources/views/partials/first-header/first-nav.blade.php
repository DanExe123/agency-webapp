<header class="bg-gray-100 shadow-sm relative ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Left -->
        <div class="flex items-center space-x-6">
            <nav class="hidden md:flex space-x-6 fixed">
                <a wire:navigate href="{{ route('dashboard') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                  Home
                  <!-- underline bar -->
                  <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                @hasrole('Agency')
                    <a href="" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        Agencies
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                @endhasrole

                @hasrole('Company')
                    <a wire:navigate href="{{ route('company') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        Companies
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                @endhasrole

              </nav>              
        </div>
  
        <!-- Right -->
        <div class="hidden md:flex items-center space-x-6">
            <x-phosphor.icons::regular.phone-call class="w-6 h-6 text-gray-500" />
            <span class="text-gray-700 font-semibold">63+ 9*********</span>

   <!-- Language Selector (Only English with US flag) -->
<div class="relative">
  <button 
    class="flex items-center px-4 py-2  rounded-md hover:bg-gray-100"
  >
    <img src="/us.png" alt="US Flag" class="w-5 h-3 mr-2">
    <span>English</span>
  </button>
</div>

        </div>
  
        <!-- Mobile Menu Button -->
        <button @click="openMenu = !openMenu" class="md:hidden">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  
    <!-- Mobile Menu -->
    <div x-show="openMenu" class="md:hidden bg-white border-t border-gray-200 p-4 space-y-4">
      <a href="#" class="block hover:text-blue-600">Home</a>
      <a href="#" class="block hover:text-blue-600">Agencies</a>
      <a href="#" class="block hover:text-blue-600">Companies</a>
      <div class="border-t pt-4 space-y-2">
        <x-phosphor.icons::regular.bell class="w-6 h-6 text-gray-500" />
        <button class="w-full px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">Sign In</button>
      </div>
    </div>
  </header>
  