<div class="min-h-screen bg-gray-100">

    <!-- Content -->
    <main class="max-w-7xl mx-auto p-6">        
        <!-- Table -->
        <div class="flex items-center gap-4 mb-4">
            <table wire:poll.500ms class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2">Agency Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Payment Method</th>
                        <th class="px-4 py-2">Payment Proof</th>
                        <th class="px-4 py-2">Subscription Plan</th>
                        <th class="px-4 py-2">Subscription Price</th>
                        <th class="px-4 py-2">Account Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ ucfirst($user->payment_method ?? '-') }}</td>
                            <td class="px-4 py-2">
                                @if($user->payment_proof_path)
                                    <a href="{{ asset('storage/'.$user->payment_proof_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                        View Proof
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $user->subscription_plan ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($user->subscription_price)
                                    ₱{{ number_format($user->subscription_price, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ ucfirst($user->account_status ?? 'pending') }}
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <button 
                                type="button"
                                onclick="Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'Do you want to approve this payment?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#28a745',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, approve it!',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.confirmPayment({{ $user->id }})
                                    }
                                })"
                                class="px-2 py-1 bg-green-500 text-white rounded hover:text-green-800"
                            >
                                Confirm Payment
                            </button>
                            
                            <button wire:click="reject({{ $user->id }})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Reject
                            </button>
                            <!-- Include SweetAlert2 if not already included -->
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
           
  

    </main>
</div>
