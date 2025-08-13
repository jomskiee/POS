<!-- Sales Reports Tab Content -->
<div class="space-y-6" x-data="{
    reportActiveTab: 'daily-sales',
    dateRange: {
        start: '',
        end: ''
    }
}">
    <!-- Report Type Navigation -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales Reports</h3>
        <div class="flex space-x-4">
            <button @click="reportActiveTab = 'daily-sales'" 
                    :class="reportActiveTab === 'daily-sales' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Daily Sales Report
            </button>
            <button @click="reportActiveTab = 'order-history'" 
                    :class="reportActiveTab === 'order-history' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Order History Report
            </button>
        </div>
    </div>

    <!-- Daily Sales Report -->
    <div x-show="reportActiveTab === 'daily-sales'" x-transition>
        <!-- Date Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-md font-semibold text-gray-900">Daily Sales Analysis</h4>
                <div class="flex items-center space-x-3">
                    <input type="date" 
                           x-model="dateRange.start"
                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-gray-500">to</span>
                    <input type="date" 
                           x-model="dateRange.end"
                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Daily Sales Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Today's Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">$2,847.32</p>
                        <p class="text-xs text-green-600">+12.5% vs yesterday</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Orders Count</p>
                        <p class="text-2xl font-bold text-gray-900">187</p>
                        <p class="text-xs text-blue-600">+8 from yesterday</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                        <p class="text-2xl font-bold text-gray-900">$15.23</p>
                        <p class="text-xs text-purple-600">+$1.20 vs yesterday</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Peak Hour</p>
                        <p class="text-2xl font-bold text-gray-900">2-3 PM</p>
                        <p class="text-xs text-yellow-600">$485 revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-gray-900">Daily Sales Trend</h4>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                </select>
            </div>
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <p class="text-gray-500">Daily Sales Chart</p>
                    <p class="text-sm text-gray-400">Chart.js integration ready</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History Report -->
    <div x-show="reportActiveTab === 'order-history'" x-transition>
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-md font-semibold text-gray-900">Order History Analysis</h4>
                <div class="flex items-center space-x-3">
                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                        <option>Refunded</option>
                    </select>
                    <input type="text" 
                           placeholder="Search orders..."
                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Export CSV
                    </button>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-sm font-medium text-gray-600">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">1,247</p>
                <p class="text-xs text-blue-600">This month</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-sm font-medium text-gray-600">Completed</p>
                <p class="text-2xl font-bold text-green-600">1,156</p>
                <p class="text-xs text-gray-500">92.7%</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">68</p>
                <p class="text-xs text-gray-500">5.5%</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-sm font-medium text-gray-600">Cancelled</p>
                <p class="text-2xl font-bold text-red-600">15</p>
                <p class="text-xs text-gray-500">1.2%</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-sm font-medium text-gray-600">Refunded</p>
                <p class="text-2xl font-bold text-purple-600">8</p>
                <p class="text-xs text-gray-500">0.6%</p>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900">Order History</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" x-data="{ 
                        orders: [
                            {
                                id: 'ORD-2024-1001',
                                customer: 'John Doe',
                                date: '2024-12-26',
                                time: '14:32',
                                items: 3,
                                total: 47.85,
                                payment: 'Card',
                                status: 'completed'
                            },
                            {
                                id: 'ORD-2024-1002',
                                customer: 'Sarah Wilson',
                                date: '2024-12-26',
                                time: '14:28',
                                items: 1,
                                total: 15.50,
                                payment: 'Cash',
                                status: 'completed'
                            },
                            {
                                id: 'ORD-2024-1003',
                                customer: 'Mike Johnson',
                                date: '2024-12-26',
                                time: '14:25',
                                items: 5,
                                total: 89.20,
                                payment: 'Digital',
                                status: 'pending'
                            },
                            {
                                id: 'ORD-2024-1004',
                                customer: 'Emma Davis',
                                date: '2024-12-26',
                                time: '14:20',
                                items: 2,
                                total: 23.75,
                                payment: 'Card',
                                status: 'refunded'
                            },
                            {
                                id: 'ORD-2024-1005',
                                customer: 'Robert Brown',
                                date: '2024-12-25',
                                time: '18:45',
                                items: 1,
                                total: 12.99,
                                payment: 'Cash',
                                status: 'completed'
                            }
                        ]
                    }">
                        <template x-for="order in orders" :key="order.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-blue-600" x-text="order.id"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="order.customer"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="order.date"></div>
                                    <div class="text-xs text-gray-500" x-text="order.time"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900" x-text="order.items + ' items'"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900" x-text="'$' + order.total.toFixed(2)"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                          :class="{
                                              'bg-green-100 text-green-800': order.payment === 'Cash',
                                              'bg-blue-100 text-blue-800': order.payment === 'Card',
                                              'bg-purple-100 text-purple-800': order.payment === 'Digital'
                                          }"
                                          x-text="order.payment"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                          :class="{
                                              'bg-green-100 text-green-800': order.status === 'completed',
                                              'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                              'bg-red-100 text-red-800': order.status === 'refunded',
                                              'bg-gray-100 text-gray-800': order.status === 'cancelled'
                                          }"
                                          x-text="order.status.charAt(0).toUpperCase() + order.status.slice(1)"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button @click="alert('View order: ' + order.id)"
                                                class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button @click="alert('Print order: ' + order.id)"
                                                class="text-green-600 hover:text-green-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">1,247</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            Previous
                        </button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md bg-blue-50 text-blue-600 border-blue-300">
                            1
                        </button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            2
                        </button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            3
                        </button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>