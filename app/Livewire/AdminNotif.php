<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class AdminNotif extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $user; // current user

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->user = auth()->user(); 
        $this->loadNotifications(); // unified loader
    }

    /**
     * Load all notifications
     */
    public function loadNotifications()
    {
        $notifications = [];

        // Pending users notification
        $pendingUsers = User::role(['agency', 'company'])
            ->where('account_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = $pendingUsers->count();

        if ($pendingCount > 0) {
            $latestPendingUser = $pendingUsers->first();

            $isRead = $this->user->pending_users_read_at
                && $this->user->pending_users_read_at >= ($latestPendingUser->created_at ?? now());

            $notifications[] = [
                'id' => 1,
                'type' => 'pending_user',
                'message' => "You have {$pendingCount} pending user(s)",
                'is_read' => $isRead,
                'icon' => 'users',
                'color' => $isRead ? 'text-gray-400' : 'text-blue-500',
                'created_at' => $latestPendingUser ? $latestPendingUser->created_at : now(),
            ];
        }

        // Custom notifications
        $customNotifs = Notification::where('receiver_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($customNotifs as $notif) {
            $notifications[] = [
                'id' => 'notif_' . $notif->id,
                'type' => 'notification',
                'message' => $notif->message,
                'is_read' => (bool) $notif->is_read,
                'icon' => 'bell',
                'color' => $notif->is_read ? 'text-gray-400' : 'text-blue-500',
                'created_at' => $notif->created_at,
            ];
        }

        // Sort by created_at descending
        $this->notifications = collect($notifications)
            ->filter(fn($n) => !empty($n['created_at']))
            ->sortByDesc(fn($n) => strtotime($n['created_at']))
            ->values()
            ->toArray();

        $this->unreadCount = collect($this->notifications)->where('is_read', false)->count();
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id)
    {
        foreach ($this->notifications as &$notif) {
            if ($notif['id'] == $id) { // loose comparison works for both string and int
                $notif['is_read'] = true;

                // Pending user notification
                if ((int)$id === 1) {
                    $this->user->pending_users_read_at = now();
                    $this->user->save();
                }

                // Custom notifications
                if (str_starts_with($id, 'notif_')) {
                    $notifId = str_replace('notif_', '', $id);
                    $dbNotif = Notification::find($notifId);
                    if ($dbNotif) {
                        $dbNotif->is_read = true;
                        $dbNotif->save();
                    }
                }
            }
        }

        // Update unread count
        $this->unreadCount = collect($this->notifications)->where('is_read', false)->count();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        // Mark pending user notification
        $this->user->pending_users_read_at = now();
        $this->user->save();

        // Mark all custom notifications
        Notification::where('receiver_id', $this->user->id)
            ->update(['is_read' => true]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin-notif', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
