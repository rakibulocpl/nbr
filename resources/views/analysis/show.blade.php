<x-app-layout>
    <div class="mx-auto max-w-screen-lg px-4 sm:px-2 lg:px-4 py-5">
        <div class="max-w-7xl mx-auto">

            {{-- Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md">
                {{-- Header --}}
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Analysis Request Details
                        </h2>

                        @php
                            $status = strtolower($analysis->status);
                            $badgeClasses = match($status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'done', 'completed' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full capitalize {{ $badgeClasses }}">
                            {{ $analysis->status }}
                        </span>
                    </div>

                    <div class="flex gap-2">
                        {{-- Back Button --}}
                        {{-- Export PDF Button --}}
                        <a href="{{ route('analysis.export-pdf', $analysis->id) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 16v-8m0 0l-3 3m3-3l3 3M4 20h16"/>
                            </svg>
                            Export PDF
                        </a>
                        <a href="{{ route('analysis.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </a>


                    </div>
                </div>


                {{-- Content --}}
                {{-- Content --}}
                <div class="p-6 space-y-8">

                    {{-- Taxpayer Info --}}
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-3">
                            Taxpayer Information
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Taxpayer Name</p>
                                <p class="text-base font-medium text-gray-800 dark:text-white">
                                    {{ $analysis->taxpayer_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">TIN No</p>
                                <p class="text-base font-medium text-gray-800 dark:text-white">
                                    {{ $analysis->tin_no }}
                                </p>
                            </div>
                        </div>
                    </div>



                    {{-- Project Information --}}
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-3">
                            File Information
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">File ID :</p>
                                <p class="font-medium text-gray-800 dark:text-white">
                                    {{ $analysis->project->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>



                    {{-- Files List --}}
                    <div>
                        <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-3">
                            Uploaded Bank Statements
                        </h3>

                        @if($analysis->files->count())
                            <div class="space-y-6">
                                @foreach ($analysis->files as $file)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50 dark:bg-gray-800">
                                        {{-- Bank Info --}}
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h4 class="font-semibold text-gray-800 dark:text-white">
                                                    {{ $file->bank->name ?? 'Unknown Bank' }}
                                                </h4>
                                                <p class="text-sm text-gray-500">{{ $file->bank->short_name ?? '-' }}</p>
                                            </div>
                                            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank"
                                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M4 4v16h16V4M8 12h8m-4-4v8"/>
                                                </svg>
                                                View PDF
                                            </a>

                                            @if(!empty($file->statement))

                                                <a href="{{ route('transactions.index', $file->id) }}"
                                                   class="text-blue-600 hover:underline text-sm font-medium">
                                                    View All Transactions →
                                                </a>

                                                <a href="{{ route('analysis.tags', $file->id) }}"
                                                   class="text-blue-600 hover:underline text-sm font-medium">
                                                    View All Tags →
                                                </a>
                                            @endif


                                        </div>

                                        {{-- Account Info --}}
                                        @if(!empty($file->statement))
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Account No</p>
                                                    <p class="font-medium text-gray-800 dark:text-white">{{ $file->statement->acc_no ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Account Type</p>
                                                    <p class="font-medium text-gray-800 dark:text-white">{{ $file->statement->acc_type ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Opening Balance</p>
                                                    <p class="font-medium text-gray-800 dark:text-white">
                                                        {{ number_format($file->statement->opening_balance, 2) ?? '-' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Closing Balance</p>
                                                    <p class="font-medium text-gray-800 dark:text-white">
                                                        {{ number_format($file->statement->closing_balance, 2) ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Yearly Summary --}}
                                            @if($file->yearlySummaries->count())
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-700 rounded-lg">
                                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                                        <tr>
                                                            <th class="px-4 py-2 border-b">Fiscal Year</th>
                                                            <th class="px-4 py-2 border-b">Total Debit</th>
                                                            <th class="px-4 py-2 border-b">Total Credit</th>
                                                            <th class="px-4 py-2 border-b">Credit Interest</th>
                                                            <th class="px-4 py-2 border-b">Source Tax</th>
                                                            <th class="px-4 py-2 border-b">Year-end Balance</th>
                                                            <th class="px-4 py-2 border-b">#</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="text-gray-700 dark:text-gray-300">
                                                        @foreach ($file->yearlySummaries as $summary)
                                                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                                                <td class="px-4 py-2">{{ $summary->fiscal_year }}</td>
                                                                <td class="px-4 py-2">{{ number_format($summary->total_debit, 2) }}</td>
                                                                <td class="px-4 py-2">{{ number_format($summary->total_credit, 2) }}</td>
                                                                <td class="px-4 py-2">{{ number_format($summary->credit_interest, 2) }}</td>
                                                                <td class="px-4 py-2">{{ number_format($summary->source_tax, 2) }}</td>
                                                                <td class="px-4 py-2">{{ number_format($summary->yearend_balance, 2) }}</td>

                                                                <td class="px-4 py-2 text-center">
                                                                    <div class="relative inline-block text-left">
                                                                        <button type="button"
                                                                                class="p-2 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none action-toggle">
                                                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                                                <path d="M6 11.25c0 .828.672 1.5 1.5 1.5S9 12.078 9 11.25 8.328 9.75 7.5 9.75 6 10.422 6 11.25zm6 0c0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5-.672-1.5-1.5-1.5-1.5.672-1.5 1.5zm6 0c0 .828.672 1.5 1.5 1.5S21 12.078 21 11.25 20.328 9.75 19.5 9.75 18 10.422 18 11.25z"/>
                                                                            </svg>
                                                                        </button>

{{--                                                                        <div class="action-menu absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">--}}
{{--                                                                            <ul class="text-sm text-gray-700">--}}
{{--                                                                                <li><a href="{{ route('statement-analysis.year-details', [$analysis->id, $summary->id, 'cash']) }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100">Cash</a></li>--}}
{{--                                                                                <li><a href="{{ route('statement-analysis.year-details', [$analysis->id, $summary->id, 'cheque']) }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100">Cheque</a></li>--}}
{{--                                                                                <li><a href="{{ route('statement-analysis.year-details', [$analysis->id, $summary->id, 'transfer']) }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100">Transfer</a></li>--}}
{{--                                                                                <li><a href="{{ route('statement-analysis.year-details', [$analysis->id, $summary->id, 'other']) }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 rounded-b-lg">Other</a></li>--}}
{{--                                                                            </ul>--}}
{{--                                                                        </div>--}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No yearly summary data available.</p>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No files uploaded.</p>
                        @endif
                    </div>


                    {{-- Footer --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                        <p>Created at: {{ $analysis->created_at->format('d M Y, h:i A') }}</p>
                        <p>Last updated: {{ $analysis->updated_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dropdowns = document.querySelectorAll('.action-toggle');

                dropdowns.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();

                        // Close all other dropdowns first
                        document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));

                        const menu = this.parentElement.querySelector('.action-menu');
                        const rect = this.getBoundingClientRect();
                        const menuHeight = 200; // approximate height of dropdown (px)
                        const viewportHeight = window.innerHeight;

                        // Reset first
                        menu.style.position = 'fixed';
                        menu.style.top = '';
                        menu.style.bottom = '';
                        menu.style.left = '';
                        menu.classList.remove('hidden');

                        // Calculate positions
                        const spaceBelow = viewportHeight - rect.bottom;
                        const spaceAbove = rect.top;

                        if (spaceBelow < menuHeight && spaceAbove > menuHeight) {
                            // Open upward
                            menu.style.bottom = (viewportHeight - rect.top + 5) + 'px';
                        } else {
                            // Open downward
                            menu.style.top = (rect.bottom + 5) + 'px';
                        }

                        // Align to right of button
                        menu.style.left = (rect.right - 160) + 'px'; // adjust width (160px = w-40)
                    });
                });

                // Close dropdowns when clicking outside
                document.addEventListener('click', () => {
                    document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));
                });
            });
        </script>
    @endpush



</x-app-layout>
