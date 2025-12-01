<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostResponse; // add this
use Illuminate\Support\Facades\Auth;

class CompanyProfile extends Component
{
    public Post $post;

    public $appliedPosts = []; // keep track of applied posts

    protected $listeners = ['proposalSubmitted' => 'refreshAppliedStatus'];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->refreshAppliedStatus();
    }

    public function refreshAppliedStatus()
    {
        $this->appliedPosts = PostResponse::where('agency_id', Auth::id())
            ->pluck('post_id')
            ->toArray();
    }

    public function hasApplied($postId)
    {
        return in_array($postId, $this->appliedPosts);
    }

    public function render()
    {
        return view('livewire.company-profile');
    }
}
