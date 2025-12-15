<?php

namespace App\Livewire\Actions;

use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
         $user = Auth::user();

        // ✅ Log the logout activity
        if ($user) {
            LogActivity::add('logged out');
        }

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
