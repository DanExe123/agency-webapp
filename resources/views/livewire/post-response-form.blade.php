<div>
    @if ($toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endif

    <form wire:submit.prevent="submit" class="space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-700">Message</label>
            <textarea wire:model="message" rows="4" class="w-full border rounded p-2 focus:ring focus:ring-blue-300"></textarea>
            @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Rate</label>
            <input type="number" wire:model="proposed_rate" class="w-full border rounded p-2 focus:ring focus:ring-blue-300" placeholder="e.g. 25000">
            @error('proposed_rate') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md w-32 h-10 hover:bg-gray-700 transition">
            Apply
        </button>
    </form>
</div>
