<div class="p-6 space-y-6 max-w-3xl mx-auto">
    <x-textarea 
        label="Job Description" 
        placeholder="Enter job description..." 
        wire:model.defer="description" 
    />

    <x-textarea 
        label="Requirements" 
        placeholder="Enter job requirements..." 
        wire:model.defer="requirements" 
    />

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <label class="font-semibold text-gray-700">Security Guard Types Needed</label>
            <x-button sm wire:click="addGuardNeed" class="!bg-green-600 !text-white">
                + Add Guard
            </x-button>
        </div>

        @foreach($guardNeeds as $index => $need)
            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-md">
                <x-select 
                    wire:model.defer="guardNeeds.{{ $index }}.guard_type_id"
                    class="w-1/2"
                >
                    <option value="">-- Select Guard Type --</option>
                    @foreach($guardTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </x-select>

                <x-input 
                    type="number" 
                    min="1"
                    class="w-1/3"
                    placeholder="Quantity" 
                    wire:model.defer="guardNeeds.{{ $index }}.quantity"
                />

                <button 
                    type="button" 
                    wire:click="removeGuardNeed({{ $index }})"
                    class="text-red-500 hover:text-red-700 font-bold"
                >
                    ✕
                </button>
            </div>
        @endforeach
    </div>

    <x-button 
        wire:click="submit" 
        text="white" 
        class="!bg-black !text-white !w-full">
        Submit Post
    </x-button>

    @if ($toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endif
</div>
