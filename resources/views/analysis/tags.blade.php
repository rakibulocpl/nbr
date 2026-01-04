<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow">

            {{-- Header --}}
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 px-5 py-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Bank Statement Tag Summary
                </h2>

                <a href="{{ route('analysis.show', $statementFile->analysis->id) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium
                           text-white bg-gray-600 rounded-md hover:bg-gray-700 transition">
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
                            'Account No' => $statementFile->statement->acc_no ?? '-',
                            'Opening Balance' => number_format($statementFile->statement->opening_balance, 2),
                            'Closing Balance' => number_format($statementFile->statement->closing_balance, 2),
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
                <!--    TAGS & COUNT LIST    -->
                <!-- ======================== -->

                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Tag Summary
                </h3>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    @foreach ($tags as $tag)
                        <a href="{{ route('transactions.index', ['fileId' => $statementFile->statement_id, 'tag' => $tag->tag]) }}">
                            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <span class="text-gray-700 dark:text-gray-200 font-medium">
                                    {{ $tag->tag }}
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                    {{ $tag->count }}
                                </span>
                            </div>
                        </a>
                    @endforeach


                </div>

                @if ($tags->count() === 0)
                    <p class="text-gray-500 text-center py-4">
                        No tags found.
                    </p>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
