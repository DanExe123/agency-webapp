<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Feedback;
use App\Models\PostResponse;
use Illuminate\Support\Facades\Auth;

class GiveFeedback extends Component
{
    public $postId;
    public $acceptedResponses = [];
    public $ratings = [];        // ['response_id' => rating]
    public $messages = [];       // ['response_id' => message]
    public $showModal = false;

    protected $rules = [
        'ratings' => 'array',
        'ratings.*' => 'required|integer|min:1|max:5',
        'messages' => 'array',
        'messages.*' => 'required|string|max:500',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->loadAcceptedResponses();
    }

    public function loadAcceptedResponses()
    {
        $post = Post::with(['responses.agency.profile'])->find($this->postId);
        $this->acceptedResponses = $post?->responses
            ->where('status', 'accepted')
            ->map(function ($response) {
                return [
                    'id' => $response->id,
                    'agency_id' => $response->agency_id,
                    'agency_name' => $response->agency->name ?? 'Unknown',
                    'logo_path' => $response->agency->profile?->logo_path ?? null,
                ];
            })->values()->toArray() ?? [];
        
        // Initialize arrays for each response
        foreach ($this->acceptedResponses as $response) {
            $this->ratings[$response['id']] = 0;
            $this->messages[$response['id']] = '';
        }
    }

    public function openModal()
    {
        if (empty($this->acceptedResponses)) {
            session()->flash('error', 'No accepted agencies found.');
            return;
        }
        $this->showModal = true;
    }

    public function submitAllFeedback()
    {
        $this->validate();

        foreach ($this->acceptedResponses as $response) {
            Feedback::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $response['agency_id'],
                'post_response_id' => $response['id'],
                'message' => $this->messages[$response['id']],
                'rating' => $this->ratings[$response['id']],
            ]);

            PostResponse::where('id', $response['id'])
                ->update(['status' => 'completed_negotiating']);
        }

        Post::find($this->postId)->update(['status' => 'completed']);
        
        $this->showModal = false;
        $this->reset(['ratings', 'messages']);
        session()->flash('success', 'All feedback submitted!');
    }

    public function render()
    {
        return view('livewire.give-feedback');
    }
}
