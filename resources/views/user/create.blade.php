<x-app-layout>
    <div class="mx-auto max-w-screen-2xl">
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
                            Create New User
                        </h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 dark:border-gray-800">
                        <form class="jquery_form_validation" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-3 border-t border-gray-100 p-4 sm:p-3 dark:border-gray-800 text-left">

                                {{-- Name --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Name
                                    </label>
                                    <input type="text" name="name" placeholder="e.g. Jon Doe" class="dark:bg-dark-900 shadow-theme-xs required focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>


                                {{-- Email --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Email
                                    </label>
                                    <input type="email" name="email" placeholder="e.g. jon@example.com" class="dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" placeholder="01XXXXXXXXX" class="dark:bg-dark-900 bd_mobile required shadow-theme-xs required focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>




                                {{-- Role --}}
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Role
                                    </label>
                                    <select name="roles[]" id="role"
                                            class="required h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white required">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{-- Department --}}
                                <div id="department_section" class="hidden">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Department
                                    </label>
                                    <select name="department_id" id="department_id"
                                            class="required h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white">
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Desk --}}
                                <div id="desk_section" class="hidden">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Desk
                                    </label>
                                    <select name="desk_id" id="desk_id"
                                            class="required h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white">
                                        <option value="">Select Desk</option>
                                    </select>
                                </div>
                                {{-- Password --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Password
                                    </label>
                                    <input type="password" id="password" name="password"
                                           placeholder="Enter password"
                                           class="required h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800
                  focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                           autocomplete="new-password" />

                                    <div id="password-strength" class="mt-1 text-xs font-medium"></div>
                                </div>

                                {{-- Confirm Password --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                                        Confirm Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           placeholder="Confirm password"
                                           class="required h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800
                  focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                           autocomplete="new-password" />

                                    <div id="password-match" class="mt-1 text-xs font-medium"></div>
                                </div>



                                {{-- Submit --}}
                                <div class="pt-4">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                                        <!-- Left Side -->
                                        <a href="{{ route('user.index') }}"
                                           class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600">
                                            Back to List
                                        </a>

                                        <!-- Right Side -->
                                        <button type="submit"
                                                class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white w-full sm:w-auto">
                                            Create Account
                                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
                                                      fill=""></path>
                                            </svg>
                                        </button>
                                    </div>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Show/hide department section based on role
                $('#role').on('change', function () {
                    const selectedRole = $(this).val();
                    // Example: show department only if role is Department Admin or Manager
                    if (selectedRole === 'Desk Officer' || selectedRole === 'Department Chief') {
                        $('#department_section').removeClass('hidden');
                        $('#department_section').trigger('change')
                    } else {
                        $('#department_section').addClass('hidden');
                        $('#desk_section').addClass('hidden');
                    }
                });

                // Load desks dynamically when department changes
                $('#department_id').on('change', function () {
                    const departmentId = $(this).val();
                    if (!departmentId) {
                        $('#desk_section').addClass('hidden');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('departments.desks') }}",
                        type: "GET",
                        data: {department_id: departmentId},
                        success: function (res) {
                            let deskSelect = $('#desk_id');
                            deskSelect.empty().append('<option value="">Select Desk</option>');
                            console.log(res);
                            res.data.forEach(desk => {
                                deskSelect.append(`<option value="${desk.id}">${desk.name}</option>`);
                            });
                            $('#desk_section').removeClass('hidden');
                        },
                        error: function () {
                            alert('Failed to load desks');
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {

                // Password strength indicator
                $('#password').on('input', function () {
                    const password = $(this).val();
                    const strengthEl = $('#password-strength');

                    let strength = 0;
                    if (password.length >= 8) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[a-z]/.test(password)) strength++;
                    if (/[0-9]/.test(password)) strength++;
                    if (/[^A-Za-z0-9]/.test(password)) strength++;

                    let text = '';
                    let color = '';

                    switch (strength) {
                        case 0:
                        case 1:
                            text = 'Very Weak';
                            color = 'text-red-600';
                            break;
                        case 2:
                            text = 'Weak';
                            color = 'text-orange-500';
                            break;
                        case 3:
                            text = 'Good';
                            color = 'text-yellow-500';
                            break;
                        case 4:
                            text = 'Strong';
                            color = 'text-green-600';
                            break;
                        case 5:
                            text = 'Very Strong';
                            color = 'text-emerald-600';
                            break;
                    }

                    strengthEl.removeClass().addClass(`mt-1 text-xs font-medium ${color}`).text(`Password Strength: ${text}`);
                });

                // Password match check
                $('#password, #password_confirmation').on('input', function () {
                    const password = $('#password').val();
                    const confirmPassword = $('#password_confirmation').val();
                    const matchEl = $('#password-match');

                    if (confirmPassword.length > 0) {
                        if (password === confirmPassword) {
                            matchEl.text('Passwords match ✅').removeClass().addClass('mt-1 text-xs font-medium text-green-600');
                        } else {
                            matchEl.text('Passwords do not match ❌').removeClass().addClass('mt-1 text-xs font-medium text-red-600');
                        }
                    } else {
                        matchEl.text('');
                    }
                });
            });
        </script>


    @endpush

</x-app-layout>
