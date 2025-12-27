<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // ✅ new property to hold role from the form
    public string $role = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:agency,company'], // ✅ role validation
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Create user
        $user = User::create($validated);

        // ✅ Assign role using Spatie
        $user->assignRole($validated['role']);

        event(new Registered($user));

        Auth::login($user);

        // Redirect after register
       // $this->redirect(route('dashboard', absolute: false), navigate: true);

       $this->redirect(route('credentials', absolute: false), navigate: true);
    }
}
