<!-- Navbar -->
<div>
    <header class="bg-white shadow-sm relative py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
        <div class="flex justify-between items-center h-16">
          
          <!-- Left: Icon + Title -->
          <div class="flex items-center gap-2">
            <x-phosphor.icons::regular.briefcase class="w-8 h-8 text-gray-600" />
            <h1 class="font-bold text-2xl text-gray-700">ESecurityJobs</h1>
          </div>
        </div>
    
        <!-- Progress Bar -->
        <div class="flex-nowrap">
          <p class="text-gray-600">Setup Progress</p>
      <div class="relative w-64 h-2 bg-gray-200 rounded-full overflow-hidden mt-2">
        <div 
          class="absolute top-0 left-0 h-3 bg-blue-600 transition-all duration-500"
          :style="'width: ' + (step * 33.3) + '%'"
        ></div>
      </div>
        </div>
    
      </div>
    </header>
    
    <div x-data="{ step: 'agency' }" class="min-h-screen bg-gray-50">
      <!-- Steps Navigation -->
      <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="flex justify-center space-x-12 border-b border-gray-200">
          <button @click="step='agency'" 
                  :class="step==='agency' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                  class="pb-3 border-b-2 font-medium text-sm focus:outline-none flex justify-start gap-2">
                  <x-phosphor.icons::regular.user class="w-5 h-5" />
            Agency Info
          </button>
          <button @click="step='founding'" 
                  :class="step==='founding' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                  class="pb-3 border-b-2 font-medium text-sm focus:outline-none flex justify-start gap-2">
                  <x-phosphor.icons::regular.user-circle class="w-5 h-5" />
            Founding Info
          </button>
          <button @click="step='contact'" 
                  :class="step==='contact' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                  class="pb-3 border-b-2 font-medium text-sm focus:outline-none flex justify-start gap-2">
                  <x-phosphor.icons::regular.at class="w-5 h-5" />
            Contact
          </button>
        </div>
      </div>
      
      <!-- credential tabs , agency info , founding info , contact -->
    @livewire('credentials-verification')
    @livewire('founding-info')
    @livewire('contact')
      
    
        </div>
      </div>
    
    </div>
    </div>
    