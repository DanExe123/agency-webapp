<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class SubscriptionControl extends Component
{
    public $users;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        // Load all users, you can filter roles if needed
        $this->users = User::all();
    }

    /**
     * Approve a user's subscription/account
     */
    public function approve($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->account_status = 'approved';
            $user->save();
            $this->loadUsers(); // refresh the table
        }
    }

    /**
     * Reject a user's subscription/account
     */
    public function reject($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->account_status = 'rejected';
            $user->save();
            $this->loadUsers(); // refresh the table
        }
    }

    /**
     * Mark a user's payment as confirmed
     */
    public function confirmPayment($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->account_status = 'approved';
            $user->subscription_start = now(); // current date as start
    
            // Determine end date based on subscription plan
            if ($user->subscription_plan === 'Monthly Access') {
                $user->subscription_end = now()->addMonth();
            } elseif ($user->subscription_plan === '1-Year Promo Access') {
                $user->subscription_end = now()->addYear();
            }
    
            $user->save();
    
            $this->loadUsers(); // refresh table
        }
    }
    

    public function render()
    {
        return view('livewire.subscription-control', [
            'users' => $this->users,
        ]);
    }
}
