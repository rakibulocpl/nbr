<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <div
            class=" px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
            <div class="mx-auto w-full max-w-[630px] text-center">


                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Create New Role
                        </h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 dark:border-gray-800">
                        <form method="POST" class="jquery_form_validation" action="{{ route('role.store') }}">
                            @csrf
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 text-left">
                                {{-- Role Name --}}
                                <div>
                                    <label class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Role Name
                                    </label>
                                    <input type="text" name="name" placeholder="e.g. Admin"
                                           class="required dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                                {{-- Permissions --}}
                                <div>
                                    <label class="required-star mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Assign Permissions
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach ($permissions as $permission)
                                            <label
                                                class="inline-flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                       class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500">
                                                <span>{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="pt-4 text-right">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:bg-brand-500 dark:hover:bg-brand-400">
                                        Create Role
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @push('scripts')
        @vite(['resources/js/from-plugins.js'])

    @endpush

</x-app-layout>
