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
                                    <span>Sales History</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'transaction-items'"
                                    :class="activeTab === 'transaction-items' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    <span>Sales List Items</span>
                                </div>
                            </button>

                            <button @click="activeTab = 'transaction-items'"
                                    :class="activeTab === 'transaction-items' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    <span>Broker Sales</span>
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
    }
}
</script>
@endsection
