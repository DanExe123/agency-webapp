<div class="flex flex-col gap-6">

    <h1 class="text-3xl font-bold">Sign in</h1>
    @if (Route::has('register'))
    <div class="space-x-1 rtl:space-x-reverse text-start text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Don\'t have an account?') }}</span>
        <flux:link :href="route('register')" class="text-blue-500" wire:navigate>{{ __('Create Account ') }}</flux:link>
    </div>
@endif
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />
        </div>

        <div class="flex justify-between items-center">
            <!-- Remember Me -->
            <flux:checkbox wire:model="remember" :label="__('Remember me')" />
        
            @if (Route::has('password.request'))
                <flux:link class="text-sm text-blue-600 hover:underline" 
                           :href="route('password.request')" 
                           wire:navigate>
                    {{ __('Forgot password?') }}
                </flux:link>
            @endif
        </div>
        
        <div class="flex items-start justify-start">
            <flux:button type="submit" 
                class="w-full !bg-[#0000006B] !text-white flex items-start justify-end gap-2">
                <span>{{ __('Sign in') }}</span>
            </flux:button>
        </div>
        
    </form>
</div>
