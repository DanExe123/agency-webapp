<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatWithCompany extends Component
{
  
    public function render()
    {
        return view('livewire.chat-with-company');
    }
}
