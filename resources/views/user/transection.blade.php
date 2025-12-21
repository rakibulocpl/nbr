<x-app-layout>
    <div class="p-4 mx-auto space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Transaction History</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.show',$user->id) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded shadow">
                    Back to User
                </a>
            </div>
        </div>

        {{-- User Info --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6 rounded-xl border border-gray-200 p-4 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Name:</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Phone:</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $user->phone }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Balance:</span>
                        <p class="text-gray-900 dark:text-gray-100">
                            {{ number_format($balance, 2) }} BDT
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Transaction Table --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Transactions</h2>

                @if($transactions->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Date</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Type</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Amount</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Balance After</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Remarks</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                        {{ $transaction->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                {{ $transaction->transection_type === 'investment'
                                                    ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200'
                                                    : 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200' }}">
                                                {{ ucfirst($transaction->transection_type) }}
                                            </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                        {{ number_format($transaction->amount, 2) }} BDT
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                        {{ number_format($transaction->current_balance, 2) }} BDT
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                        {{ $transaction->description }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No transactions found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
