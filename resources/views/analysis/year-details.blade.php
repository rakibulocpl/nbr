<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow">

            {{-- Header --}}
            <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 px-5 py-3">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ $summary->fiscal_year }} — {{ ucfirst($action ?? 'Details') }}
                </h2>
                <a href="{{ route('analysis.show', $summary->file->analysis->id) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>

            <div class="p-5 space-y-6">
                {{-- Basic Info --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">Taxpayer</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $summary->file->analysis->taxpayer_name ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">TIN No</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $summary->file->analysis->tin_no ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">Bank</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            {{ $summary->file->bank->short_name ?? $summary->file->bank->name ?? '-' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">Account No</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $summary->file->acc_no ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">Opening</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ number_format($summary->file->opening_balance, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-gray-500 text-xs">Closing</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ number_format($summary->file->closing_balance, 2) }}</p>
                    </div>
                </div>

                {{-- Summary Numbers (inline badges) --}}
                <div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm">
                    <span class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <strong>Debit:</strong> {{ number_format($summary->total_debit, 2) }}
                    </span>
                    <span class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <strong>Credit:</strong> {{ number_format($summary->total_credit, 2) }}
                    </span>
                    <span class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <strong>Interest:</strong> {{ number_format($summary->credit_interest, 2) }}
                    </span>
                    <span class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <strong>Tax:</strong> {{ number_format($summary->source_tax, 2) }}
                    </span>
                    <span class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <strong>Year-End:</strong> {{ number_format($summary->yearend_balance, 2) }}
                    </span>
                </div>

                {{-- Transactions --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-3 py-2 border-b">Date</th>
                            <th class="px-3 py-2 border-b">Code</th>
                            <th class="px-3 py-2 border-b">Details</th>
                            <th class="px-3 py-2 border-b">Ref</th>
                            <th class="px-3 py-2 border-b text-right">Debit</th>
                            <th class="px-3 py-2 border-b text-right">Credit</th>
                            <th class="px-3 py-2 border-b text-right">Balance</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300">
                        @forelse ($summaryDetails as $tx)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-3 py-1.5">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</td>
                                <td class="px-3 py-1.5">{{ $tx->transaction_code }}</td>
                                <td class="px-3 py-1.5 truncate max-w-[180px]">{{ $tx->details }}</td>
                                <td class="px-3 py-1.5">{{ $tx->ref ?? '-' }}</td>
                                <td class="px-3 py-1.5 text-right">{{ $tx->debit ? number_format($tx->debit, 2) : '-' }}</td>
                                <td class="px-3 py-1.5 text-right">{{ $tx->credit ? number_format($tx->credit, 2) : '-' }}</td>
                                <td class="px-3 py-1.5 text-right">{{ number_format($tx->balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500">No transactions available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
