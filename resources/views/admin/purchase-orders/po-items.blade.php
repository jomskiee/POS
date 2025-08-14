<!-- Purchase Order Items Tab Content -->
<div class="space-y-6">
    <!-- PO Items Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Items</p>
                    <p class="text-2xl font-bold text-gray-900">1,247</p>
                    <p class="text-xs text-blue-600">Across all POs</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Delivered Items</p>
                    <p class="text-2xl font-bold text-gray-900">1,089</p>
                    <p class="text-xs text-green-600">87.3% delivered</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Items</p>
                    <p class="text-2xl font-bold text-gray-900">158</p>
                    <p class="text-xs text-orange-600">12.7% pending</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900">$186K</p>
                    <p class="text-xs text-purple-600">This quarter</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- PO Items Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Purchase Order Items</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Search items..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All POs</option>
                        <option>PO-2024-001</option>
                        <option>PO-2024-002</option>
                        <option>PO-2024-003</option>
                        <option>PO-2024-004</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Ordered</option>
                        <option>Delivered</option>
                        <option>Received</option>
                        <option>Cancelled</option>
                    </select>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Export
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">PO-2024-001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Wireless Bluetooth Headphones</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">WBH-001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">25</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$89.99</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$2,249.75</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">View</button>
                            <button class="text-green-600 hover:text-green-800">Receive</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">PO-2024-001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">USB-C Charging Cables (3ft)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">USC-3FT</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">100</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$12.50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$1,250.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">View</button>
                            <button class="text-orange-600 hover:text-orange-800">Track</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">PO-2024-002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Wireless Mouse - Ergonomic</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">WM-ERG-01</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$24.99</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$1,249.50</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Received</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">View</button>
                            <button class="text-green-600 hover:text-green-800">QC</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">PO-2024-003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4K Webcam with Auto-Focus</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">WC-4K-AF</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$129.99</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$1,949.85</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">View</button>
                            <button class="text-green-600 hover:text-green-800">Complete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">PO-2024-004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Desk Organizer Set - Bamboo</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">DO-BAMB-SET</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">20</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$34.50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$690.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Ordered</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">View</button>
                            <button class="text-red-600 hover:text-red-800">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Item Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Items by Category</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-blue-500 rounded"></div>
                        <span class="text-sm text-gray-900">Electronics</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">847 items</span>
                        <span class="text-xs text-gray-500 block">67.9%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <span class="text-sm text-gray-900">Office Supplies</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">245 items</span>
                        <span class="text-xs text-gray-500 block">19.6%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-purple-500 rounded"></div>
                        <span class="text-sm text-gray-900">Furniture</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">89 items</span>
                        <span class="text-xs text-gray-500 block">7.1%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                        <span class="text-sm text-gray-900">Industrial</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">45 items</span>
                        <span class="text-xs text-gray-500 block">3.6%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-red-500 rounded"></div>
                        <span class="text-sm text-gray-900">Software</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">21 items</span>
                        <span class="text-xs text-gray-500 block">1.7%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Ordered Items</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-600">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">USB-C Cables</p>
                            <p class="text-xs text-gray-600">USC-3FT • 450 units</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">$5,625</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Wireless Mouse</p>
                            <p class="text-xs text-gray-600">WM-ERG-01 • 320 units</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">$7,997</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">3</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Bluetooth Headphones</p>
                            <p class="text-xs text-gray-600">WBH-001 • 175 units</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">$15,748</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">4</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">4K Webcam</p>
                            <p class="text-xs text-gray-600">WC-4K-AF • 95 units</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">$12,349</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">5</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Desk Organizer</p>
                            <p class="text-xs text-gray-600">DO-BAMB-SET • 85 units</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">$2,933</span>
                </div>
            </div>
        </div>
    </div>
</div>