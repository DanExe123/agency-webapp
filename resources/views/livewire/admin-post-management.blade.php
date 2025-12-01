<div class="min-h-screen bg-gray-100">
    <!-- Content -->
    <main class="max-w-7xl mx-auto p-6"> 
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
                    <option value="open">Open</option>
                    <option value="clode">Close</option>
                    <option value="archived">Archived</option>
                    <option value="completed">Completed</option>
                </select>

            </div>   
        <div class="bg-white rounded-lg shadow overflow-hidden p-4">

            <!-- Flash message -->
            @if (session()->has('message'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif       

            <div class="overflow-x-auto">
                <table wire:poll class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2">Post ID</th>
                            <th class="px-4 py-2">Company / User</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Requirements</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Created</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($posts as $post)
                            <tr x-data="{ openArchiveConfirm: false, selectedPostId: null }">
                                <td class="px-4 py-2">{{ $post->id }}</td>
                                <td class="px-4 py-2">{{ $post->user->profile->company_name ?? $post->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $post->description }}</td>
                                <td class="px-4 py-2">{{ $post->requirements }}</td>
                                <td class="px-4 py-2 capitalize">
                                    <span class="
                                        px-2 py-1 rounded-full text-xs font-semibold
                                        @if($post->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($post->status === 'archived') bg-gray-200 text-gray-700
                                        @elseif($post->status === 'open') bg-blue-100 text-blue-700
                                        @elseif($post->status === 'completed') bg-green-100 text-green-700
                                        @elseif($post->status === 'proposed') bg-blue-100 text-blue-700
                                        @endif
                                    ">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-gray-500 text-sm">
                                    {{ $post->created_at->diffForHumans() }}
                                </td>
                                <td class="px-4 py-2 relative" x-data="{ openMenu: false, openConfirm: false, selectedPostId: {{ $post->id }}, actionType: '' }">
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
                                        @click.outside="openMenu = false"
                                        class="absolute right-0 mt-2 bg-white shadow-lg rounded-md w-40 z-20 border"
                                    >
                                        <ul class="py-1 text-sm">
                                            <!-- Archive Button -->
                                            <li>
                                                <button 
                                                    @click="actionType='archive'; openConfirm = true; openMenu=false"
                                                    :disabled="'{{ $post->status }}' === 'archived'"
                                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    Archive
                                                </button>
                                            </li>

                                            <!-- Unarchive Button -->
                                            <li>
                                                <button 
                                                    @click="actionType='unarchive'; openConfirm = true; openMenu=false"
                                                    :disabled="'{{ $post->status }}' !== 'archived'"
                                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-green-600 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    Unarchive
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Confirmation Modal -->
                                    <div x-show="openConfirm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
                                        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative" @click.outside="openConfirm = false">
                                            <h2 class="text-lg font-semibold mb-4" :class="actionType==='archive' ? 'text-red-600' : 'text-green-600'">
                                                Confirm <span x-text="actionType==='archive' ? 'Archive' : 'Unarchive'"></span>
                                            </h2>
                                            <p class="mb-4 text-gray-700">
                                                Are you sure you want to <span x-text="actionType==='archive' ? 'archive' : 'unarchive'"></span> this post?
                                            </p>

                                            <div class="flex justify-end gap-3">
                                                <button @click="openConfirm = false" class="px-4 py-2 border rounded hover:bg-gray-100">Cancel</button>
                                                <button 
                                                    @click="$wire.updateStatus(selectedPostId, actionType); openConfirm = false"
                                                    :class="actionType==='archive' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                                    class="px-4 py-2 text-white rounded"
                                                >
                                                    Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $posts->links() }}
            </div>
        </div>
     
    
    </main>
</div>
