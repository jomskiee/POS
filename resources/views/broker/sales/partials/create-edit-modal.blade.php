{{-- Create/Edit Sale Modal --}}
@if(request('modal') === 'create' || request('modal') === 'edit')
    @if(request('modal') === 'edit' && !$editingSales)
        {{-- Sales record not found --}}
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full max-w-md mx-auto">
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
        {{-- Unified Sale Modal --}}
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl w-full max-w-md mx-auto">
                    {{-- Modal Header --}}
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

                    {{-- Modal Body --}}
                    <div class="bg-white px-6 py-6">
                        <form action="{{ request('modal') === 'create' ? route('broker.sales.store') : route('broker.sales.update', $editingSales->id ?? '') }}"
                              method="POST"
                              class="space-y-6">
                            @csrf
                            @if(request('modal') === 'edit')
                                @method('PUT')
                            @endif

                            {{-- Basic Information --}}
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
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm bg-gray-100 cursor-not-allowed transition-colors"
                                           placeholder="0.00"
                                           readonly>
                                    @error('total_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sales Details --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Sales Details <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-6" id="sales-details-container">
                                    @foreach($salesDetails as $index => $detail)
                                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 sales-detail-row" data-index="{{ $index }}">
                                            <div class="flex flex-wrap gap-4">
                                                {{-- Fish Type Selection --}}
                                                <div class="flex-1 min-w-[200px]">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fish Type</label>
                                                    <select name="sales_details[{{ $index }}][fish_type_id]"
                                                            class="fish-type-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            required>
                                                        <option value="">Select Fish Type</option>
                                                        @foreach($fishTypes as $fishType)
                                                            <option value="{{ $fishType->id }}"
                                                                    {{ (string)($detail['fish_type_id'] ?? '') === (string)$fishType->id ? 'selected' : '' }}>
                                                                {{ $fishType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Fish Box Selection (Auto-populated, disabled) --}}
                                                <div class="flex-1 min-w-[200px]">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fish Box</label>
                                                    <div class="fish-boxes-container space-y-1 max-h-32 overflow-y-auto">
                                                        @if(is_array($detail['box_id']) && count($detail['box_id']) > 0)
                                                            @foreach($detail['box_id'] as $boxIndex => $boxId)
                                                                <div class="fish-box-item mb-1">
                                                                    <select name="sales_details[{{ $index }}][box_id][]"
                                                                            class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed"
                                                                            disabled>
                                                                        <option value="{{ $boxId }}" selected>Fish Box #{{ $boxId }}</option>
                                                                    </select>
                                                                    <input type="hidden" name="sales_details[{{ $index }}][box_id][]" class="fish-box-hidden-input" value="{{ $boxId }}">
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="fish-box-item mb-1">
                                                                <select name="sales_details[{{ $index }}][box_id][]"
                                                                        class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed"
                                                                        disabled>
                                                                    <option value="">Auto-selected</option>
                                                                </select>
                                                                <input type="hidden" name="sales_details[{{ $index }}][box_id][]" class="fish-box-hidden-input">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Unit Price --}}
                                                <div class="flex-1 min-w-[150px]">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                                                    <input type="number" name="sales_details[{{ $index }}][unit_price]"
                                                           value="{{ $detail['unit_price'] ?? '' }}"
                                                           step="0.01" min="0"
                                                           class="unit-price-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="0.00">
                                                </div>

                                                {{-- Quantity --}}
                                                <div class="flex-1 min-w-[120px]">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">QTY</label>
                                                    <input type="number" name="sales_details[{{ $index }}][quantity]"
                                                           value="{{ $detail['quantity'] ?? '1' }}"
                                                           min="1"
                                                           class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="1">
                                                </div>

                                                {{-- Sub Total (Auto-calculated, disabled) --}}
                                                <div class="flex-1 min-w-[150px]">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sub Total</label>
                                                    <input type="number" name="sales_details[{{ $index }}][sub_total]"
                                                           value="{{ $detail['sub_total'] ?? '' }}"
                                                           step="0.01" min="0"
                                                           class="sub-total-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed"
                                                           readonly>
                                                </div>

                                                {{-- Remove Button --}}
                                                <div class="flex-shrink-0">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                                                    <button type="button" class="remove-detail-btn text-red-600 hover:text-red-800 transition-colors p-2 rounded-lg hover:bg-red-50">
                                                        <x-heroicon-o-trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Hidden fields for item and description --}}
                                            <input type="hidden" name="sales_details[{{ $index }}][item]" class="item-input" value="{{ $detail['item'] ?? '' }}">
                                            <input type="hidden" name="sales_details[{{ $index }}][item_description]" class="item-description-input" value="{{ $detail['item_description'] ?? '' }}">
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Total Amount Display --}}
                                <div class="mt-6 bg-blue-50 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">TOTAL:</span>
                                        <span class="text-2xl font-bold text-blue-600" id="total-amount-display">₱0.00</span>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-4 flex space-x-3">
                                    <button type="button" id="add-sales-detail-btn"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        <x-heroicon-o-plus class="w-4 h-4 mr-2 inline" />
                                        Add Sales Detail
                                    </button>
                                    <button type="button" id="scan-qr-btn"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        <x-heroicon-o-qr-code class="w-4 h-4 mr-2 inline" />
                                        Scan QR Code
                                    </button>
                                </div>
                                @error('sales_details')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Buyer Information --}}
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

                            {{-- Remarks --}}
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

                            {{-- Modal Footer --}}
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

