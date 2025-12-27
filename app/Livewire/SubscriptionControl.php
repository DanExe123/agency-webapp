<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Notification;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class SubscriptionControl extends Component
{
    public $payments;
    public $remarks;

    public function mount()
    {
        $this->loadPayments();
    }

    public function loadPayments()
    {
        $this->payments = Payment::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function approve($paymentId)
    {
        $payment = Payment::find($paymentId);
        if (!$payment) return;

        $payment->status = 'approved';

        // Set expires_at based on plan
        if ($payment->plan === 'monthly') {
            $payment->expires_at = now()->addMonth();
        } else {
            $payment->expires_at = now()->addYear();
        }

        $payment->save();

        // Update user account status
        if ($payment->user) {
            $payment->user->account_status = 'verified';
            $payment->user->save();

            // Create notification for the user
            Notification::create([
                'sender_id'   => Auth::id(), // admin who approved
                'receiver_id' => $payment->user->id,
                'message'     => "Your subscription payment for {$payment->plan} has been approved.",
                'is_read'     => false,
            ]);
        }

        // Log admin activity
        LogActivity::add(
            "Approved subscription for user {$payment->user?->name} (ID: {$payment->user_id})",
            'SubscriptionControl::approve'
        );

        $this->loadPayments();
    }

    public function reject($paymentId)
{
    $payment = Payment::find($paymentId);
    if (!$payment) return;

    // Validate remarks is required
    $this->validate([
        'remarks' => 'required|string|max:1000',
    ]);

    $payment->status = 'rejected';
    $payment->remarks = $this->remarks; // save remarks
    $payment->save();

    // Notify user
    if ($payment->user) {
        Notification::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $payment->user->id,
            'message'     => "Your subscription payment for {$payment->plan} has been rejected. Reason: {$this->remarks}",
            'is_read'     => false,
        ]);
    }

    // Log admin activity
    LogActivity::add(
        "Rejected subscription for user {$payment->user?->name} (ID: {$payment->user_id}). Remarks: {$this->remarks}",
        'SubscriptionControl::reject'
    );

    $this->remarks = null; // reset
    $this->loadPayments();
}


    public function render()
    {
        return view('livewire.subscription-control', [
            'payments' => $this->payments,
        ]);
    }
}
