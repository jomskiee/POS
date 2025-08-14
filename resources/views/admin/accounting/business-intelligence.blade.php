<!-- Business Intelligence Tab Content -->
<div class="space-y-6">
    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Forecasting -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenue Forecast</p>
                    <p class="text-2xl font-bold text-gray-900">$95,420</p>
                    <p class="text-xs text-green-600">+18.5% predicted</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Goal Tracking -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Monthly Goal</p>
                    <p class="text-2xl font-bold text-gray-900">87%</p>
                    <p class="text-xs text-orange-600">$13,000 to target</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Customer Analytics -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Customer LTV</p>
                    <p class="text-2xl font-bold text-gray-900">$1,245</p>
                    <p class="text-xs text-green-600">+12.3% vs last quarter</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Performance Score -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Performance Score</p>
                    <p class="text-2xl font-bold text-gray-900">8.7</p>
                    <p class="text-xs text-purple-600">Excellent rating</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Forecasting Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Forecasting</h3>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Next 3 months</option>
                    <option>Next 6 months</option>
                    <option>Next 12 months</option>
                </select>
            </div>
            <div class="h-64 flex items-end justify-between space-x-2">
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 120px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Jan</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 140px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Feb</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 180px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Mar</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-400 rounded-t opacity-60" style="height: 200px;"></div>
                    <span class="text-xs text-gray-400 mt-2">Apr</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-400 rounded-t opacity-60" style="height: 220px;"></div>
                    <span class="text-xs text-gray-400 mt-2">May</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-400 rounded-t opacity-60" style="height: 240px;"></div>
                    <span class="text-xs text-gray-400 mt-2">Jun</span>
                </div>
            </div>
            <div class="flex items-center justify-center mt-4 space-x-6 text-xs">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded"></div>
                    <span>Actual</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-400 opacity-60 rounded"></div>
                    <span>Predicted</span>
                </div>
            </div>
        </div>

        <!-- Goal Progress -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Goal Tracking</h3>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Monthly Revenue Goal</span>
                        <span class="text-sm text-gray-500">$75,000 / $85,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: 88%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>88% achieved</span>
                        <span>$10,000 remaining</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">New Customers</span>
                        <span class="text-sm text-gray-500">156 / 200</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: 78%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>78% achieved</span>
                        <span>44 remaining</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Profit Margin</span>
                        <span class="text-sm text-gray-500">31.2% / 35%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-purple-500 h-3 rounded-full" style="width: 89%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>89% achieved</span>
                        <span>3.8% remaining</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Reports -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Monthly Comparison</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Revenue</p>
                        <p class="text-xs text-gray-600">vs last month</p>
                    </div>
                    <span class="text-lg font-bold text-green-600">+15.3%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Expenses</p>
                        <p class="text-xs text-gray-600">vs last month</p>
                    </div>
                    <span class="text-lg font-bold text-red-600">+8.2%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Customers</p>
                        <p class="text-xs text-gray-600">vs last month</p>
                    </div>
                    <span class="text-lg font-bold text-blue-600">+22.1%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Yearly Comparison</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Revenue</p>
                        <p class="text-xs text-gray-600">vs last year</p>
                    </div>
                    <span class="text-lg font-bold text-green-600">+28.7%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Profit</p>
                        <p class="text-xs text-gray-600">vs last year</p>
                    </div>
                    <span class="text-lg font-bold text-green-600">+34.2%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Growth Rate</p>
                        <p class="text-xs text-gray-600">compound annual</p>
                    </div>
                    <span class="text-lg font-bold text-blue-600">19.5%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Real-time Metrics</h3>
            <div class="space-y-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">$2,847</p>
                    <p class="text-sm text-gray-600">Today's Sales</p>
                    <div class="flex items-center justify-center mt-1">
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-sm text-green-600">+12.4% vs yesterday</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">47</p>
                    <p class="text-sm text-gray-600">Active Customers</p>
                    <span class="text-sm text-blue-600">Currently shopping</span>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">156</p>
                    <p class="text-sm text-gray-600">Orders Today</p>
                    <span class="text-sm text-purple-600">Avg order: $18.25</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts and Notifications -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Business Intelligence Alerts</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start space-x-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-green-800">Revenue target on track</p>
                        <p class="text-xs text-green-600">87% of monthly goal achieved with 6 days remaining</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Customer acquisition trending up</p>
                        <p class="text-xs text-blue-600">22% increase in new customers this month</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-start space-x-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Profit margin below target</p>
                        <p class="text-xs text-yellow-600">Current: 31.2%, Target: 35% - Review pricing strategy</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-purple-800">Top performing product category</p>
                        <p class="text-xs text-purple-600">Electronics generating 45% of total revenue</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>