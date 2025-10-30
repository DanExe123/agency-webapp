<div>
    @if ($toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Message</label>
            <textarea wire:model="message" rows="3" class="w-full border rounded p-2"></textarea>
            @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Proposed Rates per Guard Type</label>
            <div class="space-y-2">
                @foreach ($post->guardNeeds as $need)
                    <div class="flex justify-between items-center gap-3 bg-gray-100/60 p-2 rounded">
                        <span class="text-sm font-medium text-gray-700">{{ $need->guardType->name }}</span>
                        <input 
                            type="number" 
                            min="0" 
                            placeholder="₱0.00" 
                            wire:model.defer="proposedRates.{{ $need->guard_type_id }}" 
                            class="w-1/3 border rounded p-1 text-right"
                        />
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition">
            Submit Proposal
        </button>
    </form>
</div>
