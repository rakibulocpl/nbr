<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <!-- Page Body -->
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                <!-- Card Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700 mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        User Information
                    </h3>
                    <a href="{{ route('user.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </a>
                </div>

                <!-- User Details -->
                <div class="grid grid-cols-1 gap-x-6 gap-y-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                            Name
                        </label>
                        <p class="text-gray-900 dark:text-gray-200">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                            Phone Number
                        </label>
                        <p class="text-gray-900 dark:text-gray-200">{{ $user->phone }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                            Email
                        </label>
                        <p class="text-gray-900 dark:text-gray-200">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                            Address
                        </label>
                        <p class="text-gray-900 dark:text-gray-200">{{ $user->address }}</p>
                    </div>
                    <!-- Department and Desk Section -->
                    @if (!empty($user->department))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                                Department
                            </label>
                            <p class="text-gray-900 dark:text-gray-200">
                                {{ $user->department->name ?? 'N/A' }}
                            </p>
                        </div>
                    @endif

                    @if (!empty($user->desk))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                                Desk
                            </label>
                            <p class="text-gray-900 dark:text-gray-200">
                                {{ $user->desk->name ?? 'N/A' }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Separator -->
                <div class="border-t border-gray-200 dark:border-gray-700 my-8"></div>

                <!-- Roles Section -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                        Assigned Roles
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @forelse ($user->roles as $role)
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                {{ $role->name }}
                            </span>
                        @empty
                            <p class="text-gray-500 text-sm">No roles assigned.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/from-plugins.js'])
    @endpush
</x-app-layout>
