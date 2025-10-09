@php
    $breadcrumbs = [
        ['title' => 'Sales Management']
    ];
@endphp

@extends('layouts.broker')

@section('content')
            <div class="w-full content-spacing">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex-1">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Sales Management</h1>
                            <p class="text-gray-600 mt-2 text-sm sm:text-base">Create, edit, and manage your sales transactions</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('broker.sales.sales', ['modal' => 'create']) }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center w-full sm:w-auto">
                                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                                New Sale
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sales Filters -->
                <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                    <form method="GET" action="{{ route('broker.sales.sales') }}" x-data="{
                        search: '{{ request('search') }}',
                        status: '{{ request('status') }}',
                        dateFrom: '{{ request('date_from') }}',
                        dateTo: '{{ request('date_to') }}'
                    }">
                        <div class="sales-filter-layout">
                            <!-- Search Field -->
                            <div class="search-field">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <div class="relative">
                                    <input type="text"
                                        name="search"
                                        x-model="search"
                                        placeholder="Search buyer name or contact..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="status-field">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" x-model="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    @foreach($salesStatusesWithDisplayNames as $status => $displayName)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ $displayName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date From -->
                            <div class="fish-type-field">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date"
                                    name="date_from"
                                    x-model="dateFrom"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Date To -->
                            <div class="fish-type-field">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date"
                                    name="date_to"
                                    x-model="dateTo"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Action Buttons -->
                            <div class="buttons-field flex justify-end space-x-2">
                                <a href="{{ route('broker.sales.sales') }}"
                                class="px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Clear
                                </a>
                                <button type="submit"
                                        class="px-3 lg:px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Count -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }} of {{ $sales->total() }} sales
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <span class="text-blue-600">(filtered)</span>
                        @endif
                    </p>
                </div>

                <!-- Sales Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($sales as $sale)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $sale->sales_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $sale->formatted_items }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $sale->buyer_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $sale->buyer_contact }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₱{{ number_format($sale->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₱{{ number_format($sale->paid_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salesStatusesWithColorClasses[$sale->status] }}">
                                                {{ $salesStatusesWithDisplayNames[$sale->status] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('broker.sales.sales', ['modal' => 'show', 'show' => $sale->id]) }}"
                                                   class="text-green-600 hover:text-green-900 transition-colors"
                                                   title="View Sale">
                                                    <x-heroicon-o-eye class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('broker.sales.sales', ['modal' => 'print', 'print' => $sale->id]) }}"
                                                   class="text-purple-600 hover:text-purple-900 transition-colors"
                                                   title="Print Receipt">
                                                    <x-heroicon-o-printer class="w-5 h-5" />
                                                </a>
                                                @if($sale->status !== \App\Constants\SalesStatusConstant::PAID)
                                                <a href="{{ route('broker.sales.sales', ['modal' => 'edit', 'edit' => $sale->id]) }}"
                                                   class="text-blue-600 hover:text-blue-900 transition-colors"
                                                   title="Edit Sale">
                                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('broker.sales.sales', ['modal' => 'payment', 'sale' => $sale->id]) }}"
                                                   class="text-green-600 hover:text-green-900 transition-colors"
                                                   title="Add Payment">
                                                    <x-heroicon-o-currency-dollar class="w-5 h-5" />
                                                </a>
                                                @endif
                                                <form action="{{ route('broker.sales.destroy', $sale->id) }}" method="POST" class="inline-block" data-swal="delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition-colors"
                                                            title="Delete Sale">
                                                        <x-heroicon-o-trash class="w-5 h-5 inline" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <x-heroicon-o-shopping-cart class="w-16 h-16 text-gray-400 mb-4" />
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No sales found</h3>
                                                <p class="text-gray-500 mb-6">Get started by creating your first sale.</p>
                                                <a href="{{ route('broker.sales.sales', ['modal' => 'create']) }}"
                                                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                                                    <x-heroicon-o-plus class="w-5 h-5" />
                                                    <span>Create Sale</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($sales->hasPages())
                    <div class="mt-8">
                        {{ $sales->appends(request()->query())->links('components.pagination') }}
                    </div>
                @endif
            </div>

