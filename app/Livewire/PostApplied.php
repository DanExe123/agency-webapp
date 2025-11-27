<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PostResponse;

class PostApplied extends Component
{
    use WithPagination;

    // Optional search/filter could go here in future
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage(); // reset pagination when search changes
    }

    public function render()
    {
        $responsesQuery = PostResponse::with('post.user.profile')
            ->where('agency_id', Auth::id())
            ->latest();

        if ($this->search) {
            $responsesQuery->whereHas('post', function($q) {
                $q->where('description', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.post-applied', [
            'responses' => $responsesQuery->paginate(8), // paginate here
        ]);
    }
}
