<div>
    <!-- Form Section -->
    <div class="max-w-4xl mx-auto px-6">
      <div x-show="step==='agency'" class="space-y-6">
  
        <h2 class="text-lg font-semibold text-gray-800">Logo, certificate of legitimacy and valid ID</h2>
  
        <!-- Uploads -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Upload Logo -->
          <div class="flex-nowrap not-italic mb-4 text-gray-600">
          <p>Upload Document</p>
          <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px]">
            <input type="file" class="hidden">
            <div class="flex flex-col items-center justify-center text-center mt-4">
              <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500" />
            <span class="text-sm font-medium text-gray-600 text-center"><strong>Browse photo</strong> or drop here</span>
            <span class="text-xs text-gray-400 mt-1">A photo larger than 400pexels<br> works best. Max photo size 5 MB</span>
          </label>
          </div>
          </div>
  
                <!-- Certificate -->
          <div class="flex-nowrap not-italic mb-4 text-gray-600">
            <p>Certificate of legitimacy</p>
  
            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px]">
              <input type="file" class="hidden">
  
              <!-- Centered content -->
              <div class="flex flex-col items-center justify-center text-center mt-10">
                <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500" />
                <span class="text-sm font-medium text-gray-600"><strong>Browse photo</strong> or drop here</span>
                <span class="text-xs text-gray-400">Banner image optimal dimension 1520x400 <br> Supported format JPEG, PNG. Max photo size 5 MB.</span>
              </div>
            </label>
          </div>
  
  
          <!-- Valid ID -->
          <div class="flex-nowrap not-italic mb-4 text-gray-600">
            <p>Valid ID</p>
          <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px]">
            <input type="file" class="hidden">
            <div class="flex flex-col items-center justify-center text-center mt-4">
              <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500" />
            <span class="text-sm font-medium text-gray-600"><strong>Browse photo</strong> drop here</span>
            <span class="text-xs text-gray-400 mt-1">A photo larger than 400px works best. Max 5 MB</span>
          </label>
          </div>
          </div>
  
        </div>
  
        <!-- Agency Name -->
        <div>
          <label for="agency" class="block text-sm font-medium text-gray-700">Agency Name</label>
          <input type="text" id="agency"
                 class="mt-1 block w-full border py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
  
            <!-- About Us -->
      <div>
        <label for="about" class="block text-sm font-medium text-gray-700">About Us</label>
  
        <div class="mt-1 border border-gray-300 rounded-md shadow-sm">
          <!-- Textarea -->
          <textarea 
            id="about" 
            rows="4" 
            placeholder="Write down about your company here. Let the candidate know who we are..." 
            class="block w-full border-0 focus:ring-0 sm:text-sm p-3 rounded-t-md"
          ></textarea>
  
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
  
        <!-- Save & Next -->
        <div class="pt-4">
          <button class="px-6 py-3 bg-[#0000006B] text-white rounded-md shadow hover:bg-blue-700 transition">
            <div class="justify-start flex gap-2">
            Save & Next 
            <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
            </div>
          </button>
        </div>
</div>