<!-- BEGIN MODAL -->
<div
    x-show="purchasePaymentModal"
    x-data="{
        purchase_amount: '',
        paymentType: '',
        purchaseBalanceError:'',
        totalBuyingPrice: {{ $landPurchaseInfo->buying_price }},
        paidAmount: {{ $landPurchaseInfo->paid_amount }},
        get remainingAmount() {
            return this.totalBuyingPrice - this.paidAmount;
        },
        get newRemaining() {
            if(this.paymentType === 'pay_to_seller') {
                return this.remainingAmount - this.purchase_amount;
            } else {
                return '';
            }
        },
        checkAmount() {
            if(this.newRemaining < 0 && this.paymentType === 'pay_to_seller' ) {
             this.purchaseBalanceError = 'Entered amount exceeds remaining balance!';
             this.purchase_amount = '';
            }else{
             this.purchaseBalanceError = ''
            }
        }
     }"
    class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-99999"
>
    <div
        class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
    ></div>
    <div
        @click.outside="$refs.purchasePaymentForm.reset();purchasePaymentModal = false"
        class="no-scrollbar relative flex w-full max-w-[700px] flex-col overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-11"
    >
        <!-- close btn -->
        <button
            @click="$refs.purchasePaymentForm.reset();purchasePaymentModal = false"
            class="transition-color absolute right-5 top-5 z-999 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300"
        >
            <svg
                class="fill-current"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"
                    fill=""
                />
            </svg>
        </button>

        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Purchase Payment Entry
            </h4>

        </div>
        <form   x-ref="purchasePaymentForm" class="flex flex-col jquery_form_validation" id="purchasePaymentForm" method="post" action="{{route('land-purchase.payment',[$landPurchaseInfo->id]) }}">
            @csrf
            <div class="px-2 overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                    <div>
                        <label
                            class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                        >
                            Payment Date
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                name="payment_date"
                                placeholder="Select date"
                                max="{{ now()->toDateString() }}"
                                class="required dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                onclick="this.showPicker()"
                            />
                            <span
                                class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400"
                            >
                          <svg
                              class="fill-current"
                              width="20"
                              height="20"
                              viewBox="0 0 20 20"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                                fill=""
                            />
                          </svg>
                        </span>
                        </div>
                    </div>

                    <div>
                        <label
                            class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                        >
                            Payment Method
                        </label>
                        <select
                            class="required dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true"
                            name="payment_method"
                        >
                            <option
                                value=""
                                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                            >
                                Select Option
                            </option>
                            @foreach($paymentMethods as $method)
                                <option
                                    value="{{ $method->value }}"
                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                >
                                    {{ $method->label() }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label
                            class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                        >
                            Payment Type
                        </label>
                        <select class="required dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300
                            focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300
                            bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                            dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true"
                                x-model="paymentType"
                                name="payment_type">

                            <option value=""  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                Select Option
                            </option>
                            <option value="pay_to_seller"  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                Pay To Seller
                            </option>
                            <option value="other_cost"  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                Others Cost
                            </option>


                        </select>
                    </div>

                    <div>
                        <label
                            class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                        >
                            Given By
                        </label>
                        <select
                            class="required dark:bg-dark-900 required shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true"
                            name="collected_by"
                        >
                            <option
                                value=""
                                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                            >
                                Select Option
                            </option>
                            @foreach($collectedBy as $collected)
                                <option
                                    value="{{ $collected->id }}"
                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                >
                                    {{ $collected->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="required-star mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                        >
                            Amount (BDT) <span class="ml-2 rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-800 dark:text-green-200">
                                    Balance: {{$balance}}
                                </span>
                        </label>
                        <input
                            type="text"
                            name="amount"
                            x-model.number="purchase_amount"
                            @input="checkAmount()"
                            class="required dark:bg-dark-900 h-11 number w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                        />
                        <p x-show="purchaseBalanceError" class="mt-1 text-sm text-red-600" x-text="purchaseBalanceError"></p>
                    </div>
                    <div x-show="paymentType === 'pay_to_seller' && newRemaining > 0">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 required-star"
                        >
                            Next Commitment Date
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                name="next_commitment_date"
                                placeholder="Select date"
                                min="<?php echo e(now()->toDateString()); ?>"
                                class="required dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                onclick="this.showPicker()"
                            />
                            <span
                                class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400"
                            >
                          <svg
                              class="fill-current"
                              width="20"
                              height="20"
                              viewBox="0 0 20 20"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                                fill=""
                            />
                          </svg>
                        </span>
                        </div>

                    </div>
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                            :class="paymentType === 'other_cost' ? 'required-star' : ''"
                        >
                            Note
                        </label>
                        <textarea
                            placeholder="Enter a description..."
                            type="text"
                            name="note"
                            rows="2"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="paymentType === 'other_cost' ? 'required' : ''"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div
                class="mt-6 px-2 py-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300 flex justify-between flex-wrap gap-2">

                <div>
                    <strong>Buying Price:</strong> <span x-text="totalBuyingPrice.toLocaleString()"></span> BDT
                </div>
                <div>
                    <strong>Paid:</strong> <span x-text="paidAmount.toLocaleString()"></span> BDT
                </div>
                <div>
                    <strong>Remaining:</strong> <span x-text="remainingAmount.toLocaleString()"></span> BDT
                </div>
                <div x-show="purchase_amount > 0 && paymentType === 'pay_to_seller'">
                    <strong>New Remaining:</strong> <span x-text="newRemaining.toLocaleString()"></span> BDT
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6 lg:justify-end">
                <button
                    @click="$refs.purchasePaymentForm.reset();purchasePaymentModal = false"
                    type="button"
                    class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto"
                >
                    Close
                </button>
                <button
                    type="submit"
                    class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<!-- END MODAL -->
