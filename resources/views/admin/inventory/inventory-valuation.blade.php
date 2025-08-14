<!-- Inventory Valuation Tab Content -->
<div class="space-y-6">
    <!-- Valuation Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900">$184,750</p>
                    <p class="text-xs text-blue-600">Current inventory</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Cost Value</p>
                    <p class="text-2xl font-bold text-gray-900">$142,380</p>
                    <p class="text-xs text-green-600">FIFO method</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Potential Profit</p>
                    <p class="text-2xl font-bold text-gray-900">$42,370</p>
                    <p class="text-xs text-purple-600">29.8% margin</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Turnover Ratio</p>
                    <p class="text-2xl font-bold text-gray-900">4.2x</p>
                    <p class="text-xs text-yellow-600">Annual rate</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Valuation Methods and Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Valuation by Category -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Inventory Valuation by Category</h3>
                        <div class="flex items-center space-x-3">
                            <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>FIFO Method</option>
                                <option>LIFO Method</option>
                                <option>Average Cost</option>
                                <option>Standard Cost</option>
                            </select>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Export Report
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retail Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit Margin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Electronics</div>
                                            <div class="text-sm text-gray-500">1,247 items</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1,247 units</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$67,450</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$89,340</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">32.4%</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">48.4%</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2zm0 0V9a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Furniture</div>
                                            <div class="text-sm text-gray-500">189 items</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">189 units</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$21,250</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$27,530</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">29.6%</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">14.9%</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Accessories</div>
                                            <div class="text-sm text-gray-500">623 items</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">623 units</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$18,340</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$23,450</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">27.9%</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12.7%</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Office Supplies</div>
                                            <div class="text-sm text-gray-500">456 items</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">456 units</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$12,150</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$15,680</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">29.0%</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8.5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Valuation Methods Comparison -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Valuation Methods</h3>
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-900">FIFO Method</h4>
                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded">Current</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">$142,380</p>
                        <p class="text-xs text-gray-600">First In, First Out</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-900">LIFO Method</h4>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">$138,920</p>
                        <p class="text-xs text-gray-600">Last In, First Out</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-900">Average Cost</h4>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">$140,650</p>
                        <p class="text-xs text-gray-600">Weighted Average</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-900">Standard Cost</h4>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">$145,200</p>
                        <p class="text-xs text-gray-600">Predetermined Cost</p>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Key Metrics</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Inventory Days</p>
                            <p class="text-xs text-gray-600">Days of supply on hand</p>
                        </div>
                        <span class="text-lg font-bold text-blue-600">87</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Gross Margin</p>
                            <p class="text-xs text-gray-600">Avg profit percentage</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">29.8%</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Stock Accuracy</p>
                            <p class="text-xs text-gray-600">System vs physical</p>
                        </div>
                        <span class="text-lg font-bold text-purple-600">96.2%</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Dead Stock</p>
                            <p class="text-xs text-gray-600">No movement >90 days</p>
                        </div>
                        <span class="text-lg font-bold text-yellow-600">2.1%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aging Analysis -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory Aging Analysis</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-green-600 mb-2">$89,240</div>
                <div class="text-sm text-gray-600">0-30 Days</div>
                <div class="text-xs text-gray-500">48.3% of inventory</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 48.3%"></div>
                </div>
            </div>

            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-blue-600 mb-2">$52,340</div>
                <div class="text-sm text-gray-600">31-60 Days</div>
                <div class="text-xs text-gray-500">28.3% of inventory</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 28.3%"></div>
                </div>
            </div>

            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600 mb-2">$28,950</div>
                <div class="text-sm text-gray-600">61-90 Days</div>
                <div class="text-xs text-gray-500">15.7% of inventory</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 15.7%"></div>
                </div>
            </div>

            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-red-600 mb-2">$14,220</div>
                <div class="text-sm text-gray-600">90+ Days</div>
                <div class="text-xs text-gray-500">7.7% of inventory</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 7.7%"></div>
                </div>
            </div>
        </div>
    </div>
</div>