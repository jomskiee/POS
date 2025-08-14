<!-- Financial Overview Tab Content -->
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">$18,450.30</p>
                    <p class="text-xs text-green-600">+15.3% from last month</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                    <p class="text-2xl font-bold text-gray-900">$12,680.75</p>
                    <p class="text-xs text-red-600">+8.2% from last month</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Net Profit</p>
                    <p class="text-2xl font-bold text-gray-900">$5,769.55</p>
                    <p class="text-xs text-green-600">+31.2% from last month</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Profit Margin</p>
                    <p class="text-2xl font-bold text-gray-900">31.3%</p>
                    <p class="text-xs text-green-600">+2.1% from last month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- P&L Statement -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Profit & Loss Statement</h3>
            <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>This Month</option>
                <option>Last Month</option>
                <option>This Quarter</option>
                <option>This Year</option>
            </select>
        </div>
        
        <div class="space-y-4">
            <!-- Revenue Section -->
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Revenue</h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Product Sales</span>
                        <span class="font-medium text-gray-900">$16,230.50</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Service Revenue</span>
                        <span class="font-medium text-gray-900">$2,219.80</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b-2 border-gray-300 font-semibold">
                        <span class="text-gray-900">Total Revenue</span>
                        <span class="text-green-600">$18,450.30</span>
                    </div>
                </div>
            </div>

            <!-- Expenses Section -->
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Expenses</h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Cost of Goods Sold</span>
                        <span class="font-medium text-gray-900">$8,120.30</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Operating Expenses</span>
                        <span class="font-medium text-gray-900">$3,240.15</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Marketing & Advertising</span>
                        <span class="font-medium text-gray-900">$890.50</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Administrative Costs</span>
                        <span class="font-medium text-gray-900">$429.80</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b-2 border-gray-300 font-semibold">
                        <span class="text-gray-900">Total Expenses</span>
                        <span class="text-red-600">$12,680.75</span>
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Net Profit</span>
                    <span class="text-2xl font-bold text-green-600">$5,769.55</span>
                </div>
                <p class="text-sm text-green-600 mt-1">31.3% profit margin</p>
            </div>
        </div>
    </div>

    <!-- Cash Flow Tracking -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Cash Flow</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Cash Inflow</span>
                        <span class="text-sm font-bold text-green-600">$18,450.30</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Cash Outflow</span>
                        <span class="text-sm font-bold text-red-600">$12,680.75</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Net Cash Flow</span>
                        <span class="text-sm font-bold text-blue-600">$5,769.55</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Financial Ratios</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Current Ratio</p>
                        <p class="text-xs text-gray-600">Current Assets / Current Liabilities</p>
                    </div>
                    <span class="text-lg font-bold text-green-600">2.4</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Gross Margin</p>
                        <p class="text-xs text-gray-600">Gross Profit / Revenue</p>
                    </div>
                    <span class="text-lg font-bold text-blue-600">56.0%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">ROI</p>
                        <p class="text-xs text-gray-600">Return on Investment</p>
                    </div>
                    <span class="text-lg font-bold text-purple-600">18.5%</span>
                </div>
            </div>
        </div>
    </div>
</div>