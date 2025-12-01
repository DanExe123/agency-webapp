<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;


class MostPopular extends Component
{
    public $posts;

    public function mount()
    {
        $this->posts = User::role('agency') // Only agencies
            ->withCount([
                'postResponses as completed_posts_count' => function ($query) {
                    $query->where('status', 'completed_negotiating');
                }
            ])
            ->with(['profile', 'feedbacksReceived']) // rating + logo
            ->orderBy('completed_posts_count', 'desc')
            ->take(5)
            ->get();
    }


    public function render()
    {
        return view('livewire.most-popular');
    }
}
