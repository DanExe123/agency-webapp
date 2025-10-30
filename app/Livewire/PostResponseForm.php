<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostResponse;
use App\Models\PostResponseRate;
use Illuminate\Support\Facades\Auth;

class PostResponseForm extends Component
{
    public $postId;
    public $message;
    public $proposedRates = []; // [guard_type_id => rate]
    public $toast = null;

    protected $rules = [
        'message' => 'required|string|min:10',
        'proposedRates.*' => 'nullable|numeric|min:0',
    ];

    public function mount($postId)
    {
        $post = Post::with('guardNeeds.guardType')->findOrFail($postId);
        foreach ($post->guardNeeds as $need) {
            $this->proposedRates[$need->guard_type_id] = null;
        }
    }

    public function submit()
    {
        $this->validate();

        $response = PostResponse::create([
            'post_id' => $this->postId,
            'agency_id' => Auth::id(),
            'message' => $this->message,
            'status' => 'pending',
        ]);

        foreach ($this->proposedRates as $guardTypeId => $rate) {
            if ($rate !== null) {
                PostResponseRate::create([
                    'post_response_id' => $response->id,
                    'guard_type_id' => $guardTypeId,
                    'proposed_rate' => $rate,
                ]);
            }
        }

        $this->reset(['message', 'proposedRates']);

        $this->toast = [
            'type' => 'success',
            'message' => 'Proposal sent successfully!',
        ];
    }

    public function render()
    {
        $post = Post::with('guardNeeds.guardType')->find($this->postId);
        return view('livewire.post-response-form', ['post' => $post]);
    }
}
