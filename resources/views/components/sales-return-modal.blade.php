<!-- BEGIN MODAL -->
<div x-show="salesReturnModal"
     class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-99999">


    <div
        class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
    ></div>

    <!-- Modal Content -->
    <div @click.outside="$refs.salesReturnForm.reset(); salesReturnModal = false"
         class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-lg dark:bg-gray-900">

        <!-- Close Button -->
        <button type="button"
                @click="$refs.salesReturnForm.reset(); salesReturnModal = false"
                class="absolute right-4 top-4 text-gray-500 hover:text-gray-700 dark:text-gray-400">
            ✕
        </button>

        <!-- Header -->
        <h4 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-white">
            Sales cancellation and Return Payment Entry
        </h4>

        <!-- Form -->
        <form x-ref="salesReturnForm"
              method="POST"
              action="{{ route('land-sale.cancel', [$landSale->id]) }}"
              id="salesReturnForm"
              class="flex flex-col gap-4">
            @csrf
            @method('PATCH')

            <!-- Payment Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                    Payment Date
                </label>
                <input
                    type="date"
                    name="payment_date"
                    max="{{ now()->toDateString() }}"
                    placeholder="Select date"
                    class="required dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    onclick="this.showPicker()"
                />
            </div>

            <!-- Payment Method -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                    Payment Method
                </label>
                <select name="payment_method" required
                        class="mt-1 w-full rounded-lg border-gray-300 px-4 py-2 text-sm dark:bg-gray-800 dark:text-white">
                    <option value="">Select Option</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->value }}">{{ $method->label() }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Given By -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 required-star">
                    Given By
                </label>
                <select name="collected_by" required
                        class="mt-1 w-full rounded-lg border-gray-300 px-4 py-2 text-sm dark:bg-gray-800 dark:text-white">
                    <option value="">Select Option</option>
                    @foreach($collectedBy as $collected)
                        <option value="{{ $collected->id }}">{{ $collected->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Amount (Read-Only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Amount (BDT)
                </label>
                <div class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm dark:bg-gray-800 dark:text-white">
                    {{ $landSale->collected_amount ?? 0 }}
                </div>
            </div>

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
                        @click="$refs.salesReturnForm.reset(); salesReturnModal = false"
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
