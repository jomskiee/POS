{{-- Show Sales Modal --}}
@if(request('modal') === 'show' && $viewingSales)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center lg:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl w-full">
                {{-- Modal Header --}}
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

                {{-- Modal Body --}}
                <div class="bg-gray-50 px-8 py-6 max-h-[70vh] overflow-y-auto">
                    {{-- Sale Information Cards --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        {{-- Sale Info Card --}}
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

                        {{-- Financial Summary Card --}}
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

                        {{-- Progress Card --}}
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

                    {{-- Sales Details --}}
                    <div class="mb-8">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                        <x-heroicon-o-archive-box class="w-5 h-5 text-indigo-600" />
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900">Items Sold</h4>
                                    <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ $viewingSales->salesDetails->sum(function($detail) { return is_array($detail->box_id) ? count($detail->box_id) : 1; }) }} fish boxes
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Box</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Total</th>
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
                                                            <div class="flex flex-wrap gap-2">
                                                                @foreach($detail->box_id as $boxId)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                                        Fish Box #{{ $boxId }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $detail->item }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">₱{{ number_format($detail->unit_price, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $detail->quantity }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-gray-900">₱{{ number_format($detail->sub_total, 2) }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center">
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

                    {{-- Payment History --}}
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

                {{-- Modal Footer --}}
                <div class="bg-white px-4 sm:px-8 py-4 sm:py-6 border-t border-gray-200 flex flex-row items-center justify-center sm:justify-between space-x-2 sm:space-x-0">
                    <div class="flex items-center space-x-4">
                        @if($viewingSales->status !== \App\Constants\SalesStatusConstant::PAID)
                            <a href="{{ route('broker.sales.sales', ['modal' => 'payment', 'sale' => $viewingSales->id]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                                Add Payment
                            </a>
                            <span class="hidden sm:block text-sm text-gray-500 text-center sm:text-left">
                                Outstanding: <span class="font-semibold text-orange-600">₱{{ number_format($viewingSales->remaining_amount, 2) }}</span>
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('broker.sales.sales') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-center">
                            Close
                        </a>
                        <a href="{{ route('broker.sales.sales', ['modal' => 'edit', 'edit' => $viewingSales->id]) }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                            Edit Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

