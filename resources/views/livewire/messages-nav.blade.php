<a
    wire:navigate
    href="{{ route('chat-list') }}"
    class="relative text-gray-500 hover:text-black transition"
>
    <x-phosphor.icons::regular.chat-teardrop-text class="w-6 h-6 text-black" />

    @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
            {{ $unreadCount }}
        </span>

        <span class="animate-ping absolute -top-1 -right-1 block h-2 w-2 rounded-full ring-2 ring-red-400 bg-red-600"></span>
    @endif
</a>
