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
                                <div class="flex items-center gap-2">
                                <img 
                                    src="{{ asset('storage/' . ($response->agency->profile->logo_path ?? 'images/default-logo.png')) }}" 
                                    alt="Logo" 
                                    class="w-8 h-8 rounded-full object-cover border"
                                >
                                <span class="font-semibold">{{ $response->agency->name ?? 'N/A' }}</span>
                            </div>
                                <p><span class="font-semibold">Message:</span> {{ $response->message }}</p>
                                
                                <!-- Display Proposed Rates by Guard Type -->
                                <div class="mt-3">
                                    <p class="font-semibold text-gray-800 mb-2">Proposed Rates per Guard Type:</p>
                                    @if($response->proposedRates->count())
                                        <table class="w-full text-xs border border-gray-200 rounded-lg overflow-hidden">
                                            <thead class="bg-gray-100 text-gray-700">
                                                <tr>
                                                    <th class="px-3 py-2 text-left font-medium">Guard Type</th>
                                                    <th class="px-3 py-2 text-left font-medium">Proposed Rate (₱)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($response->proposedRates as $rate)
                                                    <tr>
                                                        <td class="px-3 py-2 text-gray-800">{{ $rate->guardType->name ?? 'Unknown' }}</td>
                                                        <td class="px-3 py-2 text-gray-600">₱{{ number_format($rate->proposed_rate, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-gray-400 text-xs">No rates provided.</p>
                                    @endif
                                </div>


                                <p class="mt-2"><span class="font-semibold">Status:</span> {{ ucfirst($response->status) }}</p>

                                @if($response->remarks)
                                    <p><span class="font-semibold">Remarks:</span> {{ $response->remarks }}</p>
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
        @if(!$showEvaluation)
            <div class="bg-white shadow rounded-lg overflow-hidden mt-8 ">
                <div class="max-h-[600px] overflow-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Description</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Requirements</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Needs</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Posted</th>
                                <th class="px-6 py-3 text-xs font-medium text-center text-gray-600 uppercase">Response</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Selected Agency</th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($posts as $post)
                                <tr class="hover:bg-gray-50 relative" x-data="{ open: false }" @click.outside="open = false">
                                    <td class="px-6 py-4 text-sm text-gray-800 max-w-[200px] break-words">
                                        {{ $post->description }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-600 max-w-[200px] break-words">
                                        {{ $post->requirements ?: '—' }}
                                    </td>
                                    <!-- Needs column -->
                                    <td class="px-6 py-4 text-sm text-center text-gray-600 relative">
                                        @php
                                            $totalNeeds = $post->guardNeeds->sum('quantity');
                                        @endphp
                                        <button 
                                            @click="open = !open"
                                            class="text-indigo-600 hover:text-indigo-800 underline">
                                            {{ $totalNeeds }} guards
                                        </button>

                                        <!-- Dropdown -->
                                        <div 
                                            x-show="open"
                                            x-transition
                                            class="absolute z-20 bg-white border border-gray-300 shadow-lg rounded-lg p-3 mt-1 w-56"
                                            @click.outside="open = false"
                                        >
                                            <p class="font-semibold text-gray-700 mb-2">Guard Type Details</p>
                                            @foreach ($post->guardNeeds as $need)
                                                <div class="flex justify-between text-sm text-gray-700">
                                                    <span>{{ $need->guardType->name }}</span>
                                                    <span>{{ $need->quantity }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="px-6 text-center py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $post->status == 'open' ? 'bg-green-100 text-green-800' : 
                                            ($post->status == 'proposed' ? 'bg-blue-100 text-blue-800' : 
                                            ($post->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($post->status ?? 'open') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-center text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-center text-gray-800">{{ $post->responses->count() }}</td>

                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        <div class="flex items-center justify-center gap-3">
                                            @php
                                                $negotiating = $post->responses->first(function($response) {
                                                    return in_array($response->status, ['negotiating', 'completed_negotiating']);
                                                });
                                            @endphp

                                            @if($negotiating)
                                                <a href="{{ route('profile.visit', $negotiating->agency_id) }}" wire:navigate class="flex items-center gap-2">
                                                    @if($negotiating->agency && $negotiating->agency->profile)
                                                        <img 
                                                            src="{{ asset('storage/' . $negotiating->agency->profile->logo_path) }}"
                                                            class="w-8 h-8 rounded-full"
                                                            alt="{{ $negotiating->agency->name }}"
                                                        >
                                                    @endif
                                                    <span>{{ $negotiating->agency->name ?? 'Unknown Agency' }}</span>
                                                </a>

                                                <!-- CHAT BUTTON -->
                                                <a 
                                                    href="{{ url('chatify', $negotiating->agency_id) }}" 
                                                    target="_blank" 
                                                    rel="noopener noreferrer"
                                                    class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded-md"
                                                >
                                                    Chat
                                                </a>
                                                
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 flex items-center gap-2">
                                        <button 
                                            wire:click="evaluateProposals({{ $post->id }})"
                                            class="text-green-600 hover:text-green-800 text-xs font-medium">
                                            Evaluate Proposals
                                        </button>

                                        <div x-data="{ open: false }" class="relative">
                                            <button 
                                                @click="open = !open"
                                                class="p-1 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    class="w-5 h-5" 
                                                    fill="none" 
                                                    viewBox="0 0 24 24" 
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zm0 6a.75.75 0 110-1.5.75.75 0 010 1.5zm0 6a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
                                            </button>

                                            <div 
                                                x-show="open"
                                                @click.away="open = false"
                                                x-transition
                                                class="absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                                                >
                                                <ul class="text-xs text-gray-700 divide-y divide-gray-100">
                                                    <li>
                                                        <li>
                                                            @if($post->status === 'proposed')
                                                                <livewire:give-feedback :post-id="$post->id" />
                                                            @endif
                                                        </li>
                                                    </li>
                                                    <li>
                                                        @if($post->status === 'closed')
                                                            <button 
                                                                wire:click="togglePostStatus({{ $post->id }})"
                                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 text-green-600"
                                                            >
                                                                Open
                                                            </button>
                                                        @else
                                                            <button 
                                                                wire:click="togglePostStatus({{ $post->id }})"
                                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 text-yellow-600"
                                                            >
                                                                Close
                                                            </button>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <button 
                                                            wire:click="viewProposals({{ $post->id }})"
                                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-indigo-600"
                                                        >
                                                            View 
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            wire:click="editPost({{ $post->id }})"
                                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-blue-600"
                                                        >
                                                            Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            wire:click="deletePost({{ $post->id }})"
                                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600"
                                                        >
                                                            Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 p-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

        @else
            <livewire:evaluate-proposals :postId="$selectedPost->id" />
        @endif
    </div>

</div>