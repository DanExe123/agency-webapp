<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PostResponse;
use Illuminate\Support\Facades\Auth;

class PostResponseForm extends Component
{
    public $postId;
    public $message;
    public $proposed_rate;
    public $toast = null;

    protected $rules = [
        'message' => 'required|string|min:10',
        'proposed_rate' => 'nullable|numeric|min:0',
    ];

    public function submit()
    {
        $this->validate();

        PostResponse::create([
            'post_id' => $this->postId,
            'agency_id' => Auth::id(),
            'message' => $this->message,
            'proposed_rate' => $this->proposed_rate,
            'status' => 'pending',
        ]);

        $this->reset(['message', 'proposed_rate']);

        $this->toast = [
            'type' => 'success',
            'message' => 'Proposal sent successfully.',
        ];
    }

    public function render()
    {
        return view('livewire.post-response-form');
    }
}
