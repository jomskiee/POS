<!-- Sales Analysis Tab Content -->
<div class="space-y-6" x-data="salesAnalysis()">
    <!-- Unified Analysis Controls -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Sales Analysis Dashboard</h2>
                <p class="text-gray-600 mt-1">Comprehensive sales metrics, trends, and performance analytics</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="bg-gray-50 px-3 py-2 rounded-lg border">
                    <label class="text-xs font-medium text-gray-600 block mb-1">Global Filter for All Charts</label>
                    <select x-model="globalFilter" @change="updateAllCharts()" class="px-3 py-1 border-0 bg-transparent text-sm focus:ring-0 focus:outline-none">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div x-show="globalFilter === 'custom'" class="flex gap-2">
                    <input type="date" x-model="customStartDate" @change="updateAllCharts()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <input type="date" x-model="customEndDate" @change="updateAllCharts()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button @click="exportAnalysis()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Export Report</span>
                </button>
            </div>
        </div>
        <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm text-blue-700">
                    <strong>Active Filter:</strong> <span x-text="getFilterDescription()"></span> - All charts and metrics below are synchronized to this time period.
                </span>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="formatCurrency(metrics.totalRevenue)"></p>
                    <div class="flex items-center mt-1">
                        <span :class="metrics.revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium flex items-center">
                            <svg x-show="metrics.revenueGrowth >= 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                            </svg>
                            <svg x-show="metrics.revenueGrowth < 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                            </svg>
                            <span x-text="Math.abs(metrics.revenueGrowth) + '%'"></span>
                        </span>
                        <span class="text-sm text-gray-500 ml-1">vs last period</span>
                    </div>
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
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="metrics.totalOrders.toLocaleString()"></p>
                    <div class="flex items-center mt-1">
                        <span :class="metrics.ordersGrowth >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium flex items-center">
                            <svg x-show="metrics.ordersGrowth >= 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                            </svg>
                            <svg x-show="metrics.ordersGrowth < 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                            </svg>
                            <span x-text="Math.abs(metrics.ordersGrowth) + '%'"></span>
                        </span>
                        <span class="text-sm text-gray-500 ml-1">vs last period</span>
                    </div>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Order Value</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="formatCurrency(metrics.avgOrderValue)"></p>
                    <div class="flex items-center mt-1">
                        <span :class="metrics.aovGrowth >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium flex items-center">
                            <svg x-show="metrics.aovGrowth >= 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                            </svg>
                            <svg x-show="metrics.aovGrowth < 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                            </svg>
                            <span x-text="Math.abs(metrics.aovGrowth) + '%'"></span>
                        </span>
                        <span class="text-sm text-gray-500 ml-1">vs last period</span>
                    </div>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Customer Count</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="metrics.customerCount.toLocaleString()"></p>
                    <div class="flex items-center mt-1">
                        <span :class="metrics.customerGrowth >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium flex items-center">
                            <svg x-show="metrics.customerGrowth >= 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                            </svg>
                            <svg x-show="metrics.customerGrowth < 0" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                            </svg>
                            <span x-text="Math.abs(metrics.customerGrowth) + '%'"></span>
                        </span>
                        <span class="text-sm text-gray-500 ml-1">vs last period</span>
                    </div>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Trend Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                <div class="text-sm text-gray-500" x-text="`Period: ${getFilterDescription()}`"></div>
            </div>
            <div class="h-64 flex items-end justify-between space-x-2">
                <template x-for="(item, index) in revenueData" :key="index">
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-blue-200 rounded-t relative" 
                             :style="`height: ${(item.value / Math.max(...revenueData.map(d => d.value))) * 240}px`">
                            <div class="w-full bg-blue-600 rounded-t absolute bottom-0"
                                 :style="`height: ${(item.value / Math.max(...revenueData.map(d => d.value))) * 240}px`">
                            </div>
                            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-gray-700"
                                 x-text="formatCurrency(item.value)"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2" x-text="item.label"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sales by Category Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Sales by Category</h3>
                <button @click="toggleChartType()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <span x-text="categoryChartType === 'doughnut' ? 'Bar View' : 'Pie View'"></span>
                </button>
            </div>
            <div class="h-64">
                <!-- Doughnut Chart Simulation -->
                <div x-show="categoryChartType === 'doughnut'" class="relative w-full h-full flex items-center justify-center">
                    <div class="w-48 h-48 rounded-full border-[40px] border-blue-500 relative">
                        <div class="absolute inset-0 rounded-full border-[40px] border-green-500" style="clip: polygon(50% 50%, 50% 0%, 100% 0%, 100% 100%, 50% 100%);"></div>
                        <div class="absolute inset-0 rounded-full border-[40px] border-purple-500" style="clip: polygon(50% 50%, 50% 0%, 0% 0%, 0% 50%);"></div>
                        <div class="absolute inset-0 rounded-full border-[40px] border-orange-500" style="clip: polygon(50% 50%, 0% 50%, 0% 100%, 50% 100%);"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900" x-text="formatCurrency(metrics.totalRevenue)"></p>
                                <p class="text-sm text-gray-500">Total Sales</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bar Chart Simulation -->
                <div x-show="categoryChartType === 'bar'" class="h-full flex items-end justify-between space-x-4">
                    <template x-for="category in categoryData" :key="category.name">
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full rounded-t relative" 
                                 :class="category.color"
                                 :style="`height: ${(category.value / Math.max(...categoryData.map(d => d.value))) * 240}px`">
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-gray-700"
                                     x-text="formatCurrency(category.value)"></div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 text-center" x-text="category.name"></span>
                        </div>
                    </template>
                </div>
            </div>
            <!-- Legend -->
            <div class="mt-4 flex flex-wrap gap-4">
                <template x-for="category in categoryData" :key="category.name">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-2" :class="category.color.replace('bg-', 'bg-')"></div>
                        <span class="text-sm text-gray-700" x-text="category.name"></span>
                        <span class="text-sm text-gray-500 ml-2" x-text="`(${((category.value / categoryData.reduce((sum, cat) => sum + cat.value, 0)) * 100).toFixed(1)}%)`"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Performance Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top Selling Products</h3>
                <div class="text-sm text-gray-500" x-text="`Period: ${getFilterDescription()}`"></div>
            </div>
            <div class="space-y-4">
                <template x-for="(product, index) in topProducts" :key="index">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600" x-text="index + 1"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="product.name"></p>
                                <p class="text-xs text-gray-500" x-text="product.quantity + ' sold'"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900" x-text="formatCurrency(product.revenue)"></p>
                            <div class="w-16 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-600 h-2 rounded-full" :style="`width: ${(product.revenue / topProducts[0].revenue) * 100}%`"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sales Performance by Hour -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Sales by Hour</h3>
                <div class="text-sm text-gray-500" x-text="`Period: ${getFilterDescription()}`"></div>
            </div>
            <div class="h-48 flex items-end justify-between space-x-1">
                <template x-for="hour in hourlyData" :key="hour.hour">
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-green-600 rounded-t" 
                             :style="`height: ${(hour.sales / Math.max(...hourlyData.map(h => h.sales))) * 180}px`">
                        </div>
                        <span class="text-xs text-gray-500 mt-1" x-text="hour.hour + 'h'"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Payment Method Breakdown -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Payment Methods</h3>
                <div class="text-sm text-gray-500" x-text="`Period: ${getFilterDescription()}`"></div>
            </div>
            <div class="space-y-4">
                <template x-for="method in paymentMethods" :key="method.name">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700" x-text="method.name"></span>
                            <span class="text-sm text-gray-900" x-text="method.percentage + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full" :class="method.color" :style="`width: ${method.percentage}%`"></div>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500" x-text="method.transactions + ' transactions'"></span>
                            <span class="text-xs text-gray-500" x-text="formatCurrency(method.amount)"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Detailed Sales Breakdown</h3>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Search transactions..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="food">Food & Beverages</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="transaction in detailedTransactions" :key="transaction.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="transaction.date"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="transaction.id"></td>
                            <td class="px-6 py-4 text-sm text-gray-900" x-text="transaction.products"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="transaction.payment"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="formatCurrency(transaction.amount)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" :class="transaction.profit >= 0 ? 'text-green-600' : 'text-red-600'" x-text="formatCurrency(transaction.profit)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function salesAnalysis() {
    return {
        globalFilter: 'month',
        customStartDate: '',
        customEndDate: '',
        categoryChartType: 'doughnut',
        
        metrics: {
            totalRevenue: 125420.50,
            revenueGrowth: 12.5,
            totalOrders: 1847,
            ordersGrowth: 8.3,
            avgOrderValue: 67.89,
            aovGrowth: 4.2,
            customerCount: 1203,
            customerGrowth: 15.7
        },
        
        revenueData: [
            { label: 'Mon', value: 12500 },
            { label: 'Tue', value: 15200 },
            { label: 'Wed', value: 18700 },
            { label: 'Thu', value: 16400 },
            { label: 'Fri', value: 21300 },
            { label: 'Sat', value: 28900 },
            { label: 'Sun', value: 22800 }
        ],
        
        categoryData: [
            { name: 'Electronics', value: 45280, color: 'bg-blue-500' },
            { name: 'Clothing', value: 32150, color: 'bg-green-500' },
            { name: 'Food & Beverages', value: 28790, color: 'bg-purple-500' },
            { name: 'Books', value: 19200, color: 'bg-orange-500' }
        ],
        
        topProducts: [
            { name: 'iPhone 15 Pro', quantity: 245, revenue: 24500 },
            { name: 'Samsung Galaxy S24', quantity: 189, revenue: 18900 },
            { name: 'MacBook Pro 16', quantity: 67, revenue: 16750 },
            { name: 'Nike Air Max', quantity: 432, revenue: 12960 },
            { name: 'Coffee Beans Premium', quantity: 789, revenue: 9867 }
        ],
        
        hourlyData: [
            { hour: 9, sales: 1200 },
            { hour: 10, sales: 2100 },
            { hour: 11, sales: 3400 },
            { hour: 12, sales: 4500 },
            { hour: 13, sales: 3800 },
            { hour: 14, sales: 3200 },
            { hour: 15, sales: 4100 },
            { hour: 16, sales: 3600 },
            { hour: 17, sales: 4800 },
            { hour: 18, sales: 3300 }
        ],
        
        paymentMethods: [
            { name: 'Credit Card', percentage: 45, transactions: 832, amount: 56689, color: 'bg-blue-500' },
            { name: 'Cash', percentage: 30, transactions: 554, amount: 37626, color: 'bg-green-500' },
            { name: 'Digital Wallet', percentage: 20, transactions: 369, amount: 25084, color: 'bg-purple-500' },
            { name: 'Bank Transfer', percentage: 5, transactions: 92, amount: 6271, color: 'bg-orange-500' }
        ],
        
        detailedTransactions: [
            { id: '#T-2024-001', date: 'Dec 26, 2024', products: 'iPhone 15 Pro, Case', payment: 'Credit Card', amount: 1049.99, profit: 249.99 },
            { id: '#T-2024-002', date: 'Dec 26, 2024', products: 'Coffee Beans (x3)', payment: 'Cash', amount: 74.97, profit: 29.97 },
            { id: '#T-2024-003', date: 'Dec 26, 2024', products: 'Samsung Galaxy S24', payment: 'Digital Wallet', amount: 899.99, profit: 249.99 },
            { id: '#T-2024-004', date: 'Dec 26, 2024', products: 'Nike Air Max, Socks', payment: 'Credit Card', amount: 149.98, profit: 59.98 },
            { id: '#T-2024-005', date: 'Dec 26, 2024', products: 'MacBook Pro 16', payment: 'Bank Transfer', amount: 2499.99, profit: 699.99 }
        ],
        
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        },
        
        updateAllCharts() {
            // Simulate data update based on global filter for all charts
            console.log('Updating all charts for period:', this.globalFilter);
            // Here you would typically make API calls to update all chart data
            // All charts are now synchronized to the same time period
        },
        
        getFilterDescription() {
            const descriptions = {
                'today': 'Today',
                'week': 'This Week', 
                'month': 'This Month',
                'quarter': 'This Quarter',
                'year': 'This Year',
                'custom': `${this.customStartDate} to ${this.customEndDate}`
            };
            return descriptions[this.globalFilter] || 'This Month';
        },
        
        exportAnalysis() {
            alert('Exporting sales analysis report...');
        },
        
        toggleChartType() {
            this.categoryChartType = this.categoryChartType === 'doughnut' ? 'bar' : 'doughnut';
        }
    }
}
</script>