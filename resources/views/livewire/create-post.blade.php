<div class="p-6 space-y-4 max-w-3xl mx-auto">
    <div class="p-2 space-y-4 max-w-3xl mx-auto">
        <x-textarea label="Job Description" placeholder="Enter company description..." wire:model.defer="description" />
        <x-textarea label="Requirements" placeholder="Enter job requirements..." wire:model.defer="requirements" />
        <x-input label="Needs" placeholder="Number of employees needed" wire:model.defer="needs" />
    
        <x-button wire:click="submit" text="white" class="!bg-black !text-white !w-full">
            Submit Post
        </x-button>
    </div>

    @if ($toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endif
    
</div>
