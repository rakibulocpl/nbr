<x-app-layout>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                {{-- Header --}}
                <div
                    class="px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-gray-800 rounded-t-2xl shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <!-- Left side: Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        File Repository
                    </h3>

                    <!-- Right side: Upload Button -->
                    <a href="{{ route('fileRepo.create') }}"
                       class="inline-flex items-center gap-2 rounded-md bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload File
                    </a>
                </div>

                {{-- Search Box --}}
                <div class="border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 p-5 sm:p-6">
                    <form method="GET" action="{{ route('fileRepo.index') }}"
                          class="flex flex-col sm:flex-row items-center gap-3 w-full max-w-lg mx-auto">

                        <div class="relative flex-1 w-full">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="🔍 Search by title, tracking no, or keyword..."
                                class="w-full rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 pl-10 pr-24 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                            />

                            {{-- Search Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z"/>
                            </svg>

                            {{-- Buttons --}}
                            <div class="absolute right-2 top-1.5 flex gap-2">
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-medium bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                                    Search
                                </button>

                                @if(request('search'))
                                    <a href="{{ route('fileRepo.index') }}"
                                       class="px-3 py-1.5 text-xs font-medium bg-gray-300 text-gray-800 rounded-full hover:bg-gray-400 transition">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40">
                                    <th class="px-5 py-3 sm:px-6 text-left font-semibold text-gray-600 dark:text-gray-300">Tracking No</th>
                                    <th class="px-5 py-3 sm:px-6 text-left font-semibold text-gray-600 dark:text-gray-300">Title</th>
                                    <th class="px-5 py-3 sm:px-6 text-left font-semibold text-gray-600 dark:text-gray-300">Status</th>
                                    <th class="px-5 py-3 sm:px-6 text-left font-semibold text-gray-600 dark:text-gray-300">Action</th>
                                </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse ($list as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition">
                                        <td class="px-5 py-4 sm:px-6 text-gray-700 dark:text-gray-300">
                                            {{ $item->tracking_no }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6 text-gray-700 dark:text-gray-300">
                                            {{ $item->title }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="inline-block rounded-full bg-green-100 text-green-800 dark:bg-green-500/15 dark:text-green-400 px-3 py-0.5 text-xs font-semibold">
                                                {{$item->statusInfo->name}}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('fileRepo.show', $item->id) }}"
                                                   class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1 rounded">
                                                    Show
                                                </a>

                                                <form action="{{ route('fileRepo.destroy', $item->id) }}" method="POST"
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40">
                            <div class="flex justify-center">
                                {{ $list->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
