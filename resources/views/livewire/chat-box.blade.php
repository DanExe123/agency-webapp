<div class="flex h-full bg-gray-50" x-data="{ showFiles: false }">

    <div class="flex flex-col bg-gray-50 border overflow-hidden transition-all duration-300"
        :class="showFiles ? 'w-[70%]' : 'w-full'"
        >
        <!-- Header -->
        <div class="flex items-center justify-between p-3 border-b bg-white shadow">
            <button class="p-2 rounded-full hover:bg-gray-200">
                <x-phosphor.icons::regular.arrow-left class="w-5 h-5" />
            </button>
            <h2 class="font-semibold text-gray-700">
                {{ $conversation ? ($conversation->user_one == auth()->id() 
                    ? $conversation->userTwo->name 
                    : $conversation->userOne->name) 
                : 'Messages' }}
            </h2>
            <div class="relative" x-data="{ open: false, showDeleteModal: false }">
                <!-- 3 DOTS BUTTON -->
                <button
                    @click="open = !open"
                    class="p-2 rounded-full hover:bg-gray-200 focus:outline-none"
                >
                    <x-phosphor.icons::bold.dots-three-vertical class="w-5 h-5" />
                </button>

                <!-- DROPDOWN -->
                <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border z-50"
                    >
                    <!-- FILES -->
                    <button
                        @click="showFiles = !showFiles; open = false"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                        <x-phosphor.icons::regular.folder class="w-4 h-4" />
                        Files
                    </button>

                    <!-- ARCHIVE / UNARCHIVE -->
                    @if(($conversation->user_one == auth()->id() && !$conversation->archived_by_user_one) || ($conversation->user_two == auth()->id() && !$conversation->archived_by_user_two))
                    <button wire:click.prevent="archiveConversation" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7v13h14V7M9 11l3-3 3 3M12 8v9" />
                        </svg>
                        Archive Chat
                    </button>
                    @else
                    <button wire:click.prevent="unarchiveConversation" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7v13h14V7M9 11l3-3 3 3M12 8v9" />
                        </svg>
                        Unarchive
                    </button>
                    @endif

                    <div class="border-t my-1"></div>

                    <!-- DELETE -->
                    <button 
                        @click="showDeleteModal = true"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Delete Conversation
                    </button>

                    <!-- DELETE CONFIRMATION MODAL -->
                    <div x-show="showDeleteModal" 
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                        x-cloak
                        >
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                            <p class="mb-4">Are you sure you want to delete this conversation? This action cannot be undone.</p>
                            <div class="flex justify-end space-x-2">
                                <button @click="showDeleteModal = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                                <button 
                                    wire:click="deleteConversationConfirmed" 
                                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Messages -->
        <div
            wire:poll.2s="loadConversation"
            x-data="{
                autoScroll: true,
                scrollToBottom() {
                    this.$nextTick(() => {
                        if (this.autoScroll) {
                            this.$el.scrollTop = this.$el.scrollHeight;
                        }
                    });
                }
            }"
            x-init="
                scrollToBottom();
                $wire.markAsRead();
            "
            x-on:livewire:update.window="scrollToBottom()"
            x-on:scroll="
                autoScroll =
                    ($el.scrollTop + $el.clientHeight + 50) >= $el.scrollHeight
            "
            class="flex-1 p-4 space-y-4 overflow-y-auto"
            >
            @forelse($messages as $msg)
                @php
                    $isOutgoing = $msg->sender_id == auth()->id();
                @endphp

                <div class="flex {{ $isOutgoing ? 'justify-end' : 'items-start space-x-2' }}">
                    
                    {{-- Sender Avatar --}}
                    @if(!$isOutgoing)
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                        @if($msg->sender->profile && $msg->sender->profile->logo_path)
                            <img src="{{ Storage::url($msg->sender->profile->logo_path) }}" alt="{{ $msg->sender->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($msg->sender->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    @endif

                    {{-- Message Bubble --}}
                    <div class="{{ $isOutgoing ? 'bg-blue-600 text-white' : 'bg-gray-600 text-white' }} px-4 py-2 rounded-lg max-w-xs break-words space-y-1">

                        {{-- File Display --}}
                        @if($msg->file_path)
                            @php 
                                $ext = strtolower(pathinfo($msg->file_path, PATHINFO_EXTENSION)); 
                                $fileName = $msg->file_name ?? basename($msg->file_path);
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            @endphp
                            
                            <div class="mb-2 p-3 bg-white/20 backdrop-blur-sm rounded-xl border border-white/50">
                                @if($isImage)
                                    <!-- Image Preview -->
                                    <div class="relative overflow-hidden rounded-lg mb-2">
                                        <img src="{{ Storage::url($msg->file_path) }}" 
                                            class="w-48 h-32 object-cover rounded-lg cursor-pointer hover:scale-105 transition-transform duration-200"
                                            onclick="window.open('{{ Storage::url($msg->file_path) }}', '_blank')">
                                        <div class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full">
                                            {{ strtoupper($ext) }}
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- File Name & Download -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 truncate">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-lg flex items-center justify-center">
                                            @if($isImage)
                                                <x-phosphor.icons::regular.image class="w-4 h-4 text-white" />
                                            @elseif(in_array($ext, ['pdf']))
                                                <x-phosphor.icons::regular.file-pdf class="w-4 h-4 text-white" />
                                            @elseif(in_array($ext, ['doc','docx']))
                                                <x-phosphor.icons::regular.file-doc class="w-4 h-4 text-white" />
                                            @elseif(in_array($ext, ['zip','rar']))
                                                <x-phosphor.icons::regular.file-zip class="w-4 h-4 text-white" />
                                            @else
                                                <x-phosphor.icons::regular.file class="w-4 h-4 text-white" />
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-medium text-sm truncate">{{ $fileName }}</p>
                                            <p class="text-xs opacity-75">{{ number_format(filesize(storage_path('app/public/' . $msg->file_path)) / 1024, 1) }} KB</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($msg->file_path) }}" 
                                    target="_blank" 
                                    download
                                    class="p-2 hover:bg-white/30 rounded-full transition-colors">
                                        <x-phosphor.icons::regular.download-simple class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        @endif


                        {{-- Text --}}
                        @if($msg->message)
                            <p>{!! nl2br(e($msg->message)) !!}</p>
                        @endif

                        {{-- Timestamp --}}
                        <span class="block text-xs text-gray-200 text-right mt-1">
                            @if($msg->created_at->gt(now()->subWeek()))
                                {{ $msg->created_at->diffForHumans() }}
                            @else
                                {{ $msg->created_at->format('M d, Y h:i A') }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-400">
                    <p class="text-lg font-medium">No messages yet</p>
                    <p class="text-sm">Start the conversation</p>
                </div>
            @endforelse
        </div>

        <!-- Footer Input -->
        @if($conversationId)
        <form wire:submit.prevent="sendMessage" class="p-3 border-t flex items-center space-x-2 bg-white" enctype="multipart/form-data">

            {{-- File Input --}}
            <input type="file" wire:model="file" id="fileInput" class="hidden">
            <button type="button" class="p-2 rounded-full hover:bg-gray-200" onclick="document.getElementById('fileInput').click()">
                <x-phosphor.icons::regular.image class="w-6 h-6 text-gray-600" />
            </button>

            {{-- File Preview --}}
            @if($file)
                <div class="px-2 py-1 bg-gray-200 rounded-md text-xs max-w-[150px] flex items-center justify-between space-x-2">
                    <span class="truncate" title="{{ $file->getClientOriginalName() }}">
                        {{ $file->getClientOriginalName() }}
                    </span>
                    <button type="button" wire:click="$set('file', null)" class="p-1 hover:bg-gray-300 rounded">
                        <x-phosphor.icons::regular.x class="w-3 h-3" />
                    </button>
                </div>
            @endif

            {{-- Message Input --}}
            <input type="text"
                placeholder="Write message here"
                wire:model.defer="messageText"
                class="flex-1 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />

            {{-- Send Button --}}
            <button type="submit" class="p-2 rounded-md bg-gray-800 hover:bg-gray-900">
                <x-phosphor.icons::regular.paper-plane-right class="w-5 h-5 text-white" />
            </button>
        </form>
        @endif
    </div>

    <div x-show="showFiles"
        x-transition
        x-cloak
        class="w-[30%] bg-white border-l flex flex-col"
        >

        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">Shared Files</h3>
            <button 
                @click="showFiles = false" 
                class="p-1 hover:bg-gray-200 rounded"
            >
                <x-phosphor.icons::regular.x class="w-4 h-4" />
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @foreach($messages as $msg)
                @if($msg->file_path)
                    <a href="{{ Storage::url($msg->file_path) }}"
                       target="_blank"
                       class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">

                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                            <x-phosphor.icons::regular.file class="w-5 h-5 text-gray-600" />
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate">
                                {{ $msg->file_name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $msg->sender->name }}
                            </p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>

</div>
