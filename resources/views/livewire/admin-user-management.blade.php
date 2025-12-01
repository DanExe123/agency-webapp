<div class="min-h-screen bg-gray-100">

    <!-- Content -->
    <main class="max-w-7xl mx-auto p-6">        
        <!-- Table -->
        <div class="flex items-center gap-4 mb-4">

            <!-- Search -->
            <input 
                type="text" 
                wire:model.debounce.300ms="search"
                placeholder="Search name or email..."
                class="border px-3 py-2 rounded w-64"
            >

            <!-- Status Filter -->
            <select wire:model="statusFilter" class="border px-3 py-2 rounded">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="verified">Verified</option>
                <option value="rejected">Rejected</option>
                <option value="archived">Archived</option>
            </select>

        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table wire:poll.500ms class="min-w-full text-sm text-left">
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
                            @if($profile->user->account_status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($profile->user->account_status === 'verified') bg-green-100 text-green-700
                            @elseif($profile->user->account_status === 'rejected') bg-red-100 text-red-700
                            @elseif($profile->user->account_status === 'archived') bg-gray-200 text-gray-700
                            @endif
                        ">
                            {{ ucfirst($profile->user->account_status) }}
                        </span>
                    </td>

                    
                    <td class="px-4 py-2" x-data="{ openMenu:false, openDocs:false, fullscreenImage: null, openApproveConfirm: false, selectedUserId: null,  openRejectConfirm: false, }" class="relative">

                        <!-- 3 DOTS BUTTON -->
                        <button @click="openMenu = !openMenu" class="p-2 rounded hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-5 h-5" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zm0 6a.75.75 0 110-1.5.75.75 0 010 1.5zm0 6a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <div 
                            x-show="openMenu"
                            @click.outside="openMenu=false"
                            class="absolute right-0 mt-2 bg-white shadow-lg rounded-md w-40 z-20 border"
                            >
                            <ul class="py-1 text-sm">

                                <!-- View Docs -->
                                <li>
                                    <button 
                                        @click="openDocs=true; openMenu=false"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100"
                                    >
                                        View Docs
                                    </button>
                                </li>

                                <!-- Approve -->
                                @if(in_array($profile->user->account_status, ['pending', 'rejected']))
                                    <li>
                                        <button 
                                            @click="openApproveConfirm = true; selectedUserId = {{ $profile->user->id }}; openMenu=false"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-green-600 font-semibold"
                                        >
                                            Approve
                                        </button>
                                    </li>
                                @endif

                                <!-- Reject -->
                                @if($profile->user->account_status === 'pending')
                                    <li>
                                        <button 
                                            @click="openRejectConfirm = true; selectedUserId = {{ $profile->user->id }}; openMenu=false"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600 font-semibold"
                                        >
                                            Reject
                                        </button>
                                    </li>
                                @endif
                                <!-- ONLY IF VERIFIED: ARCHIVE -->
                                @if($profile->user->account_status === 'verified')
                                    <li>
                                        <button 
                                            wire:click="archive({{ $profile->user->id }})"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700 font-semibold"
                                        >
                                            Archive
                                        </button>
                                    </li>
                                @endif

                                <!-- ONLY IF ARCHIVED: UNARCHIVE -->
                                @if($profile->user->account_status === 'archived')
                                    <li>
                                        <button 
                                            wire:click="unarchive({{ $profile->user->id }})"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-blue-600 font-semibold"
                                        >
                                            Unarchive
                                        </button>
                                    </li>
                                @endif

                            </ul>
                        </div>

                        <!-- Approve Confirmation Modal -->
                        <div 
                            x-show="openApproveConfirm" 
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-transition
                            >
                            <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative" @click.outside="openApproveConfirm = false">
                                <h2 class="text-lg font-semibold mb-4 text-green-700">Confirm Approval</h2>
                                <p class="mb-6 text-gray-700">Are you sure you want to approve this user account?</p>

                                <div class="flex justify-end gap-3">
                                    <button 
                                        @click="openApproveConfirm = false" 
                                        class="px-4 py-2 border rounded hover:bg-gray-100"
                                    >
                                        Cancel
                                    </button>
                                    <button 
                                        @click="$wire.approve(selectedUserId); openApproveConfirm = false" 
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                                    >
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Modal -->
                        <!-- AlpineJS Full Screen Viewer -->
                        <div 
                            x-show="fullscreenImage"
                            x-transition
                            x-cloak
                            class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[9999]"
                            >
                            <img :src="fullscreenImage" class="max-w-[95%] max-h-[95%] object-contain">
                            
                            <button 
                                @click="fullscreenImage = null"
                                class="absolute top-6 right-6 text-white text-2xl font-bold"
                            >
                                ✕
                            </button>
                        </div>
                        <!-- Documents Modal -->

                        <div 
                            x-show="openDocs"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-cloak
                            x-transition
                            >
                            <div 
                                @click.outside="openDocs = false"
                                class="bg-white w-[420px] max-h-[80vh] rounded-lg shadow-xl p-6 overflow-y-auto relative"
                                x-transition
                            >
                                <!-- Header with EX button -->
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">Documents</h2>
                                    <button 
                                        @click="openDocs = false"
                                        class="text-gray-500 hover:text-gray-700 text-xl font-bold"
                                    >
                                        ✕
                                    </button>
                                </div>

                                <div class="space-y-4">

                                    {{-- LOGO --}}
                                    @if($profile->logo_path)
                                        <div class="border p-3 rounded-lg shadow-sm">
                                            <p class="font-semibold mb-2">Logo</p>

                                            <img 
                                                src="{{ Storage::url($profile->logo_path) }}" 
                                                class="w-full h-40 object-contain bg-gray-50 rounded cursor-pointer"
                                                @click="fullscreenImage = '{{ Storage::url($profile->logo_path) }}'"
                                            >

                                            <button 
                                                @click="fullscreenImage = '{{ Storage::url($profile->logo_path) }}'"
                                                class="mt-2 text-blue-600 underline text-sm"
                                            >
                                                View Full Screen
                                            </button>

                                            <a href="{{ route('download', ['file' => $profile->logo_path]) }}" 
                                                class="block text-blue-500 mt-1 text-xs underline">
                                                Download ({{ $profile->logo_original_name ?? 'Logo' }})
                                            </a>
                                        </div>
                                    @endif

                                    {{-- BUSINESS PERMIT --}}
                                    @if($profile->bpl_path)
                                        <div class="border p-3 rounded-lg shadow-sm">
                                            <p class="font-semibold mb-2">Business Permit</p>

                                            <img 
                                                src="{{ Storage::url($profile->bpl_path) }}" 
                                                class="w-full h-40 object-contain bg-gray-50 rounded cursor-pointer"
                                                @click="fullscreenImage = '{{ Storage::url($profile->bpl_path) }}'"
                                            >

                                            <button 
                                                @click="fullscreenImage = '{{ Storage::url($profile->bpl_path) }}'"
                                                class="mt-2 text-blue-600 underline text-sm"
                                            >
                                                View Full Screen
                                            </button>

                                            <a href="{{ route('download', ['file' => $profile->bpl_path]) }}" 
                                                class="block text-blue-500 mt-1 text-xs underline">
                                                Download ({{ $profile->bpl_original_name ?? 'Business Permit' }})
                                            </a>
                                        </div>
                                    @endif

                                    {{-- DTI --}}
                                    @if($profile->dti_path)
                                        <div class="border p-3 rounded-lg shadow-sm">
                                            <p class="font-semibold mb-2">DTI Certificate</p>

                                            <img 
                                                src="{{ Storage::url($profile->dti_path) }}" 
                                                class="w-full h-40 object-contain bg-gray-50 rounded cursor-pointer"
                                                @click="fullscreenImage = '{{ Storage::url($profile->dti_path) }}'"
                                            >

                                            <button 
                                                @click="fullscreenImage = '{{ Storage::url($profile->dti_path) }}'"
                                                class="mt-2 text-blue-600 underline text-sm"
                                            >
                                                View Full Screen
                                            </button>

                                            <a href="{{ route('download', ['file' => $profile->dti_path]) }}" 
                                                class="block text-blue-500 mt-1 text-xs underline">
                                                Download ({{ $profile->dti_original_name ?? 'DTI Certificate' }})
                                            </a>
                                        </div>
                                    @endif

                                </div>

                                <!-- Footer -->
                                <div class="flex justify-end mt-4">
                                    <button 
                                        @click="openDocs = false"
                                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Confirmation Modal -->
                        <div x-show="openRejectConfirm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative" @click.outside="openRejectConfirm = false">
                                <h2 class="text-lg font-semibold mb-4 text-red-600">Confirm Rejection</h2>
                                <p class="mb-4 text-gray-700">Are you sure you want to reject this user account?</p>

                                <div class="flex justify-end gap-3">
                                    <button @click="openRejectConfirm = false" class="px-4 py-2 border rounded hover:bg-gray-100">Cancel</button>
                                    <button @click="$wire.openRejectModal(selectedUserId); openRejectConfirm = false" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirm</button>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        @if($showRejectModal)
                            <div 
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                x-transition>
                                <div class="bg-white w-96 rounded-lg shadow-lg p-6">
                                    <h2 class="text-lg font-semibold mb-4">Reject Feedback</h2>

                                    <!-- Bind to Livewire -->
                                    <textarea 
                                        wire:model.defer="rejectFeedback"
                                        class="w-full border rounded-md p-2 mb-4"
                                        rows="4"
                                        placeholder="Enter rejection feedback..."></textarea>
                                    @error('rejectFeedback')
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror

                                    <div class="flex justify-end gap-2">
                                        <button 
                                            wire:click="closeRejectModal"
                                            class="px-3 py-1 border rounded-md hover:bg-gray-100">
                                            Cancel
                                        </button>

                                        <!-- Call Livewire reject() -->
                                        <button 
                                            wire:click="reject"
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
            <div class="p-4">
                {{ $profiles->links() }}
            </div>
        </div>



    </main>
</div>
