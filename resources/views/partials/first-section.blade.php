<section class="max-w-7xl mx-auto px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <!-- Left -->
    <div class="space-y-6" data-aos="fade-up" data-aos-duration="2000">
      <h1 class="text-4xl sm:text-4xl font-bold text-gray-900 leading-tight tracking-wide"  data-aos="fade-up" data-aos-duration="2000">
        Find a company that <br> suits your agency.
      </h1>
      
      <p class="text-gray-600" data-aos="fade-up" data-aos-duration="2000">
        This is a website for companies who are in need of security guards.
      </p>

  
      <!-- Search Bar -->
      <a href="{{ route('search') }}" class="block">
      <div class="bg-white shadow-md rounded-md flex items-center p-2 space-x-2 w-full max-w-xl overflow-hidden cursor-pointer">
        
          <!-- First Input (Search) -->
          <div class="relative flex-1 flex items-center">
            <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-900 absolute left-3 top-1/2 transform -translate-y-1/2" />
            <input 
              type="text" 
              placeholder="Company/agency title, Keyword"
              class="w-full border-none focus:ring-0 text-sm pl-10 pr-3 py-2 pointer-events-none"
            >
          </div>

          <!-- Divider -->
          <div class="w-px h-6 bg-gray-300"></div>

          <!-- Second Input (Location) -->
          <div class="relative flex-1 flex items-center">
            <x-phosphor.icons::regular.map-pin class="w-5 h-5 text-gray-900 absolute left-3 top-1/2 transform -translate-y-1/2" />
            <input 
              type="text" 
              placeholder="Your Location"
              class="w-full border-none focus:ring-0 text-sm pl-10 pr-3 py-2 pointer-events-none"
            >
          </div>

          <!-- Button -->
          <button class="bg-black text-white px-6 py-2 text-sm font-medium hover:bg-gray-800 pointer-events-none">
            Find
          </button>
      </div>
      </a>



      <!-- Suggestions -->
      <p class="text-sm text-gray-500">
        Suggestion: <span class="font-semibold">Bodyguard</span>, 
        <span class="font-semibold text-gray-900">Securityguard</span>, Ladyguard
      </p>
    </div>

    <!-- Right (Illustration) -->
    <div class="flex justify-center md:justify-end" data-aos="fade-left" data-aos-duration="2000" >
      <img src="{{ asset('hero-removebg-preview.png') }}" alt="Illustration" class="w-[550px] sm:w-96">
    </div>
  </section>