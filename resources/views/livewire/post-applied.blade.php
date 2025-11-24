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

    <div class="max-w-7xl mx-auto mt-6 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Posts You Applied To</h2>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-medium">
                <tr>
                    <th class="px-4 py-2 text-left">Company</th>
                    <th class="px-4 py-2 text-left">Message</th> 
                    <th class="px-4 py-2 text-left">Requirements</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-left">Submitted</th>
                    <th class="px-4 py-2 text-Center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responses as $response)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 flex items-center space-x-2">
                            @if ($response->post && $response->post->user && $response->post->user->profile && $response->post->user->profile->logo_path)
                                <img 
                                    src="{{ asset('storage/' . $response->post->user->profile->logo_path) }}" 
                                    alt="Company Logo" 
                                    class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-xs">
                                    N/A
                                </div>
                            @endif

                            <span>{{ $response->post->user->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $response->message ?? 'No message' }}
                        </td>
                        <td class="px-4 py-2">
                            @if (!empty($response->post->requirements))
                                <ul class="list-disc list-inside text-gray-600 text-xs">
                                    @foreach (explode("\n", $response->post->requirements) as $req)
                                        @if (trim($req) !== '')
                                            <li>{{ trim($req) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-gray-400 italic">No requirements listed.</p>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @php
                                $status = $response->status ?? 'pending';
                                $colors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'not_selected' => 'bg-yellow-100 text-yellow-800',
                                    'negotiating' => 'bg-blue-100 text-blue-800',
                                    'closed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                            @endphp

                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-500">
                            {{ $response->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ url('chatify', $response->post->user_id) }}"  target="_blank" 
                            class="inline-block px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded-md">
                                Chat with Company
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            You haven’t applied to any posts yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

