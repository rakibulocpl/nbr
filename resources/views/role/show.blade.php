<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <div
            class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-gray-900 xl:px-10 xl:py-12 shadow-sm">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                    View Role
                </h3>
                <a href="{{ route('role.index') }}"
                   class="inline-flex items-center gap-1 rounded-md bg-gray-500 px-3 py-2 text-xs font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 dark:focus:ring-offset-gray-900 transition">
                    ← Back
                </a>
            </div>

            <!-- Role Details -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-white">{{ $role->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Permissions</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if($role->permissions && $role->permissions->count())
                            @foreach($role->permissions as $permission)
                                <span class="inline-flex items-center rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800 dark:bg-brand-900 dark:text-brand-200">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No permissions assigned.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
