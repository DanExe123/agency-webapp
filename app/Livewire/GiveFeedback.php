<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostResponse;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class GiveFeedback extends Component
{
    public $postId;
    public $message = '';
    public $rating = 0; // default rating
    public $showModal = false;
    public $userId; // ID of the user being rated
    public $userName; // Name of the user being rated
    public $user;

    protected $rules = [
        'message' => 'required|string|max:500',
        'rating' => 'required|integer|min:1|max:5',
    ];

   public function openModal($postId)
    {
        $this->postId = $postId;

        // Get the negotiating agency for this post
        $post = Post::with('responses.agency.profile')->find($postId);
        $negotiating = $post?->responses->firstWhere('status', 'negotiating');

        if ($negotiating && $negotiating->agency) {
            $this->userId = $negotiating->agency_id;
            $this->userName = $negotiating->agency->name ?? 'Unknown Agency';
            $this->user = $negotiating->agency; // <-- assign the user object here
        }

        $this->showModal = true;
    }

    public function submitFeedback()
    {
        $this->validate();

        $post = Post::find($this->postId);

        if ($post) {
            // Update PostResponse that is negotiating
            $negotiatingResponse = $post->responses()->where('status', 'negotiating')->first();
            if ($negotiatingResponse) {
                $negotiatingResponse->update(['status' => 'completed_negotiating']);
                
                // Save feedback
                Feedback::create([
                    'sender_id' => Auth::id(),
                    'receiver_id' => $negotiatingResponse->agency_id,
                    'message' => $this->message,
                    'rating' => $this->rating,
                ]);
            }

            // Update Post status
            $post->update(['status' => 'completed']);
        }

        $this->showModal = false;
        $this->reset(['message', 'rating']);
       // $this->emit('postUpdated'); // optional, refresh parent list
    }

    public function render()
    {
        return view('livewire.give-feedback');
    }
}
