<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostGuardNeed;
use App\Models\SecurityGuardType;
use App\Helpers\LogActivity;

class CreatePost extends Component
{
    public $description = '';
    public $requirements = '';
    public $toast = null;

    // Dynamic rows for guard type & quantity
    public $guardNeeds = [
        ['guard_type_id' => '', 'quantity' => '']
    ];

    public function addGuardNeed()
    {
        $this->guardNeeds[] = ['guard_type_id' => '', 'quantity' => ''];
    }

    public function removeGuardNeed($index)
    {
        unset($this->guardNeeds[$index]);
        $this->guardNeeds = array_values($this->guardNeeds); // reindex
    }

    public function preSubmit()
{
    // Validate inputs first
    $this->validate([
        'description' => 'required|string',
        'requirements' => 'nullable|string',
        'guardNeeds.*.guard_type_id' => 'required|exists:security_guard_types,id',
        'guardNeeds.*.quantity' => 'required|integer|min:1',
    ]);

    // If validation passes, tell Alpine to open confirmation modal
    $this->dispatch('open-confirm-modal');
}


    public function submit()
    {
        $this->validate([
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'guardNeeds.*.guard_type_id' => 'required|exists:security_guard_types,id',
            'guardNeeds.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        if (!$userId) {
            $this->toast = [
                'type' => 'error',
                'message' => 'You must be logged in to submit a post.',
            ];
            return;
        }

        // Create the post
        $post = Post::create([
            'user_id' => $userId,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'status' => 'open',
        ]);

        // Save each guard need
        foreach ($this->guardNeeds as $need) {
            PostGuardNeed::create([
                'post_id' => $post->id,
                'guard_type_id' => $need['guard_type_id'],
                'quantity' => $need['quantity'],
            ]);
        }

        LogActivity::add('created a post: "' . $post->description); // this is what we fucking add

        // Reset form
        $this->reset(['description', 'requirements', 'guardNeeds']);
        $this->guardNeeds = [['guard_type_id' => '', 'quantity' => '']];

          // Emit a browser event to trigger the success modal
        $this->dispatch('post-created');

        $this->toast = [
            'type' => 'success',
            'message' => 'Job Post Submitted Successfully!',
        ];
    }

    public function render()
    {
        return view('livewire.create-post', [
            'guardTypes' => SecurityGuardType::all(),
        ]);
    }
}
