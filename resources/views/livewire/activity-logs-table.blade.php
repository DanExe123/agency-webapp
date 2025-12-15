<div>

    <div class="max-w-7xl mx-auto mt-6 px-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Posts You Applied To</h2>
        <div class="mb-4 flex items-center space-x-2">
                <input 
                    type="text" 
                    placeholder="Search actions..." 
                    wire:model.debounce.300ms="search"
                    class="border px-2 py-1 rounded w-1/3"
                />
            </div>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
            

            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-4 py-2 text-left">Action</th>
                        <th class="px-4 py-2 text-left">Location / IP</th>
                        <th class="px-4 py-2 text-left">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">You {{ $log->action }}</td>
                            <td class="px-4 py-2">{{ $log->location ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-2 mb-2">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
