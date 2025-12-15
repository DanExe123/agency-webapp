<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Choose your account type to continue')" />



   <div x-data="{ payment_method: @entangle('payment_method') }">
        <!-- Payment Method Selection with Alpine.js -->
        <div x-data="{ payment_method: @entangle('payment_method') }" class="flex flex-col gap-4">
            <label class="text-gray-600 font-medium">Select Payment Method</label>

            <select x-model="payment_method" class="border rounded-md px-3 py-2 text-sm" required>
                <option value="">-- Choose Payment Method --</option>
                <option value="ewallet">E-Wallet (GCash)</option>
                <option value="bank">Bank Account (Unavailable)</option>
            </select>

            <!-- Bank Note -->
            <p x-show="payment_method === 'bank'" class="text-sm text-red-600 mt-1" x-cloak>
                Bank account option is currently unavailable. Please select E-Wallet to continue.
            </p>

            <!-- E-Wallet Upload -->
            <div x-show="payment_method === 'ewallet'" class="mt-2" x-cloak>
                <p class="text-sm text-gray-600 mt-1">Please upload your e-wallet payment proof below:</p>
                <input type="file" wire:model="payment_proof" accept="image/*"
                    class="block w-full text-sm text-gray-900 border rounded-md cursor-pointer bg-gray-50 focus:outline-none py-2 px-2" />

                <!-- Preview -->
                @if($payment_proof)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Preview:</p>
                        <img src="{{ $payment_proof->temporaryUrl() }}" alt="Payment Proof"
                            class="mt-2 w-48 h-48 object-cover rounded-md border" />
                    </div>
                @endif
            </div>
             </div>
        </div>

        <div 
        x-data="{ 
            selectedPlan: null,
            init() {
                const plan = localStorage.getItem('selectedPlan');
                if(plan) {
                    this.selectedPlan = JSON.parse(plan);
                    // Sync to Livewire
                    @this.set('subscription_plan', this.selectedPlan.plan);
                    @this.set('subscription_price', this.selectedPlan.price);
                }
            } 
        }" 
        x-init="init()"
    >
        <!-- Display selected plan -->
        <template x-if="selectedPlan">
            <div class="mb-6 rounded-md border p-4 bg-gray-50">
                <p class="text-gray-700 text-sm">You have selected:</p>
                <p class="font-semibold text-lg text-gray-900" x-text="selectedPlan.plan"></p>
                <p class="text-gray-500" 
                   x-text="'₱' + selectedPlan.price + (selectedPlan.plan.includes('Monthly') ? '/month' : '/year')">
                </p>
            </div>
        </template>
    </div>
    



   
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
