<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-10">

        <!-- 💼 Header -->
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-2">
                📊 File Repository Dashboard
            </h1>
            <p class="text-gray-500 dark:text-gray-400">
                Overview of uploaded files and their current status
            </p>
        </div>

        <!-- 🧾 Status Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            <!-- Total Files -->
            <div class="p-5 bg-gradient-to-br from-sky-500 to-sky-600 text-white rounded-2xl shadow hover:scale-[1.02] transition-transform duration-200">
                <h3 class="text-sm uppercase opacity-90">Total Files</h3>
                <p class="text-3xl font-bold mt-1">{{ $totalFiles }}</p>
            </div>

            @foreach ($statusCounts as $status => $count)
                @php
                    $colorMap = [
                        'Initiated' => 'from-blue-500 to-blue-600',
                        'Desk Assigned' => 'from-purple-500 to-fuchsia-600',
                        'Accepted' => 'from-green-500 to-emerald-600',
                        'Rejected' => 'from-red-500 to-rose-600',
                        'Archived' => 'from-gray-500 to-slate-600',
                        'Unknown' => 'from-gray-400 to-gray-500',
                    ];
                    $gradient = $colorMap[$status] ?? 'from-gray-400 to-gray-500';
                @endphp
                <div class="p-5 bg-gradient-to-br {{ $gradient }} text-white rounded-2xl shadow hover:scale-[1.02] transition-transform duration-200">
                    <h3 class="text-sm uppercase opacity-90">{{ $status }}</h3>
                    <p class="text-3xl font-bold mt-1">{{ $count }}</p>
                </div>
            @endforeach
        </div>

        <!-- 📄 Recent Files -->
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    📂 Latest Uploaded Analysis
                </h2>
                <a href="{{ route('fileRepo.index') }}"
                   class="text-sm font-medium text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 transition">
                    View All →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">File Name</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Uploaded At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($files as $index => $file)
                        @php
                            $statusName = $file->statusInfo->name ?? 'Unknown';
                            $colorClass = match($statusName) {
                                'Initiated' => 'bg-blue-500',
                                'Desk Assigned' => 'bg-purple-500',
                                'Accepted' => 'bg-green-500',
                                'Rejected' => 'bg-red-500',
                                'Archived' => 'bg-gray-500',
                                default => 'bg-gray-400',
                            };
                        @endphp
                        <tr class="border-b dark:border-gray-800 hover:bg-sky-50 dark:hover:bg-sky-900/20 transition">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                {{ $file->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 truncate max-w-[200px]">{{ $file->file_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-white text-xs font-medium rounded-full {{ $colorClass }}">
                                        {{ $statusName }}
                                    </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No files uploaded yet 📭
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
