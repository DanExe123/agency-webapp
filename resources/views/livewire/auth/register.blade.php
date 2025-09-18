<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Choose your account type to continue')" />

    <!-- Role Selection -->
    @if(!$role)
        <div class="flex flex-col gap-4 text-center">
            <span class="text-gray-600">Select what type of account you want to create:</span>
            <div class="flex gap-4 justify-center">
                <button type="button" wire:click="$set('role', 'agency')"
                    class="px-4 py-2 rounded-md border text-sm font-medium 
                           bg-black text-white hover:bg-gray-800">
                    Agency Account
                </button>

                <button type="button" wire:click="$set('role', 'company')"
                    class="px-4 py-2 rounded-md border text-sm font-medium 
                           bg-black text-white hover:bg-gray-800">
                    Company Account
                </button>
            </div>
        </div>
    @else
        <!-- Show Selected Role + Back Option -->
        <div class="flex items-center justify-between">
            <span class="text-gray-600">
                You are creating a <strong class="capitalize">{{ $role }}</strong> account
            </span>
            <button type="button" wire:click="$set('role', '')"
                class="text-sm text-red-600 hover:underline">
                Back
            </button>
        </div>

        <!-- Registration Form -->
        <form method="POST" wire:submit="register" class="flex flex-col gap-6">
            <!-- Name -->
            <flux:input
                wire:model="name"
                :label="__('Agency/Company Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Agency/Company name')"
            />

            <!-- Email -->
            <flux:input
                wire:model="email"
                :label="__('Email address')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full bg-black text-white hover:bg-gray-800">
                    {{ __('Create Account') }}
                </flux:button>
            </div>
        </form>
    @endif

    <!-- Already have an account -->
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('loginform')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
