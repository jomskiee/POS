@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['title' => 'Sales & Transactions']
    ];
@endphp

@section('content')
<div class="w-full" x-data="salesManagement()" x-init="activeTab = 'analysis'">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Sales & Analytics</h1>
                            <p class="text-gray-600 mt-2">Transaction management, payment processing, returns handling, and comprehensive sales analytics</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button @click="openReceiptModal()"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                <span>Preview Receipt</span>
                            </button>
                            <button @click="openReturnModal()"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                <span>Process Return</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'analysis'"
                                    :class="activeTab === 'analysis' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>Sales Analysis</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'transactions'"
                                    :class="activeTab === 'transactions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    <span>Transaction History</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'transaction-items'"
                                    :class="activeTab === 'transaction-items' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    <span>Transaction List Items</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'payments'"
                                    :class="activeTab === 'payments' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span>Payment Methods</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'returns'"
                                    :class="activeTab === 'returns' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    <span>Returns & Refunds</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Sales Analysis Tab -->
                <div x-show="activeTab === 'analysis'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.sales.analysis')
                </div>

                <!-- Transaction History Tab -->
                <div x-show="activeTab === 'transactions'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.sales.transactions')
                </div>

                <!-- Transaction List Items Tab -->
                <div x-show="activeTab === 'transaction-items'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.sales.transaction-items')
                </div>

                <!-- Payment Methods Tab -->
                <div x-show="activeTab === 'payments'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.sales.payments')
                </div>

                <!-- Returns & Refunds Tab -->
                <div x-show="activeTab === 'returns'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.sales.returns')
                </div>
            </div>

            <!-- Receipt Preview Modal -->
            <div x-show="showReceiptModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeReceiptModal()">
                <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Receipt Preview</h3>
                        <button @click="closeReceiptModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4 font-mono text-sm">
                        <div class="text-center mb-4">
                            <h4 class="font-bold">POS SYSTEM</h4>
                            <p class="text-xs">123 Business Street</p>
                            <p class="text-xs">City, State 12345</p>
                            <p class="text-xs">Phone: (555) 123-4567</p>
                        </div>

                        <div class="border-t border-b border-gray-300 py-2 mb-2">
                            <div class="flex justify-between">
                                <span>Receipt #:</span>
                                <span>R-2024-001</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Date:</span>
                                <span x-text="new Date().toLocaleDateString()"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Time:</span>
                                <span x-text="new Date().toLocaleTimeString()"></span>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="flex justify-between">
                                <span>Coffee</span>
                                <span>$4.50</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pastry</span>
                                <span>$2.25</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-300 pt-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>$6.75</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax (8%):</span>
                                <span>$0.54</span>
                            </div>
                            <div class="flex justify-between font-bold">
                                <span>Total:</span>
                                <span>$7.29</span>
                            </div>
                        </div>

                        <div class="text-center mt-4 text-xs">
                            <p>Thank you for your business!</p>
                            <p>Visit us again soon</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 mt-4">
                        <button @click="closeReceiptModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Close
                        </button>
                        <button @click="printReceipt()"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                            Print Receipt
                        </button>
                    </div>
                </div>
            </div>

            <!-- Return/Refund Modal -->
            <div x-show="showReturnModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeReturnModal()">
                <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Process Return/Refund</h3>
                        <button @click="closeReturnModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="processReturn()">
                        <div class="space-y-4">
                            <div>
                                <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                                <input type="text"
                                       id="transaction_id"
                                       x-model="returnForm.transaction_id"
                                       required
                                       placeholder="Enter transaction ID"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="return_reason" class="block text-sm font-medium text-gray-700 mb-1">Return Reason</label>
                                <select id="return_reason"
                                        x-model="returnForm.reason"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select reason</option>
                                    <option value="defective">Defective Product</option>
                                    <option value="wrong_item">Wrong Item</option>
                                    <option value="customer_change">Customer Changed Mind</option>
                                    <option value="damaged">Damaged in Transit</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label for="refund_amount" class="block text-sm font-medium text-gray-700 mb-1">Refund Amount</label>
                                <input type="number"
                                       id="refund_amount"
                                       x-model="returnForm.amount"
                                       step="0.01"
                                       min="0"
                                       required
                                       placeholder="0.00"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="return_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea id="return_notes"
                                          x-model="returnForm.notes"
                                          rows="3"
                                          placeholder="Additional notes..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button"
                                    @click="closeReturnModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    :disabled="returnForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!returnForm.loading">Process Return</span>
                                <span x-show="returnForm.loading">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

<script>
function salesManagement() {
    return {
        // State
        activeTab: 'transactions',
        showReceiptModal: false,
        showReturnModal: false,

        // Form data
        returnForm: {
            transaction_id: '',
            reason: '',
            amount: '',
            notes: '',
            loading: false
        },

        // Methods
        openReceiptModal() {
            this.showReceiptModal = true;
        },

        closeReceiptModal() {
            this.showReceiptModal = false;
        },

        openReturnModal() {
            this.showReturnModal = true;
            this.resetReturnForm();
        },

        closeReturnModal() {
            this.showReturnModal = false;
            this.resetReturnForm();
        },

        resetReturnForm() {
            this.returnForm = {
                transaction_id: '',
                reason: '',
                amount: '',
                notes: '',
                loading: false
            };
        },

        printReceipt() {
            // Simulate printing
            alert('Receipt sent to printer!');
            this.closeReceiptModal();
        },

        processReturn() {
            if (!this.returnForm.transaction_id || !this.returnForm.reason || !this.returnForm.amount) {
                alert('Please fill in all required fields');
                return;
            }

            this.returnForm.loading = true;

            // Simulate API call
            setTimeout(() => {
                alert('Return processed successfully!');
                this.closeReturnModal();
            }, 2000);
        }
    }
}
</script>
@endsection
