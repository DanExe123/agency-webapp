<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserProfile;
use App\Models\Notification;
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
     * Load notifications based on UserProfile and Notification models
     */
    public function loadNotifications()
    {
        $notifications = [];

        // 1️⃣ UserProfile notifications
        $profiles = UserProfile::with('user')->where('user_id', $this->user->id)->get();
        foreach ($profiles as $profile) {
            $status = $profile->user->account_status ?? 'unknown';
            $notifications[] = [
                'id' => 'profile_'.$profile->id,
                'type' => 'account_status',
                'message' => "Your account is {$status}",
                'is_read' => (bool) $profile->is_read,
                'icon' => $status === 'verified' ? 'check-circle' : 'hourglass',
                'color' => $profile->is_read
                    ? 'text-gray-400'
                    : ($status === 'verified' ? 'text-green-500' : 'text-yellow-500'),
                'created_at' => $profile->created_at, 
            ];
        }

        // 2️⃣ Custom Notifications based on receiver_id
        $userNotifications = Notification::where('receiver_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($userNotifications as $notif) {
            $notifications[] = [
                'id' => 'notif_'.$notif->id,
                'type' => 'notification',
                'message' => $notif->message,
                'is_read' => (bool) $notif->is_read,
                'icon' => 'bell',
                'color' => $notif->is_read ? 'text-gray-400' : 'text-blue-500',
                'created_at' => $notif->created_at,
            ];
        }

        // Combine and sort
        $this->notifications = collect($notifications)
            ->filter(fn ($n) => !empty($n['created_at']))
            ->sortByDesc(fn ($n) => strtotime($n['created_at']))
            ->values()
            ->toArray();

        $this->unreadCount = collect($this->notifications)->where('is_read', false)->count();
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
 * Mark a single notification (UserProfile or Notification) as read
 */
public function markAsRead($id)
{
    if (str_starts_with($id, 'profile_')) {
        $profileId = str_replace('profile_', '', $id);
        $profile = UserProfile::where('user_id', $this->user->id)
                              ->where('id', $profileId)
                              ->first();
        if ($profile && !$profile->is_read) {
            $profile->is_read = true;
            $profile->save();
        }
    }

    if (str_starts_with($id, 'notif_')) {
        $notifId = str_replace('notif_', '', $id);
        $notif = Notification::where('id', $notifId)
                             ->where('receiver_id', $this->user->id)
                             ->first();
        if ($notif && !$notif->is_read) {
            $notif->is_read = true;
            $notif->save();
        }
    }

    $this->loadNotifications(); // refresh list & counts
}

/**
 * Mark all notifications as read (UserProfile + Notification)
 */
public function markAllAsRead()
{
    UserProfile::where('user_id', $this->user->id)->update(['is_read' => true]);
    Notification::where('receiver_id', $this->user->id)->update(['is_read' => true]);

    $this->loadNotifications(); // refresh list & counts
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
