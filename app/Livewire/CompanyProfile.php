<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostResponse; // add this
use Illuminate\Support\Facades\Auth;

class CompanyProfile extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    // ✅ Check if the logged-in agency already applied
    public function hasApplied($postId)
    {
        return PostResponse::where('post_id', $postId)
            ->where('agency_id', Auth::id())
            ->exists();
    }

    public function render()
    {
        return view('livewire.company-profile');
    }
}
