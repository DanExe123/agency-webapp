<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatWithCompany extends Component
{
    // public $companyId;       // the company we’re chatting with
    // public $messageText = ''; 
    // public $messages = [];

    // public function mount($companyId)
    // {
    //    // $this->companyId = $companyId;
    //     $this->loadMessages();
    // }

    // public function loadMessages()
    // {
    //     $this->messages = Message::where(function ($q) {
    //             $q->where('sender_id', Auth::id())
    //               ->where('receiver_id', $this->companyId);
    //         })
    //         ->orWhere(function ($q) {
    //             $q->where('sender_id', $this->companyId)
    //               ->where('receiver_id', Auth::id());
    //         })
    //         ->orderBy('created_at', 'asc')
    //         ->get();
    // }

    // public function sendMessage()
    // {
    //     if (trim($this->messageText) === '') return;

    //     Message::create([
    //         'sender_id'   => Auth::id(),
    //         'receiver_id' => $this->companyId,
    //         'content'     => $this->messageText,
    //     ]);

    //     $this->messageText = '';
    //     $this->loadMessages();
    // }

    public function render()
    {
        return view('livewire.chat-with-company');
    }
}
