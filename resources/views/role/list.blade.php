<x-app-layout>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex items-center justify-between">
                    <!-- Left side: Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Roles
                    </h3>

                    <!-- Right side: Button -->
                    <a href="{{ route('role.create') }}"
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
                                <!-- table header start -->
                                <thead>

                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Role
                                                </p>
                                            </div>
                                        </th>


                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Status
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Action
                                                </p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- table header end -->
                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center gap-3">

                                                        <div>
                                                            <span
                                                                class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                                {{$role->name}}
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                        Active
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <a href="{{route('role.show', [$role->id])}}"
                                                        class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1 rounded mr-2">Show</a>
                                                    {{-- @can('role.edit') --}}
                                                    <a href="{{route('role.edit', [$role->id])}}"
                                                        class="bg-brand-500 hover:bg-brand-600 text-white text-xs px-3 py-1 rounded mr-2">Edit</a>
                                                    {{-- @endcan --}}
                                                    {{-- @can('role.delete') --}}
                                                    <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this role?')"
                                                            class="bg-brand-500 hover:bg-brand-600 text-white text-xs px-3 py-1 rounded">
                                                            Delete
                                                        </button>
                                                    </form>
                                                    {{-- @endcan --}}
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
