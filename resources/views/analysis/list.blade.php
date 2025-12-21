<x-app-layout>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div
                    class="px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex items-center justify-between">
                    <!-- Left side: Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Analysis Requests
                    </h3>

                    <!-- Right side: Button -->
                    <a href="{{ route('analysis.create') }}"
                       class="inline-flex items-center gap-2 rounded-md bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New
                    </a>
                </div>

                <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <!-- ====== Table Start ====== -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50">
                                    <th class="px-5 py-3 sm:px-6 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                                        Taxpayer Name
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                                        TIN
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($list as $item)
                                    <tr>
                                        <td class="px-5 py-4 sm:px-6 text-gray-700 dark:text-gray-300">
                                            {{ $item->taxpayer_name }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6 text-gray-700 dark:text-gray-300">
                                            {{ $item->tin_no }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @php
                                                $status = strtolower($item->status);
                                                $badgeClasses = match($status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400',
                                                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400',
                                                    'done', 'completed' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400',
                                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-400',
                                                };
                                            @endphp
                                            <span class="inline-block rounded-full px-3 py-0.5 text-xs font-semibold capitalize {{ $badgeClasses }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('analysis.show', $item->id) }}"
                                                   class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1 rounded">
                                                    Show
                                                </a>
                                                <form action="{{ route('analysis.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination Section -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing
                            <span class="font-medium">{{ $list->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $list->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $list->total() }}</span>
                            results
                        </div>
                        <div>
                            {{ $list->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                    <!-- ====== Table End ====== -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
