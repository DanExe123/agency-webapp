<div>
<header class="bg-white shadow-sm relative py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Icon + Search with Flag -->
            <div class="flex items-center space-x-3">
                <!-- Icon -->
                <div class="flex gap-1 justify-start">
                    <x-phosphor.icons::regular.briefcase class="w-6 h-6 text-gray-600" />
                    <h1 class="font-bold text-gray-700">ESecurityJobs</h1>
                </div>

                <!-- Search Box with Flag Selector -->
                <div class="relative flex items-center border border-gray-300 rounded-md overflow-hidden">
                    <!-- Flag Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center px-2 py-1 text-sm hover:bg-gray-100">
                            <!-- Static PH flag -->
                            <img src="{{ asset('ph.png') }}" alt="PH Flag" class="w-5 h-3 mr-1">
                            <x-phosphor.icons::regular.caret-down class="w-4 h-4 text-gray-900 ml-1" />
                        </button>
                    </div>
                    <!-- Divider -->
                    <div class="w-px h-6 bg-gray-300 mx-2"></div>

                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <input type="text" placeholder="agency title, keyword, company"
                               class="w-[500px] pl-8 pr-3 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 border-0">
                        <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-400 absolute left-2 top-3" />
                    </div>
                </div>
            </div>

            <!-- Right: Sign In Button -->
            <div>
                <a wire:navigate href="{{ route('loginform') }}">
                    <button class="px-4 py-2 border bg-black rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black text-white">
                        Log Out
                    </button>
                </a>
            </div>

        </div>
    </div>
</header>

   <div x-data="{ openModal: false }" class="max-w-7xl mx-auto mt-8 px-6">
        <!-- Top Controls -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live="search"
                        placeholder="Search job description..." 
                        class="pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-black focus:outline-none w-64"
                    />
                    <x-phosphor.icons::regular.magnifying-glass class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" />
                </div>

                <!-- Status Filter -->
                <select 
                    wire:model.live="statusFilter"
                    class="border border-gray-300 rounded-md text-sm py-2 px-3 focus:ring-1 focus:ring-black focus:outline-none"
                >
                    <option value="">All Status</option>
                    <option value="open">Open</option>
                    <option value="proposed">Proposed</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <!-- Create Button (Right aligned) -->
            <button 
                @click="openModal = true"
                class="bg-black text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-gray-800 transition"
            >
                + Create Job Post
            </button>
        </div>

        <!-- Modal -->
        <div 
            x-show="openModal" 
            x-transition 
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            >
            <div 
                @click.away="openModal = false"
                class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative"
            >
                <!-- X Button -->
                <button 
                    @click="openModal = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold"
                >
                    &times;
                </button>

                <!-- Modal Header -->
                <h2 class="text-xl font-bold text-gray-800 border-b pb-2">
                    Create New Job Post
                </h2>

                <!-- Modal Body -->
                <div class="pt-4 space-y-4">
                    <livewire:create-post />
                </div>
            </div>
        </div>

        <!-- Responses Modal -->
        <div 
            x-data="{ open: @entangle('showResponsesModal') }"
            x-show="open" 
            x-transition 
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div 
                @click.away="open = false; @this.showResponsesModal = false"
                class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative"
            >
                <button 
                    @click="open = false; @this.showResponsesModal = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold"
                >
                    &times;
                </button>

                <h2 class="text-xl font-bold text-gray-800 border-b pb-2">
                    Agency Proposals
                </h2>

                <div class="pt-4 space-y-3 max-h-96 overflow-y-auto">
                    @if(count($selectedPostResponses))
                        @foreach($selectedPostResponses as $response)
                            <div class="border p-3 rounded-md">
                                <p><span class="font-semibold">Agency:</span> {{ $response['agency']['name'] ?? 'N/A' }}</p>
                                <p><span class="font-semibold">Message:</span> {{ $response['message'] }}</p>
                                <p><span class="font-semibold">Proposed Rate:</span> {{ $response['proposed_rate'] }}</p>
                                <p><span class="font-semibold">Status:</span> {{ ucfirst($response['status']) }}</p>
                                @if($response['remarks'])
                                    <p><span class="font-semibold">Remarks:</span> {{ $response['remarks'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center">No proposals yet.</p>
                    @endif
                </div>
            </div>
        </div>



        <!-- Job Posts Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden mt-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Requirements</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Needs</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Posted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-center text-gray-600 uppercase">Response</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $post->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $post->requirements ?: '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $post->needs }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $post->status == 'open' ? 'bg-green-100 text-green-800' : 
                                    ($post->status == 'proposed' ? 'bg-blue-100 text-blue-800' : 
                                    'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($post->status ?? 'open') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-800">{{ $post->responses->count() }}</td>

                            <td class="px-6 py-4 text-sm text-gray-600 flex items-center gap-2">
                                <!-- View Proposals -->
                                <button 
                                    wire:click="viewProposals({{ $post->id }})"
                                    class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                    View Proposals
                                </button>


                                <!-- Edit -->
                                <button 
                                    wire:click="editPost({{ $post->id }})" 
                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                    Edit
                                </button>

                                <!-- Close -->
                                @if($post->status !== 'closed')
                                    <button 
                                        wire:click="closePost({{ $post->id }})" 
                                        class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">
                                        Close
                                    </button>
                                @endif

                                <!-- Delete -->
                                <button 
                                    wire:click="deletePost({{ $post->id }})" 
                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                    class="text-red-600 hover:text-red-800 text-xs font-medium">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No job posts yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            
        </div>
    </div>


</div>