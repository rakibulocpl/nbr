<x-app-layout>
    <div class="mx-auto max-w-screen-lg px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white"> File Upload</h2>
                <a href="{{ route('fileRepo.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('fileRepo.store') }}" enctype="multipart/form-data"
                  class="p-6 space-y-8 jquery_form_validation">
                @csrf

                {{-- Sarok No & Date --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block required-star text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Reference No.
                        </label>
                        <input type="text" name="sarok_no" placeholder="Enter Sarok No."
                               class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                    </div>

                    <div x-data>
                        <label class="block text-sm required-star font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Date
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                name="relevant_date"
                                max="{{ now()->toDateString() }}"
                                onclick="this.showPicker()"
                                class="required w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow focus:border-brand-300 focus:ring-2 focus:ring-brand-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                            />
                        </div>
                    </div>


                </div>

                {{-- Urgency --}}
                <div>
                    <label class="block required-star text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Urgency</label>
                    <select name="urgency"
                            class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        <option value="">Select urgency level</option>
                        <option value="Normal">Normal</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Very Urgent">Very Urgent</option>
                        <option value="Confidential">Confidential</option>
                    </select>
                </div>
                {{-- File Title --}}
                <div>
                    <label class="block required-star text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">File
                        Title</label>
                    <input type="text" name="title" placeholder="Enter file title"
                           class="required h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                </div>

                {{-- Sender Group --}}
                <div x-data="{ senderIct: false }"
                     class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Sender Information</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- Department --}}
                        <div>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="senderIct" x-model="senderIct"
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="senderIct" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    ICT Ministry
                                </label>
                            </div>

                            <div x-show="senderIct" x-transition >
                                <select name="sender_department_select" x-bind:disabled="!senderIct"
                                        class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="!senderIct"   x-transition>
                                <input type="text" x-bind:disabled="senderIct" name="sender_department_input"
                                       placeholder="Enter Department"
                                       class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                            </div>
                        </div>

                        {{-- Designation --}}
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1.5">Designation</label>
                            <input type="text" name="sender_designation" placeholder="Enter designation"
                                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1.5">Name</label>
                            <input type="text" name="sender_name" placeholder="Enter sender name"
                                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                        </div>
                    </div>
                </div>

                {{-- Receiver Group --}}
                <div x-data="{ receiverIct: false }"
                     class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Receiver Information</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- Department --}}
                        <div>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="receiverIct" x-model="receiverIct"
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="receiverIct" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    ICT Ministry
                                </label>
                            </div>

                            <div x-show="receiverIct" x-transition >
                                <select name="receiver_department_select" x-bind:disabled="!receiverIct"
                                        class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="!receiverIct" x-transition >
                                <input type="text" name="receiver_department_input"
                                       placeholder="Enter Department" x-bind:disabled="receiverIct"
                                       class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                            </div>
                        </div>

                        {{-- Designation --}}
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1.5">Designation</label>
                            <input type="text" name="receiver_designation" placeholder="Enter designation"
                                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1.5">Name</label>
                            <input type="text" name="receiver_name" placeholder="Enter receiver name"
                                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                        </div>
                    </div>
                </div>

                {{-- Onulipi Group --}}
                <div x-data="{ onulipiList: [{ isIct: false }] }"
                     class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">CC Departments</h3>

                    <template x-for="(onulipi, index) in onulipiList" :key="index">
                        <div
                            class="mb-4 p-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-900">

                            <div class="flex flex-col sm:flex-row gap-4 items-center">
                                {{-- Checkbox --}}
                                <div class="flex items-center">
                                    <input type="checkbox" :id="'onulipiIct'+index" x-model="onulipi.isIct"
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label :for="'onulipiIct'+index"
                                           class="ml-2 text-sm text-gray-700 dark:text-gray-300">ICT Ministry</label>
                                </div>

                                {{-- ICT Select --}}
                                <div class="flex-1" x-show="onulipi.isIct" x-transition>
                                    <select :name="'onulipi_department_select['+index+']'" x-bind:disabled="!onulipi.isIct"
                                            class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Manual Input --}}
                                <div class="flex-1" x-show="!onulipi.isIct" x-transition>
                                    <input type="text" x-bind:disabled="onulipi.isIct" :name="'onulipi_department_input['+index+']'"
                                           placeholder="Enter Department"
                                           class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"/>
                                </div>

                                {{-- Remove Button --}}
                                <button type="button" @click="onulipiList.splice(index, 1)"
                                        x-show="onulipiList.length > 1"
                                        class="text-red-500 hover:text-red-700 text-sm">Remove
                                </button>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="onulipiList.push({ isIct: false })"
                            class="text-sm text-blue-600 hover:text-blue-800 mt-1 inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Onulipi
                    </button>
                </div>


                {{-- File Upload --}}
                <div>
                    <label class="block text-sm font-medium required-star text-gray-700 dark:text-gray-300 mb-1.5">Upload
                        PDF File</label>
                    <input type="file" accept="application/pdf" name="file"
                           class="required w-full text-sm border border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-lg px-3 py-2 cursor-pointer focus:border-blue-500 focus:ring-blue-100 outline-none transition"/>
                </div>

                {{-- Submit --}}
                <div class="pt-4 flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-sm font-medium text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save to Archive
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/from-plugins.js'])
    @endpush
</x-app-layout>
