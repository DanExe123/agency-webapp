<div x-data="{ open: false }" class="relative" wire:poll.visible.2s="loadNotifications">
    <!-- Bell Button -->
    <button @click="open = !open" class="text-gray-500 hover:text-black relative">
        <x-phosphor.icons::regular.bell class="w-6 h-6 text-black" />
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                {{ $unreadCount }}
            </span>
            <span class="animate-ping absolute -top-1 -right-1 block h-2 w-2 rounded-full ring-2 ring-red-400 bg-red-600"></span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" x-cloak @click.away="open = false" x-transition
        class="absolute right-0 mt-2 w-96 bg-white border rounded-lg shadow-lg overflow-hidden z-50">

        <div class="p-4 border-b font-semibold text-gray-700">Notifications</div>

        <ul class="max-h-80 overflow-y-auto divide-y">
            @forelse($notifications as $notif)
                <li wire:click="markAsRead('{{ $notif['id'] }}')"
                    class="px-4 py-3 flex gap-3 rounded-md cursor-pointer transition {{ !$notif['is_read'] ? 'bg-gray-100 shadow-sm border-l-4 border-blue-500' : '' }}">
                    
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center mt-1">
                        <x-dynamic-component :component="'phosphor.icons::regular.' . $notif['icon']"
                            class="w-5 h-5 {{ $notif['color'] }}" />
                    </div>

                    <!-- Message + Timestamp -->
                    <div class="flex-1 flex flex-col">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-700">{{ $notif['message'] }}</p>
                            @if(!$notif['is_read'])
                                <span class="ml-2 bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded">NEW</span>
                            @endif
                        </div>

                        {{-- Timestamp --}}
                        @if(isset($notif['created_at']))
                            @php $c = $notif['created_at']; @endphp
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $c->diffInHours() < 24 ? $c->diffForHumans() : $c->format('M d, Y • h:i A') }}
                            </p>
                        @endif
                    </div>
                </li>
            @empty
                <li class="px-4 py-3 text-center text-sm text-gray-500">No new notifications</li>
            @endforelse
        </ul>

        @if($unreadCount > 0)
            <div class="p-2 border-t text-center">
                <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:underline">Mark All as Read</button>
            </div>
        @endif
    </div>
</div>
