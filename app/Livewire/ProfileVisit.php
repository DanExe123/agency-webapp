<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ProfileVisit extends Component
{
    public User $user;

    public $posts;
    public $feedbacks;

    public function mount(User $user)
    {
        $this->user = $user;

        // Eager load relations
        $this->user->load(['profile', 'feedbacksReceived.sender.profile']);

        $this->posts = $this->user->posts()->latest()->get();
        $this->feedbacks = $this->user->feedbacksReceived()->with('sender.profile')->get();
    }

    public function render()
    {
        return view('livewire.profile-visit');
    }
}
