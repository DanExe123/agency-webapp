<div class="max-w-3xl mx-auto p-6 space-y-6">
  <div class="relative">
    <!-- Search Bar -->
    <div class="bg-white shadow-md rounded-md flex items-center p-3 space-x-3 w-full max-w-full overflow-hidden">
      
      <!-- First Input (Search) -->
      <div class="relative flex-1 flex items-center">
        <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-900 absolute left-3 top-1/2 transform -translate-y-1/2" />
        <input 
          type="text" 
          wire:model.debounce.500ms="search"
          placeholder="Company/agency title, Keyword"
          class="w-full border-none focus:ring-0 text-base pl-10 pr-3 py-3" 
        />
      </div>
      
      <!-- Divider -->
      <div class="w-px h-8 bg-gray-300"></div>
      
      <!-- Second Input (Location) -->
      <div class="relative flex-1 flex items-center">
        <x-phosphor.icons::regular.map-pin class="w-5 h-5 text-gray-900 absolute left-3 top-1/2 transform -translate-y-1/2" />
        <input 
          type="text" 
          wire:model.debounce.500ms="location"
          placeholder="Your Location"
          class="w-full border-none focus:ring-0 text-base pl-10 pr-3 py-3"
        />
      </div>
      
      <!-- FIND Button -->
      <button 
        wire:click="find"
        wire:loading.attr="disabled"
        class="bg-black text-white px-5 py-3 text-base font-semibold hover:bg-gray-800 disabled:opacity-50 flex items-center gap-1 transition-all rounded"
      >
        <span wire:loading.remove>Find</span>
        <span wire:loading>🔍</span>
      </button>
    </div>
  
    <!-- Search Results Dropdown -->
    @if($showResults && count($searchResults) > 0)
      <div class="absolute z-50 w-full max-w-full mt-2 bg-white shadow-lg rounded-md border">
        @foreach($searchResults as $user)
          <a href="{{ route('profile.visit', $user->id) }}" 
             class="flex items-center p-3 hover:bg-gray-50 border-b last:border-b-0 transition-colors">
            <!-- Avatar -->
            <div class="flex-shrink-0">
              @if($user->profile?->logo_path)
                <img src="{{ asset('storage/' . $user->profile->logo_path) }}" 
                     alt="{{ $user->name }}" 
                     class="w-12 h-12 rounded-full object-cover">
              @else
                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                  {{ $user->initials() }}
                </div>
              @endif
            </div>

            <!-- User Info -->
            <div class="ml-4 flex-1 min-w-0">
              <p class="text-base font-medium text-gray-900 truncate">{{ $user->name }}</p>
              <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
              @if($user->profile)
                <p class="text-xs text-gray-500">
                  {{ $user->profile->city ?? '' }}, {{ $user->profile->country ?? '' }}
                </p>
              @endif
            </div>

            <!-- Rating -->
            <div class="flex items-center ml-3 text-right space-x-1">
              @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $user->averageRating() >= $i ? 'fill-current text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.285a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118L10 13.347l-2.893 2.02c-.784.57-1.838-.196-1.54-1.118l1.07-3.285a1 1 0 00-.364-1.118L3.47 8.712c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.285z"/>
                </svg>
              @endfor
              <span class="text-sm font-medium text-gray-900 ml-1">
                {{ number_format($user->averageRating(), 1) }} 
                <span class="text-gray-500 font-normal">({{ $user->feedbackCount() }})</span>
              </span>
            </div>
          </a>
        @endforeach
      </div>
    @elseif($showResults)
      <div class="absolute z-50 w-full max-w-full mt-2 bg-white shadow-lg rounded-md border p-4 text-center text-gray-500">
        No results found
      </div>
    @endif
  </div>
</div>
