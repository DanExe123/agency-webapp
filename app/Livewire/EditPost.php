<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostGuardNeed;
use App\Models\SecurityGuardType;

class EditPost extends Component
{
    public $postId;
    public $description = '';
    public $requirements = '';
    public $guardNeeds = [];
    public $guardTypes;
    public $openSuccess = false;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->guardTypes = SecurityGuardType::all();

        $post = Post::with('guardNeeds')->findOrFail($postId);

        $this->description = $post->description;
        $this->requirements = $post->requirements;
        $this->guardNeeds = $post->guardNeeds->map(function($need) {
            return [
                'id' => $need->id,
                'guard_type_id' => $need->guard_type_id,
                'quantity' => $need->quantity,
            ];
        })->toArray();
    }

    public function addGuardNeed()
    {
        $this->guardNeeds[] = ['id' => null, 'guard_type_id' => '', 'quantity' => ''];
    }

    public function removeGuardNeed($index)
    {
        if (isset($this->guardNeeds[$index]['id'])) {
            PostGuardNeed::find($this->guardNeeds[$index]['id'])?->delete();
        }
        unset($this->guardNeeds[$index]);
        $this->guardNeeds = array_values($this->guardNeeds);
    }

    public function updatePost()
    {
        $this->validate([
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'guardNeeds.*.guard_type_id' => 'required|exists:security_guard_types,id',
            'guardNeeds.*.quantity' => 'required|integer|min:1',
        ]);

        $post = Post::findOrFail($this->postId);
        $post->update([
            'description' => $this->description,
            'requirements' => $this->requirements,
        ]);

        foreach ($this->guardNeeds as $need) {
            if ($need['id']) {
                PostGuardNeed::find($need['id'])->update([
                    'guard_type_id' => $need['guard_type_id'],
                    'quantity' => $need['quantity'],
                ]);
            } else {
                PostGuardNeed::create([
                    'post_id' => $this->postId,
                    'guard_type_id' => $need['guard_type_id'],
                    'quantity' => $need['quantity'],
                ]);
            }
        }

        $this->openSuccess = true;
        $this->dispatch('post-updated');
        
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
