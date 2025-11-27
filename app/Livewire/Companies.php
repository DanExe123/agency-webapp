<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\UserProfile;

class Companies extends Component
{
    use WithPagination;

    public $searchKeyword = '';
    public $searchLocation = []; // array for multiple checkbox selections
    public $allLocations = [];   // store all existing locations

    public function mount()
    {
        // Fetch all distinct addresses from user profiles
        $this->allLocations = UserProfile::whereNotNull('address')
            ->distinct()
            ->pluck('address')
            ->toArray();
    }

    public function applySearch()
    {
        $this->resetPage();
    }

    public function goToCompanyProfile($postId)
    {
        return redirect()->route('company-profile', ['post' => $postId]);
    }

    public function render()
    {
        $query = Post::with(['user.profile', 'guardNeeds.guardType'])
            ->where('status', 'open')
            ->orderBy('created_at', 'desc');

        // Keyword search
        if ($this->searchKeyword) {
            $query->where(function($q) {
                $q->where('description', 'like', '%' . $this->searchKeyword . '%')
                  ->orWhereHas('user', function($uq) {
                      $uq->where('name', 'like', '%' . $this->searchKeyword . '%')
                         ->orWhereHas('profile', function($pq) {
                             $pq->where('organization_type', 'like', '%' . $this->searchKeyword . '%')
                                ->orWhere('about_us', 'like', '%' . $this->searchKeyword . '%');
                         });
                  });
            });
        }

        // Filter by selected locations
        if (!empty($this->searchLocation)) {
            $query->whereHas('user.profile', function($q) {
                $q->whereIn('address', $this->searchLocation);
            });
        }

        $posts = $query->paginate(5);

        return view('livewire.companies', [
            'posts' => $posts,
        ]);
    }
}


