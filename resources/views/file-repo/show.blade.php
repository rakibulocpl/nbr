<x-app-layout>
    <div class="mx-auto max-w-screen-lg px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-5xl mx-auto">

            {{-- Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            File Repository — Details
                        </h2>

                        {{-- Status Label --}}
                        @if($file->statusInfo)
                            @php
                                $statusColors = [
                                    'Initiated' => 'bg-yellow-100 text-yellow-700',
                                    'Desk Assigned' => 'bg-blue-100 text-blue-700',
                                    'Accepted' => 'bg-green-100 text-green-700',
                                    'Rejected' => 'bg-red-100 text-red-700',
                                    'Archived' => 'bg-gray-200 text-gray-700',
                                ];
                                $statusColor = $statusColors[$file->statusInfo->name] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="text-xs font-medium px-3 py-1 rounded-full {{ $statusColor }}">
                                {{ $file->statusInfo->name }}
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('fileRepo.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </a>
                </div>

                {{-- Update File Status --}}
                @if($file->status == 2)
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-t-2xl">
                        <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Update File Status
                        </h3>

                        <form id="updateStatusForm" method="POST" action="{{ route('fileRepo.updateStatus', $file->id) }}"
                              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @csrf
                            <input type="hidden" name="file_id" value="{{ $file->id }}">

                            <div>
                                <label for="status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Select Status
                                </label>
                                <select id="status_id" name="status_id"
                                        class="required w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400">
                                    <option value="">-- Select Status --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" @selected($file->status == $status->id)>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Remarks
                                </label>
                                <textarea id="remarks" name="remarks" rows="2"
                                          placeholder="Add remarks about the status update..."
                                          class="required w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Assign Desk --}}
                @if($file->status == 1)
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-t-2xl">
                        <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Assign Desk
                        </h3>

                        <form id="assignDeskForm" method="POST" action="{{ route('fileRepo.assignDesk', $file->id) }}"
                              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @csrf
                            <input type="hidden" name="file_id" value="{{ $file->id }}">

                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Name of the Department/Office/Organization
                                </label>
                                <select id="department" name="department_id"
                                        class="required w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400">
                                    <option value="">-- Select Department --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="desk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Desk / Officer
                                </label>
                                <select id="desk" name="desk_id"
                                        class="required w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400">
                                    <option value="">-- Select Desk --</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Content --}}
                <div class="p-6 space-y-6">

                    {{-- File Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Title</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">{{ $file->title }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">File Name</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">{{ $file->file_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">File Type</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">{{ strtoupper($file->file_type) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Page Count</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">{{ $file->page_count ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Date</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">
                                {{ $file->relevant_date ? \Carbon\Carbon::parse($file->relevant_date)->format('d M Y') : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Uploaded By</p>
                            <p class="text-base font-medium text-gray-800 dark:text-white">
                                {{ optional($file->uploader)->name ?? 'System' }}
                            </p>
                        </div>

                        {{-- Tags --}}
                        @if(!empty($file->tags))
                            <div class="col-span-full">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tags</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $file->tags) as $tag)
                                        @php $tag = trim($tag); @endphp
                                        <a href="{{ route('fileRepo.index', ['tag' => $tag]) }}"
                                           class="inline-flex items-center px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-400 transition">
                                            #{{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 🔹 Communication Details --}}
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Communication Details</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Sender --}}
                            @if($file->sender_department || $file->sender_department_custom_name)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Sender Information</p>
                                    <p class="text-base font-medium text-gray-800 dark:text-white">
                                        {{ $file->sender_department->name ?? $file->sender_department_custom_name }}
                                    </p>
                                    @if($file->sender_designation || $file->sender_name)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $file->sender_designation ? $file->sender_designation.', ' : '' }}
                                            {{ $file->sender_name }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                            {{-- Receiver --}}
                            @if($file->receiver_department || $file->receiver_department_custom_name)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Receiver Information</p>
                                    <p class="text-base font-medium text-gray-800 dark:text-white">
                                        {{ $file->receiver_department->name ?? $file->receiver_department_custom_name }}
                                    </p>
                                    @if($file->receiver_designation || $file->receiver_name)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $file->receiver_designation ? $file->receiver_designation.', ' : '' }}
                                            {{ $file->receiver_name }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                            {{-- Onulipi / CC Departments --}}
                            @if($file->onulipis && $file->onulipis->count())
                                <div class="col-span-full">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Onulipi (CC) Departments</p>
                                    <ul class="list-disc list-inside space-y-1 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($file->onulipis as $onu)
                                            <li>{{ $onu->display_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PDF Preview --}}
                    <div class="pt-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">PDF Preview</p>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <iframe
                                src="{{ asset('storage/' . $file->file_path) }}"
                                class="w-full h-[600px]"
                                frameborder="0">
                            </iframe>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                        <p>Created at: {{ $file->created_at->format('d M Y, h:i A') }}</p>
                        <p>Last updated: {{ $file->updated_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/from-plugins.js'])
        <script>
            $(document).ready(function () {
                // Load desks dynamically
                $('#department').on('change', function () {
                    const departmentId = $(this).val();
                    const $desk = $('#desk');
                    $desk.html('<option value="">Loading...</option>');

                    if (!departmentId) {
                        $desk.html('<option value="">-- Select Desk --</option>');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('departments.desks') }}",
                        type: "GET",
                        data: { department_id: departmentId },
                        success: function (response) {
                            $desk.empty().append('<option value="">-- Select Desk --</option>');
                            if (response.data && response.data.length) {
                                response.data.forEach(desk => {
                                    $desk.append(`<option value="${desk.id}">${desk.name}</option>`);
                                });
                            } else {
                                $desk.append('<option value="">No desks available</option>');
                            }
                        },
                        error: function () {
                            $desk.html('<option value="">Error loading desks</option>');
                        }
                    });
                });

                // Disable error text display for both forms
                $("#assignDeskForm, #updateStatusForm").validate({
                    errorPlacement: function () { return false; }
                });
            });
        </script>
    @endpush
</x-app-layout>
