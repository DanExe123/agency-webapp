<section class="py-16 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">How ESecurityJobs Work</h2>
      </div>
  
      <!-- Steps -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-10 text-center relative" data-aos="fade-up" data-aos-duration="2000">
  
        <!-- Step 1 -->
        <div class="relative group flex flex-col items-center space-y-4 p-6 bg-gray-50 rounded-lg hover:bg-white transition ease-in-out duration-300 shadow-sm hover:shadow-md overflow-visible">
          <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 transition-colors duration-300 group-hover:bg-gray-900 relative z-20">
            <x-phosphor.icons::duotone.user-circle-plus class="w-8 h-8" />
          </div>
          <p class="text-sm font-medium text-gray-700">Create account</p>
          <p class="text-xs text-gray-500">for both agencies & companies</p>
        </div>
        
        <!-- Connector (curved line with arrow at ENDPOINT) -->
        <div class="absolute top-0 left-[100px] w-[350px] h-[100px] pointer-events-none z-10 rotate-180">
          <svg viewBox="0 0 250 100" class="w-full h-full">
            <!-- Arrowhead definition -->
            <defs>
              <marker id="arrowhead" markerWidth="10" markerHeight="10" 
                      refX="5" refY="3" orient="auto-start-reverse" fill="#9ca3af">
                <path d="M0,0 L0,6 L9,3 z" />
              </marker>
            </defs>

            <!-- Curve -->
            <path d="M 50 40 Q 125 100 200 40" 
                  stroke="#9ca3af" 
                  stroke-width="3" 
                  fill="none" 
                  stroke-dasharray="6 6"
                  marker-start="url(#arrowhead)" />
          </svg>
        </div>



        <!-- Step 2 -->
        <div class="relative group flex flex-col items-center space-y-4 p-6 bg-gray-50 rounded-lg hover:bg-white transition ease-in-out duration-300 shadow-sm hover:shadow-md overflow-visible">
          <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 transition-colors duration-300 group-hover:bg-gray-900 relative z-20">
            <x-phosphor.icons::regular.cloud-arrow-up class="w-8 h-8" />
          </div>
          <p class="text-sm font-medium text-gray-700">Upload CV/Resume</p>
          <p class="text-xs text-gray-500">to verify legitimacy</p>
        </div>

          <!-- Connector (curved line with arrow at ENDPOINT) -->
          <div class="absolute top-10 left-[460px] w-[250px] h-[100px] pointer-events-none z-10 ">
            <svg viewBox="0 0 250 100" class="w-full h-full">
              <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="10" 
                        refX="9" refY="3" orient="auto" fill="#9ca3af">
                  <path d="M0,0 L0,6 L9,3 z" />
                </marker>
              </defs>
          
              <!-- Curve -->
              <path d="M 50 40 Q 125 100 200 40" 
                    stroke="#9ca3af" 
                    stroke-width="3" 
                    fill="none" 
                    stroke-dasharray="6 6"
                    marker-end="url(#arrowhead)" /> 
            </svg>
          </div>
  
        

      
  
        <!-- Step 3 -->
        <div class="relative group flex flex-col items-center space-y-4 p-6 bg-gray-50 rounded-lg hover:bg-white transition ease-in-out duration-300 shadow-sm hover:shadow-md overflow-visible">
          <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 transition-colors duration-300 group-hover:bg-gray-900 relative z-20">
            <x-phosphor.icons::regular.magnifying-glass-plus class="w-8 h-8" />
          </div>
          <p class="text-sm font-medium text-gray-700">Find suitable agencies & companies</p>
          <p class="text-xs text-gray-500">to find each other</p>

         <!-- Connector (curved line with arrow at ENDPOINT) -->
         <div class="absolute top-0 left-[100px] w-[420px] h-[100px] pointer-events-none z-10 rotate-180">
          <svg viewBox="0 0 250 100" class="w-full h-full">
            <!-- Arrowhead definition -->
            <defs>
              <marker id="arrowhead" markerWidth="10" markerHeight="10" 
                      refX="5" refY="3" orient="auto-start-reverse" fill="#9ca3af">
                <path d="M0,0 L0,6 L9,3 z" />
              </marker>
            </defs>

            <!-- Curve -->
            <path d="M 50 40 Q 125 100 200 40" 
                  stroke="#9ca3af" 
                  stroke-width="3" 
                  fill="none" 
                  stroke-dasharray="6 6"
                  marker-start="url(#arrowhead)" />
          </svg>
        </div>
          
        </div>
  
        <!-- Step 4 -->
        <div class="relative group flex flex-col items-center space-y-4 p-6 bg-gray-50 rounded-lg hover:bg-white transition ease-in-out duration-300 shadow-sm hover:shadow-md overflow-visible">
          <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 transition-colors duration-300 group-hover:bg-gray-900 relative z-20">
            <x-phosphor.icons::regular.seal-check class="w-8 h-8" />
          </div>
          <p class="text-sm font-medium text-gray-700">External communication</p>
          <p class="text-xs text-gray-500">Companies and agencies can contact each other<br> through their own contact information</p>
  
          <!-- Arrow going UP -->
         
        </div>
      </div>
    </div>
  </section>
  