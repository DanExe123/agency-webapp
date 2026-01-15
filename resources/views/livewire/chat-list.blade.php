<div class="flex h-[91vh] bg-gray-50">

    <!-- LEFT SIDEBAR -->
    <div class="w-80 bg-white border-r border-gray-200 shadow-sm flex flex-col">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Messages</h2>
        </div>

        <!-- Active Conversations -->
        <div class="flex-1 overflow-y-auto">
            @forelse($activeConversations as $chat)
                @php
                    $otherUser = $chat->user_one == auth()->id() ? $chat->userTwo : $chat->userOne;
                    $unreadCount = $chat->messages->count();
                @endphp

                <div wire:click="openChat({{ $chat->id }})"
                    class="p-4 cursor-pointer border-b transition
                            {{ $conversationId == $chat->id ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}
                            {{ $unreadCount > 0 ? 'bg-yellow-50' : 'hover:bg-gray-50' }}"
                    x-data="{ openDropdown: false }"
                    >
                    {{-- Avatar & Info --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden">
                                @if($otherUser->profile && $otherUser->profile->logo_path)
                                    <img src="{{ Storage::url($otherUser->profile->logo_path) }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium">
                                        {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $otherUser->name ?? 'User' }}</p>
                                <p class="text-xs truncate mt-0.5 {{ $unreadCount > 0 ? 'font-bold text-gray-900' : 'text-gray-500' }}">
                                    {{ optional($chat->lastMessage)->message ?: 'No messages yet' }}
                                </p>
                            </div>
                        </div>

                        {{-- Right: Unread Badge + Dropdown --}}
                        <div class="flex items-center space-x-2">
                            @if($unreadCount > 0)
                                <div class="w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold shadow-lg">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </div>
                            @endif

                            <div class="relative" @click.stop>
                                <button @click="openDropdown = !openDropdown" class="p-2 rounded-full hover:bg-gray-200 focus:outline-none">
                                    <x-phosphor.icons::regular.dots-three-vertical class="w-5 h-5" />
                                </button>

                                <div x-show="openDropdown" x-transition @click.away="openDropdown = false"
                                    class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border z-50">
                                    <!-- Archive -->
                                    <button wire:click="archiveConversation({{ $chat->id }})"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Archive Chat
                                    </button>
                                    <!-- Delete -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="px-4 text-gray-400 text-sm">No active conversations</p>
            @endforelse
        </div>

       <!-- Archived Conversations -->
        <div x-data="{ open: false }" class="border-t border-gray-100">
            <!-- Toggle Button -->
            <button @click="open = !open"
                class="w-full px-4 py-2 flex items-center justify-between text-gray-700 font-medium hover:bg-gray-50 focus:outline-none">
                <span>Archived</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Archived Conversations List -->
            <div x-show="open" x-transition class="overflow-y-auto max-h-60">
                <div x-show="open" x-transition class="overflow-y-auto max-h-60">
                    @forelse($archivedConversations as $chat)
                        @php
                            $otherUser = $chat->user_one == auth()->id() ? $chat->userTwo : $chat->userOne;
                        @endphp

                        <div wire:click="openArchivedChat({{ $chat->id }})"
                            class="p-4 cursor-pointer border-b transition {{ $conversationId == $chat->id ? 'bg-blue-50 border-r-2 border-blue-500' : 'hover:bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden">
                                    @if($otherUser->profile && $otherUser->profile->logo_path)
                                        <img src="{{ Storage::url($otherUser->profile->logo_path) }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-400 flex items-center justify-center text-white font-medium">
                                            {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $otherUser->name ?? 'User' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="px-4 text-gray-400 text-sm">No archived conversations</p>
                    @endforelse
                </div>

            </div>
        </div>

    </div>


    <!-- MAIN CHAT AREA -->
    <div class="flex-1 flex flex-col bg-gray-50">
        @if($conversationId)
            <livewire:chat-box :conversationId="$conversationId" />
        @else
            <div class="flex-1 flex items-center justify-center text-gray-400">
                <p>Select a conversation to start chatting</p>
            </div>
        @endif
    </div>

</div>
