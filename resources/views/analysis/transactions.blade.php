<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow">

            {{-- Header --}}
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 px-5 py-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Bank Statement Details
                </h2>

                <a href="{{ route('analysis.show', $statementFile->analysis->id) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium
                           text-white bg-gray-600 rounded-md hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>

            {{-- Body --}}
            <div class="p-5 space-y-8">

                <!-- ======================== -->
                <!--   Basic Information     -->
                <!-- ======================== -->

                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Basic Information
                </h3>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    @php
                        $info = [
                            'Taxpayer' => $statementFile->analysis->taxpayer_name ?? '-',
                            'TIN No' => $statementFile->analysis->tin_no ?? '-',
                            'Bank' => $statementFile->bank->short_name ?? $statementFile->bank->name ?? '-',
                            'Account No' => $statementFile->acc_no ?? '-',
                            'Opening Balance' => number_format($statementFile->opening_balance, 2),
                            'Closing Balance' => number_format($statementFile->closing_balance, 2),
                        ];
                    @endphp

                    @foreach ($info as $label => $value)
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-gray-500 text-xs">{{ $label }}</p>
                            <p class="mt-1 font-medium text-gray-800 dark:text-gray-100">{{ $value }}</p>
                        </div>
                    @endforeach

                </div>


                <!-- ======================== -->
                <!--   Transactions Table    -->
                <!-- ======================== -->

                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Transactions
                </h3>

                {{-- Search Box --}}
                <form method="GET" class="flex items-center gap-2 mb-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search in transactions…"
                           class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64
                                  dark:bg-gray-800 dark:text-gray-100"
                    >

                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Search
                    </button>

                    @if(request('search'))
                        <a href="{{ url()->current() }}"
                           class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Clear
                        </a>
                    @endif
                </form>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">

                    <table class="min-w-full table-fixed text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 border-b text-left w-28">Date</th>
                            <th class="px-4 py-2 border-b text-left w-24">Code</th>
                            <th class="px-4 py-2 border-b text-left w-[40%]">Details</th>
                            <th class="px-4 py-2 border-b text-left w-24">Ref</th>
                            <th class="px-4 py-2 border-b text-right w-28">Debit</th>
                            <th class="px-4 py-2 border-b text-right w-28">Credit</th>
                            <th class="px-4 py-2 border-b text-right w-28">Balance</th>
                        </tr>
                        </thead>

                        <tbody class="text-gray-700 dark:text-gray-300">
                        @php
                            $transections = $searchData ?? $transections ?? [];
                        @endphp

                        @forelse ($transections as $tx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition border-b border-gray-100 dark:border-gray-700">

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $tx->transaction_code }}
                                </td>

                                <td class="px-4 py-2 whitespace-normal break-words">
                                    {{ $tx->details }}
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $tx->ref ?? '-' }}
                                </td>

                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    {{ $tx->debit ? number_format($tx->debit, 2) : '-' }}
                                </td>

                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    {{ $tx->credit ? number_format($tx->credit, 2) : '-' }}
                                </td>

                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    {{ number_format($tx->balance, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                    No transactions available.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    @if($searchData == null && !$searchData != [])
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                            {{ $transections->links() }}
                        </div>
                    @endif


                </div>

            </div>
        </div>

    </div>
</x-app-layout>
