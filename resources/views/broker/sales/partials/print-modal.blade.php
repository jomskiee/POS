{{-- Print Receipt Modal --}}
@if(request('modal') === 'print')
    @if($printingSales)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center lg:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full max-w-md mx-auto">
                    {{-- Modal Header --}}
                    <div class="bg-white px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Print Receipt</h3>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('broker.sales.sales') }}"
                                   class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <x-heroicon-o-x-mark class="w-6 h-6" />
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Receipt Content --}}
                    <div class="bg-white px-6 py-6" id="receipt-content">
                        <div class="max-w-md mx-auto bg-white">
                            {{-- Company Header --}}
                            <div class="text-center border-b border-gray-200 pb-4 mb-4">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $printingSales->broker->name }}</h1>
                                <p class="text-sm text-gray-600">{{ $printingSales->broker->stall_name }}</p>
                                <p class="text-xs text-gray-500">Receipt #{{ $printingSales->id }}</p>
                            </div>

                            {{-- Sale Information --}}
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

                            {{-- Items --}}
                            <div class="border-t border-gray-200 pt-4 mb-4">
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Items Sold</h3>
                                <div class="space-y-3">
                                    @foreach($printingSales->salesDetails as $detail)
                                        <div class="bg-gray-50 rounded-lg p-3">
                                            <div class="flex justify-between items-start mb-2">
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">{{ $detail->item }}</div>
                                                    @if($detail->item_description)
                                                        <div class="text-xs text-gray-500 mt-1">{{ $detail->item_description }}</div>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-semibold text-gray-900">₱{{ number_format($detail->sub_total, 2) }}</div>
                                                    <div class="text-xs text-gray-500">{{ $detail->quantity }} × ₱{{ number_format($detail->unit_price, 2) }}</div>
                                                </div>
                                            </div>

                                            {{-- Fish Boxes --}}
                                            @if(is_array($detail->box_id) && count($detail->box_id) > 0)
                                                <div class="mt-2">
                                                    <div class="text-xs text-gray-600 mb-1">Fish Boxes:</div>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach($detail->box_id as $boxId)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                Fish Box #{{ $boxId }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Payment History --}}
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

                            {{-- Payment Summary --}}
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

                            {{-- Remarks --}}
                            @if($printingSales->remarks)
                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Remarks</h3>
                                    <p class="text-xs text-gray-600">{{ $printingSales->remarks }}</p>
                                </div>
                            @endif

                            {{-- Footer --}}
                            <div class="border-t border-gray-200 pt-4 text-center">
                                <p class="text-xs text-gray-500">Thank you for your business!</p>
                                <p class="text-xs text-gray-400 mt-1">Generated on {{ now()->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <a href="{{ route('broker.sales.sales') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Close
                        </a>
                        <button onclick="printReceiptBroker()"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                            <x-heroicon-o-printer class="w-4 h-4 mr-2 inline" />
                            Print Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Sale not found for printing --}}
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

