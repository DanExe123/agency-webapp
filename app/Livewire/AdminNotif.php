<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AdminNotif extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $user; // current user

    public function mount()
    {
        $this->user = auth()->user(); 
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $pendingCount = User::where('account_status', 'pending')->count();

        $notifications = [];

        if ($pendingCount > 0) {
            $notifications[] = [
                'id' => 1,
                'type' => 'pending_user',
                'message' => "You have {$pendingCount} pending user(s)",
                'is_read' => $this->user->is_read ?? false, // from user model
                'icon' => 'users',
                'color' => 'text-blue-500'
            ];
        }

        $this->notifications = $notifications;
        $this->unreadCount = collect($notifications)->where('is_read', false)->count();
    }

       // New function for company account notifications
    // ------------------------------
    public function loadCompanyStatusNotifications()
    {
        $notifications = [];

        if ($this->user->account_status === 'pending') {
            $notifications[] = [
                'id' => 101,
                'type' => 'company_pending',
                'message' => "Your account is still pending for verification",
                'is_read' => $this->user->is_read ?? false,
                'icon' => 'hourglass', // Phosphor icon
                'color' => 'text-yellow-500',
            ];
        } elseif ($this->user->account_status === 'verified') {
            $notifications[] = [
                'id' => 102,
                'type' => 'company_verified',
                'message' => "Your account has been successfully verified",
                'is_read' => $this->user->is_read ?? false,
                'icon' => 'check-circle', // Phosphor icon
                'color' => 'text-green-500',
            ];
        }

        $this->notifications = $notifications;
        $this->unreadCount = collect($notifications)->where('is_read', false)->count();
    }
    // Mark all notifications as read (update user model)
    public function markAsRead()
    {
        $this->user->is_read = true;
        $this->user->save();

        foreach ($this->notifications as &$notif) {
            $notif['is_read'] = true;
        }

        $this->unreadCount = 0;
    }

    // Mark a single notification as read
    public function markSingleAsRead($type, $id)
    {
        foreach ($this->notifications as &$notif) {
            if (($notif['type'] ?? null) === $type && ($notif['id'] ?? null) == $id) {
                $notif['is_read'] = true;
                $this->user->is_read = true; // update user model
                $this->user->save();
            }
        }

        $this->unreadCount = collect($this->notifications)->where('is_read', false)->count();
    }

    public function render()
    {
        return view('livewire.admin-notif');
    }
}
