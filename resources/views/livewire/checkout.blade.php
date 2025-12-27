<div class="max-w-xl mx-auto p-6 space-y-6" x-data="{ payment_method: @entangle('payment_method') }">

    <h2 class="text-2xl font-bold">Checkout</h2>

    <!-- Plan Summary -->
    <div class="rounded-md border p-4 bg-gray-50">
        <p class="text-sm text-gray-600">Selected Plan</p>
        <p class="text-lg font-semibold capitalize">
            {{ $plan }} access
        </p>
        <p class="text-gray-500">
            ₱{{ number_format($price) }}
            {{ $plan === 'monthly' ? '/month' : '/year' }}
        </p>
    </div>

    <!-- Payment Method -->
    <div class="space-y-2">
        <label class="font-medium text-gray-700">Payment Method</label>

        <select x-model="payment_method"
                class="w-full border rounded-md px-3 py-2">
            <option value="">-- Select --</option>
            <option value="ewallet">E-Wallet (GCash / Maya)</option>
            <option value="bank" disabled>Bank Account (Unavailable)</option>
        </select>

        @error('payment_method')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <!-- Instructions -->
        <div x-show="payment_method === 'bank'" class="text-sm text-red-600 mt-1" x-cloak>
            Bank account option is currently unavailable.
            Please select E-Wallet to continue.
        </div>

        <div x-show="payment_method === 'ewallet'" class="text-sm text-gray-700 mt-1 space-y-1" x-cloak>
            <p>Currently we accept the following E-Wallets:</p>
            <ul class="list-disc list-inside">
                <li>GCash: <span class="font-medium">0917-XXX-XXXX</span></li>
                <li>Maya: <span class="font-medium">0922-XXX-XXXX</span></li>
            </ul>
        </div>
    </div>

    <!-- Upload Proof -->
    <div x-show="payment_method === 'ewallet'" class="space-y-2" x-cloak>
        <label class="font-medium text-gray-700">Upload Payment Proof</label>

        <input type="file"
               wire:model="payment_proof"
               accept="image/*"
               class="w-full border rounded-md px-3 py-2">

        @error('payment_proof')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <!-- Uploading indicator -->
        <p wire:loading wire:target="payment_proof"
           class="text-sm text-gray-500">
            Uploading...
        </p>

        <!-- Preview -->
        <template x-if="$wire.payment_proof">
            <img :src="$wire.payment_proof ? $wire.payment_proof.temporaryUrl() : ''"
                 class="w-40 rounded-md border mt-2">
        </template>
    </div>

    <!-- Continue -->
    <button wire:click="proceed"
            wire:loading.attr="disabled"
            wire:target="proceed,payment_proof"
            class="w-full bg-black text-white py-2 rounded-md
                   hover:bg-gray-800 disabled:opacity-50">
        Continue
    </button>

</div>
