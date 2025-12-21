<x-app-layout>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex items-center justify-between">
                    <!-- Left side: Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        User List

                    </h3>

                    <!-- Right side: Button -->
                    <a href="{{ route('user.create') }}"
                       class="inline-flex items-center gap-2 rounded-md bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New
                    </a>
                </div>

                <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <!-- ====== Table Six Start -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">User</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Phone</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Roles</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                                    <img src="{{ asset('tailadmin/build/src/images/user/user-17.jpg') }}" alt="brand" />
                                                </div>
                                                <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                        {{ $user->name }}
                    </span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->phone }}</p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($user->roles as $role)
                                                    <span class="rounded-full bg-blue-50 px-2 py-0.5 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">
                            {{ $role->name }}
                        </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                Active
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex items-center">
                                                <a href="{{ route('user.show', $user->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1 rounded mr-2">Show</a>
                                                <a href="{{ route('user.edit', $user->id) }}" class="bg-brand-500 hover:bg-brand-600 text-white text-xs px-3 py-1 rounded mr-2">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- ====== Table Six End -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
