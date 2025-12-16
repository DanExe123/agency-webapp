<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;


#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): mixed
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        $user = Auth::user()->load('profile'); // ✅ eager load profile

        LogActivity::add('logged in');
/*
        if ($user->account_status === 'pending') {
            $this->dispatch('account-pending', [
                'title' => 'Account Pending',
                'text' => 'Your account is still pending. Please wait a few minutes while we check your payment.',
                'icon' => 'warning'
            ]);
    
            Auth::logout(); // optional: log them out
            return null; // STOP any further redirects
        }

*/

       /*  if ($user->subscription_end && now()->gt($user->subscription_end)) {
            $this->dispatch('account-expired', [
                'title' => 'Account Expired',
                'text' => 'Your subscription has expired. Please renew to continue accessing the dashboard.',
                'icon' => 'error'
            ]);
        
            Auth::logout();
            return null;
        }
            */

        // 🚨 Force credentials route if Agency/Company has no profile
        if ($user->hasAnyRole(['Agency', 'Company']) && $user->profile === null) {
            return redirect()->route('credentials'); // ✅ always works
        }

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin-dashboard');
        }

        if ($user->hasAnyRole(['Company', 'Agency'])) {
            return redirect()->route('dashboard');
        }

        // fallback
        return redirect()->intended('/');
    }



    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
