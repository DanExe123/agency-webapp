<div class="min-h-screen bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow-sm relative py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Left: Logo -->
                <div class="flex items-center gap-2">
                    <x-phosphor.icons::regular.briefcase class="w-6 h-6 text-gray-600" />
                    <h1 class="font-bold text-gray-700">ESecurityJobs</h1>
                </div>

                <!-- Center: Page Title -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Review Users Credentials</h2>
                </div>

                <!-- Right: Logout -->
                <div>
                    @auth
                        {{-- If logged in, show Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 border bg-black rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black text-white">
                                Log Out
                            </button>
                        </form>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-7xl mx-auto p-6">

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm text-gray-500">Total Agencies</h2>
                <p class="text-2xl font-bold text-gray-800">120</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm text-gray-500">Pending Documents</h2>
                <p class="text-2xl font-bold text-yellow-600">35</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm text-gray-500">Approved</h2>
                <p class="text-2xl font-bold text-green-600">80</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm text-gray-500">Rejected</h2>
                <p class="text-2xl font-bold text-red-600">5</p>
            </div>
        </div>

        
        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2">Agency Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Organization</th>
                        <th class="px-4 py-2">Industry</th>
                        <th class="px-4 py-2">Year</th>
                        <th class="px-4 py-2">Website</th>
                        <th class="px-4 py-2">Account status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                @foreach($profiles as $profile)
                <tr x-data="{ openDocs: false, openReject: false }">
                    <td class="px-4 py-2">{{ $profile->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $profile->user->email }}</td>
                    <td class="px-4 py-2">{{ $profile->organization_type }}</td>
                    <td class="px-4 py-2">{{ $profile->industry_type }}</td>
                    <td class="px-4 py-2">{{ optional($profile->year_established)->format('Y') }}</td>
                    <td class="px-4 py-2 text-blue-600">{{ $profile->website }}</td>
                    <td class="px-4 py-2">
                        <span class="
                            px-2 py-1 rounded-full text-xs font-semibold
                            @if($profile->account_status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($profile->account_status === 'verified') bg-green-100 text-green-700
                            @elseif($profile->account_status === 'rejected') bg-red-100 text-red-700
                            @endif
                        ">
                            {{ ucfirst($profile->account_status) }}
                        </span>
                    </td>

                    <td class="px-4 py-2 flex gap-2">
                        
                        <!-- View Documents -->
                        <button @click="openDocs = true"
                                class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            View Docs
                        </button>

                        <!-- Approve -->
                        <button 
                            wire:click="approve({{ $profile->id }})"
                            class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Approve
                        </button>

                        <!-- Reject -->
                        <button 
                            wire:click="openRejectModal({{ $profile->id }})"
                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Reject
                        </button>


                        <!-- Documents Modal -->
                        <div x-show="openDocs"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">
                            
                            <div class="bg-white w-96 rounded-lg shadow-lg p-6"
                                x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="scale-90 opacity-0"
                                x-transition:enter-end="scale-100 opacity-100"
                                x-transition:leave="transition ease-in duration-200 transform"
                                x-transition:leave-start="scale-100 opacity-100"
                                x-transition:leave-end="scale-90 opacity-0">
                                
                                <h2 class="text-lg font-semibold mb-4">Documents</h2>

                                <ul class="space-y-2">
                                    @if($profile->logo_path)
                                        <li>
                                            <a href="{{ route('download', ['file' => $profile->logo_path]) }}"
                                            class="text-blue-600 underline">
                                                {{ $profile->logo_original_name ?? 'Logo' }}
                                            </a>
                                        </li>
                                    @endif
                                    @if($profile->bpl_path)
                                        <li>
                                            <a href="{{ route('download', ['file' => $profile->bpl_path]) }}"
                                            class="text-blue-600 underline">
                                                {{ $profile->bpl_original_name ?? 'Business Permit License' }}
                                            </a>
                                        </li>
                                    @endif
                                    @if($profile->dti_path)
                                        <li>
                                            <a href="{{ route('download', ['file' => $profile->dti_path]) }}"
                                            class="text-blue-600 underline">
                                                {{ $profile->dti_original_name ?? 'DTI Certificate' }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <div class="flex justify-end mt-4">
                                    <button @click="openDocs = false"
                                            class="px-3 py-1 border rounded-md hover:bg-gray-100">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        @if($showRejectModal)
                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-transition>
                            <div class="bg-white w-96 rounded-lg shadow-lg p-6">
                                <h2 class="text-lg font-semibold mb-4">Reject Feedback</h2>

                                <!-- Bind to Livewire -->
                                <textarea wire:model.defer="rejectFeedback"
                                        class="w-full border rounded-md p-2 mb-4"
                                        rows="4"
                                        placeholder="Enter rejection feedback..."></textarea>
                                @error('rejectFeedback')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror

                                <div class="flex justify-end gap-2">
                                    <button wire:click="closeRejectModal"
                                            class="px-3 py-1 border rounded-md hover:bg-gray-100">
                                        Cancel
                                    </button>

                                    <!-- Call Livewire reject() -->
                                    <button wire:click="reject"
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>
