<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserProfile;
use App\Models\User;
use App\Helpers\LogActivity;

class AdminUserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public $selectedProfile = null;
    public $showModal = false;

    public $rejectUserId = null;
    public $rejectFeedback = '';
    public $showRejectModal = false;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
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
        if ($user = User::find($userId)) {
            $user->account_status = 'verified';
            $user->rejection_feedback = null;
            $user->save();

            // Activity log
            LogActivity::add('approved user application: "' . $user->name . '"');

            session()->flash('message', 'User approved.');
        }
    }

    public function reject()
    {
        $this->validate([
            'rejectFeedback' => 'required|string|max:500',
        ]);

        if ($user = User::find($this->rejectUserId)) {
            $user->account_status = 'rejected';
            $user->rejection_feedback = $this->rejectFeedback;
            $user->save();
        }

        LogActivity::add('rejected user application: "' . $user->name . '"');

        $this->closeRejectModal();
    }

    public function archive($userId)
    {
        if ($user = User::find($userId)) {
            $user->account_status = 'archived';
            $user->save();
        }

        LogActivity::add('archived user: "' . $user->name . '"');
    }

    public function unarchive($userId)
    {
        if ($user = User::find($userId)) {
            $user->account_status = 'verified';
            $user->save();
        }
         LogActivity::add('unarchived user: "' . $user->name . '"');
    }

    public function render()
    {
        $profiles = UserProfile::with('user')

            // SEARCH filter
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })

            // STATUS filter
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('account_status', $this->statusFilter);
                });
            })

            ->paginate(10);

        return view('livewire.admin-user-management', [
            'profiles' => $profiles,
        ]);
    }
}
