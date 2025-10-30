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
    public $expandedPostId = null;
    public $showEvaluation = false;
    public $selectedPost = null;


    protected $listeners = [
        'postCreated' => 'fetchPosts',
        'backToList' => 'backToList',
    ];

    public function evaluateProposals($postId)
    {
        $this->selectedPost = Post::find($postId);
        $this->showEvaluation = true;
    }

    public function backToList()
    {
        $this->showEvaluation = false;
        $this->selectedPost = null;
    }


    public function viewProposals($postId)
    {
        $post = Post::with([
            'responses.agency',
            'responses.proposedRates.guardType'
        ])->find($postId);

        if ($post) {
            // Don't convert to array!
            $this->selectedPostResponses = $post->responses;
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

    public function togglePostStatus($id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($post) {
            $newStatus = $post->status === 'closed' ? 'open' : 'closed';
            $post->update(['status' => $newStatus]);
            $this->fetchPosts(); // refresh the list
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

    public function toggleNeeds($postId)
    {
        $this->expandedPostId = $this->expandedPostId === $postId ? null : $postId;
    }

    public function fetchPosts()
    {
        $query = Post::with(['guardNeeds.guardType', 'responses'])
            ->where('user_id', Auth::id());

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
