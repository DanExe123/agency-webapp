<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PostResponse;

class PostApplied extends Component
{
    public $responses = [];

    public function mount()
    {
        $this->responses = PostResponse::with('post')
            ->where('agency_id', Auth::id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.post-applied', [
            'responses' => $this->responses,
        ]);
    }
}
