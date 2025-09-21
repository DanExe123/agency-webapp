<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CompanyPosted extends Component
{
    public $posts;
    public $expandedPostId = null; // track which post is expanded

    public function mount()
    {
        $this->posts = Post::orderBy('created_at', 'desc')->get();
    }

    public function togglePost($postId)
    {
        // collapse if already open, else expand
        $this->expandedPostId = $this->expandedPostId === $postId ? null : $postId;
    }

    public function render()
    {
        return view('livewire.company-posted');
    }
}
