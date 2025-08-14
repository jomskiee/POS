<!-- Stock Alerts Tab Content -->
<div class="space-y-6">
    <!-- Alerts Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Critical Alerts</p>
                    <p class="text-2xl font-bold text-gray-900">23</p>
                    <p class="text-xs text-red-600">Immediate attention</p>
                </div>
                <div class="bg-red-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-2xl font-bold text-gray-900">89</p>
                    <p class="text-xs text-orange-600">Below threshold</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Normal Stock</p>
                    <p class="text-2xl font-bold text-gray-900">2,635</p>
                    <p class="text-xs text-green-600">Above threshold</p>
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
                    <p class="text-sm font-medium text-gray-600">Overstock</p>
                    <p class="text-2xl font-bold text-gray-900">156</p>
                    <p class="text-xs text-blue-600">Excess inventory</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Critical Alerts Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Stock Alerts Dashboard</h3>
                <div class="flex items-center space-x-3">
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Alerts</option>
                        <option>Critical</option>
                        <option>Low Stock</option>
                        <option>Overstock</option>
                    </select>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Configure Alerts
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Threshold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alert Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">4K Webcam</div>
                                    <div class="text-sm text-gray-500">WC-4K-AF</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">0 units</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5 units</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Critical</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2 min ago</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">Reorder</button>
                            <button class="text-green-600 hover:text-green-800">Adjust</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">USB-C Cable</div>
                                    <div class="text-sm text-gray-500">USC-3FT</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-600">8 units</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15 units</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Low Stock</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15 min ago</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">Reorder</button>
                            <button class="text-green-600 hover:text-green-800">Adjust</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Office Chair</div>
                                    <div class="text-sm text-gray-500">OC-ERG-01</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">125 units</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">50 units</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Overstock</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1 hour ago</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-purple-600 hover:text-purple-800">Promote</button>
                            <button class="text-green-600 hover:text-green-800">Adjust</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alert Configuration and Notifications -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Alert Configuration</h3>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Critical Alert Threshold</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Out of Stock Alert</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Email Notifications</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Low Stock Settings</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Default Threshold</label>
                            <input type="number" value="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Alert Frequency</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option>Real-time</option>
                                <option>Hourly</option>
                                <option>Daily</option>
                                <option>Weekly</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Overstock Detection</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Overstock Multiplier</label>
                            <input type="number" value="3" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Auto-Promotion Suggestions</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                    Save Configuration
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Notifications</h3>
            <div class="space-y-4">
                <div class="border-l-4 border-red-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Critical Stock Alert</p>
                            <p class="text-xs text-gray-600">4K Webcam is completely out of stock</p>
                        </div>
                        <span class="text-xs text-gray-500">2 min ago</span>
                    </div>
                    <div class="mt-2 flex space-x-2">
                        <button class="text-xs bg-blue-600 text-white px-2 py-1 rounded">Reorder</button>
                        <button class="text-xs bg-gray-600 text-white px-2 py-1 rounded">Dismiss</button>
                    </div>
                </div>

                <div class="border-l-4 border-orange-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Low Stock Warning</p>
                            <p class="text-xs text-gray-600">USB-C Cable stock below threshold (8/15)</p>
                        </div>
                        <span class="text-xs text-gray-500">15 min ago</span>
                    </div>
                    <div class="mt-2 flex space-x-2">
                        <button class="text-xs bg-blue-600 text-white px-2 py-1 rounded">Reorder</button>
                        <button class="text-xs bg-gray-600 text-white px-2 py-1 rounded">Dismiss</button>
                    </div>
                </div>

                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Overstock Detection</p>
                            <p class="text-xs text-gray-600">Office Chair inventory high (125/50)</p>
                        </div>
                        <span class="text-xs text-gray-500">1 hour ago</span>
                    </div>
                    <div class="mt-2 flex space-x-2">
                        <button class="text-xs bg-purple-600 text-white px-2 py-1 rounded">Promote</button>
                        <button class="text-xs bg-gray-600 text-white px-2 py-1 rounded">Dismiss</button>
                    </div>
                </div>

                <div class="border-l-4 border-green-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Stock Replenished</p>
                            <p class="text-xs text-gray-600">Wireless Mouse stock restored (67 units)</p>
                        </div>
                        <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                    <div class="mt-2 flex space-x-2">
                        <button class="text-xs bg-gray-600 text-white px-2 py-1 rounded">Dismiss</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>