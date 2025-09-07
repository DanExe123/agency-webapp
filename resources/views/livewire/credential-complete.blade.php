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

            <!-- Login Section -->
        <main class="min-h-screen flex items-center justify-center px-4">
            <div class="w-full flex flex-col items-center text-center space-y-3 p-6">
                <!-- Icon -->
                <div class="flex justify-center items-center w-20 h-20 rounded-full" style="background-color: #E7F0FA;">
                    <x-phosphor.icons::regular.checks class="w-10 h-10 text-blue-600" />
                </div>
            
                <!-- Title -->
                <p class="text-gray-800 text-2xl font-semibold">
                    🎉 Congratulations, please wait to approve your verification!
                </p>
            
                <!-- Subtitle -->
                <p class="text-gray-600 text-sm max-w-xl">
                    When approved, you may now browse our website and find your suitable company for your security agency.
                </p>
            
                <!-- Info -->
                <p class="text-gray-600 text-sm max-w-xl">
                    It takes a day or an hour to approve your verification.
                </p>
            
                <!-- Footer -->
                <p class="text-gray-600 text-sm max-w-xl">
                    Thank you for your consideration in waiting. <br>
                    Results will be emailed to your registered email address.
                </p>
            </div>
            
        </main>
            
        </div>
      </div>
    
  