<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Notification;
use App\Helpers\LogActivity;

class Checkout extends Component
{
    use WithFileUploads;

    public string $plan;
    public int $price;
    public ?string $payment_method = null;
    public $payment_proof;

    public function mount(string $plan)
    {
        $plans = [
            'monthly' => 500,
            'yearly'  => 2500,
        ];

        abort_unless(isset($plans[$plan]), 404);

        $this->plan = $plan;
        $this->price = $plans[$plan];
    }

    public function proceed()
    {
        $this->validate([
            'payment_method' => 'required|in:ewallet',
            'payment_proof'  => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proofPath = $this->payment_proof->store('payments', 'public');

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'plan' => $this->plan,
            'amount' => $this->price,
            'payment_method' => $this->payment_method,
            'payment_proof_path' => $proofPath,
            'status' => 'pending',
        ]);

        // Add Activity Log
        LogActivity::add("Submitted {$this->plan} subscription payment", "Checkout");

        // Create Notification for Admin (receiver_id = 1)
        Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => 1,
            'message' => Auth::user()->name . " submitted a {$this->plan} subscription payment",
            'is_read' => false,
        ]);

        session(['checkout_payment_id' => $payment->id]);

        return redirect()->route('register');
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
