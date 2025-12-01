<div x-data="{ openResponseModal: false, openConfirm: false, openSuccess: false }"
     x-on:proposal-submitted.window="openSuccess = true"
     x-on:open-confirm-modal.window="openConfirm = true">
    <!-- Apply Button -->
    <button 
        @click="openResponseModal = true"
        class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700"
    >
        Apply
    </button>

    <!-- RESPONSE MODAL -->
    <div x-show="openResponseModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
        <div @click.away="openResponseModal = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button @click="openResponseModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
            <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Send Proposal</h2>

            <!-- Form -->
            <form class="space-y-4" @submit.prevent="$wire.preSubmit()">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea wire:model.defer="message" rows="3" class="w-full border rounded p-2"></textarea>
                    @error('message') 
                        <span class="text-red-600 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proposed Rates per Guard Type</label>
                    <div class="space-y-2">
                        @foreach ($post->guardNeeds as $need)
                            <div class="flex justify-between items-center gap-3 bg-gray-100/60 p-2 rounded">
                                <span class="text-sm font-medium text-gray-700">{{ $need->guardType->name }}</span>
                                <input type="number" min="0" placeholder="₱0.00"
                                    wire:model.defer="proposedRates.{{ $need->guard_type_id }}"
                                    class="w-1/3 border rounded p-1 text-right" />
                            </div>
                            @error('proposedRates.' . $need->guard_type_id)
                                <span class="text-red-600 text-sm block ml-2">{{ $message }}</span>
                            @enderror
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition">
                    Submit Proposal
                </button>
            </form>

        </div>
    </div>

    <!-- CONFIRMATION MODAL -->
    <div x-show="openConfirm" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
        <div @click.away="openConfirm = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Submission</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to submit this proposal?</p>
            <div class="flex justify-end gap-3">
                <button @click="openConfirm = false" class="px-4 py-2 rounded bg-gray-200">Cancel</button>
                <button @click="
                        $wire.submit(); 
                        openConfirm = false; 
                        openResponseModal = false;
                        openSuccess = true
                    " 
                    class="px-4 py-2 rounded bg-gray-900 text-white"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <!-- SUCCESS MODAL -->
    <div x-show="openSuccess" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
            <h3 class="text-lg font-semibold text-green-600 mb-4">Success!</h3>
            <p class="text-gray-700 mb-6">Your proposal has been sent successfully.</p>
            <div class="flex justify-center">
                <button 
                    @click="openSuccess = false; $wire.dispatch('proposalSubmitted')"
                    class="px-5 py-2 bg-gray-900 text-white rounded"
                >
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
