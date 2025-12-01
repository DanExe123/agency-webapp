<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchControl extends Component
{
    public $search = '';
    public $location = '';
    public $searchResults = [];
    public $showResults = false;

    public function updatedSearch()
    {
        $this->find();
    }

    public function updatedLocation()
    {
        $this->find();
    }

    public function find()
{
    $this->searchCompaniesOrAgencies();

    
}


    private function searchCompaniesOrAgencies()
    {
        // Hide dropdown if both fields empty
        if (strlen($this->search) < 2 && strlen($this->location) < 2) {
            $this->searchResults = [];
            $this->showResults = false;
            return;
        }

        $userRole = Auth::user()->getRoleNames()->first();

        $query = User::with('profile')
            ->whereHas('profile');

        // Filter based on role
        if ($userRole === 'Agency') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Company');
            });
        } elseif ($userRole === 'Company') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Agency');
            });
        }

        // Search by name/email
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by profile.address only
        if ($this->location) {
            $query->whereHas('profile', function ($q) {
                $q->where('address', 'like', '%' . $this->location . '%');
            });
        }

        $this->searchResults = $query->limit(10)->get();
        $this->showResults = true;
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->location = '';
        $this->searchResults = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.search-control');
    }
}
