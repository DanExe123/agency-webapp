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
    public $searchLocation = []; // ✅ Always array
    public $allLocations = [];

    public function mount()
    {
        $this->allLocations = UserProfile::whereNotNull('address')
            ->distinct()
            ->pluck('address')
            ->toArray();
    }

     public function goToCompanyProfile($postId)
    {
        return redirect()->route('company-profile', ['post' => $postId]);
    }

    public function applySearch()
    {
        // ✅ Ensure array format
        if (is_string($this->searchLocation)) {
            $this->searchLocation = [$this->searchLocation];
        }
        $this->resetPage();
    }

    public function updatedSearchLocation($value)
    {
        // ✅ Convert string to array on checkbox change
        if (is_string($value)) {
            $this->searchLocation = [$value];
        }
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

        // ✅ FIXED: Location filter - ensure array & exists
        if (!empty($this->searchLocation) && is_array($this->searchLocation)) {
            $query->whereHas('user.profile', function($q) {
                $q->whereIn('address', $this->searchLocation);
            });
        }

        $posts = $query->paginate(5);

        return view('livewire.companies', [
            'posts' => $posts,
            'allLocations' => $this->allLocations, // ✅ Pass to view
        ]);
    }
}
