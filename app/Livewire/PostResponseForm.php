<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostResponse;
use App\Models\PostResponseRate;
use App\Models\Notification;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class PostResponseForm extends Component
{
    public $postId;
    public $message;
    public $proposedRates = []; // [guard_type_id => rate]
    public $toast = null;
    public $post;

    protected $rules = [
        'message' => 'required|string',
        'proposedRates.*' => 'required|numeric|min:0',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->post = Post::with('guardNeeds.guardType')->findOrFail($postId);

        foreach ($this->post->guardNeeds as $need) {
            $this->proposedRates[$need->guard_type_id] = null;
        }
    }

    public function preSubmit()
{
    // Validate first
    $this->validate();

    // If validation passes, trigger Alpine to open confirmation modal
    $this->dispatch('open-confirm-modal');
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

        Notification::create([
            'sender_id'   => Auth::id(),              // agency
            'receiver_id' => $this->post->user_id,    // company owner
            'message'     =>  Auth::user()->name .
                            ' applied to your post: ' .
                            $this->post->description,
        ]);

        // ✅ Add activity log here
    LogActivity::add('Submitted a proposal for "' . $this->post->description . '"', );


        $this->reset(['message', 'proposedRates']);
        foreach ($this->post->guardNeeds as $need) {
            $this->proposedRates[$need->guard_type_id] = null;
        }

        $this->toast = [
            'type' => 'success',
            'message' => 'Proposal sent successfully!',
        ];

       // $this->dispatch('proposalSubmitted');
    }

    public function render()
    {
        return view('livewire.post-response-form', [
            'post' => $this->post,
        ]);
    }
}
