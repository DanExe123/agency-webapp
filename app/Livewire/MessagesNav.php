<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mensahe;

class MessagesNav extends Component
{
    public function render()
    {
        $unreadCount = Mensahe::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->where('is_deleted', false)
            ->count();

        return view('livewire.messages-nav', compact('unreadCount'));
    }
}
