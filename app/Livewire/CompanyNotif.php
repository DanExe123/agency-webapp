<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class CompanyNotif extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $pendingCount = 0;
    public $verifiedCount = 0;
    public $user;
    protected $listeners = ['refreshComponent' => '$refresh'];


    public function mount()
    {
        $this->user = Auth::user();
        $this->loadNotifications();
        $this->countUserStatuses();
    }

    /**
     * Load notifications based on user account status
     */
    public function loadNotifications()
    {
        $notifications = [];

        // Get all profiles of the user
        $profiles = UserProfile::with('user')->where('user_id', $this->user->id)->get();

        foreach ($profiles as $profile) {
            $status = $profile->user->account_status ?? 'unknown';

            $notifications[] = [
                'id' => $profile->id,
                'type' => 'account_status',
                'message' => "Your account is {$status}",
                'is_read' => $profile->is_read ?? false,
                'icon' => $status === 'verified' ? 'check-circle' : 'hourglass',
                'color' => $profile->is_read ? 'text-gray-400' : ($status === 'verified' ? 'text-green-500' : 'text-yellow-500'),
            ];
        }

        $this->notifications = $notifications;
        $this->unreadCount = $profiles->where('is_read', false)->count();
    }

    /**
     * Count all users by account status
     */
    public function countUserStatuses()
    {
        $this->pendingCount = UserProfile::whereHas('user', function ($query) {
            $query->where('account_status', 'pending');
        })->count();

        $this->verifiedCount = UserProfile::whereHas('user', function ($query) {
            $query->where('account_status', 'verified');
        })->count();
    }

    /**
     * Mark a single profile notification as read by profile ID
     */
    public function markProfileAsRead($profileId)
    {
        $profile = UserProfile::where('user_id', $this->user->id)
                              ->where('id', $profileId)
                              ->first();
    
        if ($profile && !$profile->is_read) {
            $profile->is_read = true;
            $profile->save();
        }
    
        // Reload notifications after marking as read
        $this->loadNotifications();
    }
    

    /**
     * Mark all profile notifications as read
     */
    public function markAllProfilesAsRead()
    {
        UserProfile::where('user_id', $this->user->id)->update(['is_read' => true]);
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.company-notif', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
            'pendingCount' => $this->pendingCount,
            'verifiedCount' => $this->verifiedCount,
        ]);
    }
}
