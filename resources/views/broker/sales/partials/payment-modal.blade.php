{{-- Add Payment Modal --}}
@if(request('modal') === 'payment')
    @if($saleForPayment)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center lg:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg md:w-full">
                    {{-- Modal Header --}}
                    <div class="bg-white px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Add Payment</h3>
                            <a href="{{ route('broker.sales.sales') }}"
                               class="text-gray-400 hover:text-gray-600 transition-colors">
                                <x-heroicon-o-x-mark class="w-6 h-6" />
                            </a>
                        </div>
                    </div>

                    {{-- Modal Body --}}
                    <div class="bg-white px-6 py-6">
                        {{-- Balance Summary --}}
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Summary</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Bill:</span>
                                    <span class="text-sm font-bold text-gray-900">₱{{ number_format($saleForPayment->total_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">To Pay Total:</span>
                                    <span class="text-sm font-bold text-green-600">₱{{ number_format($saleForPayment->paid_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center border-t pt-2">
                                    <span class="text-sm text-gray-600">Running Balance:</span>
                                    <span class="text-sm font-bold text-orange-600">₱{{ number_format($saleForPayment->remaining_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('broker.sales-payments.store') }}" method="POST" class="space-y-6" x-data="paymentForm()" x-init="initializePaymentForm()">
                            @csrf

                            <input type="hidden" name="sales_id" value="{{ request('sale') }}">

                            <div>
                                <label for="paid_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Paid Amount <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="paid_amount" name="paid_amount" required
                                       step="0.01" min="0.01" :max="maxPaymentAmount"
                                       x-model="paidAmount"
                                       @input="validatePaymentAmount()"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="0.00">
                                <div class="mt-1 text-xs text-gray-500">
                                    Maximum payment: ₱<span x-text="maxPaymentAmount.toFixed(2)"></span>
                                </div>
                                <div x-show="paymentError" class="mt-1 text-sm text-red-600" x-text="paymentError"></div>
                                @error('paid_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="payment_date" name="payment_date" required
                                       value="{{ old('payment_date', date('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('payment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select id="payment_method" name="payment_method" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="GCash" {{ old('payment_method') == 'GCash' ? 'selected' : '' }}>GCash</option>
                                    <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>
                                    <option value="Other" {{ old('payment_method') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Modal Footer --}}
                            <div class="flex justify-end space-x-3 pt-4">
                                <a href="{{ route('broker.sales.sales') }}"
                                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Cancel
                                </a>
                                <button type="submit" :disabled="paymentError || paidAmount <= 0"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                    Add Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Sale not found for payment --}}
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center lg:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg md:w-full">
                    <div class="bg-white px-6 py-6">
                        <div class="text-center">
                            <div class="bg-red-100 p-4 rounded-full w-16 h-16 mx-auto mb-4">
                                <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-red-600" />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Sale Not Found</h3>
                            <p class="text-gray-500 mb-6">The sale you're trying to add payment for could not be found or you don't have permission to access it.</p>
                            <a href="{{ route('broker.sales.sales') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                                Back to Sales
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

