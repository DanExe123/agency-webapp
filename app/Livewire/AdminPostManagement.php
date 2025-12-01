<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class AdminPostManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    protected $paginationTheme = 'tailwind';

    public function updateStatus($postId, $action)
    {
        $post = Post::find($postId);
        if (!$post) return;

        if ($action === 'archive') {
            $post->status = 'archived';
            session()->flash('message', 'Post archived successfully.');
        } elseif ($action === 'unarchive') {
            $post->status = 'open'; // or 'open' depending on your app
            session()->flash('message', 'Post unarchived successfully.');
        }

        $post->save();
    }

    // Optional helper for Blade x-show
    public function getPostStatus($postId)
    {
        $post = Post::find($postId);
        return $post ? $post->status : null;
    }


    // Archive a post
    public function archive($postId)
    {
        $post = Post::find($postId);
        if ($post) {
            $post->status = 'archived';
            $post->save();
            session()->flash('message', 'Post archived successfully.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::with('user.profile')
            ->when($this->search, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->when($this->statusFilter && $this->statusFilter !== 'all', function($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin-post-management', [
            'posts' => $posts
        ]);
    }
}
