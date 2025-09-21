<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AgenciesMessages extends Component
{
    public $users;
    public $onlineCount = 0;

    public function mount()
    {
        $this->loadUsers();
    }

    // Load all users and count online users
    public function loadUsers()
    {
        // Fetch all users
        $this->users = User::orderBy('name')->get();

        // Count online users
        $this->onlineCount = $this->users->filter(function($user) {
            return $user->last_seen && now()->diffInMinutes($user->last_seen) < 5;
        })->count();
    }

    public function render()
    {
        return view('livewire.agencies-messages', [
            'users' => $this->users,
            'onlineCount' => $this->onlineCount,
        ]);
    }
}
