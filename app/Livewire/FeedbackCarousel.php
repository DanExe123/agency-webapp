<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Feedback;

class FeedbackCarousel extends Component
{
    public $feedbacks = [];

    protected $listeners = ['viewProfile'];

public function viewProfile($userId)
{
    return redirect()->route('profile.show', $userId);
}

    public function mount()
    {
        // Fetch all feedbacks with sender + profile
        $this->feedbacks = Feedback::with(['sender.profile'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.feedback-carousel');
    }
}
