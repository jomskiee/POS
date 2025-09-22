<!-- Transaction History Tab Content -->
<div class="space-y-6">
    <!-- Filters Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales Filters</h3>
        <form method="GET" action="{{ route('admin.sales.index', ['tab' => 'transactions']) }}">
            <input type="hidden" name="tab" value="transactions">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date"
                           name="date_from"
                           value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date"
                           name="date_to"
                           value="{{ request('date_to', now()->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        @foreach($statusOptions as $statusValue => $statusDisplayName)
                            <option value="{{ $statusValue }}" {{ request('status') == $statusValue ? 'selected' : '' }}>
                                {{ $statusDisplayName }}
                            </option>
                        @endforeach
                    </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Customer name or Broker name..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Clear
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Apply
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-currency-dollar class="w-6 h-6 text-white" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($transactionsData['totalRevenue'], 2) }}</p>
                    <p class="text-xs text-green-600">Period total</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-document-text class="w-6 h-6 text-white" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Sales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($transactionsData['totalTransactions']) }}</p>
                    <p class="text-xs text-blue-600">All sales</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-clock class="w-6 h-6 text-white" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($transactionsData['pendingCount']) }}</p>
                    <p class="text-xs text-yellow-600">Active orders</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-check-circle class="w-6 h-6 text-white" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Paid Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($transactionsData['paidCount']) }}</p>
                    <p class="text-xs text-purple-600">Completed sales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Sales History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Broker</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactionsData['transactions'] as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-600">#{{ $transaction->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->broker->name ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->buyer_name ?: 'Anonymous' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->salesDetails->count() }} items</div>
                                @if($transaction->salesDetails->count() > 0)
                                    <div class="text-xs text-gray-500">
                                        @foreach($transaction->salesDetails->take(2) as $detail)
                                            {{ $detail->fishBox->fishType->name ?? 'Unknown' }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        @if($transaction->salesDetails->count() > 2)
                                            +{{ $transaction->salesDetails->count() - 2 }} more
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">₱{{ number_format($transaction->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $transaction->status === 'Paid' ? 'bg-green-100 text-green-800' :
                                       ($transaction->status === 'Active' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-blue-100 text-blue-800') }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.sales.index', ['tab' => 'transactions', 'modal' => 'show', 'show' => $transaction->id]) }}"
                                       class="text-green-600 hover:text-green-900 transition-colors"
                                       title="View Sale">
                                        <x-heroicon-o-eye class="w-5 h-5" />
                                    </a>
                                    <a href="{{ route('admin.sales.index', ['tab' => 'transactions', 'modal' => 'print', 'print' => $transaction->id]) }}"
                                       class="text-purple-600 hover:text-purple-900 transition-colors"
                                       title="Print Receipt">
                                        <x-heroicon-o-printer class="w-5 h-5" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <x-heroicon-o-document-text class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                                <p>No transactions found for the selected period</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactionsData['transactions']->hasPages())
            <div class="mt-8">
                {{ $transactionsData['transactions']->appends(request()->query())->links('components.pagination') }}
            </div>
        @endif
    </div>

    <!-- View Sales Modal -->
    @if(request('modal') === 'show' && $viewingSales)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle " aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl w-full">
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
                        <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}"
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
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="bg-white px-4 sm:px-8 py-4 sm:py-6 border-t border-gray-200 flex flex-row items-center justify-center sm:justify-between space-x-2 sm:space-x-0">
                    <div class="flex items-center space-x-4">
                        @if($viewingSales->status !== \App\Constants\SalesStatusConstant::PAID)
                            <span class="hidden sm:block text-sm text-gray-500 text-center sm:text-left">
                                Outstanding: <span class="font-semibold text-orange-600">₱{{ number_format($viewingSales->remaining_amount, 2) }}</span>
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-center">
                            Close
                        </a>
                        <a href="{{ route('admin.sales.index', ['tab' => 'transactions', 'modal' => 'print', 'print' => $viewingSales->id]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <x-heroicon-o-printer class="w-4 h-4 mr-2" />
                            Print Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Print Sales Modal -->
    @if(request('modal') === 'print' && $printingSales)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle " aria-hidden="true">&#8203;</span>

                    <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full max-w-md mx-auto">
                        <!-- Modal Header -->
                        <div class="bg-white px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Print Receipt</h3>
                                <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}"
                                    class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <x-heroicon-o-x-mark class="w-6 h-6" />
                                </a>
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
                                        <span class="font-medium">{{ $printingSales->buyer_name ?: 'Anonymous' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Contact:</span>
                                        <span class="font-medium">{{ $printingSales->buyer_contact ?: 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Broker:</span>
                                        <span class="font-medium">{{ $printingSales->broker->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium {{ $salesStatusesWithColorClasses[$printingSales->status] ?? 'text-gray-600' }}">
                                            {{ $salesStatusesWithDisplayNames[$printingSales->status] ?? $printingSales->status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Items -->
                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Items</h3>
                                    @foreach($printingSales->salesDetails as $detail)
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>{{ $detail->fishBox->fishType->name ?? 'Unknown' }} x{{ $detail->quantity }}</span>
                                            <span>₱{{ number_format($detail->total_price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

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

                                <!-- Footer -->
                                <div class="border-t border-gray-200 pt-4 text-center">
                                    <p class="text-xs text-gray-500">Thank you for your business!</p>
                                    <p class="text-xs text-gray-400 mt-1">Generated on {{ now()->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                    </button>
                            <button onclick="printReceiptAdmin()"
                                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">
                                Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="{{ asset('js/print-receipt.js') }}" defer></script>
<script>

// Print receipt function - calls external print-receipt.js
function printReceiptAdmin() {
    const receiptTitle = 'Receipt #{{ $printingSales ? $printingSales->id : "" }}';

    // Check if element exists before calling print
    const element = document.getElementById('receipt-content');
    // Add a small delay to ensure the element is fully rendered
    setTimeout(function() {
        window.printReceipt('receipt-content', receiptTitle);
    }, 100);
}
</script>
