<header class="bg-gray-100 shadow-sm relative ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Left -->
        <div class="flex items-center space-x-6">
            <nav class="hidden md:flex space-x-6 fixed">
                @hasrole('Admin')
                    <a wire:navigate href="{{ route('admin-dashboard') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        Dashboard
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                    <a wire:navigate href="{{ route('admin-UserManage') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        User Management
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                    <a wire:navigate href="{{ route('admin-PostManage') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        Post Management
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                    <a wire:navigate href="{{ route('admin-Audit') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                        Audit Trail
                        <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                    </a>
                @endhasrole

             @hasrole('Agency|Company')
              <a wire:navigate href="{{ route('dashboard') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                  Home
                  <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
              </a>
              @endhasrole

              @hasrole('Agency')
                @if(Auth::user()->account_status === 'verified')
                  <a wire:navigate href="{{ route('company') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                      Companies
                      <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                  </a>
                  <a wire:navigate href="{{ route('post-applied') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                      Post Applied
                      <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                  </a>
                @else
                    <!-- 🚫 Show disabled text or tooltip for unverified accounts -->
                    <span class="text-gray-400 cursor-not-allowed text-sm italic">
                        (Account not verified)
                    </span>
                @endif
              @endhasrole

              @hasrole('Company')
                  @if(Auth::user()->account_status === 'verified')
                      <a wire:navigate href="{{ route('job-posting') }}" class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                          Job Posting
                          <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                      </a>
                  @else
                      <!-- 🚫 Show disabled text or tooltip for unverified accounts -->
                      <span class="text-gray-400 cursor-not-allowed text-sm italic">
                          (Account not verified)
                      </span>
                  @endif
              @endhasrole

              @hasanyrole('Company|Agency')
                @if(Auth::user()->account_status === 'verified')
                  <a  href="{{ route('chatify') }}" target="_blank"  class="relative group text-gray-500 hover:text-blue-600 transition-colors">
                      Messages
                      <span class="absolute left-0 -bottom-[18px] w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                  </a>
                @endif
              @endhasanyrole
          </nav>
           
        </div>
  
        <!-- Right -->
         <div class="hidden md:flex items-center space-x-2">
         
            @hasrole('Admin')
            <livewire:admin-notif />
            @endhasrole


            @hasanyrole('Company|Agency')
            <livewire:company-notif />

            @endhasrole

                @auth
                    <!-- Livewire Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        
                        <button @click="open = !open" class="flex items-center space-x-2 rounded-md hover:bg-gray-100 px-3 py-2">
                            @if(Auth::user()->profile && Auth::user()->profile->logo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile->logo_path) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/40" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                            @endif
                            <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                            <!-- Profile Link -->
                            <a wire:navigate href="{{ route('settings.profile') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-black transition-colors duration-150">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 7a4 4 0 100 8 4 4 0 000-8z" />
                                </svg>
                                Profile
                            </a>

                            <!-- Divider -->
                            <div class="border-t my-1"></div>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm font-medium text-white bg-black rounded-md hover:bg-gray-100 hover:text-black transition-colors duration-150">
                                    <svg class="w-5 h-5 text-white group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-8V7" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>

                    </div>
                @endauth


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
  