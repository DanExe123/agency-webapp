<div>
  <!-- Founding Info -->
  <div class="max-w-4xl mx-auto px-6">
    <div x-show="step==='founding'" class="space-y-6">
    <!-- Row 1: Organization Type / Industry Types / Team Size -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label for="organization" class="block text-sm font-medium text-gray-700">Organization Type</label>
        <select id="organization" class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-400">
          <option class>Select...</option>
        </select>
      </div>
  
      <div>
        <label for="industry" class="block text-sm font-medium text-gray-700">Industry Types</label>
        <select id="organization" class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-400">
          <option>Select...</option>
        </select>
      </div>
  
      <div>
        <label for="team-size" class="block text-sm font-medium text-gray-700">Team Size</label>
        <select id="organization" class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-400">
          <option>Select...</option>
        </select>
      </div>
    </div>
  
    <!-- Row 2: Year / Website -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="year" class="block text-sm font-medium text-gray-700">Year of Establishment</label>
        <div class="mt-1 relative">
          <input type="date" id="year" placeholder="dd/mm/yyyy" 
                 class="block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pr-1 text-gray-400">
        </div>
      </div>
  
      <div>
        <label for="website" class="block text-sm font-medium text-gray-700">Agency Website</label>
        <div class="mt-1 relative">
          <input type="url" id="website" placeholder="Website url..." 
                 class="block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm pl-10 text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <x-phosphor.icons::regular.globe class="w-5 h-5" />
          </span>
        </div>
      </div>
    </div>
  
    <!-- Row 3: Vision -->
    <div>
      <label for="vision" class="block text-sm font-medium text-gray-700">Agency Vision & Specializations</label>
      <div class="mt-1 border border-gray-300 rounded-md shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
        <textarea id="vision" rows="4" placeholder="Tell us about your agency vision & Specializations..." 
                  class="block w-full border-0 focus:ring-0 sm:text-sm p-3 rounded-t-md"></textarea>
    <!-- Toolbar -->
    <div class="flex items-center gap-4 px-3 py-2 border-t border-gray-200 text-gray-500 text-sm">
        <button type="button" class="hover:text-blue-600">
        <x-phosphor.icons::regular.text-b class="w-4 h-4 text-black" />
        </button>
        <button type="button" class="italic hover:text-blue-600">
        <x-phosphor.icons::regular.text-italic class="w-4 h-4 text-black" />
        </button>
        <button type="button" class="underline hover:text-blue-600">
        <x-phosphor.icons::regular.text-underline class="w-4 h-4 text-black" />
        </button>
        <button type="button" class="line-through hover:text-blue-600">
        <x-phosphor.icons::regular.text-strikethrough class="w-4 h-4 text-black" />
        </button>
        <button type="button" class="hover:text-blue-600">
        <x-phosphor.icons::regular.text-strikethrough class="w-4 h-4 text-black" />
        </button>
        |


        <button type="button" class="hover:text-blue-600">
        <x-phosphor.icons::regular.link class="w-4 h-4 text-black" />
        </button>
        |
        <button type="button" class="hover:text-blue-600">
        <x-phosphor.icons::regular.text-align-justify class="w-4 h-4 text-black" />
        </button>
        <button type="button" class="hover:text-blue-600">
        <x-phosphor.icons::regular.list-numbers class="w-4 h-4 text-black" />
        </button>
    </div>
      </div>
    </div>
  
    <!-- Buttons -->
    <div class="flex justify-start gap-2">
      <button class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
      <button class="px-6 py-3 bg-[#0000006B] text-white rounded-md shadow hover:bg-blue-700 transition">
        <div class="justify-start flex gap-2">
        Save & Next 
        <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
        </div>
      </button>
    </div>
  
  </div>
  </div>
  
</div>
