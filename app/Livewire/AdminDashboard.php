<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserProfile;

class AdminDashboard extends Component
{
    public $profiles;
    public $selectedProfile = null;
    public $showModal = false;

    public $rejectProfileId = null;
    public $rejectFeedback = '';
    public $showRejectModal = false;

    public function mount()
    {
        // Fetch all profiles with related user
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

    public function openRejectModal($profileId)
    {
        $this->rejectProfileId = $profileId;
        $this->rejectFeedback = '';
        $this->showRejectModal = true;
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->rejectProfileId = null;
        $this->rejectFeedback = '';
    }

    public function approve($profileId)
    {
        $profile = UserProfile::find($profileId);
        $profile->account_status = 'verified';
        $profile->rejection_feedback = null; // clear old feedback
        $profile->save();

        session()->flash('message', 'Profile approved successfully.');
        $this->mount();
    }

    public function reject()
    {
        $this->validate([
            'rejectFeedback' => 'required|string|max:500',
        ]);

        if ($this->rejectProfileId) {
            $profile = UserProfile::find($this->rejectProfileId);
            $profile->account_status = 'rejected';
            $profile->rejection_feedback = $this->rejectFeedback; // ✅ consistent
            $profile->save();

            session()->flash('message', 'Profile rejected with feedback.');
            $this->closeRejectModal();
            $this->mount();
        }
    }


    public function render()
    {
        return view('livewire.admin-dashboard', [
            'profiles' => $this->profiles
        ]);
    }
}
