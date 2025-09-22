<!-- Navbar + Combined Steps -->
<div class="min-h-screen bg-gray-50">
  
  <!-- Navbar -->
  <header class="bg-white shadow-sm relative py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
      <div class="flex items-center gap-2 h-16">
        <x-phosphor.icons::regular.briefcase class="w-8 h-8 text-gray-600" />
        <h1 class="font-bold text-2xl text-gray-700">ESecurityJobs</h1>
      </div>

      <!-- Progress Bar -->
      <div>
        <p class="text-gray-600">Setup Progress</p>
        <div class="relative w-64 h-2 bg-gray-200 rounded-full overflow-hidden mt-2">
          <div 
            class="absolute top-0 left-0 h-3 bg-blue-600 transition-all duration-500"
            style="width: {{ $step * 33.3 }}%"
          ></div>
        </div>
      </div>
    </div>
  </header>

  <!-- Steps Navigation -->
  <div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex justify-center space-x-12 border-b border-gray-200">
      <button class="pb-3 border-b-2 font-medium text-sm flex gap-2 cursor-default 
        {{ $step === 1 ? 'border-blue-600 text-blue-600' : 'text-gray-500' }}">
        <x-phosphor.icons::regular.user class="w-5 h-5" /> Info
      </button>
      <button class="pb-3 border-b-2 font-medium text-sm flex gap-2 cursor-default 
        {{ $step === 2 ? 'border-blue-600 text-blue-600' : 'text-gray-500' }}">
        <x-phosphor.icons::regular.user-circle class="w-5 h-5" /> Founding Info
      </button>
      <button class="pb-3 border-b-2 font-medium text-sm flex gap-2 cursor-default 
        {{ $step === 3 ? 'border-blue-600 text-blue-600' : 'text-gray-500' }}">
        <x-phosphor.icons::regular.at class="w-5 h-5" /> Contact
      </button>
    </div>
  </div>

  <!-- Main Form -->
  <form wire:submit.prevent="save" class="space-y-6">

    <!-- STEP 1 -->
    @if($step === 1)
    <div class="max-w-4xl mx-auto px-6 space-y-6">
      <h2 class="text-lg font-semibold text-gray-800">Logo, bpl of legitimacy and valid ID</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Logo -->
        <div class="text-gray-600">
            <p>Company/Agency Logo</p>
            <label
                class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px] relative">
                <input type="file" wire:model="logo" class="hidden">

                {{-- Case 1: Temp uploaded file --}}
                @if ($logo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <span class="text-sm font-medium text-gray-600 truncate">{{ $logo->getClientOriginalName() }}</span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('logo', null)">✕</button>

                {{-- Case 2: Already saved file from DB --}}
                @elseif(!empty($logo))
                    <span class="text-sm font-medium text-gray-600 truncate">
                        {{ $profile->logo_original_name ?? basename($logo) }}
                    </span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('logo', null)">✕</button>

                {{-- Case 3: No file yet --}}
                @else
                    <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500" />
                    <span class="text-sm font-medium text-gray-600"><strong>Browse photo</strong> or drop here</span>
                @endif
            </label>
            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- bpl -->
        <div class="text-gray-600">
            <p>Business Permit and License (BPL)</p>
            <label
                class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px] relative">
                <input type="file" wire:model="bpl" class="hidden">

                @if ($bpl instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <span
                        class="text-sm font-medium text-gray-600 truncate">{{ $bpl->getClientOriginalName() }}</span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('bpl', null)">✕</button>

                @elseif(!empty($bpl))
                    <span class="text-sm font-medium text-gray-600 truncate">
                        {{ $profile->bpl_original_name ?? basename($bpl) }}
                    </span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('bpl', null)">✕</button>

                @else
                    <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500 mt-6" />
                    <span class="text-sm font-medium text-gray-600"><strong>Browse photo</strong> or drop here</span>
                @endif
            </label>
            @error('bpl') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Valid ID -->
        <div class="text-gray-600">
            <p>DTI Certificate</p>
            <label
                class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 cursor-pointer hover:border-blue-400 transition mt-2 h-[250px] relative">
                <input type="file" wire:model="dti" class="hidden">

                @if ($dti instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <span
                        class="text-sm font-medium text-gray-600 truncate">{{ $dti->getClientOriginalName() }}</span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('dti', null)">✕</button>

                @elseif(!empty($dti))
                    <span class="text-sm font-medium text-gray-600 truncate">
                        {{ $profile->dti_original_name ?? basename($dti) }}
                    </span>
                    <button type="button" class="absolute top-2 right-2 text-red-500 text-lg"
                        wire:click="$set('dti', null)">✕</button>

                @else
                    <x-phosphor.icons::regular.cloud-arrow-up class="w-12 h-12 text-gray-500" />
                    <span class="text-sm font-medium text-gray-600"><strong>Browse photo</strong> drop here</span>
                @endif
            </label>
            @error('dti') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">About Us</label>
        <textarea wire:model="about_us" rows="4" placeholder="Write down about your company here..." class="block w-full border rounded-md p-3"></textarea>
        @error('about_us') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end">
        <button type="button" wire:click="nextStep" class="px-6 py-3 bg-[#0000006B] text-white rounded-md hover:bg-blue-700 flex gap-2">
          Save & Next <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
        </button>
      </div>
    </div>
    @endif

    <!-- STEP 2 -->
    @if($step === 2)
    <div class="max-w-4xl mx-auto px-6 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Organization Type</label>
          <select wire:model="organization_type" class="mt-1 block w-full border py-2 rounded-md text-gray-400">
            <option>Select...</option>
            <option value="Private">Private</option>
            <option value="Public">Public</option>
          </select>
          @error('organization_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Industry Types</label>
          <select wire:model="industry_type" class="mt-1 block w-full border py-2 rounded-md text-gray-400">
            <option>Select...</option>
            <option value="Security">Security</option>
          </select>
          @error('industry_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Team Size</label>
          <select wire:model="team_size" class="mt-1 block w-full border py-2 rounded-md text-gray-400">
            <option>Select...</option>
            <option value="1-10">1-10</option>
            <option value="11-50">11-50</option>
            <option value="50+">50+</option>
          </select>
          @error('team_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Year of Establishment</label>
          <input wire:model="year_established" type="date" class="mt-1 block w-full border py-2 rounded-md text-gray-400">
          @error('year_established') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Agency/Company Website</label>
          <div class="relative">
            <input wire:model="website" type="url" placeholder="Website url..." class="mt-1 block w-full border py-2 rounded-md text-gray-400 pl-10">
            <x-phosphor.icons::regular.globe class="w-5 h-5 text-gray-400 absolute left-3 top-3" />
          </div>
          @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Agency/Company Vision & Specializations</label>
        <textarea wire:model="vision" rows="4" placeholder="Tell us about your agency vision..." class="block w-full border rounded-md p-3"></textarea>
        @error('vision') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-between">
        <button type="button" wire:click="prevStep" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Previous</button>
        <button type="button" wire:click="nextStep" class="px-6 py-3 bg-[#0000006B] text-white rounded-md hover:bg-blue-700 flex gap-2">
          Save & Next <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
        </button>
      </div>
    </div>
    @endif

    <!-- STEP 3 -->
    @if($step === 3)
    <div class="max-w-4xl mx-auto px-6 space-y-6">
      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input wire:model="address" type="text" class="mt-1 block w-full border py-2 rounded-md">
        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <div class="flex items-center space-x-2">
          <div class="flex items-center border border-gray-300 rounded-md px-2 py-2 bg-gray-50">
            <img src="/ph.png" alt="PH" class="w-5 h-3 mr-2">
            <span class="text-sm">+63</span>
          </div>
          <input wire:model="phone" type="text" placeholder="Phone number..." class="flex-1 block border py-2 rounded-md">
        </div>
        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>


      <div class="flex justify-between">
        <button type="button" wire:click="prevStep"
            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
            Previous
        </button>
        <button type="submit"
            class="px-6 py-3 bg-[#0000006B] text-white rounded-md hover:bg-blue-700 flex gap-2">
            Finish
            <x-phosphor.icons::regular.arrow-right class="w-6 h-6 text-white" />
        </button>
      </div>
    </div>
    @endif
  </form>
</div>
