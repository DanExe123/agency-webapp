<div class="min-h-screen bg-gray-100" 
     x-data="{
         isOpen: false,
         paymentId: null,
         action: '',
         openModal(id, type) {
             this.paymentId = id;
             this.action = type;
             this.isOpen = true;
         },
         closeModal() {
             this.isOpen = false;
             this.paymentId = null;
             this.action = '';
         },
         confirmAction() {
             if(this.action === 'approve') {
                 $wire.approve(this.paymentId)
             } else if(this.action === 'reject') {
                 $wire.reject(this.paymentId)
             }
             this.closeModal()
         }
     }">

    <main class="max-w-7xl mx-auto p-6">
        <table wire:poll.500ms class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-2">Agency Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Payment Method</th>
                    <th class="px-4 py-2">Payment Proof</th>
                    <th class="px-4 py-2">Subscription Plan</th>
                    <th class="px-4 py-2">Subscription Price</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($payments as $payment)
                    <tr>
                        <td class="px-4 py-2">{{ $payment->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $payment->user->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($payment->payment_method) }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/'.$payment->payment_proof_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                View Proof
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ ucfirst($payment->plan) }}</td>
                        <td class="px-4 py-2">₱{{ number_format($payment->amount, 2) }}</td>
                        @php $c = $payment->created_at; @endphp
                        <td class="px-4 py-2 text-gray-500">
                            {{ $c->diffInHours() < 24 ? $c->diffForHumans() : $c->format('M d, Y • h:i A') }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="
                                px-2 py-1 rounded-full text-xs font-semibold
                                {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $payment->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $payment->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-2 flex gap-2">
                            <button @click="openModal({{ $payment->id }}, 'approve')" class="px-2 py-1 bg-green-500 text-white rounded hover:text-green-800">
                                Approve
                            </button>
                            <button @click="openModal({{ $payment->id }}, 'reject')" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Reject
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <!-- Confirmation Modal -->
    <div x-show="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
        <div class="bg-white rounded-lg p-6 w-96" @click.away="closeModal()">
            <h2 class="text-lg font-bold mb-4">Confirm Action</h2>
            <p class="mb-2">Are you sure you want to <span x-text="action"></span> this payment?</p>

            <!-- Remarks input only for reject -->
            <template x-if="action === 'reject'">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Remarks <span class="text-red-500">*</span></label>
                    <textarea 
                        x-model="$wire.remarks" 
                        rows="3" 
                        class="w-full border rounded px-2 py-1"
                        placeholder="Enter reason for rejection"
                    ></textarea>
                </div>
            </template>

            <div class="flex justify-end gap-3">
                <button 
                    @click="confirmAction()" 
                    :class="action === 'approve' ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600'" 
                    class="px-4 py-2 text-white rounded"
                >
                    Yes
                </button>
                <button @click="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>


</div>
