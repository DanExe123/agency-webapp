<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $description = '';
    public $requirements = '';
    public $needs = '';
    public $toast = null; // Holds the toast data
   
    public function submit()
    {
        $this->validate([ 
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'needs' => 'required|string',    
        ]);

        $userId = auth()->id();

        if (!$userId) {
            $this->toast = [
                'type' => 'error',
                'message' => 'User must be logged in to submit a post.',
            ];
            return;
        }

        Post::create([
            'user_id' => $userId,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'needs' => $this->needs,
        ]);

        $this->reset();
        $this->dispatch('postCreated'); // 🔥 tell JobPosting to refresh

        $this->toast = [
            'type' => 'success',
            'message' => 'Job Post Submitted Successfully',
        ];
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
