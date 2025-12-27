<section class="w-full">
    <x-settings.layout :heading="__('Profile')" :subheading="__('Manage your profile')">
         {{-- Account Status Notification --}}
        @php
            $user = auth()->user();
        @endphp

        @if($user && $user->profile) {{-- only show if user has a profile --}}
            @if($user->account_status === 'pending')
                <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800">
                    Your account is currently <strong>Pending</strong>. Please wait for verification.
                </div>
            @elseif($user->account_status === 'rejected')
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-800">
                    Your account was <strong>Rejected</strong>.
                    @if($user->rejection_feedback)
                        <div class="mt-1">
                            Feedback: {{ $user->rejection_feedback }}
                        </div>
                    @endif
                </div>
            @endif
        @endif
        
        {{-- Edit / Cancel button --}}
        <div class="flex justify-end mb-4">
            @if (isset($isEditing) && $isEditing)
                <button wire:click="cancelEdit" type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancel
                </button>
            @else
                <button wire:click="edit" type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit Profile
                </button>
            @endif
        </div>

        {{-- EDIT FORM --}}
        @if (isset($isEditing) && $isEditing)
            <form wire:submit.prevent="updateProfileInformation" class="my-6 w-full space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model.defer="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
                    <flux:input wire:model.defer="email" :label="__('Email')" type="email" required autocomplete="email" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Organization Type Select -->
                    <div class="flex flex-col">
                        <label class="mb-1 font-semibold text-gray-700">{{ __('Organization Type') }}</label>
                        <select wire:model.defer="organization_type" class="border rounded-md px-3 py-2">
                            <option>Select...</option>
                            <option value="Private">Private</option>
                            <option value="Public">Public</option>
                        </select>
                        @error('organization_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Industry Type Select -->
                    <div class="flex flex-col">
                        <label class="mb-1 font-semibold text-gray-700">{{ __('Industry Type') }}</label>
                        <select wire:model.defer="industry_type" class="border rounded-md px-3 py-2">
                            <option value="">Select Industry Type</option>
                            <option value="tech">Security agency</option>
                            <option value="tech">Technology</option>
                            <option value="finance">Finance</option>
                            <option value="health">Healthcare</option>
                            <option value="education">Education</option>
                            <option value="other">Other</option>
                        </select>
                        @error('industry_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model.defer="phone" :label="__('Phone')" type="text" />

                    <!-- Team Size Select -->
                    <div class="flex flex-col">
                        <label class="mb-1 font-semibold text-gray-700">{{ __('Team Size') }}</label>
                        <select wire:model.defer="team_size" class="border rounded-md px-3 py-2">
                            <option>Select...</option>
                            <option value="1-10">1-10</option>
                            <option value="11-50">11-50</option>
                            <option value="50+">50+</option>
                        </select>
                        @error('team_size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model.defer="website" :label="__('Website')" type="url" />
                    <flux:input wire:model.defer="year_established" :label="__('Year Established')" type="date" />
                </div>

                <div>
                    <flux:input wire:model.defer="address" :label="__('Address')" type="text" />
                </div>

                <div>
                    <flux:textarea wire:model.defer="about_us" :label="__('About / Description')" />
                </div>

                <div>
                    <flux:textarea wire:model.defer="vision" :label="__('Vision')" />
                </div>

                {{-- FILE PREVIEWS --}}

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Logo --}}
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm font-semibold mb-2">Logo</h3>
                        <div class="w-24 h-24 rounded-full overflow-hidden border border-gray-200 mb-2">
                            @if($logoFile)
                                <img src="{{ $logoFile->temporaryUrl() }}" class="w-full h-full object-cover" />
                            @elseif($logo_path)
                                <img src="{{ asset('storage/' . $logo_path) }}" class="w-full h-full object-cover" />
                            @else
                                <img src="https://via.placeholder.com/150" class="w-full h-full object-cover" />
                            @endif
                        </div>
                        <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">
                            Select Logo
                            <input type="file" wire:model="logoFile" accept="image/*" class="hidden" />
                        </label>
                        @error('logoFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- BPL --}}
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm font-semibold mb-2">BPL</h3>
                        @if($bpl_path)
                            <a href="{{ asset('storage/' . $bpl_path) }}" target="_blank" class="text-blue-600 underline mb-2 block">
                                {{ $bpl_original_name ?? 'View Current BPL' }}
                            </a>
                        @endif
                        <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">
                            Upload BPL
                            <input type="file" wire:model="bplFile" accept=".pdf,.jpg,.png" class="hidden" />
                        </label>
                        @error('bplFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        @if($bplFile)
                            <span class="text-gray-700 text-sm mt-1 truncate w-32 block">{{ $bplFile->getClientOriginalName() }}</span>
                        @endif
                    </div>

                    {{-- DTI --}}
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm font-semibold mb-2">DTI</h3>
                        @if($dti_path)
                            <a href="{{ asset('storage/' . $dti_path) }}" target="_blank" class="text-blue-600 underline mb-2 block">
                                {{ $dti_original_name ?? 'View Current DTI' }}
                            </a>
                        @endif
                        <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">
                            Upload DTI
                            <input type="file" wire:model="dtiFile" accept=".pdf,.jpg,.png" class="hidden" />
                        </label>
                        @error('dtiFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        @if($dtiFile)
                            <span class="text-gray-700 text-sm mt-1 truncate w-32 block">{{ $dtiFile->getClientOriginalName() }}</span>
                        @endif
                    </div>
                </div>



                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end w-full md:w-1/3">
                        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                            {{ __('Save') }}
                        </button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>

            </form>
        @endif

        {{-- READ-ONLY PROFILE DISPLAY --}}
        @if (!isset($isEditing) || ! $isEditing)
            @php
                $user = auth()->user();
                $profile = $user->profile;
                $isIncomplete = 
                    !$profile ||
                    !$profile->bpl_path ||
                    !$profile->dti_path ||
                    !$profile->logo_path ||
                    empty($profile->organization_type) ||
                    empty($profile->industry_type);
            @endphp

            <div class="max-w-5xl mx-auto p-6 bg-white rounded-lg border">
                @if($isIncomplete)
                <div class="border-l-4 border-b border-yellow-500 text-yellow-700 p-4 mb-6 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">Finish your profile or verification process.</p>
                        <p class="text-sm">Some required information or documents are missing.</p>
                    </div>
                    <a href="{{ route('credentials') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Complete Now
                    </a>
                </div>
            @endif
                <div class="flex flex-col md:flex-row md:items-center gap-6 mb-8">
                    {{-- Logo --}}
                    <div class="w-28 h-28 rounded-full overflow-hidden border border-gray-200">
                        @if($profile && $profile->logo_path)
                            <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://via.placeholder.com/150" alt="No Logo" class="w-full h-full object-cover">
                        @endif
                    </div>

                    {{-- Name, Type, Industry, Address --}}
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $profile->organization_type ?? 'Agency / Company' }} • {{ $profile->industry_type ?? 'Industry N/A' }}</p>
                        <p class="text-gray-500 text-sm">{{ $profile->address ?? 'No address provided' }}</p>

                        {{-- Ratings --}}
                        <div class="flex items-center gap-2 mt-2">
                            <span class="font-semibold text-yellow-500">★ {{ $user->averageRating() }}</span>
                            <span class="text-gray-500 text-sm">({{ $user->feedbackCount() }} Feedbacks)</span>
                        </div>
                    </div>
                </div>

                {{-- About / Vision / Website --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-1">About</h3>
                    <p class="text-gray-600 text-sm">{{ $profile->about_us ?? 'No information available.' }}</p>
                </div>

                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-1">Vision</h3>
                        <p class="text-gray-600 text-sm">{{ $profile->vision ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-1">Website</h3>
                        @if(!empty($profile->website))
                            <a href="{{ $profile->website }}" target="_blank" class="text-blue-600 underline">{{ $profile->website }}</a>
                        @else
                            <p class="text-gray-600 text-sm">N/A</p>
                        @endif
                    </div>
                </div>

                {{-- Other Details --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-sm text-gray-500"><span class="font-semibold">Team Size:</span> {{ $profile->team_size ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500"><span class="font-semibold">Established:</span>  {{ $profile && $profile->year_established ? \Carbon\Carbon::parse($profile->year_established)->format('Y') : 'N/A' }}</div>
                    <div class="text-sm text-gray-500"><span class="font-semibold">Phone:</span> {{ $profile->phone ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500"><span class="font-semibold">Type:</span> {{ $profile->organization_type ?? 'N/A' }}</div>
                </div>


                @php
                    function truncateFileName($fileName, $limit = 12) {
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $name = pathinfo($fileName, PATHINFO_FILENAME);

                        if (strlen($name) > $limit) {
                            $name = Str::limit($name, $limit, '...');
                        }

                        return $name . '.' . $ext;
                    }
                @endphp
                                {{-- File Links --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    {{-- BPL --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-1">BPL</h3>
                        @if($profile && $profile->bpl_path)
                            <a href="{{ asset('storage/' . $profile->bpl_path) }}" target="_blank" class="text-blue-600 underline">
                                {{ truncateFileName($profile->bpl_original_name ?? 'View BPL') }}
                            </a>
                        @else
                            <p class="text-gray-500 text-sm">No BPL uploaded</p>
                        @endif
                    </div>

                    {{-- DTI --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-1">DTI</h3>
                        @if($profile && $profile->dti_path)
                            <a href="{{ asset('storage/' . $profile->dti_path) }}" target="_blank" class="text-blue-600 underline">
                                {{ truncateFileName($profile->dti_original_name ?? 'View DTI') }}
                            </a>
                        @else
                            <p class="text-gray-500 text-sm">No DTI uploaded</p>
                        @endif
                    </div>

                </div>

                {{-- Feedbacks --}}
                @if($user->feedbacksReceived->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Feedbacks</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($user->feedbacksReceived as $feedback)
                                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-2 mb-2">
                                        @for($i=1;$i<=5;$i++)
                                            <span class="{{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <p class="text-gray-600 text-sm mb-2">{{ $feedback->message }}</p>
                                    <p class="text-xs text-gray-500">
                                        - {{ $feedback->sender->name ?? 'Anonymous' }} ({{ $feedback->sender->profile->organization_type ?? 'Agency' }})
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- FILE 
        <livewire:settings.delete-user-form />UPLOADS --}}
    </x-settings.layout>
</section>