{{-- Modals --}}
@include('broker.sales.partials.create-edit-modal')
@include('broker.sales.partials.payment-modal')
@include('broker.sales.partials.print-modal')
@include('broker.sales.partials.show-modal')

{{-- Hidden template for new sales detail rows (used by JavaScript) --}}
<template id="sales-detail-row-template">
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 sales-detail-row">
        <div class="flex flex-wrap gap-4">
            <!-- Fish Type Selection -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fish Type</label>
                <select name="sales_details[INDEX][fish_type_id]"
                        class="fish-type-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Select Fish Type</option>
                    @foreach($fishTypes ?? [] as $fishType)
                        <option value="{{ $fishType->id }}">{{ $fishType->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fish Box Selection (Auto-populated, disabled) -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fish Box</label>
                <div class="fish-boxes-container space-y-1 max-h-32 overflow-y-auto">
                    <div class="fish-box-item mb-1">
                        <select class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed" disabled>
                            <option value="">Auto-selected</option>
                        </select>
                        <input type="hidden" name="sales_details[INDEX][box_id][]" class="fish-box-hidden-input">
                    </div>
                </div>
            </div>

            <!-- Unit Price -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                <input type="number" name="sales_details[INDEX][unit_price]" step="0.01" min="0"
                       class="unit-price-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="0.00">
            </div>

            <!-- Quantity -->
            <div class="flex-1 min-w-[120px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">QTY</label>
                <input type="number" name="sales_details[INDEX][quantity]" value="1" min="1"
                       class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="1">
            </div>

            <!-- Sub Total (Auto-calculated, disabled) -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sub Total</label>
                <input type="number" name="sales_details[INDEX][sub_total]" step="0.01" min="0"
                       class="sub-total-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed"
                       readonly>
            </div>

            <!-- Remove Button -->
            <div class="flex-shrink-0">
                <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button type="button" class="remove-detail-btn text-red-600 hover:text-red-800 transition-colors p-2 rounded-lg hover:bg-red-50">
                    <x-heroicon-o-trash class="w-5 h-5" />
                </button>
            </div>
        </div>

        <!-- Hidden fields for item and description -->
        <input type="hidden" name="sales_details[INDEX][item]" class="item-input" value="">
        <input type="hidden" name="sales_details[INDEX][item_description]" class="item-description-input" value="">
    </div>
</template>

<script src="{{ asset('js/print-receipt.js') }}" defer></script>
<script src="{{ asset('js/sales-qr-scanner.js') }}" defer></script>
<script src="{{ asset('js/sales-form.js') }}" defer></script>
<script>
// Initialize sales form and QR scanner when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sales QR Scanner
    window.salesQrScanner = new SalesQRScanner();

    // Setup QR scan button event listener
    const scanBtn = document.getElementById('scan-qr-btn');
    if (scanBtn) {
        scanBtn.addEventListener('click', function() {
            if (window.salesQrScanner) {
                window.salesQrScanner.openModal();
            } else {
                toastr.error('QR Scanner not initialized. Please refresh the page.');
            }
        });
    }

    // Initialize sales form
    if (typeof initializeSalesForm === 'function') {
        initializeSalesForm({
            fishBoxes: @json($fishBoxes ?? []),
            fishTypes: @json($fishTypes ?? []),
            detailIndex: {{ count($salesDetails) }}
        });
    }
});

function paymentForm() {
    return {
        paidAmount: 0,
        maxPaymentAmount: {{ $saleForPayment ? $saleForPayment->remaining_amount : 0 }},
        paymentError: '',

        initializePaymentForm() {
            // Initialize form
        },

        validatePaymentAmount() {
            this.paymentError = '';

            if (this.paidAmount > this.maxPaymentAmount) {
                this.paymentError = 'Payment amount cannot exceed the remaining balance of ₱' + this.maxPaymentAmount.toFixed(2);
                return false;
            }

            if (this.paidAmount <= 0) {
                this.paymentError = 'Payment amount must be greater than 0';
                return false;
            }

            return true;
        }
    }
}

// Print receipt function - calls external print-receipt.js
function printReceiptBroker() {
    const receiptTitle = 'Receipt #{{ $printingSales ? $printingSales->id : "" }}';
    window.printReceipt('receipt-content', receiptTitle);
}

</script>
@endsection
