<div>
    <!-- contact Info -->
    <div class="max-w-4xl mx-auto px-6">
      <div x-show="step==='contact'" class="space-y-6">
     
      <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <div>
          <label for="Address" class="block text-sm font-medium text-gray-700">Address</label>
          <input type="text" id="agency"
          class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pl-2">
        </div>
    
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <!-- Left: Icon + Search with Flag -->
        <div class="flex items-center space-x-3">
            <!-- Search Box with Flag Selector -->
            <div class="relative flex items-center border border-gray-300 rounded-md overflow-hidden">
              
              <!-- Flag Dropdown -->
              <div x-data="{ open: false, selected: { flag: '/ph.png', label: 'Ph' } }" class="relative">
                <button 
                  @click="open = !open" 
                  class="flex items-center px-2 py-1 text-sm hover:bg-gray-100"
                >
                  <img :src="selected.flag" alt="Flag" class="w-5 h-3 mr-1">
                  <span x-text="">+63</span>
                </button>
              </div>
    
              <!-- Divider -->
              <div class="w-px h-6 bg-gray-300 mx-2"></div>
    
              <!-- Search Input -->
              <div class="relative flex-1">
                <input 
                  type="text" 
                  placeholder="Phone number .."
                  class="w-[500px] pl-8 pr-3 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 border-0"
                >
                <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-400 absolute left-2 top-3" />
              </div>
            </div>
          </div>
        </div>

        <!-- email -->
        <div>
          <label for="Address" class="block text-sm font-medium text-gray-700">Email</label>
          <div class="relative">
          <input type="text" id="agency"
          placeholder="Enter email Address .."
          class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pl-2">
          <x-phosphor.icons::regular.envelope class="w-5 h-5 text-gray-400 absolute left-2 top-2" />
          </div>
        </div>
    
      </div>  
      <!-- Buttons -->
      <div class="flex justify-start gap-2">
        <button class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
        <button class="px-6 py-3 bg-[#0000006B] text-white rounded-md shadow hover:bg-blue-700 transition">
          <div class="justify-start flex gap-2">
          Finish 
          <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
          </div>
        </button>
      </div>
    
    </div>
    </div>
    
  </div>
  