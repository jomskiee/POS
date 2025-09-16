@extends('layouts.broker')

@section('content')
            <div class="w-full">
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
                        <div class="grid grid-cols-12 gap-4 items-end">
                            <!-- Search Field -->
                            <div class="col-span-12 md:col-span-4">
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
                            <div class="col-span-6 md:col-span-2">
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
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date"
                                    name="date_from"
                                    x-model="dateFrom"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Date To -->
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date"
                                    name="date_to"
                                    x-model="dateTo"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-span-12 md:col-span-2 flex justify-end space-x-2">
                                <a href="{{ route('broker.sales.sales') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Clear
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
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

<!-- Unified Sale Modal -->
@if(request('modal') === 'create' || request('modal') === 'edit')
    @if(request('modal') === 'edit' && !$editingSales)
        <!-- Sales record not found -->
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 py-6">
                        <div class="text-center">
                            <div class="bg-red-100 p-4 rounded-full w-16 h-16 mx-auto mb-4">
                                <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-red-600" />
                        </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Sale Not Found</h3>
                            <p class="text-gray-500 mb-6">The sale you're trying to edit could not be found or you don't have permission to access it.</p>
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
    @else
        <!-- Unified Sale Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ request('modal') === 'create' ? 'Create Sale' : 'Edit Sale' }}
                            </h3>
                    <a href="{{ route('broker.sales.sales') }}"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="bg-white px-6 py-6">
                        <form action="{{ request('modal') === 'create' ? route('broker.sales.store') : route('broker.sales.update', $editingSales->id ?? '') }}"
                              method="POST"
                              class="space-y-6">
                    @csrf
                            @if(request('modal') === 'edit')
                    @method('PUT')
                            @endif

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sales_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Sales Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="sales_date" name="sales_date" required
                                           value="{{ request('modal') === 'edit' && $editingSales ? $editingSales->sales_date->format('Y-m-d') : (old('sales_date', date('Y-m-d'))) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('sales_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Total Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="total_amount" name="total_amount" required
                                   step="0.01" min="0"
                                           value="{{ request('modal') === 'edit' && $editingSales ? $editingSales->total_amount : (old('total_amount', '')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="0.00">
                            @error('total_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sales Details -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sales Details <span class="text-red-500">*</span>
                        </label>
                                <div class="space-y-4" id="sales-details-container">
                                    @foreach($salesDetails as $index => $detail)
                                        <div class="flex items-end space-x-4 p-4 border border-gray-200 rounded-lg sales-detail-row">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fish Box</label>
                                                <select name="sales_details[{{ $index }}][box_id]"
                                                        class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        required>
                                                    @if(request('modal') !== 'edit')
                                            <option value="">Select Fish Box</option>
                                                    @endif
                                                    @foreach($fishBoxes as $fishBox)
                                                        @if($fishBox->fishType)
                                                            <option value="{{ $fishBox->id }}"
                                                                    data-fish-type="{{ $fishBox->fishType->name }}"
                                                                    {{ (string)$detail['box_id'] === (string)$fishBox->id ? 'selected' : '' }}>
                                                                {{ $fishBox->name }} ({{ $fishBox->fishType->name }})
                                                            </option>
                                                        @endif
                                                    @endforeach
                                        </select>
                                    </div>
                                    <!-- Hidden Item field - automatically populated with fish type name -->
                                            <input type="hidden" name="sales_details[{{ $index }}][item]"
                                                   value="{{ $detail['item'] ?? '' }}" class="item-input">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                <input type="text" name="sales_details[{{ $index }}][item_description]"
                                                       value="{{ $detail['item_description'] ?? '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Item description">
                                    </div>
                                            <button type="button" class="remove-detail-btn text-red-600 hover:text-red-800 transition-colors">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                                    @endforeach
                        </div>
                                <button type="button" id="add-sales-detail-btn"
                                class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2 inline" />
                            Add Sales Detail
                        </button>
                        @error('sales_details')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buyer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="buyer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Buyer Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="buyer_name" name="buyer_name"
                                           value="{{ request('modal') === 'edit' && $editingSales ? $editingSales->buyer_name : (old('buyer_name', '')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Enter buyer name">
                            @error('buyer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="buyer_contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Buyer Contact
                            </label>
                            <input type="text" id="buyer_contact" name="buyer_contact"
                                           value="{{ request('modal') === 'edit' && $editingSales ? $editingSales->buyer_contact : (old('buyer_contact', '')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Enter buyer contact">
                            @error('buyer_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                            Remarks
                        </label>
                        <textarea id="remarks" name="remarks" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                          placeholder="Enter any additional remarks">{{ request('modal') === 'edit' && $editingSales ? ($editingSales->remarks ?? '') : (old('remarks', '')) }}</textarea>
                        @error('remarks')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('broker.sales.sales') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors {{ request('modal') === 'create' ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700' }}">
                                    {{ request('modal') === 'create' ? 'Create Sale' : 'Update Sale' }}
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endif

<!-- Add Payment Modal -->
@if(request('modal') === 'payment')
    @if($saleForPayment)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Add Payment</h3>
                    <a href="{{ route('broker.sales.sales') }}"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="bg-white px-6 py-6">
                <!-- Balance Summary -->
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
                            <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>
                            <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="Other" {{ old('payment_method') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
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
    <!-- Sale not found for payment -->
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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

<!-- Print Receipt Modal -->
@if(request('modal') === 'print')
    @if($printingSales)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Print Receipt</h3>
                    <div class="flex items-center space-x-3">
                        <!-- <button onclick="printReceipt()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <x-heroicon-o-printer class="w-4 h-4 mr-2" />
                            Print
                        </button> -->
                        <a href="{{ route('broker.sales.sales') }}"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Receipt Content -->
            <div class="bg-white px-6 py-6" id="receipt-content">
                <div class="max-w-md mx-auto bg-white">
                    <!-- Company Header -->
                    <div class="text-center border-b border-gray-200 pb-4 mb-4">
                        <h1 class="text-2xl font-bold text-gray-900">Fish Box POS</h1>
                        <p class="text-sm text-gray-600">Sales Receipt</p>
                        <p class="text-xs text-gray-500">Receipt #{{ $printingSales->id }}</p>
                    </div>

                    <!-- Sale Information -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">{{ $printingSales->sales_date->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Buyer:</span>
                            <span class="font-medium">{{ $printingSales->buyer_name }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Contact:</span>
                            <span class="font-medium">{{ $printingSales->buyer_contact }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium {{ $salesStatusesWithColorClasses[$printingSales->status] }}">
                                {{ $salesStatusesWithDisplayNames[$printingSales->status] }}
                            </span>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Items Sold</h3>
                        <div class="space-y-2">
                            @foreach($printingSales->salesDetails as $detail)
                                <div class="flex justify-between items-start text-sm">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $detail->item }}</div>
                                        @if($detail->fishBox)
                                            <div class="text-xs text-gray-500">{{ $detail->fishBox->name }}</div>
                                        @endif
                                        @if($detail->item_description)
                                            <div class="text-xs text-gray-500">{{ $detail->item_description }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment History -->
                    @if($printingSales->salesPayments->count() > 0)
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Payment History</h3>
                        <div class="space-y-2">
                            @foreach($printingSales->salesPayments as $payment)
                                <div class="flex justify-between items-center text-xs">
                                    <div>
                                        <div class="font-medium">{{ $payment->payment_date->format('M d, Y') }}</div>
                                        <div class="text-gray-500">{{ $payment->payment_method }}</div>
                                    </div>
                                    <div class="font-semibold text-green-600">₱{{ number_format($payment->paid_amount, 2) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Payment Summary -->
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Amount:</span>
                                <span class="font-semibold">₱{{ number_format($printingSales->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Paid Amount:</span>
                                <span class="font-semibold text-green-600">₱{{ number_format($printingSales->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm border-t pt-2">
                                <span class="text-gray-600 font-semibold">Remaining Balance:</span>
                                <span class="font-bold text-orange-600">₱{{ number_format($printingSales->remaining_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks -->
                    @if($printingSales->remarks)
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Remarks</h3>
                        <p class="text-xs text-gray-600">{{ $printingSales->remarks }}</p>
                    </div>
                    @endif

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-4 text-center">
                        <p class="text-xs text-gray-500">Thank you for your business!</p>
                        <p class="text-xs text-gray-400 mt-1">Generated on {{ now()->format('M d, Y g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <a href="{{ route('broker.sales.sales') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Close
                </a>
                <button onclick="printReceipt()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    <x-heroicon-o-printer class="w-4 h-4 mr-2 inline" />
                    Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>
    @else
    <!-- Sale not found for printing -->
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-6">
                    <div class="text-center">
                        <div class="bg-red-100 p-4 rounded-full w-16 h-16 mx-auto mb-4">
                            <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-red-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Sale Not Found</h3>
                        <p class="text-gray-500 mb-6">The sale you're trying to print could not be found or you don't have permission to access it.</p>
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

<!-- Show Sales Modal -->
@if(request('modal') === 'show' && $viewingSales)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <x-heroicon-o-shopping-cart class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Sale Details</h3>
                            <p class="text-blue-100 text-sm">Sale #{{ $viewingSales->id }} - {{ $viewingSales->sales_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('broker.sales.sales') }}"
                        class="text-white hover:text-blue-200 transition-colors p-2 hover:bg-white hover:bg-opacity-20 rounded-lg">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="bg-gray-50 px-8 py-6 max-h-[70vh] overflow-y-auto">
                <!-- Sale Information Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Sale Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <x-heroicon-o-user class="w-5 h-5 text-blue-600" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Sale Information</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2" />
                                    Date
                                </span>
                                <span class="text-sm font-semibold text-gray-900">{{ $viewingSales->sales_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-user class="w-4 h-4 mr-2" />
                                    Buyer
                                </span>
                                <span class="text-sm font-semibold text-gray-900">{{ $viewingSales->buyer_name }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-phone class="w-4 h-4 mr-2" />
                                    Contact
                                </span>
                                <span class="text-sm font-semibold text-gray-900">{{ $viewingSales->buyer_contact }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-flag class="w-4 h-4 mr-2" />
                                    Status
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $salesStatusesWithColorClasses[$viewingSales->status] }}">
                                    {{ $salesStatusesWithDisplayNames[$viewingSales->status] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <x-heroicon-o-currency-dollar class="w-5 h-5 text-green-600" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Financial Summary</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-banknotes class="w-4 h-4 mr-2" />
                                    Total Amount
                                </span>
                                <span class="text-lg font-bold text-gray-900">₱{{ number_format($viewingSales->total_amount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-check-circle class="w-4 h-4 mr-2" />
                                    Paid Amount
                                </span>
                                <span class="text-lg font-bold text-green-600">₱{{ number_format($viewingSales->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <x-heroicon-o-clock class="w-4 h-4 mr-2" />
                                    Remaining
                                </span>
                                <span class="text-lg font-bold {{ $viewingSales->remaining_amount > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                    ₱{{ number_format($viewingSales->remaining_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                <x-heroicon-o-chart-bar class="w-5 h-5 text-purple-600" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Payment Progress</h4>
                        </div>
                        <div class="space-y-4">
                            @php
                                $progressPercentage = $viewingSales->total_amount > 0 ? ($viewingSales->paid_amount / $viewingSales->total_amount) * 100 : 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Payment Progress</span>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($progressPercentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-300"
                                     style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <div class="text-center">
                                @if($viewingSales->status === \App\Constants\SalesStatusConstant::PAID)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <x-heroicon-o-check-circle class="w-4 h-4 mr-1" />
                                        Fully Paid
                                    </span>
                                @elseif($viewingSales->status === \App\Constants\SalesStatusConstant::PARTIALLY_PAID)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <x-heroicon-o-clock class="w-4 h-4 mr-1" />
                                        Partially Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <x-heroicon-o-exclamation-triangle class="w-4 h-4 mr-1" />
                                        Pending Payment
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($viewingSales->remarks)
                <div class="mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 text-yellow-600" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Remarks</h4>
                        </div>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-400">{{ $viewingSales->remarks }}</p>
                    </div>
                </div>
                @endif

                <!-- Sales Details -->
                <div class="mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                    <x-heroicon-o-archive-box class="w-5 h-5 text-indigo-600" />
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Items Sold</h4>
                                <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $viewingSales->salesDetails->count() }} items
                                </span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Box</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($viewingSales->salesDetails as $detail)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 p-1.5 rounded-lg mr-3">
                                                        <x-heroicon-o-archive-box class="w-4 h-4 text-blue-600" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $detail->fishBox->name ?? 'N/A' }}</div>
                                                        @if($detail->fishBox && $detail->fishBox->fishType)
                                                            <div class="text-xs text-gray-500">{{ $detail->fishBox->fishType->name }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $detail->item }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $detail->item_description ?? '-' }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <x-heroicon-o-archive-box class="w-12 h-12 text-gray-400 mb-2" />
                                                    <p class="text-sm text-gray-500">No items found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                @if($viewingSales->salesPayments->count() > 0)
                <div class="mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="bg-emerald-100 p-2 rounded-lg mr-3">
                                    <x-heroicon-o-credit-card class="w-5 h-5 text-emerald-600" />
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Payment History</h4>
                                <span class="ml-2 bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $viewingSales->salesPayments->count() }} payments
                                </span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($viewingSales->salesPayments as $payment)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="bg-gray-100 p-1.5 rounded-lg mr-3">
                                                        <x-heroicon-o-calendar class="w-4 h-4 text-gray-600" />
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $payment->payment_date->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-lg font-bold text-green-600">
                                                    ₱{{ number_format($payment->paid_amount, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 p-1.5 rounded-lg mr-3">
                                                        <x-heroicon-o-credit-card class="w-4 h-4 text-blue-600" />
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $payment->payment_method }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    {{ $payment->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                                    {{ $payment->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('broker.sales-payments.destroy', $payment->id) }}"
                                                      method="POST"
                                                      class="inline"
                                                      data-swal="delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors p-1 rounded-lg hover:bg-red-50"
                                                            title="Delete Payment">
                                                        <x-heroicon-o-trash class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                        <div class="bg-gray-100 p-4 rounded-full w-16 h-16 mx-auto mb-4">
                            <x-heroicon-o-credit-card class="w-8 h-8 text-gray-400" />
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No Payment History</h4>
                        <p class="text-gray-500 mb-4">This sale doesn't have any payment records yet.</p>
                        <a href="{{ route('broker.sales.sales', ['modal' => 'payment', 'sale' => $viewingSales->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Add Payment
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-white px-8 py-6 border-t border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('broker.sales.sales', ['modal' => 'payment', 'sale' => $viewingSales->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                        Add Payment
                    </a>
                    @if($viewingSales->status !== \App\Constants\SalesStatusConstant::PAID)
                        <span class="text-sm text-gray-500">
                            Outstanding: <span class="font-semibold text-orange-600">₱{{ number_format($viewingSales->remaining_amount, 2) }}</span>
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('broker.sales.sales') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Close
                    </a>
                    <a href="{{ route('broker.sales.sales', ['modal' => 'edit', 'edit' => $viewingSales->id]) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                        Edit Sale
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script src="{{ asset('js/print-receipt.js') }}" defer></script>
<script>
// Simple sales form functionality
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sales-details-container');
    const addBtn = document.getElementById('add-sales-detail-btn');
    const fishBoxes = @json($fishBoxes ?? []);
    let detailIndex = {{ count($salesDetails) }};


    // Add new sales detail
    addBtn.addEventListener('click', function() {
        const newRow = createSalesDetailRow(detailIndex);
        container.appendChild(newRow);
        detailIndex++;
    });

    // Remove sales detail
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-detail-btn')) {
            const row = e.target.closest('.sales-detail-row');
            if (container.children.length > 1) {
                row.remove();
            }
        }
    });

    // Update item name when fish box is selected
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('fish-box-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const fishType = selectedOption.getAttribute('data-fish-type');
            const itemInput = e.target.closest('.sales-detail-row').querySelector('.item-input');
            itemInput.value = fishType || '';
        }
    });

    function createSalesDetailRow(index) {
        const row = document.createElement('div');
        row.className = 'flex items-end space-x-4 p-4 border border-gray-200 rounded-lg sales-detail-row';

        let optionsHtml = '<option value="">Select Fish Box</option>';
        fishBoxes.forEach(fishBox => {
            optionsHtml += `<option value="${fishBox.id}" data-fish-type="${fishBox.fish_type.name}">${fishBox.name} (${fishBox.fish_type.name})</option>`;
        });

        row.innerHTML = `
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Fish Box</label>
                <select name="sales_details[${index}][box_id]"
                        class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    ${optionsHtml}
                </select>
            </div>
            <input type="hidden" name="sales_details[${index}][item]" value="" class="item-input">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" name="sales_details[${index}][item_description]"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Item description">
            </div>
            <button type="button" class="remove-detail-btn text-red-600 hover:text-red-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;

        return row;
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
function printReceipt() {
    const receiptTitle = 'Receipt #{{ $printingSales ? $printingSales->id : "" }}';
    window.printReceipt('receipt-content', receiptTitle);
}

</script>
@endsection
