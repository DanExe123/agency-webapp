<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserProfile;
use App\Models\User;

class AdminDashboard extends Component
{
    public $profiles;
    public $selectedProfile = null;
    public $showModal = false;

    public $rejectUserId = null;
    public $rejectFeedback = '';
    public $showRejectModal = false;

    public function mount()
    {
        // Fetch all profiles with their user (who now has account_status)
        $this->profiles = UserProfile::with('user')->get();
    }

    public function openModal($profileId)
    {
        $this->selectedProfile = UserProfile::with('user')->find($profileId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProfile = null;
    }

    public function openRejectModal($userId)
    {
        $this->rejectUserId = $userId;
        $this->rejectFeedback = '';
        $this->showRejectModal = true;
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->rejectUserId = null;
        $this->rejectFeedback = '';
    }

    public function approve($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->account_status = 'verified';
            $user->rejection_feedback = null;
            $user->save();

            session()->flash('message', 'User account approved successfully.');
            $this->mount();
        }
    }

    public function reject()
    {
        $this->validate([
            'rejectFeedback' => 'required|string|max:500',
        ]);

        if ($this->rejectUserId) {
            $user = User::find($this->rejectUserId);
            if ($user) {
                $user->account_status = 'rejected';
                $user->rejection_feedback = $this->rejectFeedback;
                $user->save();

                session()->flash('message', 'User account rejected with feedback.');
                $this->closeRejectModal();
                $this->mount();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'profiles' => $this->profiles
        ]);
    }
}
