<!-- Returns & Refunds Tab Content -->
<div class="space-y-6">
    <!-- Returns Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Today's Returns</p>
                    <p class="text-2xl font-bold text-gray-900">$145.60</p>
                    <p class="text-xs text-red-600">3 transactions</p>
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
                    <p class="text-sm font-medium text-gray-600">Pending Returns</p>
                    <p class="text-2xl font-bold text-gray-900">5</p>
                    <p class="text-xs text-yellow-600">Awaiting approval</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Return Rate</p>
                    <p class="text-2xl font-bold text-gray-900">2.1%</p>
                    <p class="text-xs text-blue-600">Within normal range</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Average Refund</p>
                    <p class="text-2xl font-bold text-gray-900">$48.53</p>
                    <p class="text-xs text-green-600">Per return</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Reasons Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Return Reasons</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Defective Product</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">45%</span>
                        <div class="w-20 h-2 bg-gray-200 rounded-full">
                            <div class="w-9 h-2 bg-red-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Wrong Item</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">28%</span>
                        <div class="w-20 h-2 bg-gray-200 rounded-full">
                            <div class="w-6 h-2 bg-yellow-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Customer Changed Mind</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">18%</span>
                        <div class="w-20 h-2 bg-gray-200 rounded-full">
                            <div class="w-4 h-2 bg-blue-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Damaged in Transit</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">9%</span>
                        <div class="w-20 h-2 bg-gray-200 rounded-full">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Refund Processing Time</h3>
            <div class="space-y-4">
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">2.3</p>
                    <p class="text-sm text-gray-600">Average days to process</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">24</p>
                        <p class="text-xs text-gray-600">Same day</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">18</p>
                        <p class="text-xs text-gray-600">1-3 days</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">8</p>
                        <p class="text-xs text-gray-600">4-7 days</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">3</p>
                        <p class="text-xs text-gray-600">>7 days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Returns Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Returns & Refunds</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Export
                    </button>
                    <select class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Processed</option>
                        <option>Rejected</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original Transaction</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-data="{ 
                    returns: [
                        {
                            id: 'RTN-2024-001',
                            transaction_id: 'TXN-2024-004',
                            customer: 'Emma Davis',
                            reason: 'Defective Product',
                            amount: 23.75,
                            date: '2024-12-26',
                            status: 'processed'
                        },
                        {
                            id: 'RTN-2024-002',
                            transaction_id: 'TXN-2024-008',
                            customer: 'John Smith',
                            reason: 'Wrong Item',
                            amount: 45.20,
                            date: '2024-12-26',
                            status: 'pending'
                        },
                        {
                            id: 'RTN-2024-003',
                            transaction_id: 'TXN-2024-012',
                            customer: 'Sarah Johnson',
                            reason: 'Customer Changed Mind',
                            amount: 76.65,
                            date: '2024-12-25',
                            status: 'approved'
                        },
                        {
                            id: 'RTN-2024-004',
                            transaction_id: 'TXN-2024-015',
                            customer: 'Mike Wilson',
                            reason: 'Damaged in Transit',
                            amount: 18.30,
                            date: '2024-12-25',
                            status: 'processed'
                        },
                        {
                            id: 'RTN-2024-005',
                            transaction_id: 'TXN-2024-019',
                            customer: 'Lisa Brown',
                            reason: 'Defective Product',
                            amount: 92.10,
                            date: '2024-12-24',
                            status: 'rejected'
                        }
                    ]
                }">
                    <template x-for="returnItem in returns" :key="returnItem.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-600" x-text="returnItem.id"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="returnItem.transaction_id"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="returnItem.customer"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="returnItem.reason"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900" x-text="'$' + returnItem.amount.toFixed(2)"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="returnItem.date"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                      :class="{
                                          'bg-green-100 text-green-800': returnItem.status === 'processed',
                                          'bg-yellow-100 text-yellow-800': returnItem.status === 'pending',
                                          'bg-blue-100 text-blue-800': returnItem.status === 'approved',
                                          'bg-red-100 text-red-800': returnItem.status === 'rejected'
                                      }"
                                      x-text="returnItem.status.charAt(0).toUpperCase() + returnItem.status.slice(1)"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button @click="alert('View return details: ' + returnItem.id)"
                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button @click="alert('Approve return: ' + returnItem.id)"
                                            class="text-green-600 hover:text-green-900 transition-colors"
                                            x-show="returnItem.status === 'pending'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <button @click="alert('Reject return: ' + returnItem.id)"
                                            class="text-red-600 hover:text-red-900 transition-colors"
                                            x-show="returnItem.status === 'pending'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>