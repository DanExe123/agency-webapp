<div x-data="{ openModal: false, openConfirm: false, openSuccess: false }" \
x-on:post-updated.window="
        openConfirm = false;
        openSuccess = true;
     "
x-cloak>

    <!-- Edit Button -->
    <button 
        @click="openModal = true" 
        class="w-full text-left px-4 py-2 hover:bg-gray-100 text-blue-600"
    >
        Edit
    </button>

    <!-- Edit Modal -->
    <div x-show="openModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
        <div @click.away="openModal = false" class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <!-- Close Button -->
            <button @click="openModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

            <h2 class="text-xl font-bold text-gray-800 border-b pb-2">Edit Job Post</h2>

            <div class="pt-4 space-y-4">
                <!-- Form Fields -->
                <x-textarea label="Job Description" placeholder="Enter job description..." wire:model.defer="description" />
                <x-textarea label="Requirements" placeholder="Enter job requirements..." wire:model.defer="requirements" />

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="font-semibold text-gray-700">Security Guard Types</label>
                        <x-button sm wire:click="addGuardNeed" class="!bg-green-600 !text-white">+ Add Guard</x-button>
                    </div>

                    @foreach($guardNeeds as $index => $need)
                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-md">
                            <x-select wire:model.defer="guardNeeds.{{ $index }}.guard_type_id" class="w-1/2">
                                <option value="">-- Select Guard Type --</option>
                                @foreach($guardTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-select>

                            <x-input type="number" min="1" class="w-1/3" placeholder="Quantity" wire:model.defer="guardNeeds.{{ $index }}.quantity" />

                            <button type="button" wire:click="removeGuardNeed({{ $index }})" class="text-red-500 hover:text-red-700 font-bold">✕</button>
                        </div>
                    @endforeach
                </div>

                <!-- Save Button triggers confirmation -->
                <x-button @click="openConfirm = true" class="!bg-black !text-white !w-full">Save Changes</x-button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="openConfirm" x-transition
     x-on:open-confirm-modal.window="openConfirm = true"
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
     style="display: none;">
    <div @click.away="openConfirm = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Submission</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to submit this job post?</p>
        <div class="flex justify-end gap-3">
            <x-button @click="openConfirm = false" class="!bg-gray-200 !text-gray-800">Cancel</x-button>
            <x-button wire:click="updatePost" class="!bg-black !text-white">Confirm</x-button>
        </div>
    </div>
</div>

    <!-- Success Modal -->
    <div x-show="openSuccess" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h3 class="text-lg font-semibold text-green-600 mb-4">Success!</h3>
            <p class="text-gray-700 mb-6">The job post has been updated successfully.</p>
            <div class="flex justify-end">
                <x-button @click="openSuccess = false" class="!bg-black !text-white">OK</x-button>
            </div>
        </div>
    </div>

</div>
