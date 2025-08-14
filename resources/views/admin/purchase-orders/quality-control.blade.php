<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Quality Checklist Template -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quality Control Checklist</h3>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label class="text-sm text-gray-700">Physical condition inspection</label>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label class="text-sm text-gray-700">Quantity verification</label>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label class="text-sm text-gray-700">Packaging integrity check</label>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label class="text-sm text-gray-700">Documentation review</label>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label class="text-sm text-gray-700">Expiry date verification</label>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quality Notes</label>
                <textarea rows="4" 
                          placeholder="Enter quality control observations..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex space-x-3">
                <button class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Approve
                </button>
                <button class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Reject
                </button>
            </div>
        </div>
    </div>

    <!-- Quality Control History -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Quality Checks</h3>
        
        <div class="space-y-4">
            <div class="border-l-4 border-green-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-900">PO-2024-001</p>
                        <p class="text-xs text-gray-600">Coffee Beans Premium - 50 units</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 14:30</p>
            </div>

            <div class="border-l-4 border-red-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-900">PO-2024-002</p>
                        <p class="text-xs text-gray-600">Electronics Components - 25 units</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 12:15</p>
                <p class="text-xs text-red-600 mt-1">Reason: Damaged packaging</p>
            </div>

            <div class="border-l-4 border-yellow-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-900">PO-2024-003</p>
                        <p class="text-xs text-gray-600">Office Supplies - 100 units</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 10:00</p>
            </div>
        </div>
    </div>
</div>