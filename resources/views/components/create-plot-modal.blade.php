<!-- BEGIN MODAL -->
<div x-show="createPlotModal"
     class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-99999">


    <div
        class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
    ></div>

    <!-- Modal Content -->
    <div @click.outside="$refs.createPlotForm.reset(); createPlotModal = false"
         class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-lg dark:bg-gray-900">

        <!-- Close Button -->
        <button type="button"
                @click="$refs.createPlotForm.reset(); createPlotModal = false"
                class="absolute right-4 top-4 text-gray-500 hover:text-gray-700 dark:text-gray-400">
            ✕
        </button>

        <!-- Header -->
        <h4 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-white">
            Sales cancellation and Return Payment Entry
        </h4>

        <!-- Form -->
        <form x-ref="createPlotForm"
              method="POST"
              action="{{ route('land.createPlot', [$land->id]) }}"
              id="createPlotForm"
              class="flex flex-col gap-4">
            @csrf
            @method('PATCH')

            <!-- Note -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Note
                </label>
                <textarea name="note" rows="2"
                          class="mt-1 w-full rounded-lg border-gray-300 px-4 py-2 text-sm dark:bg-gray-800 dark:text-white"
                          placeholder="Enter a note..."></textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                        @click="$refs.createPlotForm.reset(); createPlotModal = false"
                        class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Close
                </button>
                <button type="submit"
                        class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                    Cancel Sale
                </button>
            </div>
        </form>
    </div>
</div>
<!-- END MODAL -->
