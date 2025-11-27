<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class JobPosting extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // For the modal
    public $selectedPostResponses = [];
    
    public $showResponsesModal = false;
    public $expandedPostId = null;
    public $showEvaluation = false;
    public $selectedPost = null;

    protected $listeners = [
        'postCreated' => '$refresh', // refresh automatically
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

    public function updatedSearch()
    {
        $this->resetPage(); // reset pagination when searching
    }

    public function updatedStatusFilter()
    {
        $this->resetPage(); // reset pagination when filtering
    }

    public function togglePostStatus($id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($post) {
            $newStatus = $post->status === 'closed' ? 'open' : 'closed';
            $post->update(['status' => $newStatus]);
            // no need to fetchPosts(), pagination will reload
        }
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->first();

        if ($post) {
            $post->delete();
            // no need to fetchPosts(), pagination will reload
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

    /**
     * Fetch query builder for posts
     */
    public function fetchQuery()
    {
        $query = Post::with(['guardNeeds.guardType', 'responses'])
            ->where('user_id', Auth::id());

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return $query->latest();
    }

    public function render()
    {
        return view('livewire.job-posting', [
            'posts' => $this->fetchQuery()->paginate(6), // paginate here, not in public property
        ]);
    }
}
