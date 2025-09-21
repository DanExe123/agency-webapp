<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class Companies extends Component
{
    public $posts; // if you want to display a list of posts

    public function mount()
    {
        // Load all posts (or filter as needed)
        $this->posts = Post::all();
    }

    /**
     * Redirect to the company profile page for a specific post.
     *
     * @param int $postId
     */
    public function goToCompanyProfile($postId)
    {
        return redirect()->route('company-profile', ['post' => $postId]);
    }

    public function render()
    {
        return view('livewire.companies');
    }
}
