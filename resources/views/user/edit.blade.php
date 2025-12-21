<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <div
            class=" px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
            <div class="mx-auto w-full max-w-[630px] text-center">

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Update User
                        </h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 dark:border-gray-800">
                        <form class="jquery_form_validation" method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') {{-- or PATCH --}}
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 text-left">

                                {{-- Name --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Name
                                    </label>
                                    <input type="text" name="name" value="{{$user->name}}" placeholder="e.g. Jon Doe" class="dark:bg-dark-900 shadow-theme-xs required focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>





                                {{-- Email --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Email
                                    </label>
                                    <input type="email" name="email" value="{{$user->email}}"  placeholder="e.g. jon@example.com" class="dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" value="{{$user->phone}}"  placeholder="01XXXXXXXXX" class="dark:bg-dark-900 bd_mobile required shadow-theme-xs required focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>




                                {{-- Address --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Address
                                    </label>
                                    <textarea name="address" rows="3"  placeholder="Full address" class="dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{$user->address}}</textarea>
                                </div>

                                {{-- Roles --}}
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Roles
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach ($roles as $role)
                                            <label
                                                class="inline-flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                       class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 required"
                                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                >
                                                <span>{{ $role->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="pt-4 text-right">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:bg-brand-500 dark:hover:bg-brand-400">
                                        Update
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
