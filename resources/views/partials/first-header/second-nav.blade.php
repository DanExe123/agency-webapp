<header class="bg-white shadow-sm relative py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Left: Icon + Search with Flag -->
        <div class="flex items-center space-x-3">
  
          <!-- Icon -->
          <x-phosphor.icons::regular.briefcase class="w-6 h-6 text-gray-900" />
  
          <!-- Search Box with Flag Selector -->
          <div class="relative flex items-center border border-gray-300 rounded-md overflow-hidden">
            
            <!-- Flag Dropdown -->
            <div x-data="{ open: false, selected: { flag: '/ph.png', label: 'Ph' } }" class="relative">
              <button 
                @click="open = !open" 
                class="flex items-center px-2 py-1 text-sm hover:bg-gray-100"
              >
                <img :src="selected.flag" alt="Flag" class="w-5 h-3 mr-1">
                <span x-text="selected.label"></span>
                <x-phosphor.icons::regular.caret-down class="w-4 h-4 text-gray-900 ml-1" />
                </svg>
              </button>
  
              <!-- Dropdown -->
              <div 
                x-show="open" 
                @click.away="open = false"
                class="absolute mt-1 w-32 bg-white border border-gray-200 rounded-md shadow-md z-10"
              >
                <ul class="py-1">
                  <li>
                    <button 
                      @click="selected = { flag: '/ph.png', label: 'Ph' }; open = false" 
                      class="flex items-center w-full px-2 py-1 text-sm hover:bg-gray-100"
                    >
                      <img src="/ph.png" alt="PH" class="w-5 h-5 mr-1"> Ph
                    </button>
                  </li>
                  <li>
                    <button 
                      @click="selected = { flag: '/us.png', label: 'En' }; open = false" 
                      class="flex items-center w-full px-2 py-1 text-sm hover:bg-gray-100"
                    >
                      <img src="/us.png" alt="EN" class="w-5 h-5 mr-1"> En
                    </button>
                  </li>
                </ul>
              </div>
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
          <a wire:navigate href="{{ route('loginform') }}">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-100">
              Sign In
            </button>
          </a>
          
        </div>
  
      </div>
    </div>
  </header>
  