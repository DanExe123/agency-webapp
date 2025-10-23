<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class JobPosting extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $posts = [];

     // For the modal
    public $selectedPostResponses = [];
    public $showResponsesModal = false;


    protected $listeners = ['postCreated' => 'fetchPosts'];

    public function viewProposals($postId)
    {
        $post = Post::with('responses.agency')->find($postId);

        if ($post) {
            $this->selectedPostResponses = $post->responses->toArray();
            $this->showResponsesModal = true;
        }
    }

    public function mount()
    {
        $this->fetchPosts();
    }

    public function updatedSearch()
    {
        $this->fetchPosts();
    }

    public function updatedStatusFilter()
    {
        $this->fetchPosts();
    }

    public function closePost($id)
{
    $post = Post::where('id', $id)->where('user_id', auth()->id())->first();

    if ($post) {
        $post->update(['status' => 'closed']);
        $this->fetchPosts();
    }
}

public function deletePost($id)
{
    $post = Post::where('id', $id)->where('user_id', auth()->id())->first();

    if ($post) {
        $post->delete();
        $this->fetchPosts();
    }
}

public function editPost($id)
{
    $this->dispatch('editPost', $id); // You can catch this event in your CreatePost component
}


    public function fetchPosts()
    {
        $query = Post::where('user_id', Auth::id());

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $this->posts = $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.job-posting', [
            'posts' => $this->posts,
        ]);
    }
}
