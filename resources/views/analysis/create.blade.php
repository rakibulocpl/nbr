<x-app-layout>
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-4xl mx-auto">

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">New Analysis Request</h2>
                    <a href="{{ route('analysis.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </a>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('analysis.store') }}" enctype="multipart/form-data" id="analysisRequestForm" class="p-2 sm:p-4 md:p-6 space-y-6">
                    @csrf

                    {{-- 🔹 Applicant Information --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">
                            Taxpayers Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Business / Name of Taxpayers <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="taxpayer_name" placeholder="e.g. ABC Traders Ltd."
                                       class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    TIN No <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tin_no" placeholder="e.g. 1234567890"
                                       class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                            </div>

                        </div>
                    </div>

                    {{-- 🔹 Project Applied For --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">
                            File Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    File ID :<span class="text-red-500">*</span>
                                </label>
                                <select name="project_id"
                                        class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition">
                                    <option value="">-- Select File --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- 🔹 Bank Statements --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">
                            Bank Statements
                        </h3>
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Upload Bank Statements <span class="text-red-500">*</span>
                            </label>
                            <button type="button" id="add-row"
                                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-2 rounded-lg text-sm transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Another File
                            </button>
                        </div>

                        <div id="file-section" class="space-y-4"></div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 flex items-center justify-center gap-2 rounded-lg px-5 py-3 text-sm font-medium text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/from-plugins.js'])
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addRowBtn = document.getElementById('add-row');
                const section = document.getElementById('file-section');
                let rowIndex = 0;

                function addRow() {
                    const index = rowIndex++;
                    const newRow = document.createElement('div');
                    newRow.classList.add(
                        'flex', 'flex-col', 'sm:flex-row', 'items-center',
                        'gap-3', 'border', 'border-gray-200', 'dark:border-gray-700',
                        'rounded-xl', 'p-4', 'bg-gray-50', 'dark:bg-gray-800', 'file-row'
                    );

                    newRow.innerHTML = `
                        <select name="banks[${index}]" class="required w-full sm:w-1/2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg text-sm px-3 py-2 focus:border-blue-400 focus:ring-blue-100 outline-none transition">
                            <option value="">-- Select Bank --</option>
                            @foreach ($banks as $key => $bank)
                    <option value="{{ $key }}">{{ $bank }}</option>
                            @endforeach
                    </select>

                    <input type="file" accept="application/pdf" name="files[${index}]" class="required w-full sm:w-1/2 text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg px-3 py-2 cursor-pointer focus:border-blue-400 focus:ring-blue-100 outline-none transition"/>

                        <button type="button" class="remove-row sm:inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition">
                            Remove
                        </button>
                    `;

                    section.appendChild(newRow);
                }

                addRowBtn.addEventListener('click', addRow);
                addRow(); // initial row

                section.addEventListener('click', function (e) {
                    if (e.target.closest('.remove-row')) {
                        e.target.closest('.file-row').remove();
                    }
                });
            });

            $(document).ready(function () {
                $("#analysisRequestForm").validate({
                    errorPlacement: function (error, element) {
                        return false;
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>

